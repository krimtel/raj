$(function() {
  $("form[name='login_form']").validate({
    rules: {
      identity: "required",
//      email: {
//        required: true,
//        email: true
//      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      identity: "Please enter your email id",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
//      email: "Please enter a valid email address"
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});


//$(function() {
//	  $("form[name='news_form']").validate({
//		ignore: [],
//        debug: false,
//	    rules: {
//	     news_desc: {
//	    	 required: function() 
//             {
//              CKEDITOR.instances.news_desc.updateElement();
//             },
//              minlength:17
//	     }
//	    },
//	    messages: {
//	      news_desc: {
//	        required: "News description in required.",
//	        minlength: "news description atleast 10 character."
//	      },
//	    },
//	    submitHandler: function(form) {
//	      form.submit();
//	    }
//	  });
//	});