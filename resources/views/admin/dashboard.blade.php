
@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <!-- <body data-layout="horizontal"> -->

       

            
           

           
            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-12">
                                <!-- card -->
                                <div class="card">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <h5 class="card-title me-2">Agricultural Market Overview</h5>
                                            <div class="ms-auto">
                                                <div>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        ALL
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        1Y
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="row align-items-center">
                                            <div class="col-xl-8">
                                                <div>
                                                    <div id="market-overview" data-colors='["#4caf50", "#ff9800"]' class="apex-charts"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="p-4">
                                                    <div class="mt-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-light-subtle text-dark font-size-16">
                                                                    1
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Wheat</span>
                                                            </div>
                        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium">+3.2%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-light-subtle text-dark font-size-16">
                                                                    2
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Rice</span>
                                                            </div>
                        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium">+5.6%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-light-subtle text-dark font-size-16">
                                                                    3
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Corn</span>
                                                            </div>
                        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill bg-danger-subtle text-danger font-size-12 fw-medium">-1.8%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-light-subtle text-dark font-size-16">
                                                                    4
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Soybean</span>
                                                            </div>
                        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium">+4.1%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm m-auto">
                                                                <span class="avatar-title rounded-circle bg-light-subtle text-dark font-size-16">
                                                                    5
                                                                </span>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <span class="font-size-16">Sugarcane</span>
                                                            </div>
                        
                                                            <div class="flex-shrink-0">
                                                                <span class="badge rounded-pill bg-danger-subtle text-danger font-size-12 fw-medium">-0.5%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="mt-4 pt-2">
                                                        <a href="" class="btn btn-primary w-100">See All Prices <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                    </div>
                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row-->
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Orders</span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="1200">0</span>
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart1" data-colors='["#28a745"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>
                                        <div class="text-nowrap">
                                            <span class="badge bg-success-subtle text-success">+150 Orders</span>
                                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Registered Farmers</span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="8500">0</span>
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart2" data-colors='["#28a745"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>
                                        <div class="text-nowrap">
                                            <span class="badge bg-success-subtle text-success">+500 Farmers</span>
                                            <span class="ms-1 text-muted font-size-13">Since last month</span>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col-->
                        
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Transactions</span>
                                                <h4 class="mb-3">
                                                    ₹<span class="counter-value" data-target="7.5">0</span>M
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart3" data-colors='["#28a745"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>
                                        <div class="text-nowrap">
                                            <span class="badge bg-success-subtle text-success">+₹500K</span>
                                            <span class="ms-1 text-muted font-size-13">Since last month</span>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Active Buyers</span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="3200">0</span>
                                                </h4>
                                            </div>
                                            <div class="col-6">
                                                <div id="mini-chart4" data-colors='["#28a745"]' class="apex-charts mb-2"></div>
                                            </div>
                                        </div>
                                        <div class="text-nowrap">
                                            <span class="badge bg-success-subtle text-success">+250 Buyers</span>
                                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->    
                        </div><!-- end row--> 
                        

                        <div class="row">
                            <div class="col-xl-5">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center mb-4">
                                            <h5 class="card-title me-2">Wallet Balance</h5>
                                            <div class="ms-auto">
                                                <div>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        ALL
                                                    </button>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        1Y
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-sm">
                                                <div id="wallet-balance" data-colors='["#777aca", "#5156be", "#a8aada"]' class="apex-charts"></div>
                                            </div>
                                            <div class="col-sm align-self-center">
                                                <div class="mt-4 mt-sm-0">
                                                    <div>
                                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i> Products</p>
                                                        <h6>40000K = <span class="text-muted font-size-14 fw-normal">₹ 4025.32</span></h6>
                                                    </div>
    
                                                    <div class="mt-4 pt-2">
                                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i> Buyer</p>
                                                        <h6>45000K = <span class="text-muted font-size-14 fw-normal">₹ 1123.64</span></h6>
                                                    </div>
    
                                                    <div class="mt-4 pt-2">
                                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i> Listing</p>
                                                        <h6>35K= <span class="text-muted font-size-14 fw-normal">₹ 2263.09</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <!-- card -->
                                        <div class="card card-h-100">
                                            <!-- card body -->
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center mb-4">
                                                    <h5 class="card-title me-2">Invested Overview</h5>
                                                    <div class="ms-auto">
                                                        <select class="form-select form-select-sm">
                                                            <option value="MAY" selected="">May</option>
                                                            <option value="AP">April</option>
                                                            <option value="MA">March</option>
                                                            <option value="FE">February</option>
                                                            <option value="JA">January</option>
                                                            <option value="DE">December</option>
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="row align-items-center">
                                                    <div class="col-sm">
                                                        <div id="invested-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
                                                    </div>
                                                    <div class="col-sm align-self-center">
                                                        <div class="mt-4 mt-sm-0">
                                                            <p class="mb-1">Invested Amount</p>
                                                            <h4>₹ 6134.39</h4>

                                                            <p class="text-muted mb-4"> + 0.0012.23 ( 0.2 % ) <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>

                                                            <div class="row g-0">
                                                                <div class="col-6">
                                                                    <div>
                                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Income</p>
                                                                        <h5 class="fw-medium">₹ 2632.46</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div>
                                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Expenses</p>
                                                                        <h5 class="fw-medium">-₹ 924.38</h5>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mt-2">
                                                                <a href="#" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-xl-4" style="display: none;">
                                        <!-- card -->
                                        <div class="card bg-primary text-white shadow-primary card-h-100">
                                            <!-- card body -->
                                            <div class="card-body p-0">
                                                <div id="carouselExampleCaptions" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">                                                   
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <div class="text-center p-4">
                                                                <i class="mdi mdi-bitcoin widget-box-1-icon"></i>
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                                        <i class="mdi mdi-currency-btc"></i>
                                                                    </span>
                                                                </div>
                                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>Bitcoin</b> News</h4>
                                                                <p class="text-white-50 font-size-13">Bitcoin prices fell sharply amid the global sell-off in equities. Negative news
                                                                    over the Bitcoin past week has dampened Bitcoin basics
                                                                    sentiment for bitcoin. </p>
                                                                <button type="button" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></button>
                                                            </div>
                                                        </div>
                                                        <!-- end carousel-item -->
                                                        <div class="carousel-item">
                                                            <div class="text-center p-4">
                                                                <i class="mdi mdi-ethereum widget-box-1-icon"></i>
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                                        <i class="mdi mdi-ethereum"></i>
                                                                    </span>
                                                                </div>
                                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>ETH</b> News</h4>
                                                                <p class="text-white-50 font-size-13">Bitcoin prices fell sharply amid the global sell-off in equities. Negative news
                                                                    over the Bitcoin past week has dampened Bitcoin basics
                                                                    sentiment for bitcoin. </p>
                                                                <button type="button" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></button>
                                                            </div>
                                                        </div>
                                                        <!-- end carousel-item -->
                                                        <div class="carousel-item">
                                                            <div class="text-center p-4">
                                                                <i class="mdi mdi-litecoin widget-box-1-icon"></i>
                                                                <div class="avatar-md m-auto">
                                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                                        <i class="mdi mdi-litecoin"></i>
                                                                    </span>
                                                                </div>
                                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>Litecoin</b> News</h4>
                                                                <p class="text-white-50 font-size-13">Bitcoin prices fell sharply amid the global sell-off in equities. Negative news
                                                                    over the Bitcoin past week has dampened Bitcoin basics
                                                                    sentiment for bitcoin. </p>
                                                                <button type="button" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></button>
                                                            </div>
                                                        </div>
                                                        <!-- end carousel-item -->
                                                    </div>
                                                    <!-- end carousel-inner -->
                                                    
                                                    <div class="carousel-indicators carousel-indicators-rounded">
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                                                            aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <!-- end carousel-indicators -->
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end col -->
                        </div> <!-- end row-->

                       
                        
                        <!-- end row-->

                       
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                
            </div>
            <!-- end main content-->

       

        
        

        @endsection