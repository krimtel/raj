<style>
.emandi-select select{float:left;margin-right:10px;}

.e-commodity-list{float:left;}
.commodity-img{float:left;}
.commodity-img span{text-align:center;float:left;width:100%;}
.panel-title > a:before {
float:right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 0px;
}
.panel-title > a.collapsed:before {

    content:"\f067";
}
.panel-title > a:hover, 
.panel-title > a:active, 
.panel-title > a:focus  {
    text-decoration:none;
}

.e-commodity-list img{width:100px;height:100px;margin-right:10px;margin-bottom:5px;margin-top:5px;border:1px solid #ddd;float:left;}
</style>

<section class="title-header-bg">
	<div class="text-center">
		<h3>ENAM MANDIS</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / eNAM Mandis </span></div>

	</div>
</section> 


<input type="hidden" id="state_id_url" value="<?php echo $this->uri->segment(2); ?>">
<input type="hidden" id="district_id_url" value="<?php echo $this->uri->segment(3); ?>">
<section class="content-section o-content-sec emandi-sec">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="col-md-12 well">
			<div class="row">			
				<div class="col-md-2 emandi-select">
					<select class="form-control" id="mandi_states">
						<option value="0">Select State</option>
					</select>
				</div>
				<div class="col-md-2 emandi-select">
					<select class="form-control" id="mandi_district">
						<option value="0">Select District</option>
					</select>
				</div>
				<div class="col-md-2 emandi-select">
					<select class="form-control"  id="mandi_mandi">
						<option value="0">Select Mandis</option>
					</select>
				</div>
				<div class="col-md-2 emandi-select">
					<select class="form-control" id="mandi_commodity">
						<option value="0">Select Commodity</option>
					</select>
				</div>
				<div class="col-md-2 emandi-select">
					<button class="btn btn-success">
						Search
					</button>
		            <button class="btn " type="button" id="emandi_reset">
						Reset
					</button>
				</div>		
			</div>	
		</div>	
	
	<div class="row">
		<div class="col-md-12">
			<div class="pull-left" style="font-size:15px;"><b>Your Search Result as follows:</b></div>
			<div class="pull-right"><b>Page:</b> <select class="mandi-pagi" class="form-control " id="mandi_page_count"><option value="0">0</option></select></div>
		</div>			
		<div class="col-md-12 emandi-list mandi-table">
			<table class="table table-striped table-bordered">
				<thead><tr><th>STATE</th><th>DISTRICT</th><th>MANDIS</th><th>ADDRESS</th><th>CONTACT NO.</th><th>MANDI COMMODITY</th></tr></thead>
			</table>
			<div class="panel-group" id="mandi_list" role="tablist" aria-multiselectable="true"></div>
		</div>
	</div>
</div>
</section>

<script>
var baseUrl = $('#base_url').val();
$.ajax({
    type: 'POST',
    url: baseUrl+'Mandi_ctrl',
    dataType: "json",
    data: {},
    beforeSend: function(){
		//$('#loader').modal({'show':true});
	},
    complete: function(){},
    success:function (response) {
    	mandi_data_render(response);
		//$('#loader').modal('toggle');
		set_data();
    }
});

function set_data(){
	console.log('set_data called.');
	var state_id = $('#state_id_url').val();
	var district_id = $('#district_id_url').val();
	$('#mandi_states').val(state_id);
	$( "#mandi_states" ).trigger( "change" );
	mandi_data_ajax();
	
}

$(document).on('change','#mandi_states',function(){
	$('#mandi_district').val(0);
	$('#mandi_mandi').val(0);
	$('#mandi_commodity').val(0);
	console.log('trigger');
	var id = $(this).val();
	var mandi_district = $('#district_id_url').val();
	
	$.ajax({
	    type: 'POST',
	    url: baseUrl+'Mandi_ctrl/district/'+id,
	    dataType: "json",
		asyn : false,
	    data: {},
	    beforeSend: function(){},
	    complete: function(){},
	    success:function (response) {
	    	console.log(response);
	    	if(response.status == 200){
	    		var x = '<option value="0">Select District</option>';
	    		$.each(response.data,function(key,value){
	    			x = x + '<option value="' + value.district_id + '">'+ value.district_name +'</option>';
	    		});
	    		$('#mandi_district').html(x);
				
				if(typeof(district_id) != "undefined" && district_id !== null) {
					$('#mandi_district').val(0);
				}
				else{
					$('#mandi_district').val(mandi_district);
				}
	    		mandi_data_ajax();
	    	}
	    	else{
	    		
	    	}
	    }
	});
});

$(document).on('change','#mandi_district',function(){
	var district_id = $("#mandi_district option:selected").text();
	var state_id = $('#mandi_states').val();
	$('#mandi_mandi').val(0);
	$('#mandi_commodity').val(0);
	$.ajax({
	    type: 'POST',
	    url: baseUrl+'Mandi_ctrl/manids/'+ district_id +'/'+ state_id,
	    dataType: "json",
	    data: {},
	    beforeSend: function(){},
	    complete: function(){},
	    success:function (response) {
	    	console.log(response);
	    	if(response.status == 200){
	    		var x = '<option value="0">Select Mandis</option>';
	    		$.each(response.data,function(key,value){
	    			x = x + '<option value="' + value.mandi_id + '">'+ value.mandi_name +'</option>';
	    		});
	    		$('#mandi_mandi').html(x);
	    		mandi_data_ajax();
	    	}
	    	else{
	    		
	    	}
	    }
	});
});

$(document).on('change','#mandi_mandi',function(){
	var mandi_id = $(this).val();
	$('#mandi_commodity').val(0);
	$.ajax({
	    type: 'GET',
	    url: baseUrl+'Mandi_ctrl/commodity/'+ mandi_id,
	    dataType: "json",
	    data: {},
	    beforeSend: function(){},
	    complete: function(){},
	    success:function (response) {
	    	console.log(response);
	    	if(response.status == 200){
	    		var x = '<option value="0">Select Commodity</option>';
	    		$.each(response.data,function(key,value){
	    			x = x + '<option value="' + value.commodity_id + '">'+ value.commodity_name +'</option>';
	    		});
	    		$('#mandi_commodity').html(x);
	    		mandi_data_ajax();
	    	}
	    	else{
	    		mandi_data_ajax();
	    	}
	    }
	});
});


$(document).on('change','#mandi_page_count,#mandi_commodity',function(){
	mandi_data_ajax();
});

$(document).on('click','.mandi_commodity_items',function(){
	var mandi_id = $(this).data('mandi_id');
	var collapse_id = $(this).data('collapse_id');
	$.ajax({
	    type: 'POST',
	    url: baseUrl+'Mandi_ctrl/commodity_list',
	    dataType: "json",
	    data: {
	    	'mandi_id' : mandi_id
	    },
	    beforeSend: function(){},
	    complete: function(){},
	    success:function (response) {
	    	console.log(response);
	    	if(response.status == 200){
	    		var x = '<div class="panel-body">';
	    		$.each(response.data,function(key,value){
	    			x = x + '<div class="emandi-list-d"><img alt="" src="'+baseUrl+'assest/images/commodity-pro/'+ value.image +'" /><br><span>'+ value.commodity_name +'</span> </div>';
	    		});
	    		x = x + '</div>';
	    		$('#'+collapse_id).html(x);
	    	}
	    	else{
	    		
	    	}
	    }
	});
});

function mandi_data_ajax(){
	//debugger;
	console.log('mandi_data_ajax');
	var mandi_states = $('#mandi_states').val();
	var mandi_district = $('#mandi_district').val();
	var mandi_mandi = 	$('#mandi_mandi').val();
	var mandi_commodity = $('#mandi_commodity').val();
	var page = $('#mandi_page_count').val();
	$.ajax({
	    type: 'POST',
	    url: baseUrl+'Mandi_ctrl/mandi_list',
	    dataType: "json",
	    data: {
	    	'mandi_states' : mandi_states,
	    	'mandi_district' : mandi_district,
	    	'mandi_mandi' : mandi_mandi,
	    	'mandi_commodity' : mandi_commodity,
	    	'page' : page
	    },
	    beforeSend: function(){
                //$('#loader').modal({'show':true});
             },
	    complete: function(){},
	    success:function (response) {
	    	console.log(response);
	    	if(response.status == 200){
	    		mandi_data_render(response);	
	    	}
	    	else{
	    		
	    	}
	    }
	});
}

function mandi_data_render(response){
	if(response.status == 200){
	    //$('#loader').modal({'show':true});
		var reminder = (response.count[0].total % 10);
    	if(reminder){
    		reminder = 1;
    	}
    	else{
    		reminder = 0;
    	}
    	var divided = parseInt(response.count[0].total / 10);
    	var pages = parseInt(divided + reminder);
    	var pages_dropdown = '';
    	for(var i = 0; i < pages; i++){
    		pages_dropdown = pages_dropdown + '<option value="'+ parseInt(i+1) +'">'+ i +'</option>';
    	}
    	$('#mandi_page_count').html(pages_dropdown);
    	if(typeof(response.page) != "undefined" && response.page !== null) {
    		$('#mandi_page_count').val(response.page);
    	}
    	
    	if(typeof(response.data) != "undefined" && response.data !== null) {
    		var x = '<option value="0">Select State</option>';
    		$.each(response.data,function(key,value){
    			x = x + '<option value="' + value.state_id + '">'+ value.state_name +'</option>';
    		});
    		$('#mandi_states').html(x);   
    	}
		
		var y = '';
		var c = 1;
		$.each(response.data2,function(key,value){
			y = y + '<div class="panel panel-default">'+
						'<div class="panel-heading" role="tab" id="headingOne">'+
      							'<table>'+
          							'<tr role="tab" id="headingOne">'+
										'<td>'+ value.state_name +'</td>'+
										'<td>'+ value.district_name +'</td>'+	
										'<td>'+ value.mandi_name +'</td>'+
										'<td>'+ value.address +'</td>'+
										'<td>'+ value.contact  +'</td>'+
										'<td class="panel-title"><a class="collapsed mandi_commodity_items" data-collapse_id="collapse_'+ c +'" data-mandi_id="'+ value.mandi_id +'" aria-expanded="false"  title="Expand"  data-target="#collapse_'+ c +'" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_'+ c +'"  aria-controls="collapse_'+c+'"><span style="font-size:13px;"><b>View</b></span> </a></td>'+
		 							'</tr>'+
								'</table>'+
						'</div>'+
						'<div id="collapse_'+c+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">'+
						'</div>'+
					'</div>';
		c = c + 1;
		});
		//$('#loader').modal('toggle');
		$('#mandi_list').html(y);
	}
	else{
	}
}
</script>