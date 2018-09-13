<div class="col-sm-12 well">
	<form id="commodity_form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url();?>admin/Commodity_ctrl/commodity_update" enctype= "multipart/form-data">
		<div class="form-group">
		    <label class="col-sm-2 control-label">commodity</label>
		    <div class="col-sm-10">
		      <select class="form-control" id="commodity">
		      		<option value="0">Select commodity</option>
		      	<?php if(isset($commodities) && (count($commodities)>0)){ ?>
		      		<?php foreach($commodities as $commodity){ ?>
		      			<option value="<?php echo $commodity['c_id'];?>"><?php echo $commodity['commodity_name']; ?></option>
		      		<?php } ?>
		      	<?php } ?>
		      </select>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Commodity Id</label>
		    <div class="col-sm-10">
		      <input type="text" name="commodity_id" id="commodity_id" class="form-control" />
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Commodity Name</label>
		    <div class="col-sm-10">
		      <input type="text" name="commodity_name" id="commodity_name" class="form-control" />
		    </div>
		  </div>
	
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Commodity Image</label>
		    <div class="col-sm-10">
		      <input type="file" name="commodity_image_select" id="commodity_image_select" class="form-control" />
		    </div>
		  </div>	  
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Commodity Image</label>
		    <div class="col-sm-10">
		      <img src="#" id="commodity_image" >
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label"> Commodity parameter title </label>
		    <div class="col-sm-10">
		      <textarea id="commodity_parameter_title" name="commodity_parameter_title" class="form-control" rows="4"></textarea>
					<div class="text-danger" id="commodity_parameter_title" style="display:none;"></div>
		            <script>
		                CKEDITOR.replace('commodity_parameter_title');
		            </script>
		    </div>
	   </div>
	   <div class="form-group">
		    <label class="col-sm-2 control-label"> Commodity parameter contant </label>
		    <div class="col-sm-10">
		      <textarea id="commodity_parameter_content" name="commodity_parameter_content" class="form-control" rows="4"></textarea>
					<div class="text-danger" id="commodity_parameter_content" style="display:none;"></div>
		            <script>
		                CKEDITOR.replace('commodity_parameter_content');
		            </script>
		    </div>
	   </div>
		  
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <input type="button" name="submit" class="btn btn-primary" value="Update" id="submit_commodity">
		      <input type="reset" name="cancel" class="btn btn-primary" value="Cancel" id="reset_commodity">
		    </div>
		  </div>
	</form>
</div>

<script>
	var baseUrl = $('#base_url').val();
	$(document).on('change','#commodity',function(){
		var c_id = $(this).val();
		$.ajax({
			type: 'POST',
			url: baseUrl+'admin/Commodity_ctrl/commodity_detail',
			dataType: "json",
			data: {
				'c_id' : c_id
			},
			beforeSend: function(){},
			complete: function(){},
			success:function (response) {
				console.log(response);
				if(response.status == 200){
					$('#commodity_id').val(response.data[0].commodity_id);
					$('#commodity_name').val(response.data[0].commodity_name);
					$('#commodity_image').attr('src', baseUrl +'/assest/images/commodity-pro/' +response.data[0].image);
					CKEDITOR.instances['commodity_parameter_title'].setData(response.data2[0].comm_title);
					CKEDITOR.instances['commodity_parameter_content'].setData(response.data2[0].comm_desc);
				}
				else {
					
				}
			}
		});
	});
	
	$(document).on('click','#submit_commodity',function(){
		$('#commodity_form').ajaxForm({
		    dataType : 'json',
		    data : {
		    	'commodity_parameter_title' : CKEDITOR.instances.commodity_parameter_title.getData(),
		    	'commodity_parameter_content' : CKEDITOR.instances.commodity_parameter_content.getData(),	
		    	
		    },
		    beforeSubmit:function(e){
				$('#loader').modal('show');
		    },
		    success:function(response){
		    	console.log(response);
		  	  if(response.status == 200){
		    	$('#loader').modal('toggle');
		    	location.reload();
		      }
		      else{
			    alert(response.msg);
		      }
		    }
	  }).submit();
	});
</script>