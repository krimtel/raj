<?php $group = $this->session->userdata('group_name'); ?>
<?php 
	$wiget_drop_Down = '';
	foreach($widgets as $widget){
		$wiget_drop_Down .= '<option value="'.$widget['w_id'].'">'.$widget['name'].'</option>'; 
	}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">New Page</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
		<section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">New Page</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="page_add_form" name="f1" method="POST" role="form" class="form-horizontal" action="<?php echo base_url();?>admin/Page_ctrl/page_create">
			<div class="box-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">Page Name</label>
					<div class="col-sm-9">
						<input id="page_name" name="page_name" type="text" class="form-control" placeholder="Enter new language" value="<?php if(isset($page_details)){ echo $page_details['0']['page_name']; }?>">
						<div class="text-danger" id="page_name_error" style="display:none;"></div>
					</div>
					<div class="col-sm-12">
						<input type="hidden" id="page_id" name="page_id" class="form-control" value="<?php if(isset($page_details)){echo $page_details[0]['p_id'];}?>">
					</div>
				</div>
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Select Layout</label>
					<div class="col-sm-9">
						<select class="form-control" name="page_layout" id="page_layout">
						<?php if(isset($page_details)){ ?>
							<option value="0" >Please select layout</option>
							<option value="1" <?php if($page_details['0']['page_layout'] == 1){ echo "selected"; }?>>1 column</option>
							<option value="2" <?php if($page_details['0']['page_layout'] == 2){ echo "selected"; }?>>2 columns</option>
							<option value="3" <?php if($page_details['0']['page_layout'] == 3){ echo "selected"; }?>>3 columns</option>
						<?php } else { ?>
							<option value="0" selected>Please select layout</option>
							<option value="1" >1 column (No Sidebar)</option>
							<option value="2" >2 columns (Left Sidebar)</option>
							<option value="3" >3 columns (Both Sidebar)</option>
						<?php } ?>
						</select>
						<div class="text-danger" id="page_layout_error" style="display: none;"></div>
					</div>
				</div>
				<?php } ?>
				<!--  -->
				<div class="form-group" id="1coumn" style="display: none;">
					<label class="col-sm-2 control-label">Select Layout</label>
					<div class="col-sm-9">
							<table class="table table-bordered">
							<tr><th>Main</th></tr>
							<tr>
								<td>
									<div id="one_col_maincontent_box"></div>
									<input type="button" id="one_col_main_addmore" value="Add more" class="btn btn-default">
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="form-group" id="2coumn" style="display: none;">
					<label class="col-sm-2 control-label">Select Layout</label>
					<div class="col-sm-9">
						<table class="table table-bordered">
							<tr>
								<th>Left</th>
<!-- 								<th>Main</th> -->
							</tr>
							<tr>
								<td>
									<div id="two_col_leftcontent_box"></div>
									<input type="button" id="two_col_leftcontent_addmore" value="Add more" class="btn btn-default">
								</td>
<!-- 								<td> -->
<!-- 									<div id="two_col_maincontent_box"></div> -->
<!-- 									<input type="button" id="two_col_maincontent_addmore" value="Add more" class="btn btn-default"> -->
<!-- 								</td> -->
							</tr>
						</table>
					</div>
				</div>
				
				<div class="form-group" id="3coumn" style="display: none;">
					<label class="col-sm-2 control-label">Select Layout</label>
					<div class="col-sm-9">
						<table class="table table-bordered">
							<tr>
								<th>Left</th>
<!-- 								<th>Main</th> -->
								<th>Right</th>
							</tr>
							<tr>
								<td>
									<div id="three_col_leftcontent_box"></div>
									<input type="button" id="three_col_leftcontent_addmore" value="Add more" class="btn btn-default">
								</td>
<!-- 								<td> -->
<!-- 									<div id="three_col_maincontent_box"></div> -->
<!-- 									<input type="button" id="three_col_maincontent_addmore" value="Add more" class="btn btn-default"> -->
<!-- 								</td> -->
								<td>
									<div id="three_col_rightcontent_box"></div>
									<input type="button" id="three_col_rightcontent_addmore" value="Add more" class="btn btn-default">
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!--  -->
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Meta tags</label>
					<div class="col-sm-9">
						<textarea name="meta_tag" id="meta_tag" rows="5" cols="" class="form-control"><?php if(isset($page_details)){echo $page_details[0]['meta_tag'];}?></textarea>
						<div class="text-danger" id="meta_tag_error" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Key words</label>
					<div class="col-sm-9">
						<textarea rows="5" name="keyword" id="keyword" cols="" class="form-control"><?php if(isset($page_details)){echo $page_details[0]['keywords'];}?></textarea>
						<div class="text-danger" id="keyword_error" style="display:none;"></div>
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Page Body</label>
					<div class="col-sm-9">
						<textarea rows="5" name="page_body" id="page_body" cols="" class="form-control"><?php if(isset($page_details)){echo $page_details[0]['page_body'];}?></textarea>
						<script>
			                CKEDITOR.replace('page_body');
			            </script>
						<div class="text-danger" id="page_body_error" style="display:none;"></div>
					</div>
				</div>
            </div>
			</form>
			<div class="box-footer">
				<?php if(isset($page_details)){ ?>
					<button id="page_update" type="submit" class="btn pull-right btn-info">Update</button>
				<?php } else {?>
					<button id="page_create" type="submit" class="btn pull-right btn-info">Save</button>
				<?php }?>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
			</div>
		</div>
		</section>
		</div>
		</section>
		
<div class="sort-code-box">
	<div class="sort-code-head sort-head-title">Sort Code <span class="pull-right"><i class="fa fa-minus"></i></span></div>
	<div class="sort-code-body">
		<ul class="sort-code-body-sec">
			<li>14</li>
			<li>12</li>
			<li>11</li>
		</ul>
	</div>
</div>
</div>


<script>
$(document).ready(function(){
    $(".sort-head-title").click(function(){
        $(".sort-code-body").slideToggle();
    });
});
</script>
<script>
$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	var uGroup = $('#u_group').val();
	
	var x = $("#page_layout").val();
	
	if(x == 1){
		$('#1coumn').hide();
		$('#2coumn').hide();
		$('#3coumn').hide();

		var page_id = $('#page_id').val();	
		$.ajax({
	        type: 'POST',
	        url: baseUrl+'admin/Ajax_ctrl/get_all_widgets',
	        dataType: "json",
	        data: {
		        'page_id' : page_id
		       },
	        beforeSend: function(){
	        	//$('#loader').modal('show');	
	        },
	        success:function (response) {
	        	$.each(response.data2,function(k,v){
	        		var x = '';
	        		$.each(response.data,function(key,value){
		        		if(value.w_id == v.widget_id){
		        			x = x + '<option value="'+ value.w_id +'" selected>'+ value.name +'</option>';
		        		}
		        		else{
		        			x = x + '<option value="'+ value.w_id +'">'+ value.name +'</option>';
		        		}
		        	});

	        		x = x + '<option value="'+ value.news_id +'">'+ value.news_content +'</option>';
		        	
					if(v.section == 'main_body'){
						var dropdown = '<select class="form-control col-sm-6" name="one_col_maincontent[]" id="">'+
						'<option value="0">select widget</option>'+
						x +
						'</select>';
						$('#one_col_maincontent_box').prepend(dropdown);
					}
		        });
	        }
		});
	}
	else if(x == 2){
		$('#1coumn').hide();
		$('#2coumn').show();
		$('#3coumn').hide();
		
		var page_id = $('#page_id').val();	
		$.ajax({
	        type: 'POST',
	        url: baseUrl+'admin/Ajax_ctrl/get_all_widgets',
	        dataType: "json",
	        data: {
		        'page_id' : page_id
		       },
	        beforeSend: function(){
// 	        	$('#loader').modal({'show':true});	
	        },
	        complete: function(){},
	        success:function (response) {
		        console.log(response);
	        	$.each(response.data2,function(k,v){
	        		var x = '';
	        		var find = 0;
	        		$.each(response.data,function(key,value){
		        		if(value.w_id == v.widget_id){
		        			x = x + '<option value="'+ value.w_id +'" selected>'+ value.name +'</option>';
		        			find = 1;
		        		}
		        		else{
		        			x = x + '<option value="'+ value.w_id +'">'+ value.name +'</option>';		        		
		        		}
		        	});

					if(find){
						x = x + '<option value="-1">News</option>'+
	        			'<option value="-2">Slider</option>'+
	        			'<option value="-3">Quick Link</option>'+
	        			'<option value="-4">Event</option>'+
	        			'<option value="-5">Videos</option>'+
	        			'<option value="-6">Contact Us</option>';
					}
					else{
						if(v.widget_id == '-1'){
		        			x = x + '<option value="-1" selected>News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-2'){
		        			x = x + '<option value="-2" selected>Slider</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-3'){
		        			x = x + '<option value="-3" selected>Quick Link</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-4'){
		        			x = x + '<option value="-4" selected>Event</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-5'){
		        			x = x + '<option value="-5" selected>Videos</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-6'){
		        			x = x + '<option value="-6" selected>Contact Us</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>';
		        		}
					}
		        	
	        		
					if(v.section == 'left_col'){
						var dropdown = '<select class="form-control col-sm-6" name="two_col_leftcontent[]" id="">'+
						'<option value="0">select widget</option>'+
						x +
						'</select>';
		        		$('#two_col_leftcontent_box').append(dropdown);
					}
// 					else{
// 						var dropdown = '<select class="form-control col-sm-6" name="two_col_maincontent[]" id="">'+
// 						'<option value="0">select widget</option>'+
// 						x +
// 						'</select>';
// 						$('#two_col_maincontent_box').prepend(dropdown);
// 					}
		        });
// 	        	$('#loader').modal('toggle');
	        }
		});
	}
	else if(x == 3){
		$('#1coumn').hide();
		$('#2coumn').hide();
		$('#3coumn').show();

		var page_id = $('#page_id').val();	
		$.ajax({
	        type: 'POST',
	        url: baseUrl+'admin/Ajax_ctrl/get_all_widgets',
	        dataType: "json",
	        data: {
		        'page_id' : page_id
		       },
	        beforeSend: function(){
// 	        	$('#loader').modal({'show':true});	
	        },
	        complete: function(){},
	        success:function (response) {
	        	$.each(response.data2,function(k,v){
	        		var x = '';
	        		var find = 0;
	        		$.each(response.data,function(key,value){
		        		if(value.w_id == v.widget_id){
		        			x = x + '<option value="'+ value.w_id +'" selected>'+ value.name +'</option>';
		        			find = 1;
		        		}
		        		else{
		        			x = x + '<option value="'+ value.w_id +'">'+ value.name +'</option>';
		        		}
		        	});

	        		if(find){
						x = x + '<option value="-1">News</option>'+
	        			'<option value="-2">Slider</option>'+
	        			'<option value="-3">Quick Link</option>'+
	        			'<option value="-4">Event</option>'+
	        			'<option value="-5">Videos</option>'+
	        			'<option value="-6">Contact Us</option>';
					}
					else{
						if(v.widget_id == '-1'){
		        			x = x + '<option value="-1" selected>News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-2'){
		        			x = x + '<option value="-2" selected>Slider</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-3'){
		        			x = x + '<option value="-3" selected>Quick Link</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-4'){
		        			x = x + '<option value="-4" selected>Event</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-5">Videos</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-5'){
		        			x = x + '<option value="-5" selected>Videos</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-6">Contact Us</option>';
		        		}
		        		else if(v.widget_id == '-6'){
		        			x = x + '<option value="-6" selected>Contact Us</option>'+
		        			'<option value="-1">News</option>'+
		        			'<option value="-2">Slider</option>'+
		        			'<option value="-3">Quick Link</option>'+
		        			'<option value="-4">Event</option>'+
		        			'<option value="-5">Videos</option>';
		        		}
					}
		        	
					if(v.section == 'left_col'){
						var dropdown = '<select class="form-control col-sm-6" name="three_col_leftcontent[]" id="">'+
						'<option value="0">select widget</option>'+
						x +
						'</select>';
		        		$('#three_col_leftcontent_box').append(dropdown);
					}
// 					else if(v.section == 'main_body'){
// 						var dropdown = '<select class="form-control col-sm-6" name="three_col_maincontent[]" id="">'+
// 						'<option value="0">select widget</option>'+
// 						x +
// 						'</select>';
// 						$('#three_col_maincontent_box').prepend(dropdown);
// 					}
					else{
						var dropdown = '<select class="form-control col-sm-6" name="three_col_rightcontent[]" id="">'+
						'<option value="0">select widget</option>'+
						x +
						'</select>';
						$('#three_col_rightcontent_box').append(dropdown);
					}
		        });
// 	        	$('#loader').modal('toggle');
	        }
		});
	}
	else{
		$('#1coumn').hide();
		$('#2coumn').hide();
		$('#3coumn').hide();
	}
});
</script>