 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu" class="pt-4">
            <!-- Left Menu Start -->
            @php
                $user = Auth::guard('admin')->user();
            @endphp

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title bg-center" data-key="t-menu">Menu</li>

                {{-- Dashboard sabko dikhana hai --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                {{-- Sirf Admin ke liye --}}
                @if($user->role_id == 1)
                    <li>
                        <a href="#">
                            <i data-feather="package"></i>
                            <span data-key="t-manufacturers">Manufacturer</span>
                        </a>
                    </li>
                @endif

                {{-- Sirf Retailer ke liye --}}
                @if($user->role_id == 2)
                    <li>
                        <a href="#">
                            <i data-feather="shopping-cart"></i>
                            <span data-key="t-orders">Orders</span>
                        </a>
                    </li>
                @endif

                {{-- Sirf Manufacturer ke liye --}}
                @if($user->role_id == 3)
                    <li>
                        <a href="#">
                            <i data-feather="clock"></i>
                            <span data-key="t-history">History</span>
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Sidebar -->

        </div>
    </div>
</div>

