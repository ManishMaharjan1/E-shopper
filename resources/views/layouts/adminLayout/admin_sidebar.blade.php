<?php $url = url()->current(); ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li <?php if(preg_match("/dashboard/i",$url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/category/i",$url)){ ?> style="display:block;" <?php } ?> >
        <li  <?php if(preg_match("/add-category/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/add-category') }}">Add Categories</a></li>
        <li  <?php if(preg_match("/view-category/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/view-category') }}">View Categories</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/product/i",$url)){ ?> style="display:block;" <?php } ?> >
        <li  <?php if(preg_match("/add-product/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/add-product') }}">Add Product</a></li>
        <li  <?php if(preg_match("/view-product/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/view-product') }}">View Products</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/coupon/i",$url)){ ?> style="display:block;" <?php } ?> >
        <li  <?php if(preg_match("/add-coupon/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/add-coupon') }}">Add Coupons</a></li>
        <li  <?php if(preg_match("/view-coupons/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/view-coupons') }}">View Coupons</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Orders</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/order/i",$url)){ ?> style="display:block;" <?php } ?> >
        <li  <?php if(preg_match("/view-orders/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/view-orders') }}">View Orders</a></li>
      </ul>
    </li>
     <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banners</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/banner/i",$url)){ ?> style="display:block;" <?php } ?> >
        <li  <?php if(preg_match("/add-banner/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/add-banner') }}">Add Banners</a></li>
        <li  <?php if(preg_match("/view-banners/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/view-banners') }}">View Banners</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/user/i",$url)){ ?> style="display:block;" <?php } ?> >
        <li  <?php if(preg_match("/view-user/i",$url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/view-user') }}">View Users</a></li>
      </ul>
    </li>
  </ul>
</div>
  <!--sidebar-menu-->