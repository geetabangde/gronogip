@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Users </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Users</li>
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

                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                            <tr>
                                                
                                                <th>Name</th>
                                                <th>Mobile Number</th>
                                                <!-- <th>Email Id</th>
                                                <th>Address</th> -->
                                                <th>City</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                        @foreach($users as $key => $user)
                                            <tr>
                                               
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->mobile_number }}</td>
                                                <!-- <td>{{ $user->email }}</td>
                                                <td>{{ $user->address }}</td> -->
                                                <td>{{ $user->city }}</td>
                                            </tr>
                                        @endforeach
                                            <!-- Repeat similar rows up to 40 -->
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
@endsection