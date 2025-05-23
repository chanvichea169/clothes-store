<div class="section-menu-left">
    <div class="box-logo">
        <a href="{{ route('admin.index') }}" id="site-logo-inner">
            <img class="" id="logo_header" alt="" src="{{ asset('images/logo/logo.png') }}"
                data-light="images/logo/logo.png" data-dark="images/logo/logo.png">
        </a>
        <div class="button-show-hide">
            <i class="icon-menu-left"></i>
        </div>
    </div>
    <div class="center">
        <div class="center-item">
            <div class="center-heading">Main Home</div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-grid"></i></div>
                        <div class="text">Dashboard</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="center-item">
            <ul class="menu-list">
                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button {{ request()->routeIs('admin.add.product') || request()->routeIs('admin.products') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                        <div class="text">Products</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{ route('admin.add.product') }}" class="{{ request()->routeIs('admin.add.product') ? 'active' : '' }}">
                                <div class="text">Add Product</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products') ? 'active' : '' }}">
                                <div class="text">Products</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button {{ request()->routeIs('admin.add.brand') || request()->routeIs('admin.brands') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-layers"></i></div>
                        <div class="text">Brand</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{ route('admin.add.brand') }}" class="{{ request()->routeIs('admin.add.brand') ? 'active' : '' }}">
                                <div class="text">New Brand</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{ route('admin.brands') }}" class="{{ request()->routeIs('admin.brands') ? 'active' : '' }}">
                                <div class="text">Brands</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button {{ request()->routeIs('admin.add.category') || request()->routeIs('admin.categories') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-layers"></i></div>
                        <div class="text">Category</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{ route('admin.add.category') }}" class="{{ request()->routeIs('admin.add.category') ? 'active' : '' }}">
                                <div class="text">New Category</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                                <div class="text">Categories</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button">
                        <div class="icon"><i class="icon-file-plus"></i></div>
                        <div class="text">Order</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{ route('order.index') }}" class="">
                                <div class="text">Orders</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="#" class="">
                                <div class="text">Order tracking</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.slide.index') }}" class="{{ request()->routeIs('admin.slide.index') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-image"></i></div>
                        <div class="text">Slider</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.category-banners.index') }}" class="{{ request()->routeIs('admin.category-banners.index') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-image"></i></div>
                        <div class="text">Banner</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('admin.coupons') }}" class="{{ request()->routeIs('admin.coupons') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-grid"></i></div>
                        <div class="text">Coupons</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('admin.contact.index') }}" class="{{ request()->routeIs('admin.contact.index') ? 'active' : '' }}">
                        <div class="icon"><i class="far fa-envelope"></i></div>
                        <div class="text">Messages</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-user"></i></div>
                        <div class="text">User</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('admin.setting.index') }}" class="{{ request()->routeIs('admin.setting.index') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-settings"></i></div>
                        <div class="text">Settings</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.about.index') }}" class="{{ request()->routeIs('admin.about.index') ? 'active' : '' }}">
                        <span class="material-symbols-rounded">
                            info
                        </span>
                        <div class="text">About</div>
                    </a>
                </li>

                <li class="menu-item">
                    {{-- <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}" class="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="icon me-2"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                            <div class="text">Logout</div>
                        </a>
                    </form> --}}
                    <a href="{{ route('home.index') }}" >
                        <div class="icon me-2"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                        <div class="text">Logout</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
