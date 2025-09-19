@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
   <!-- start page title -->
   <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Brand</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">Brand</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <!-- Voucher Listing Page -->
   <div class="row listing-form">
      <div class="col-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="card-title">🧾 Brand List</h4>
                </div>
               
            </div>
            <div class="card-body">
               <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Manufacturer</th>
                        <th>Brand Name</th>
                        <th>Image</th>
                        <th>Description</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($brands as $key => $brand)
                     <tr>
                         <td>{{ $loop->iteration }}</td>
                        <td>{{ $brand->manufacturer ? $brand->manufacturer->name : 'N/A' }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                           @if($brand->image)
                              <img src="{{ $brand->image }}" alt="{{ $brand->name }}" width="50" height="50">
                           @else
                              N/A
                           @endif
                        </td>
                        <td>{{ $brand->description }}</td>
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