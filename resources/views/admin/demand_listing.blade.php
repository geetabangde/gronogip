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
                                                <th>Crop Name</th>
                                                <th>Quantity</th>
                                                <th>Preferred Delivery Date</th>
                                                <th>Delivery Location</th>
                                                <th>Contact Details</th>
                                                <th>Additional Address</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Wheat</td>
                                                <td>1000 Kg</td>
                                                <td>2025-03-10</td>
                                                <td>Indore, MP</td>
                                                <td>9876543210</td>
                                                <td>Near Bus Stand, Indore</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Basmati Rice</td>
                                                <td>500 Kg</td>
                                                <td>2025-03-15</td>
                                                <td>Bhopal, MP</td>
                                                <td>9856231470</td>
                                                <td>Sector 5, Bhopal</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Sugarcane</td>
                                                <td>2000 Kg</td>
                                                <td>2025-03-20</td>
                                                <td>Pune, MH</td>
                                                <td>9988776655</td>
                                                <td>Market Yard, Pune</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Groundnut</td>
                                                <td>1500 Kg</td>
                                                <td>2025-03-12</td>
                                                <td>Nashik, MH</td>
                                                <td>9123456789</td>
                                                <td>Main Road, Nashik</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Fresh Mango</td>
                                                <td>800 Kg</td>
                                                <td>2025-03-25</td>
                                                <td>Jaipur, RJ</td>
                                                <td>9001234567</td>
                                                <td>Near Railway Station, Jaipur</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm">Edit</button>
                                                    <button class="btn btn-danger btn-sm">Delete</button>
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