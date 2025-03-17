@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Demand Listing </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Demand Listing</li>
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
                                                <th>Demand product Name</th>
                                                <th>Quantity</th>
                                                <th>Preferred Delivery Date</th>
                                                <th>Delivery Location</th>
                                                <th>Contact Details</th>
                                                <th>Selling Rate</th>
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->subcategory ? $product->subcategory->name : 'N/A' }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->delivary_date }}</td>
                                                <td>{{ $product->user ? $product->user->city : 'N/A' }}</td>
                                                <td>{{ $product->user ? $product->user->mobile_number : 'N/A' }}</td>
                                                <td>₹{{ $product->selling_rate }}</td>
                                                <td>{{ $product->per_unit }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                     
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

@endsection