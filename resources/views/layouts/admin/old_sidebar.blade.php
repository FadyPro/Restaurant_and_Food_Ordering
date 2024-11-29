<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
{{--        @php--}}
{{--            $notifications = \App\Models\OrderPlacedNotification::where('seen', 0)--}}
{{--                ->latest()--}}
{{--                ->take(10)--}}
{{--                ->get();--}}
{{--            $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();--}}
{{--        @endphp--}}
        @if (auth()->user()->id === 1)
            <li class="dropdown dropdown-list-toggle">
                <a href="" data-toggle="dropdown"
                   class="nav-link nav-link-lg message-envelope "><i
                        class="far fa-envelope"></i></a>
            </li>
        @endif

        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                                     class="nav-link notification-toggle nav-link-lg notification_beep "><i
                    class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons rt_notification">
{{--                    @foreach ($notifications as $notification)--}}
{{--                        <a href="" class="dropdown-item">--}}
{{--                            <div class="dropdown-item-icon bg-info text-white">--}}
{{--                                <i class="fas fa-bell"></i>--}}
{{--                            </div>--}}
{{--                            <div class="dropdown-item-desc">--}}
{{--                                {{ $notification->message }}--}}
{{--                                <div class="time">{{ date('h:i A | d-F-Y', strtotime($notification->created_at)) }}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    @endforeach--}}

                </div>
                <div class="dropdown-footer text-center">
                    <a href="">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->avatar) }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <!-- Authentication -->
                <form method="POST" action="">
                    @csrf

                    <a href="#"
                       onclick="event.preventDefault();
                    this.closest('form').submit();"
                       class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>

            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">{{config('settings.site_name')}}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">PR</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ setSidebarActive(['admin.dashboard']) }}"><a class="nav-link" href=""><i class="fas fa-fire"></i>
                    Dashboard</a>
            </li>

            <li class="menu-header">Starter</li>

            <li class="{{ setSidebarActive(['admin.slider.*']) }}"><a class="nav-link" href=""><i class="fas fa-images"></i>
                    <span>Slider</span></a></li>

            <li class="{{ setSidebarActive(['admin.daily-offer.*']) }}"><a class="nav-link" href=""><i class="far fa-clock"></i>
                    <span>Daily Offer</span></a></li>

            <li class="dropdown {{ setSidebarActive([
                'admin.orders.index',
                'admin.pending-orders',
                'admin.inprocess-orders',
                'admin.delivered-orders',
                'admin.declined-orders'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i>
                    <span>Orders </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.orders.index']) }}"><a class="nav-link" href="">All Orders</a></li>
                    <li class="{{ setSidebarActive(['admin.pending-orders']) }}" ><a class="nav-link" href="">Pending Orders</a></li>
                    <li class="{{ setSidebarActive(['admin.inprocess-orders']) }}" ><a class="nav-link" href="">In Process Orders</a></li>
                    <li class="{{ setSidebarActive(['admin.delivered-orders']) }}" ><a class="nav-link" href="">Delivered Orders</a></li>
                    <li class="{{ setSidebarActive(['admin.declined-orders']) }}" ><a class="nav-link" href="">Decliend Orders</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setSidebarActive([
                'admin.category.*',
                'admin.product.*',
                'admin.product-reviews.index',
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i>
                    <span>Manage Products </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.category.*']) }}" ><a class="nav-link" href="">Product Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.product.*']) }}" ><a class="nav-link" href="">Products</a></li>
                    <li class="{{ setSidebarActive(['admin.product-reviews.index']) }}" ><a class="nav-link" href="">Product Reviews</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ setSidebarActive([
                'admin.coupon.*',
                'admin.delivery-area.*',
                'admin.payment-setting.index',
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i>
                    <span> Manage Ecommerce </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.coupon.*']) }}" ><a class="nav-link" href="">Coupon</a></li>
                    <li class="{{ setSidebarActive(['admin.delivery-area.*']) }}" ><a class="nav-link" href="">Delivery Areas</a></li>
                    <li class="{{ setSidebarActive(['admin.payment-setting.index']) }}" ><a class="nav-link" href="">Payment Gateways</a>
                    </li>

                </ul>
            </li>

            <li class="dropdown {{ setSidebarActive([
                'admin.reservation-time.*',
                'admin.reservation.index',
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chair"></i>
                    <span>Manage Reservations </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.reservation-time.*']) }}" ><a class="nav-link" href="">Reservation Times</a></li>
                    <li class="{{ setSidebarActive(['admin.reservation.index']) }}" ><a class="nav-link" href="">Reservation</a></li>
                </ul>
            </li>

            @if (auth()->user()->id === 1)
                <li class="{{ setSidebarActive(['admin.chat.index']) }}"><a class="nav-link" href=""><i class="fas fa-comment-dots"></i>
                        <span>Messages</span></a></li>
            @endif

            <li class="dropdown {{ setSidebarActive([
                'admin.blog-category.*',
                'admin.blogs.*',
                'admin.blogs.comments.index'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-rss"></i>
                    <span> Blog </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.blog-category.*']) }}" ><a class="nav-link" href="">Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.blogs.*']) }}" ><a class="nav-link" href="">All Blogs</a></li>
                    <li class="{{ setSidebarActive(['admin.blogs.comments.index']) }}" ><a class="nav-link" href="">Comments</a></li>
            </li>
        </ul>
        </li>


        <li class="dropdown {{ setSidebarActive([
            'admin.why-choose-us.*',
            'admin.banner-slider.*',
            'admin.chefs.*',
            'admin.app-download.index',
            'admin.testimonial.*',
            'admin.counter.index'
        ]) }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-stream"></i>
                <span>Sections </span></a>
            <ul class="dropdown-menu">
                <li class="{{ setSidebarActive(['admin.why-choose-us.*']) }}"><a class="nav-link" href="">Why choose us</a></li>
                <li class="{{ setSidebarActive(['admin.banner-slider.*']) }}"><a class="nav-link" href="">Banner Slider</a></li>
                <li class="{{ setSidebarActive(['admin.chefs.*']) }}"><a class="nav-link" href="">Chefs</a></li>
                <li class="{{ setSidebarActive(['admin.app-download.index']) }}"><a class="nav-link" href="">App Download Section</a>
                </li>
                <li class="{{ setSidebarActive(['admin.testimonial.*']) }}"><a class="nav-link" href="">Testimonial</a></li>
                <li class="{{ setSidebarActive(['admin.counter.index']) }}"><a class="nav-link" href="">Counter</a></li>

            </ul>
        </li>

        <li class="dropdown {{ setSidebarActive([
            'admin.custom-page-builder.*',
            'admin.about.index',
            'admin.trams-and-conditions.index',
            'admin.contact.index',
            'admin.privacy-policy.index',
        ]) }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-alt"></i>
                <span>Pages </span></a>
            <ul class="dropdown-menu">
                <li class="{{ setSidebarActive(['admin.custom-page-builder.*']) }}" ><a class="nav-link" href="">Custom Page</a></li>

                <li class="{{ setSidebarActive(['admin.about.index']) }}" ><a class="nav-link" href="">About</a></li>
                <li class="{{ setSidebarActive(['admin.privacy-policy.index']) }}" ><a class="nav-link" href="">Privacy Policy</a></li>
                <li class="{{ setSidebarActive(['admin.trams-and-conditions.index']) }}" ><a class="nav-link" href="">Trams and
                        Conditions</a></li>
                <li class="{{ setSidebarActive(['admin.contact.index']) }}" ><a class="nav-link" href="">Contact</a></li>

            </ul>
        </li>

        <li class="{{ setSidebarActive(['admin.news-letter.index']) }}"><a class="nav-link" href=""><i class="fas fa-newspaper"></i>
                <span>News Letter</span></a></li>

        <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link" href=""><i class="fas fa-link"></i>
                <span>Social Links</span></a></li>

        <li class="{{ setSidebarActive(['admin.footer-info.index']) }}"><a class="nav-link" href=""> <i class="fas fa-info-circle"></i> <span>Footer Info</span></a></li>

        <li class="{{ setSidebarActive(['admin.menu-builder.index']) }}"><a class="nav-link" href=""><i class="fas fa-list-alt"></i>
                <span>Menu Builder</span></a></li>

        <li class="{{ setSidebarActive(['admin.admin-management.*']) }}"><a class="nav-link" href=""><i class="fas fa-user-shield"></i>
                <span>Admin Management</span></a></li>

        <li class="{{ setSidebarActive(['admin.setting.index']) }}"><a class="nav-link" href=""><i class="fas fa-cogs"></i>
                <span>Settings</span></a></li>

        <li class="{{ setSidebarActive(['admin.clear-database.index*']) }}"><a class="nav-link" href=""><i class="fas fa-exclamation-triangle"></i>
                <span>Clear Database</span></a></li>
    </aside>
</div>
