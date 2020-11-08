<aside class="sidebar col-lg-3">
    <div class="widget widget-dashboard">
        <h3 class="widget-title">My Account</h3>

        <ul class="list">
            <li class="{{ isActiveRoute('user_dash')}}"><a href="/home">Account Dashboard</a></li>
            <li class="{{ areActiveRoutes(['user_orders','show_order'])}}"><a href="/my-orders">My Orders</a></li>
        </ul>
    </div><!-- End .widget -->
</aside><!-- End .col-lg-3 -->
