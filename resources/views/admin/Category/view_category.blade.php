@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
<div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-category') }}">Categories</a> <a href="#" class="current">View Category</a> </div>
    <h1>Categories</h1>
     @include('layouts.adminLayout.session')
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Categories</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category ID</th>
                  <th>Categry Name</th>
                   <th>Categry Level</th>
                  <th>Category URL</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @php 
              $i =1
              @endphp
                	@foreach($categories as  $category)
                <tr class="gradeX">
                  <td>{{$i++}}</td>
                  <td>{{$category->category_name}}</td>
                  <td>
                      {{-- {{$category->parent_id}} --}}
                    @foreach($parentCategories as $parentCategory)
                      @if($parentCategory->id==$category->parent_id)
                          {{$parentCategory->category_name}}
                        @endif
                   @endforeach
                  </td>
                 
                  <td>{{$category->url}}</td>
                  <td>
                    @if($category->status==1)
                      Active
                    @else
                      Inactive
                    @endif
                  </td>
                  <td class="center"><a href="{{ url('/admin/edit-category/'. $category->id) }}" class="btn btn-primary btn-mini">Edit</a>
                   <a rel ="{{$category->id}}" rel1="delete-category" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
                </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection()