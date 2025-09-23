@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
   <!-- start page title -->
   <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Orders</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">Orders</li>
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
                        <div>
                            <h4 class="card-title">🧾 Orders List</h4>
                        </div>
                        
                    </div>

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Manufacturer Name</th>
                                    <th>Order ID</th>
                                    <th>User Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Payment Method</th>
                                    <th>Total</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $orderIndex => $order)
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $orderIndex + 1 }}</td>
                                            <td>{{ $item->manufacturer->name ?? '-' }}</td>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>
                                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $order->status ?? '-' }}</td>
                                            <td>{{ $order->payment_status ?? '-' }}</td>
                                            <td>{{ $order->payment_method ?? '-' }}</td>
                                            <td>{{ number_format($item->subtotal, 2) }}</td>
                                            <td>{{ $order->address ?? '-' }}</td>
                                        </tr>
                                    @endforeach
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