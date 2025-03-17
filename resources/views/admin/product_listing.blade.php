@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Product Listing </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Product Listing</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Requirement Product Name</th>
                                                <th>Quantity</th>
                                                
                                                <th>Selling Rate</th>
                                                <th>Rate Unit</th>
                                                
                                                
                                                <th>Images</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->subcategory ? $product->subcategory->name : 'N/A' }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>₹{{ $product->selling_rate }}</td>
                                                <td>{{ $product->per_unit }}</td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                   

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
@endsection