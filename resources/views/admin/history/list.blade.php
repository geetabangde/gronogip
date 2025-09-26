@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
   <!-- start page title -->
   <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">History</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">History</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <!-- Voucher Listing Page -->
   <!-- Product Listing Page -->
        <div class="row listing-form">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">🧾 History List</h4>
                    </div>

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>QR Code ID</th>
                             <th>QR Image</th>
                            <th>Description</th>
                            <th>Payment ID</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Method</th>
                            <th>VPA</th>
                            <th>RRN</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $index => $payment)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $payment->razorpay_qr_id }}</td>
                                <td>
                                    @if($payment->image_url)
                                        <a href="{{ $payment->image_url }}" target="_blank">
                                            <img src="{{ $payment->image_url }}" alt="QR Code" width="50" height="50">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $payment->description ?? '-' }}</td>
                                <td>{{ $payment->razorpay_payment_id }}</td>
                                <td>₹{{ number_format($payment->amount/100, 2) }}</td>
                                <td>{{ $payment->currency }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status === 'captured' ? 'success' : 'danger' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ strtoupper($payment->method) }}</td>
                                <td>{{ $payment->vpa ?? '-' }}</td>
                                <td>{{ $payment->rrn ?? '-' }}</td>
                                <td>{{ $payment->paid_at ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>

   <!-- container-fluid -->
</div>
@endsection