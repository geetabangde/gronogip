 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title" data-key="t-menu">Menu</li>

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i data-feather="home"></i>
                    <span data-key="t-dashboard">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users') }}">
                    <i data-feather="users"></i>
                    <span data-key="t-dashboard">Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.categories.index') }}">
                    <i data-feather="share-2"></i>
                    <span data-key="t-dashboard">Category</span>
                </a>
            </li>


            <li>
            <a href="{{ route('admin.subcategories.index') }}">
                     <i data-feather="file-text"></i>
                    <span data-key="t-dashboard">Requirement Product</span>
                </a>
            </li>


            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="grid"></i>  
                    <span data-key="t-apps">Listing</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.product_listing') }}">
                            <span data-key="t-calendar">Product Listing</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.demand_listing') }}">
                            <span data-key="t-chat">Demand Listing</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="{{ route('admin.products.index') }}" >
                    <i data-feather="briefcase"></i>
                    <span data-key="t-dashboard">Product for Sell</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.redeem.index') }}" >
                    <i data-feather="briefcase"></i>
                    <span data-key="t-dashboard">Product Redeem</span>
                </a>
            </li>


            <li>
                <a href="{{ route('admin.order') }}" >
                    <i data-feather="users"></i>
                    <span data-key="t-dashboard">Orders</span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i data-feather="sliders"></i>
                    <span data-key="t-authentication">Enquiry</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('admin.requirement') }}" data-key="t-login">For Requirement </a></li>
                    <li><a href="{{ route('admin.demand') }}" data-key="t-register">For Demand</a></li>
                   
                </ul>
            </li>

            

            <li>
                <a href="{{ route('admin.banners.index') }}">
                    <i data-feather="pie-chart"></i>
                    <span data-key="t-dashboard">Banner</span>
                </a>
            </li>



        </ul>

        <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5" >
            <div class="card-body">
                <img src="assets/images/giftbox.png" alt="">
                <div class="mt-4">
                    <h5 class="alertcard-title font-size-16">Welcome to Kisan Trade</h5>
                    <p class="font-size-13">A Smart Marketplace for Farmers & Buyers</p>
                    <a href="#!" class="btn btn-primary mt-2">Go to Website</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->
