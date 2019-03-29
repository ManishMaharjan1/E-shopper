@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-product') }}">Products</a> <a href="#" class="current">Edit Product</a> </div>
    <h1>Products</h1>
    @include('layouts.adminLayout.session')
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Product</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('/admin/edit-product/'.$productdetails->id) }}" name="edit_product" id="edit_product" enctype="multipart/form-data" novalidate="novalidate">
            	{{csrf_field()}}
              <div class="control-group">
                <label class="control-label"> Under Category</label>
                <div class="controls">
                  <select name ="category_id" id="category_id" style="width:220px;" value="{{$productdetails->parent_id}}">
                    <?php echo $categories_dropdown; ?>
                   
                  </select>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value="{{$productdetails->product_name}}">
                </div>
              </div>  
              <div class="control-group">
                <label class="control-label">Product Code</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code" value="{{$productdetails->product_code}}">
                </div>
              </div>
               <div class="control-group">
                <label class="control-label">Product Color</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color" value="{{$productdetails->product_color}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea name="description" id="description">{{$productdetails->description}}</textarea>
                </div>
              </div>
               <div class="control-group">
                <label class="control-label">Material and Care</label>
                <div class="controls">
                  <textarea name="care" id="care">{{$productdetails->care}}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Price</label>
                <div class="controls">
                  <input type="text" name="price" id="price" value="{{$productdetails->price}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Image</label>
                <div class="controls">
                  <input type="file" name="image" id="image">
                  <input type="hidden" name="current_image" value="{{$productdetails->image}}">
                  @if(!empty($productdetails->image))
                 <img style="width:40px" src="{{ asset('/images/backend_images/products/small/'.$productdetails->image)}}"> || 
                 <a href="{{ url('/admin/delete-product-image/'.$productdetails->id) }}">Delete</a>
                 @endif
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit Category" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection()