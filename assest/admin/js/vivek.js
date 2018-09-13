$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	var uGroup = $('#u_group').val();

	$("form[name='login_form']").validate({
		rules: {
			identity: {
				required: true,
				minlength:4
			},
			password: {
				required: true
			}

		},
		messages: {
			username: {
					required: "Please enter your identity",
					minlength: "Your username must consist of at least 4 characters"
			},
			password: {
				required: "Please enter your password",
				minlength: "Your Password must consist of at least 3 characters"
			}
		},
		 submitHandler: function(form) {
		      form.submit();
		    }
	});
	

	
	
	$('#news_form').validate({
	ignore:[],
	debug: false,
		 event: 'blur',
	rules: {
		news_desc: {
			required: function(news_desc) {
		          CKEDITOR.instances[news_desc.id].updateElement();
		          var editorcontent = news_desc.value.replace(/<[^>]*>/gi, '');
		          return editorcontent.length === 0;
		          }
		}
	},
	messages: {
		news_desc: {
				required: "Please Fill News Discription"
		}	
	}
});
	
	$('#widget_form').validate({
		ignore:[],
		debug: false,
			 event: 'blur',
		rules: {
			widget_name:{
				required: true
			},
			widget_content: {
				required: function(widget_content) {
			          CKEDITOR.instances[widget_content.id].updateElement();
			          var editorcontent = widget_content.value.replace(/<[^>]*>/gi, '');
			          return editorcontent.length === 0;
			          }
			}
		},
		messages: {
			widget_name:{
				required: "please fill widget name"
			},
			widget_content: {
					required: "Please Fill Widget Content"
			}	
		}
		
	});

	$('#link_form').validate({
		ignore:[],
		debug: false,
			 event: 'blur',
		rules: {
			link_desc: {
				required: function(link_desc) {
			          CKEDITOR.instances[link_desc.id].updateElement();
			          var editorcontent = link_desc.value.replace(/<[^>]*>/gi, '');
			          return editorcontent.length === 0;
			          }
			}
		},
		messages: {
			link_desc: {
					required: "Please Fill Link Description Field"
			}	
		}
		
	});
	
	$('#event_form').validate({
		ignore:[],
		debug: false,
			 event: 'blur',
		rules: {
			link_desc: {
				required: function(link_desc) {
			          CKEDITOR.instances[link_desc.id].updateElement();
			          var editorcontent = link_desc.value.replace(/<[^>]*>/gi, '');
			          return editorcontent.length === 0;
			          }
			}
		},
		messages: {
			link_desc: {
					required: "Please Fill Link Description Field"
			}	
		}
		
	});

