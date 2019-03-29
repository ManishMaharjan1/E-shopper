/*price range*/

if ($.fn.slider) {
    $('#sl2').slider();
}

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

/*scroll to top*/

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});


$(document).ready(function(){

    //Change Price and stock with size//
    $("#selSize").change(function(){
       var idSize = $(this).val();
       if(idSize==""){
        return false;
       }
       $.ajax({
            type:'get',
            url:'../get-product-price',
            data:{idSize:idSize},
            success:function(resp){
                // alert(resp); return false;
                var arr = resp.split('#');
                $("#getPrice").html("Rs."+arr[0]);
                $("#price").val(arr[0]);
                if(arr[1]==0){
                    $("#cartButton").hide();
                    $("#available").text("Out of Stock");
                }
                else{
                    $("#cartButton").show();
                    $("#available").text("In Stock");
                }
            },error:function(){
                alert("Error");
            }
       });
   });
    //Replace image with alternate image//
    $(".changeImage").click(function(){
        var image = $(this).attr('src');
        $(".mainImage").attr("src", image);
    });
    // Instantiate EasyZoom instances
        var $easyzoom = $('.easyzoom').easyZoom();

        // Setup thumbnails example
        var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

        $('.thumbnails').on('click', 'a', function(e) {
            var $this = $(this);

            e.preventDefault();

            // Use EasyZoom's `swap` method
            api1.swap($this.data('standard'), $this.attr('href'));
        });

        // Setup toggles example
        var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

        $('.toggle').on('click', function() {
            var $this = $(this);

            if ($this.data("active") === true) {
                $this.text("Switch on").data("active", false);
                api2.teardown();
            } else {
                $this.text("Switch off").data("active", true);
                api2._init();
            }
        });

   //Validate Register User form on keyup and submit
   $("#registerForm").validate({
        rules:{
            name:{
                required:true,
                minlength:5,
                accept:"[a-zA-Z]+"
            },
            password:{
                required:true,
                minlength:6
            },
            email:{
                required:true,
                email:true,
                remote:"check-email"
            }
        },
        messages:{
            name:{
                required:"Please enter your Name",
                accept:"Your name must contain letter only"
            },   
            password:{
                required:"Please provide your password",
                minlength:"Your password must be of atleast 6 character long"
            },
            email:{
                required:"Please enter your email",
                email:"Please enter valid email",
                remote:"Email already exists"
            }
        },
   });

 //Validate Account Update form on keyup and submit
    $("#accountForm").validate({
        rules:{
            name:{
                required:true,
                minlength:5,
                accept:"[a-zA-Z]+"
            },
            address:{
                required:true
            },
            city:{
                required:true
            },
            state:{
                required:true
            },
            country:{
                required:true
            },
            // pincode:{
            //     required:true
            // },
            mobile:{
                required:true,
                minlength:10
            }
        },
        messages:{
            name:{
                required:"Please enter your Name",
                accept:"Your name must contain letter only"
            },   
            address:{
                required:"Please provide your address"
            },
            city:{
                required:"Please provide your City "
            },
            state:{
                required:"Please provide your State"
            },
            country:{
                required:"Please select your Country"
            }
        },
   });

    //Validate Login form on keyup and submit
   $("#loginForm").validate({
        rules:{
            email:{
                required:true,
                email:true
            },
            password:{
                required:true
            }
        },
        messages:{
            email:{
                required:"Please enter your email",
                email:"Please enter valid email"
            },
             password:{
                required:"Please provide your password"
            }
        },
   });

   //Check User Password//
    $("#current_pwd").keyup(function(){
        var current_pwd = $(this).val();
        $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            },
            type:'get',
            url:'check-user-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp=="true"){
                    $("#chkPwd").html("<font color='green'>Current Password is correct</font>");
                }else if(resp=="false"){
                    $("#chkPwd").html("<font color='red'>Current Password is incorrect</font>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //User new password validation//
    $("#passwordForm").validate({
        rules:{
            current_pwd:{
                required: true,
                minlength:6,
                maxlength:20
            },
            new_pwd:{
                required:true,
                minlength:6,
                maxlength:20,
            },
            confirm_pwd:{
                required:true,
                minlength:6,
                maxlength:20,
                equalTo:"#new_pwd"
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



   //Password strength script//
   $('#myPassword').passtrength({
      minChars: 4,
      passwordToggle: true,
      tooltip: true,
      eyeImg : "images/frontend_images/eye.svg"
    });

});


// $("#current_pwd").keyup(function(){
//   var current_pwd = $("#current_pwd").val();
//   $.ajax({
//    type:'get',
//    url:'/check-user-pwd',
//    data:{current_pwd:current_pwd},
//    success:function(resp){
//     if(resp=="false"){
//      $("#chkPwd").html("<font color='red'>Current Password is incorrect</font>");
//     }else if(resp=="true"){
//      $("#chkPwd").html("<font color='green'>Current Password is correct</font>");
//     }
//    },error:function(){
//     alert("Error");
//    }
//   });
//  });