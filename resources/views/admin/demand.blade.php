@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')

<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">For Demand </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">For Demand</li>
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
                                                <th>Title</th>
                                                <th>Enquiry From</th>
                                                <th>Enquiry To</th>
                                                <th>Subcategory Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Need Premium Wheat</td>
                                                <td>Farmer A</td>
                                                <td>Trader B</td>
                                                <td>Wheat</td>
                                                <td>₹25/kg</td>
                                                <td>1000 Kg</td>
                                                <td>Indore, MP</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Looking for Organic Rice</td>
                                                <td>Trader C</td>
                                                <td>Supplier D</td>
                                                <td>Basmati Rice</td>
                                                <td>₹90/kg</td>
                                                <td>500 Kg</td>
                                                <td>Bhopal, MP</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Urgent Sugarcane Requirement</td>
                                                <td>Factory X</td>
                                                <td>Supplier Y</td>
                                                <td>Sugarcane</td>
                                                <td>₹40/kg</td>
                                                <td>2000 Kg</td>
                                                <td>Pune, MH</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Need Groundnut in Bulk</td>
                                                <td>Wholesaler P</td>
                                                <td>Farmer Q</td>
                                                <td>Groundnut</td>
                                                <td>₹70/kg</td>
                                                <td>1500 Kg</td>
                                                <td>Nashik, MH</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Looking for Fresh Mangoes</td>
                                                <td>Retailer M</td>
                                                <td>Supplier N</td>
                                                <td>Alphonso Mango</td>
                                                <td>₹120/kg</td>
                                                <td>800 Kg</td>
                                                <td>Jaipur, RJ</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                                </td>
                                            </tr>
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