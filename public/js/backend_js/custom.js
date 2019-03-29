$(document).ready(function(){

	//Password validation//
	$("#new_pwd").click(function(){
		var current_pwd = $("#current_pwd").val();
		//alert(current_pwd);
		$.ajax({
			type:'get',
			url: '/admin/check-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
					//alert(resp);
					if(resp=="false"){
						$("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
					}
					else if(resp=="true"){
						$("#chkPwd").html("<font color='green'>Current Password is Ccorrect</font>");
					}
				},
				error:function(){
					alert("Error");
				}
		});
	});

	//Category Form Validation//
	//aDD cATEGORY Validation
	 $("#add_category").validate({
		rules:{

			category_name:{
				required:true,
			},
			description:{
				required:true,
				
			},
			
			url:{
				required:true,
				
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});


	 //Add Product Validation//

	 $("#add_product").validate({
		rules:{
			category_id:{
				required:true,
			},

			product_name:{
				required:true,
			},

			product_code:{
				required:true,
				
			},
			
			product_color:{
				required:true,
				
			},
			price:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	 

	 //Delete//

	 $("#delCat").click(function(){
		alert(test); die;
		if(confirm('Are you sure to delete this Category?')){
			return true;
		}
		return false;
	});

});