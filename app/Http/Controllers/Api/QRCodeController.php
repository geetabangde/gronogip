<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QRCode;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class QRCodeController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'usage' => 'required|in:single_use,multiple_use',
            'fixed_amount' => 'required|boolean',
            'payment_amount' => 'nullable|numeric|min:1',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|array',
        ]);

        $user = User::findOrFail($request->user_id);

        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');

        $payload = [
            "type" => "upi_qr",
            "name" => $request->name,
            "usage" => $request->usage,
            "fixed_amount" => $request->fixed_amount,
            "payment_amount" => $request->payment_amount,
            "description" => $request->description,
            "notes" => $request->notes ?? ['user_id' => $user->id],
        ];
        

        if($request->usage == 'single_use') {
            $payload['close_by'] = now()->addMinutes(120)->timestamp;
        }

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->post('https://api.razorpay.com/v1/payments/qr_codes', $payload);

        if($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => $response->body()
            ], 400);
        }

        $data = $response->json();

        $qr = QRCode::create([
            'user_id' => $user->id,
            'razorpay_qr_id' => $data['id'],
            'image_url' => $data['image_url'],
            'usage' => $data['usage'],
            'fixed_amount' => $data['fixed_amount'],
            'payment_amount' => $data['payment_amount'] ?? null,
            'description' => $data['description'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => $data['status'],
        ]);

        return response()->json([
            'success' => true,
            'qr_code' => $qr
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
}
