 
<section class="title-header-bg">
	<div class="text-center">
		<h3>TRAINNING CALENDAR</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / Resources/ Trainning Calendar </span></div>

	</div>
</section> 


<section class="content-section apmc-training-sec" >
        <div class="container-fuild" style="padding-left:4%;padding-right:4%;padding-top:50px;padding-bottom:30px;">
<div class="col-md-12 well" style="margin-bottom:30px;">                
<div class="row">
                        
<div class="col-md-4">                                
<select class="form-control " id="training_state">
                                <option value="0">Select State</option>
                                </select>
</div>
<div class="col-md-4">  
                                <select class="form-control" id="training_apmc">
                                <option value="0">Select APMC</option>
                                </select>
</div>
<div class="col-md-4">  
 <input class="form-control" placeholder="Search APMC" type="text" id="training_apmc_search" />
</div>
<div class="col-md-4">
<input class="form-control" type="date" id="training_date_from" />
</div>

<div class="col-md-4">
<input class="form-control" type="date" id="training_date_to" />
</div>
<div class="col-md-4">
<button class="btn btn-success">Search</button>
<button type="button" class="btn btn-deafult" id="trainning_reset">Reset</button>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="pull-left" style="font-size:15px;margin-bottom:15px;margin-top:-15px;"><b>Your Search Result as follows:</b></div>
</div>
</div>	
<div class="row"><div class="col-md-12 video-gallery events-list" id="trainig_cand_list"></div></div>
                </div>
      
</section>
<style>
.expand-icon > a:before {
    float: right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 5px;
}
.expand-icon > a.collapsed:before {
    float: right !important;
    content:"\f067";
}
.expand-icon > a:hover, 
.expand-icon > a:active, 
.expand-icon > a:focus  {
    text-decoration:none;
}
</style>
<script>
	var baseUrl = $('#base_url').val();
	$.ajax({
        type: 'POST',
        url: baseUrl+'Ajax_ctrl/get_all_states',
        dataType: "json",
        data: {
        },
        beforeSend: function(){
        	$('#loader').modal({'show':true});	
        },
        complete: function(){},
        success:function (response) {
        	$('#loader').modal('toggle');
        	if(response.status == 200){
        		var x = '<option value="0">Select State</option>';
        		$.each(response.data,function(key,value){
        			x = x + '<option value="'+ value.state_code +'">'+ value.name +'</option>'; 
        		});
        	$('#training_state').html(x);
        	}
        }
	});
	
	$.ajax({
        type: 'POST',
        url: baseUrl+'Ajax_ctrl/get_all_training_data',
        dataType: "json",
        data: {
        },
        beforeSend: function(){
        	$('#loader').modal({'show':true});	
        },
        complete: function(){},
        success:function (response) {
        	$('#loader').modal('toggle');
        	if(response.status == 200){
        		var x = '';
        		var counter = 0;
        		var res_length = response.data.length;
        		$.each(response.data,function(key,value){
        			x = x + '<table class="table table-bordered table-striped">'+
	                    		'<thead>'+
	                            	'<tr>'+
	                            		'<th style="width:7%;" colspan="2">'+ value.state_name +'</th>'+
	                            		'<th style="width:10%;" colspan="3">'+ value.apmc_name +'</th>'+
	                            		'<th class="expand-icon" style="width:10%;text-align:center;" colspan="8"><a class="collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="demo_'+ counter +'" title="Expand" style="cursor:pointer;" data-target="#demo_'+ counter +'"><span style="font-size:13px;"><b>View</b></span> </a></th>'+
	                            	'</tr>'+
	                    		'</thead>';
	                    		if(value.round){
	                    			var y = '<tbody id="demo_'+ counter +'" class="collapse">'+
				                    			'<tr>'+
			                            		'<td>Round</td>'+
			                            		'<td>APMC code</td>'+
			                            		//'<td>Vendor</td>'+
			                            		'<td>Training Plan Date</td>'+
			                            		'<td>Training Date</td>'+
			                            		'<td>No. of Farmers Participated</td>'+
			                            		'<td>No. of Traders Participated</td>'+
			                            		'<td>No. of CA Participated</td>'+
			                            		'<td>APMC Staff Participated</td>'+
			                            		'<td>Other Participants</td>'+
			                            		'<td>Total Participants</td>'+
			                            		'<td>Feedback Score</td>'+
			                            	'</tr>';
	                    			$.each(value.round,function(k,v){
	                    				y = y + '<tr>'+
	                            					'<td>'+ k +'</td>'+
				                            		'<td>'+ v.apmc_id +'</td>'+
				                            		//'<td>'+ v.vendor +'</td>'+
				                            		'<td>'+ v.training_plan_date +'</td>'+
				                            		'<td>'+ v.training_date +'</td>'+
				                            		'<td>'+ v.no_of_farmer_participated +'</td>'+
				                            		'<td>'+ v.no_of_traders_participated +'</td>'+
				                            		'<td>'+ v.no_of_ca_participated +'</td>'+
				                            		'<td>'+ v.apmc_staff_participated +'</td>'+
				                            		'<td>'+ v.other_participants +'</td>'+
				                            		'<td>'+ v.total_participants +'</td>'+
				                            		'<td>'+ v.feedback_score +'</td>'+
                            					'</tr>';
	                    			})
	                    		}
	                    		x = x + y;
	                    		x = x + '</tbody>'+
            				'</table>';
            				counter++;
        		});
        		$('#trainig_cand_list').html(x);
        	}
        }
	});

         $(document).on('click','#trainning_reset',function(){
		location.reload();
	});
</script>