//////////////////////////////////////Language///////////////////////////////////////////////////////////// 
	
	$(document).on('keyup','#language_name',function(){
		var language = $("#language_name").val().trim();
		if($("#language_name").val() == ''){
			$("#language_response").html('Language name not empty.'); 
		}
		var pattern =  new RegExp("^[a-zA-Z]*$");
		var that = this;
		if(pattern.test(language)) {
			if(language==''){
				 $("#language_create").attr("disabled", "disabled");
				 
			}
			else if (language != ''){
		         $("#language_response").show();
		         $.ajax({
		            url: baseUrl +'admin/language_ctrl/language_check',
		            type: 'POST',
		            dataType: "json",
		            data: {
		            	'language' : language,
		            },
		            success: function(response){
		                if(response.status == 200){
		                	$(that).removeClass('txt_error');
		                	//$("#language_create").attr("disabled", false);
		                	language_form_check();
		                	$("#language_response").html('');
		                }else {
		                    $(that).addClass('txt_error');
		                    $("#language_create").attr("disabled", "disabled");
		                    $("#language_response").html("<span class='exists'>"+ response.msg +"</span>");
		                }
		                
		             }
		          });
		      }else{
		         $("#language_response").hide();
		      }
		}
		else if(language!=pattern){
			$("#language_response").html("<span class='exists'>only char allowed</span>");
			$(that).addClass('txt_error');
			$("#language_create").attr("disabled", "disabled");
		}
	    });
	
	     
	////////////////////
	$(document).on('keyup','#language_name_eng',function(){
		var language_name_eng = $("#language_name_eng").val().trim();
		if($("#language_name_eng").val() == ''){
			$("#language_response").html('Language name not empty.'); 
		}
		var pattern =  new RegExp("^[a-zA-Z]*$");
		var that = this;
		if(pattern.test(language_name_eng)) {
			if(language_name_eng==''){
				 $("#language_create").attr("disabled", "disabled");
				 
			}
			else if (language_name_eng != ''){
		         $("#language_response").show();
		         $.ajax({
		            url: baseUrl +'admin/language_ctrl/language_check_eng',
		            type: 'POST',
		            dataType: "json",
		            data: {
		            	'language_name_eng' : language_name_eng,
		            },
		            success: function(response){
		                if(response.status == 200){
		                	$(that).removeClass('txt_error');
		                	//$("#language_create").attr("disabled", false);
		                	language_form_check();
		                	$("#language_response").html('');
		                }else {
		                    $(that).addClass('txt_error');
		                    $("#language_create").attr("disabled", "disabled");
		                    $("#language_response").html("<span class='exists'>"+ response.msg +"</span>");
		                }
		                
		             }
		          });
		      }else{
		         $("#language_response").hide();
		      }
		}
		else if(language_name_eng!=pattern){
			$("#language_response").html("<span class='exists'>only char allowed</span>");
			$(that).addClass('txt_error');
			$("#language_create").attr("disabled", "disabled");
		}
	    });
	
	///////////////////////Users Language////////////////////////////////////////////////
	
	$(document).on('change','#users_list_drop_down',function(){
		if($(this).val() != 0){
			$('#users_language_drop_down_box').show();
		}
		else{
			$('#users_language_drop_down_box').hide();
		}
		
		$(document).on('click','#users_language_drop_down',function(){
			if($(this).val() == 0){
				$("#users_language_update").attr("disabled","disabled");
			}
		});
		
	});
	
	
	//////////////////////////////// Slider Create //////////////////////////////////////
	
	$(document).on('click','#slider_create',function(){
		 var form_valid = true;
		 var alt_tag=$(this).data('slider_alt');
		 
		 if($('#userFiles').val() == ''){
				$('#userfile_error').html('Please select image for slider.').css('display','block');
				form_valid = false;
			}
		 else{
				$('#userfile_error').css('display','none');
			}
		 
		 if($('#slider_alt').val() == ''){
			 $('#slider_alt_error').html('please Fill Alt Tag').css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#slider_alt_error').css('display','none');
		 }
		 
		 if($('#slider_order').val()==''){ 
			 $('#slider_order_error').html("please Fill Slider Sort Order").css('display','block');
			 form_valid = false;
		 }
		 
		 else{
			 $('#slider_order_error').css('display','none');
		 }
			
			
		if(form_valid){
			$('#slider_form').ajaxForm({
				dataType : 'json',
				data : 'alt_tag',
				beforeSubmit:function(e){
					$('#loader').modal('show');
			    },
			    success:function(response){
			  	  if(response.status == 200){
			    	$('#loader').modal('toggle');
			    	alert(response.msg);
			    	location.reload();
			      }
			      else{
				    alert(response.msg);
			      }
			    }
			}).submit();
		}
	});
	
	
	$(document).on('click','#slider_update',function(){
		var form_valid = true;
		
		if($('#slider_alt').val() == ''){
			$('#slider_alt_error').html('Please enter Slider Tag.').css('display','block');
			form_valid = false;
		}
		else if($('#slider_alt').val().length < 5){
			$('#slider_alt_error').html('Please Enter Valid Event tag.').css('display','block');
			form_valid = false;
		}
		else{
			$('#slider_alt_error').css('display','none');
		}

		if(uGroup != 'subadmin'){
			if(!$.isNumeric($('#slider_order').val())){
				$('#slider_order_error').html('Slider Order Must Be Numaric.').css('display','block');
				form_valid = false;
			}
			else if($('slider_order').val() == ''){
				$('#slider_order_error').html('Slider Order is required.').css('display','block');
				form_valid = false;
			}
			else{
				$('#slider_order_error').css('display','none');
			}
			
		}
		alert(form_valid);
   		if(form_valid){
			$('#slider_form').ajaxForm({
			    dataType : 'json',
			    data : {},
			    beforeSubmit:function(e){
					$('#loader').modal('show');
			    },
			    success:function(response){
			  	  if(response.status == 200){
			    	$('#loader').modal('toggle');
			    	alert(response.msg);
			    	location.reload();
			      }
			      else{
				    alert(response.msg);
			      }
			    }
		  }).submit();
   		}
	});
	
	function readURL(input) {

		  if (input.files && input.files[0]) {
		    var reader = new FileReader();

		    reader.onload = function(e) {
		      $('#image_upload_preview').attr('src', e.target.result);
		    }
		    reader.readAsDataURL(input.files[0]);
		  }
		}
	
	$(document).on('change','#userFiles',function(e){
		 readURL(this);
	});
	
	$(document).on('click','.slider_edit',function(){
		var slider_id = $(this).data('slider_id');
		$.ajax({
			type: 'POST',
			url: baseUrl+'admin/Slider_ctrl/get_slider_content',
			dataType: "json",
			data: {
				's_id'	: slider_id
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){},
				success:function (response) {
					console.log(response);
					if(response.status == 200){
						$('#loader').modal('toggle');	
						$('#loader-1 #myModalLabel').html('Slider Update');
						$('#loader-1 .modal-footer').hide();
						var x = '<form name="f1" id="slider_update_popup" method="POST" enctype="multipart/form-data" action="'+ baseUrl +'admin/Slider_ctrl/slider_update_subadmin" class="form-horizontal">'+
							  		'<div class="form-group">'+
							  			'<label for="inputEmail3" class="col-sm-2 control-label">Slider image</label>'+
							  			'<div class="col-sm-10">'+
							  				'<img width="30" src="'+baseUrl+'/Slider_gallary/'+ response.data[0].lang_id +'/'+ response.data[0].slider_image +'" id="image_preview_popup">'+
							  				'<input type="file" name="file" id="slider_photo_popup" class="form-control">'+
							  				'<input type="hidden" name="slider_id_popup" class="form-control" id="slider_id_popup" value="'+ slider_id +'">'+
							  				'<div class="text-danger" id="slider_photo_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
							  			'<label for="inputPassword3" class="col-sm-2 control-label">Short</label>'+
							  			'<div class="col-sm-10">'+
							  			'<input type="text" name="slider_id_sort" class="form-control" id="slider_id_sort" value="'+ response.data[0].sort +'">'+
							  				'<div class="text-danger" id="slider_tag_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
							  			'<label for="inputPassword3" class="col-sm-2 control-label">Tag</label>'+
							  			'<div class="col-sm-10">'+
							  				'<input type="text" name="slider_tag_popup" class="form-control" id="slider_tag_popup" value="'+ response.data[0].alt_tag +'"/>'+
							  				'<div class="text-danger" id="slider_tag_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
						  			'<div class="col-sm-offset-2 col-sm-10">'+
						  				'<input type="button" class="btn btn-primary" id="slider_update_popup_submit" value="update">'+
						  			'</div>'+
						  		'</div>'+
							  	'</div>'+
							  '</form>';
						$('#loader-1 .modal-body').html(x);
						$('#loader-1').modal({
        	    			show : true,
        	    			backdrop : false,
        	    			keyboard: false
        	    		});
						
//						$('#image_upload_preview').attr('src',baseUrl+'Slider_gallary/'+ response.data[0].lang_id +'/'+response.data[0].slider_image);
//						$('#slider_id').val(response.data[0].s_id);
//						$('#slider_alt').val(response.data[0].alt_tag);
//						$('#slider_order').val(response.data[0].sort);
//						$('#slider_update').show();
//						$('#slider_create').hide();
					}
					else{
					}
				}
		});
	});
	
	
	$(document).on('click','.slider_published',function(){
		var x = confirm('Are you sure.');
		if(!x){
			if($(this).prop('checked') == true){
				$(this).prop('checked', false);
			}
			else{
				$(this).prop('checked', true);
			}
		}
		else{
			var status = $(this).prop('checked');
			var s_id = $(this).data('slider_id');
			$.ajax({
				type: 'POST',
				url: baseUrl+'admin/Slider_ctrl/slider_publish',
				dataType: "json",
				data: {
					's_id'	: s_id,
					'status' : status
				},
				beforeSend: function(){
					$('#loader').modal({'show':true});	
				},
				complete: function(){},
				success:function (response) {
					console.log(response);
					$('#loader').modal('toggle');
				}
			});
		}
	});
	
	$(document).on('click','.slider_delete',function(){
		var x = confirm('Are you sure.'); 
		if(x){
			var s_id = $(this).data('slider_id');
			$.ajax({
				type: 'POST',
				url: baseUrl+'admin/Slider_ctrl/slider_delete',
				dataType: "json",
				data: {
					's_id'	: s_id
				},
				beforeSend: function(){
					$('#loader').modal({'show':true});	
				},
				complete: function(){},
				success:function (response) {
					console.log(response);
					$('#loader').modal('toggle');
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.slider_tranlate',function(){
		var slider_id = $(this).data('slider_id');
		
		$.ajax({
			type: 'POST',
			url: baseUrl+'admin/Slider_ctrl/get_slider_content',
			dataType: "json",
			data: {
				's_id'	: slider_id
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){},
				success:function (response) {
					console.log(response);
					if(response.status == 200){
						$('#loader').modal('toggle');	
						$('#loader-1 #myModalLabel').html('slider update');
						$('#loader-1 .modal-footer').hide();
						var x = '<form name="f1" id="slider_update_popup" method="POST" enctype="multipart/form-data" action="'+ baseUrl +'admin/Slider_ctrl/slider_update_subadmin" class="form-horizontal">'+
							  		'<div class="form-group">'+
							  			'<label for="inputEmail3" class="col-sm-2 control-label">Email</label>'+
							  			'<div class="col-sm-10">'+
							  				'<img width="30" src="'+baseUrl+'/Slider_gallary/'+ response.data[0].lang_id +'/'+ response.data[0].slider_image +'" id="image_preview_popup">'+
							  				'<input type="file" name="file" id="slider_photo_popup" class="form-control">'+
							  				'<input type="hidden" name="slider_id_popup" class="form-control" id="slider_id_popup" value="'+ slider_id +'">'+
							  				'<div class="text-danger" id="slider_photo_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
							  			'<label for="inputPassword3" class="col-sm-2 control-label">Tag</label>'+
							  			'<div class="col-sm-10">'+
							  				'<input type="text" name="slider_tag_popup" class="form-control" id="slider_tag_popup" value="'+ response.data[0].alt_tag +'"/>'+
							  				'<div class="text-danger" id="slider_tag_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
						  			'<div class="col-sm-offset-2 col-sm-10">'+
						  				'<input type="button" class="btn btn-primary" id="slider_update_popup_submit" value="update">'+
						  			'</div>'+
						  		'</div>'+
							  	'</div>'+
							  '</form>';
						$('#loader-1 .modal-body').html(x);
					}
					else{
						$('#loader').modal('toggle');
						$('#loader-1 #myModalLabel').html('slider update');
						$('#loader-1 .modal-footer').hide();
						//$('#loader .modal-footer').html('<input type="button" class="btn btn-primary" id="slider_update_popup" value="update">');
						var x = '<form name="f1" id="slider_update_popup" method="POST" enctype="multipart/form-data" action="'+ baseUrl +'admin/Slider_ctrl/slider_update_subadmin" class="form-horizontal">'+
							  		'<div class="form-group">'+
							  			'<label for="inputEmail3" class="col-sm-2 control-label">Email</label>'+
							  			'<div class="col-sm-10">'+
							  				'<input type="file" name="file" id="slider_photo_popup" class="form-control">'+
							  				'<input type="hidden" name="slider_id_popup" class="form-control" id="slider_id_popup" value="'+ slider_id +'">'+
							  				'<div class="text-danger" id="slider_photo_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
							  			'<label for="inputPassword3" class="col-sm-2 control-label">Tag</label>'+
							  			'<div class="col-sm-10">'+
							  				'<input type="text" name="slider_tag_popup" class="form-control" id="slider_tag_popup" />'+
							  				'<div class="text-danger" id="slider_tag_popup_error" style="display:none;"></div>'+
							  			'</div>'+
							  		'</div>'+
							  		'<div class="form-group">'+
						  			'<div class="col-sm-offset-2 col-sm-10">'+
						  				'<input type="button" class="btn btn-primary" id="slider_update_popup_submit" value="update">'+
						  			'</div>'+
						  		'</div>'+
							  	'</div>'+
							  '</form>';
						$('#loader-1 .modal-body').html(x);
					}
				}
		});
		
		$('#loader-1').modal({
			show : true,
			keyboard : false,
			backdrop : false
		});
	});
	
	
	$(document).on('click','#slider_update_popup_submit',function(){
		 var form_valid = true;
		 var alt_tag = $('#slider_tag_popup').val();
		 var s_id = $('#slider_id_popup').val();
		 var image = $('#image_preview_popup').attr('src');	
		 var sort = $('#slider_id_sort').val();
		 if(image == ''){
			 if($('#slider_photo_popup').val() == ''){
					$('#slider_photo_popup_error').html('Please select image for slider.').css('display','block');
					form_valid = false;
				}
			 else{
					$('#slider_photo_popup_error').css('display','none');
				} 
		 }
		 
		if(alt_tag == ''){
			$('#slider_tag_popup_error').html('Please enter image tags for slider.').css('display','block');
			form_valid = false;
		}
		if(alt_tag.length < 3){
			$('#slider_tag_popup_error').html('tag is not valid.').css('display','block');
			form_valid = false;
		}
		else{
			$('#slider_tag_popup_error').css('display','none');
		}
		if(form_valid){
			$('#slider_update_popup').ajaxForm({
			    dataType : 'json',
			    data : {
			    },
			    beforeSubmit:function(e){
					$('#loader').modal('show');
			    },
			    success:function(response){
			  	  if(response.status == 200){
			    	$('#loader').modal('toggle');
			    	alert(response.msg);
			    	location.reload();
			      }
			      else{
				    alert(response.msg);
			      }
			    }
		  }).submit();
		}
	});
//////////////////////////////////////////////////////Videos///////////////////////////////////////////////////////////////////////////////////	
	$(document).on('click','#video_create',function(){
		 var form_valid = true;
		var v_desc= CKEDITOR.instances.v_desc.getData();
		 var v_url=$(this).data('v_url');
		 
		 if($('#v_url').val() == ''){
				$('#v_url_error').html('Please Enter Url For Video.').css('display','block');
				form_valid = false;
			}
		 else{
				$('#v_url_error').css('display','none');
			}
		 
		 if($('#v_title').val() == ''){
			 $('#v_title_error').html('please Fill Video Title').css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_title_error').css('display','none');
		 }
		 
		 if($('v_desc') == ''){
			 $('#v_desc_error').html('please Fill Video Description').css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_desc_error').css('display','none');
		 }
		 
		 if($('#v_order').val()==''){
			 $('#v_order_error').html("please Fill Video Sort Order").css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_order').css('display','none');
		 }
		 

		 if($('#v_category').val()=='0'){
			 $('#v_category_error').html("please select video category").css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_category').css('display','none');
		 }
		 
		if(form_valid){
			$('#video_form').ajaxForm({
				dataType : 'json',
				data: {
					'v_desc'	: v_desc,
				},
				beforeSubmit:function(e){
					$('#loader').modal('show');
			    },
			    success:function(response){
			  	  if(response.status == 200){
			    	$('#loader').modal('toggle');
			    	alert(response.msg);
			    	location.reload();
			      }
			      else{
				    alert(response.msg);
			      }
			    }
			}).submit();
		}
	});	

	$(document).on('click','.video_published',function(){
	var x = confirm('Are you sure.');
	if(!x){
		if($(this).prop('checked') == true){
			$(this).prop('checked', false);
		}
		else{
			$(this).prop('checked', true);
		}
	}
	else{
		var status = $(this).prop('checked');
		var v_id = $(this).data('video_id');
		$.ajax({
			type: 'POST',
			url: baseUrl+'admin/Video_ctrl/video_publish',
			dataType: "json",
			data: {
				'v_id'	: v_id,
				'status' : status
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){},
			success:function (response) {
				console.log(response);
				$('#loader').modal('toggle');
			}
		});
	}
});
	$(document).on('click','.video_delete',function(){
		var x = confirm('Are you sure.'); 
		if(x){
			var v_id = $(this).data('video_id');
			$.ajax({
				type: 'POST',
				url: baseUrl+'admin/Video_ctrl/video_delete',
				dataType: "json",
				data: {
					'v_id'	: v_id
				},
				beforeSend: function(){
					$('#loader').modal({'show':true});	
				},
				complete: function(){},
				success:function (response) {
					console.log(response);
					$('#loader').modal('toggle');
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.video_edit,.video_tranlate',function(){
		var v_id= $(this).data('video_id');
		$.ajax({
			type: 'post',
			url: baseUrl+'admin/Video_ctrl/get_video_data',
			dataType: "json",
			data:{
				'v_id'  :  v_id
			},
			beforeSend: function(){
				$('#loader').modal({'show': true});
			},
			complete: function(){},
			success: function (response){
				console.log(response);
	        	$('#loader').modal('toggle');
	        	if(response.status == 200){
	        		CKEDITOR.instances['v_desc'].setData(response.data[0].v_content);
	        		$('#video_id').val(response.data[0].v_id);
	        		$('#v_order').val(response.data[0].sort);
	        		$('#v_url').val(response.data[0].v_url);
	        		$('#v_title').val(response.data[0].v_title);
	        		$('#v_category').val(response.data[0].category_id);
	        		$('#video_update').show();
	        		$('#video_create').hide();
	        	}
	        	else{
	        		
	        	}
			}
		});
	});
	
	$(document).on('click','#video_update',function(){
		var form_valid = true;
		 if($('#v_url').val() == ''){
				$('#v_url_error').html('Please Enter Url For Video.').css('display','block');
				form_valid = false;
			}
		 else{
				$('#v_url_error').css('display','none');
			}
		 
		 if($('#v_title').val() == ''){
			 $('#v_title_error').html('please Fill Video Title').css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_title_error').css('display','none');
		 }
		 
		 if($('v_desc') == ''){
			 $('#v_desc_error').html('please Fill Video Description').css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_desc_error').css('display','none');
		 }
		 
		 if($('#v_order').val()==''){
			 $('#v_order_error').html("please Fill Video Sort Order").css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_order_error').css('display','none');
		 }
		 if($('#v_category').val()=='0'){
			 $('#v_category_error').html("please select video category").css('display','block');
			 form_valid = false;
		 }
		 else{
			 $('#v_category_error').css('display','none');
		 }
		 
			 if(form_valid){
			var v_id = $('#video_id').val();
			var v_url = $('#v_url').val();
			var v_desc = CKEDITOR.instances.v_desc.getData();
			var v_title = $('#v_title').val();
			var v_sort = $('#v_order').val();
			var v_category = $('#v_category').val();

			$.ajax({
				type : 'post',
				url : baseUrl+'admin/Video_ctrl/update_video',
				dataType : "json",
				data: {
					'v_id' : v_id,
					'v_url' : v_url,
					'v_desc': v_desc,
					'v_title':v_title,
					'v_sort':v_sort,
					'v_category':v_category
				},
				beforeSend: function(){
					$('#loader').modal({'show': true});
				},
				complete: function(){},
				success:function(response){
				  	  if(response.status == 200){
				    	$('#loader').modal('toggle');
				    	alert(response.msg);
				    	location.reload();
				      }
				      else{
					    alert(response.msg);
				      }
				    }
				});
		 }
	});
	
////////////////////////////////////////////////////////////video_category /////////////////////////////////////////////////////////////	

	$(document).on('click','#v_category_create,#v_category_update',function(){
		
		var form_valid = true;
		if($('#v_category_name').val() == ''){
			$('#v_category_name_error').html('Please Enter Video Category.').css('display','block');
			form_valid = false;
		}
	 else{
			$('#v_category_name_error').css('display','none');
		}
		
		if($('#v_category_parent_drop_down').val() == '0'){
			$('#v_category_parent_drop_down_error').html('Please Enter Parent Video Category.').css('display','block');
			form_valid = false;
		}
	 else{
			$('#v_category_parent_drop_down_error').css('display','none');
		}
		
		$('#video_cat_form').ajaxForm({
		    dataType : 'json',
		    data : {
		    },
		    beforeSubmit:function(e){
				$('#loader').modal('show');
		    },
		    success:function(response){
		    	console.log(response);
		  	  if(response.status == 200){
		    	$('#loader').modal('toggle');
		    	alert(response.msg);
		    	//location.reload();
		      }
		      else{
			    alert(response.msg);
		      }
		    }
	  }).submit();
	});
	
	$(document).on('click','.v_cat_list_item',function(){
		var vc_id = $(this).data('vc_id'); 
		$.ajax({
			type : 'post',
			url : baseUrl+'admin/Video_ctrl/category_detail',
			dataType : "json",
			data: {
				'vc_id' : vc_id
			},
			beforeSend: function(){
				$('#loader').modal({'show': true});
			},
			complete: function(){},
			success:function(response){
				if(response.status==200){
					$('#v_cat_id').val(response.data[0].v_id)
					$('#v_category_name').val(response.data[0].category_name);
					$('#v_category_parent_drop_down').val(response.data[0].p_id);
				}
				$('#loader').modal('toggle');
			}
		});
	});
	
	$(document).on('click','.video_is_home',function(){
		var x = confirm('Are You Sure');
		if(!x){
			if($(this).prop('checked')==true){
				$(this).prop('checked',false);
			}
			else{
				$this.prop('checked',true);
			}
		}
		else{
			var status1=$(this).prop('checked');
			var v_id=$(this).data('video_id');
			$.ajax({
				type  :		'post',
				url   :      baseUrl+'admin/video_ctrl/video_is_home',
				dataType : "json",
				data  :      {
					'status1' :  status1,
					'v_id'    :  v_id
				},
				beforesend : function(){
					$('#loader').modal({'show' : true});
				},
				complete: function(){},
				success: function(response){
					console.log(response);
					console.log(response.status);
					$('#loader').modal('hide');
				}
			});
		}
	});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////f	
	
	$(document).on('click','.file_clr',function(){
		var soft_files =  $(this).data('file');
		alert (soft_files);
		$.ajax({
			type  :		'post',
			url   :      baseUrl+'admin/Cache_ctrl/cache_clear',
			dataType: "json",
			data  :      {
				'soft_files' :  soft_files
				
			},
			beforesend : function(){
				$('#loader').modal({'show' : true});
			},
			complete: function(){},
			success: function(response){
				console.log(response);
				if(response.status == 200){
					$('#loader').modal('hide');
				}
				else{
					alert('Something went gone wrong.');
				}
			}
		});
		
	});

////////////////////////////////////////////////////USER PROFILE///////////////////////////////////////////////////////////////////////////
	
//	function filePreview(input) {
//		if (input.files && input.files[0]) {
//	        var reader = new FileReader();
//	        reader.onload = function (e) {
//	            $('#profile_form + img').remove();
//	            $('#profile_form').after('<img src="'+e.target.result+'" width="450" height="300"/>');
//	        }
//	        reader.readAsDataURL(input.files[0]);
//	    }
//	}
	$("#userFiles").change(function () {
	    // filePreview(this);
	});
	
	$(document).on('click','#profile_update',function(){
		var form_valid = true;
		 if($('#f_name').val() == ''){
				$('#f_name_error').html('Please Fill First Name.').css('display','block');
				form_valid = false;
			}
		 else{
				$('#f_name_error').css('display','none');
			}
		 if($('#l_name').val() == ''){
				$('#l_name_error').html('Please Fill Last Name.').css('display','block');
				form_valid = false;
			}
		 else{
				$('#l_name_error').css('display','none');
			}
		 if($('#contact').val() == ''){
				$('#contact_error').html('Please Fill Contact Field.').css('display','block');
				form_valid = false;
			}
		 else{
				$('#contact_error').css('display','none');
			}
//		 if($('#email').val() == ''){
//				$('#email_error').html('Please Fill Email Field.').css('display','block');
//				form_valid = false;
//			}
//		 else{
//				$('#email_error').css('display','none');
//			}
		 
		 var uid = $('#uid').val();
		if(form_valid){
			$('#profile_form').ajaxForm({
				dataType : 'json',
				data: {},
				beforeSubmit:function(e){
					$('#loader').modal('show');
			    },
			    success:function(response){
			  	  if(response.status == 200){
			    	$('#loader').modal('toggle');
			    	alert(response.msg);
			    	location.reload();
			      }
			      else{
				    alert(response.msg);
			      }
			    }
			}).submit();
		}
	});
	
/////////////////////////////////////////////////////Image Onchange//////////////////////////////////////////////////////////////////////
	
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('.img-circle').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#myImg").change(function(){
	    readURL(this);
	});
	
//////////////////User Lang Handle/////////////////////////
	$(document).on('click','#upd_lang_file',function(){
			var user_lang = $('#user_lang').val();
			alert(user_lang); 
			$.ajax({
				type: 'POST',
				url: baseUrl+'admin/Lang_ctrl/upd_lang_file',
				dataType: "json",
				data: {
					'user_lang'	: user_lang
				},
				beforeSend: function(){
					$('#loader').modal({'show':true});	
				},
				complete: function(){},
				success:function (response) {
					console.log(response);
					$('#loader').modal('toggle');
					location.reload();
				}
			});
	});

          $(document).on('click','#widget_reset,#video_reset,#slider_reset,#event_reseet,#link_reset,#news_reset,#menu_reset,#u_reg_reset,#users_language_reset,#language_reset,#user_profile_reset,#user_password_reset,#trainning_reset,#story_reset,#ocmmodity_reset',function(){
		location.reload();
	});

    
	
});

function language_form_check(){
	var pattern =  new RegExp("^[a-zA-Z]*$");
	if($('#language_name_eng').val() != '' && $("#language_name").val() != ''){
                if((pattern.test($('#language_name_eng').val()))) {
			$("#language_create").attr("disabled", false);
		}
		else{
			$("#language_create").attr("disabled", 'disabled');
		}
	}

	
}
