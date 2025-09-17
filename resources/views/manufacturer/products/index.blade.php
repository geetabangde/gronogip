@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
   <!-- start page title -->
   <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Products</h4>
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                  <li class="breadcrumb-item active">Products</li>
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
                            <h4 class="card-title">🧾 Product List</h4>
                        </div>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-primary"
                        style="background-color: #ca2639; color: white; border: none;">
                            <i class="fas fa-plus"></i> Add
                        </a>
                    </div>

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" width="50" height="50">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
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