<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QRPayment;
use App\Models\QRCode;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QRCodeController extends Controller
{
    public function create(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');

        // Validate required fields
        $request->validate([
            'type' => 'required|string|in:upi_qr',
            'usage' => 'required|string|in:single_use,multiple_use',
            'name' => 'nullable|string|max:255',
            'fixed_amount' => 'nullable|boolean',
            'payment_amount' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'customer_id' => 'nullable|string',
            'close_by' => 'nullable|integer',
            'notes' => 'nullable|array|max:15'
        ]);

        // Prepare the payload
        $payload = [
            'type' => $request->type,
            'usage' => $request->usage,
            'fixed_amount' => $request->boolean('fixed_amount', false), // Default to false if not provided
        ];

        // Add optional fields if provided
        if ($request->has('name')) {
            $payload['name'] = $request->name;
        }

        if ($request->has('payment_amount')) {
            $payload['payment_amount'] = $request->payment_amount;
        }

        if ($request->has('description')) {
            $payload['description'] = $request->description;
        }

        if ($request->has('customer_id')) {
            $payload['customer_id'] = $request->customer_id;
        }

        if ($request->has('close_by')) {
            $payload['close_by'] = $request->close_by;
        }

        if ($request->has('notes') && is_array($request->notes)) {
            // Validate notes array - max 15 key-value pairs, 256 chars each
            $notes = $request->notes;
            if (count($notes) > 15) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notes can have maximum 15 key-value pairs'
                ], 400);
            }

            foreach ($notes as $key => $value) {
                if (strlen($key) > 256 || strlen($value) > 256) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Each note key and value must be maximum 256 characters'
                    ], 400);
                }
            }
            
            $payload['notes'] = $notes;
        }

        // Additional validation for single_use QR codes
        if ($request->usage === 'single_use' && !$request->boolean('fixed_amount', false)) {
            return response()->json([
                'success' => false,
                'message' => 'For single_use QR codes, fixed_amount must be true'
            ], 400);
        }

        $url = "https://api.razorpay.com/v1/payments/qr_codes";

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($url, $payload);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => $response->body(),
                'status_code' => $response->status()
            ], $response->status());
        }

        // Get the response data
        $qrCodeData = $response->json();

        // Store QR code in database
        try {
            $qrCode = DB::table('q_r_codes')->insert([
                'user_id' => $user->id,
                'razorpay_qr_id' => $qrCodeData['id'],
                'image_url' => $qrCodeData['image_url'],
                'usage' => $qrCodeData['usage'],
                'fixed_amount' => $qrCodeData['fixed_amount'],
                'payment_amount' => $qrCodeData['payment_amount'] ?? null,
                'description' => $qrCodeData['description'] ?? null,
                'notes' => isset($qrCodeData['notes']) ? json_encode($qrCodeData['notes']) : null,
                'status' => $qrCodeData['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'QR Code created and saved successfully',
                'qr_code' => $qrCodeData
            ]);

        } catch (\Exception $e) {
            // If database insert fails, log the error but still return the Razorpay response
            \Log::error('Failed to save QR code to database: ' . $e->getMessage());
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code created successfully but failed to save to database',
                'qr_code' => $qrCodeData,
                'warning' => 'Database save failed'
            ]);
        }
    }

    public function fetchPaymentsForQR(Request $request, $qrId)
    {
        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');

        // Get authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Find QR code in your DB and ensure it belongs to authenticated user
        $qr = DB::table('q_r_codes')
            ->where('razorpay_qr_id', $qrId)
            ->where('user_id', $user->id)
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code not found or unauthorized'
            ], 404);
        }

        // Parse query parameters from request
        $from  = $request->get('from') ? (int)$request->get('from') : Carbon::now()->subDays(30)->timestamp;
        $to    = $request->get('to')   ? (int)$request->get('to')   : Carbon::now()->timestamp;
        $count = $request->get('count', 10);
        $skip  = $request->get('skip', 0);

        // Build query parameters (without qr_id)
        $query = [
            'count' => $count,
            'skip'  => $skip,
        ];

        // Add optional time filters
        if ($from) $query['from'] = $from;
        if ($to)   $query['to']   = $to;

        // Call Razorpay API with QR ID in URL path
        $url = "https://api.razorpay.com/v1/payments/qr_codes/{$qrId}/payments";
        
        $response = Http::withBasicAuth($keyId, $keySecret)->get($url, $query);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => $response->body()
            ], $response->status());
        }

        $responseData = $response->json();
        $payments = $responseData['items'] ?? [];

        // Optional: Store payments in database for future reference
        try {
            foreach ($payments as $payment) {
                // Check if payment already exists
                $existingPayment = DB::table('qr_payments')
                    ->where('razorpay_payment_id', $payment['id'])
                    ->first();

                if (!$existingPayment) {
                    DB::table('qr_payments')->insert([
                        'qr_code_id' => $qr->id,
                        'razorpay_payment_id' => $payment['id'],
                        'amount' => $payment['amount'],
                        'currency' => $payment['currency'] ?? 'INR',
                        'status' => $payment['status'],
                        'method' => $payment['method'],
                        'vpa' => $payment['vpa'] ?? null,
                        'email' => $payment['email'] ?? null,
                        'contact' => $payment['contact'] ?? null,
                        'notes' => isset($payment['notes']) ? json_encode($payment['notes']) : null,
                        'fee' => $payment['fee'] ?? 0,
                        'tax' => $payment['tax'] ?? 0,
                        'rrn' => isset($payment['acquirer_data']['rrn']) ? $payment['acquirer_data']['rrn'] : null,
                        'paid_at' => isset($payment['created_at']) ? date('Y-m-d H:i:s', $payment['created_at']) : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log error but don't fail the response
            \Log::error('Failed to save payments to database: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'count' => $responseData['count'] ?? 0,
            'payments' => $payments
        ]);
    }



    public function fetchAll(Request $request)
    {
        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');

        // Optionally, you can pass count & skip for pagination
        $count = $request->get('count', 10);  // default 10
        $skip  = $request->get('skip', 0);    // default 0

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->get('https://api.razorpay.com/v1/payments/qr_codes', [
                'count' => $count,
                'skip'  => $skip
            ]);

        if($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => $response->body()
            ], 400);
        }

        $data = $response->json();

        return response()->json([
            'success' => true,
            'qr_codes' => $data
        ]);
    }

    public function fetchAllPayments(Request $request)
    {
        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');

        // Query parameters (defaults)
        // Convert normal date to UNIX timestamp
        $from = strtotime($request->get('from', '2025-09-01')); 
        $to   = strtotime($request->get('to', '2025-09-23')); 
        $count = $request->get('count', 10);
        $skip  = $request->get('skip', 0);

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->get('https://api.razorpay.com/v1/payments', [
                'from'  => $from,
                'to'    => $to,
                'count' => $count,
                'skip'  => $skip,
            ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => $response->body(),
            ], 400);
        }

        $data = $response->json();

        return response()->json([
            'success' => true,
            'payments' => $data
        ]);
    }


    // public function fetchPaymentsForQR(Request $request, $id)
    // {
    //         $keyId = env('RAZORPAY_KEY_ID');
    //         $keySecret = env('RAZORPAY_KEY_SECRET');

    //         // Query params
    //         $from  = $request->get('from') ? strtotime($request->get('from')) : Carbon::now()->subDays(30)->timestamp;
    //         $to    = $request->get('to')   ? strtotime($request->get('to'))   : Carbon::now()->timestamp;
    //         $count = $request->get('count', 10);
    //         $skip  = $request->get('skip', 0);

    //         $query = [
    //             'count' => $count,
    //             'skip'  => $skip,
    //         ];

    //         if ($from) $query['from'] = $from;
    //         if ($to)   $query['to']   = $to;

    //         $url = "https://api.razorpay.com/v1/payments/qr_codes/{$id}/payments";

    //         $response = Http::withBasicAuth($keyId, $keySecret)->get($url, $query);

    //         if ($response->failed()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $response->body()
    //             ], 400);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'payments' => $response->json()
    //         ]);
    // }
}
