@if(Session::has('flash_message_error'))
<div class="alert alert-error alert-block" style="background-color:#f2dfd0;">
  <button type="button" class="close" data-dismiss="alert">×</button> 
  <strong>{!!session('flash_message_error')!!}</strong> 
</div>
@endif     
@if(Session::has('flash_message_success'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
  <strong>{!!session('flash_message_success')!!}</strong> 
</div>
@endif