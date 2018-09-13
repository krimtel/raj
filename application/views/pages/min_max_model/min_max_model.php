 <section class="title-header-bg">
	<div class="text-center">
		<h3>MIN MAX MODEL PRICES</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / Market Data / Min Max Model Prices </span></div>

	</div>
</section>


<section class="content-section o-content-sec emandi-sec">
<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
<div class="row">
<?php date_default_timezone_set("America/New_York");
$date = date("Y-m-d");
?>
<div class="col-sm-12 well">
<input type="hidden" id="previous_date" value="<?php echo date('Y-m-d', strtotime($date .' -1 day'));?>">
<input type="hidden" id="current_date" value="<?php echo $date;?>">
<div class="col-md-2 emandi-select">
State
<select class="form-control" id="min_max_state">
	<option value="0">Select State</option>
</select>
</div>
<div class="col-md-2 emandi-select">
APMC
<select class="form-control" id="min_max_apmc">
	<option value="0">Select APMC</option>
</select>
</div>
<div class="col-md-2 emandi-select">
Commodity
<select class="form-control" id="min_max_commodity">
	<option value="0">Select Commodity</option>
</select>
</div>
<div class="col-md-2 emandi-select">From Date <input class="form-control" type="date" id="min_max_apmc_from_date" /></div>
<div class="col-md-2 emandi-select">To Date <input class="form-control" type="date" id="min_max_apmc_to_date" /></div>
<div class="col-md-2 emandi-select"><input style="margin-top:21px;" class="btn btn-success" type="button" value="Refresh" id="refresh"></div>
</div>

<div class="row">
<div class="col-md-12">
<div class="pull-left" style="font-size:15px;"><b>Your Search Result as follows:</b></div>
<div class="pull-right"><b>Page:</b> <select class="form-control mandi-pagi" name="min_max_no_of_list" id="min_max_no_of_list"></select></div>
</div>
<div class="col-md-12">	
<table class="table table-striped table-bordered table-responsive">
	<thead>
		<tr>
			<th>State</th>
			<th>APMC</th>
			<th>Commodity</th>
			<th>Min Price</th>
			<th>Modal Price</th>
			<th>Max Price</th>
			<th>Commodity Arrivals (in Quintal)</th>
			<th>Commodity Traded (in Quintal)</th>
		</tr>
	</thead>
	<tbody class="tbodya" id="data_list"></tbody>
</table>
</div>
</div>
</div>
</section>


<script type= "text/javascript">

function number_formate(num){
	var a = num;
	 var b = ",";
	 if(a.length == 4){
		 var position = 1;
		 var output = [a.slice(0, position), b, a.slice(position)].join('');
	 }
	 else if(a.length == 5){
		 var position = 2;
		 var output = [a.slice(0, position), b, a.slice(position)].join('');
	 }
	 else if(a.length == 6){
		 var position = 1;
		 var output = [a.slice(0, position), b, a.slice(position)].join('');
		 var position = 4;
		 var output = [output.slice(0, position), b, output.slice(position)].join('');
	 }
	 else if(a.length == 7){
		 var position = 2;
		 var output = [a.slice(0, position), b, a.slice(position)].join('');
		 var position = 5;
		 var output = [output.slice(0, position), b, output.slice(position)].join('');
	 }
	 else if(a.length == 8){
		 var position = 1;
		 var output = [a.slice(0, position), b, a.slice(position)].join('');
		 var position = 4;
		 var output = [output.slice(0, position), b, output.slice(position)].join('');
		 var position = 7;
		 var output = [output.slice(0, position), b, output.slice(position)].join('');
	 }
	 else{
		 var output = num;
	 }
	return output;
}



$('#min_max_apmc_from_date').val($('#previous_date').val());
$('#min_max_apmc_to_date').val($('#current_date').val());

get_all_state();
fetch_table_data();
$(document).on('change','#min_max_no_of_list',function(){
	var value = $(this).val();
	pagination(value);
});

$(document).on('change','#min_max_commodity,#min_max_apmc_from_date,#min_max_apmc_to_date',function(){
	fetch_table_data();
	$('#min_max_no_of_list').val(start);
});
$(document).on('click','#refresh',function(){
	fetch_table_data();
	$('#min_max_no_of_list').val(start);
});

var start = 0;
var limit = 10;
var data_array = [];

function fetch_table_data(){
	var stateName = $("#min_max_state option:selected").text();
	var apmcName = $("#min_max_apmc option:selected").text();
	var commodityName =  $("#min_max_commodity option:selected").text();
	var from_date = $('#min_max_apmc_from_date').val();
	var to_date =$('#min_max_apmc_to_date').val();
	if(stateName == 'Select State'){
		stateName = '';
	}
	if(apmcName == 'Select APMC'){
		apmcName = '';
	}
	if(commodityName == 'Select Commodity'){
		commodityName = 'null';
	}
	
	
	$.ajax({
	    type: 'POST',
	    url: 'http://enam.gov.in/NamWebSrv/rest/CommodityPrice/getMinMaxModelPrice',
	    dataType: "json",
	    data: {
	    	'language' : 'en',
	    	'stateName' : stateName,
	    	'apmcName' :apmcName,
	    	'commodityName' : commodityName, 
	    	'fromDate' : from_date,
	 		'toDate' : to_date
	    },
	    beforeSend: function(){
	    	$('#loader').modal({'show':true});	
	    },
	    complete: function(){},
		success:function (response) {
			if(response.statusMsg == 'S'){
				data_array = [];
	    		$.each(response.listCommodity,function(key,value){
	    			data_array.push(value);
	    		});
	    		var array_length = data_array.length;
	    		var pages = parseInt(parseInt(array_length)/parseInt(limit));
	    		var y = '';
	    		for(var i = 0;i<= pages; i++){
	        		y = y + '<option value="'+ i +'">'+ parseInt(parseInt(i)+1) +'</option>';
	    		}
	    		$('#min_max_no_of_list').html(y);
	    		pagination(start);
			}
			else{
				$('#data_list').html('No record Found.');					
			}
		}
	});
}


function pagination(start){
	var array_length = data_array.length;
// console.log(data_array);
	if(start != 0){
		slug = 1;
		}
	else{
		slug = 0;
	}
	var x = '';
	
	for(var i = parseInt(parseInt(start*limit)+slug); i <= (parseInt(parseInt(parseInt(start)*10))+10); i++){

		if(i < array_length){
			x = x + '<tr>'+
					'<td align="center">'+ data_array[i].stateName +'</td>'+
					'<td align="center">'+ data_array[i].apmcName +'</td>'+
					'<td align="center">'+ data_array[i].commodityName +'</td>'+
					'<td align="center">'+ number_formate(data_array[i].minPrice) +'</td>'+
					'<td align="center">'+ number_formate(data_array[i].modelPrice) +'</td>'+
					'<td align="center">'+ number_formate(data_array[i].maxPrice) +'</td>'+
					'<td align="center">'+ number_formate(data_array[i].arrivalQty) +'</td>'+
					'<td align="center"  colspan="2">'+ number_formate(data_array[i].soldQty) +'</td>';	
				x = x + '</tr>';  
		}
		else{
    		break;
		}
	} 
	$('#data_list').html(x);
}
//-----------------------------------------------------------------------------------------------------//

$(document).on('change','#min_max_state',function(){
	$('#min_max_apmc').val(0);
	$('#min_max_commodity').val(0);
	var stateId = $('#min_max_state').val();
	var s_id = stateId.split(':');
	$.ajax({
		    type: 'GET',
		    url: 'http://enam.gov.in/NamWebSrv/rest/MastersUpdate/getApmc',
		    dataType: "json",
		    aycs : false,
		    data: {
		    	'language' : 'en',
		    	'stateId' : s_id[1]
		    },
		    beforeSend: function(){
		    	$('#loader').modal({'show':true});	
		    },
		    complete: function(){},
		    success:function (response) {
		    	//console.log(response);
		    	var x = '<option value="0">Select APMC</option>';
		    	$.each(response.listStateApmc,function(key,value){
		    		x = x + '<option label="'+ value.apmcDesc +'" value="string:'+ value.apmcId +'">'+ value.apmcDesc +'</option>'; 
		    	});
		    	$('#min_max_apmc').html(x);
		    }
		});
	//fetch_table_data();
	$('#min_max_no_of_list').val(start);
});
	//-----------------------------------------------------------------------------------------------------
	$(document).on('change','#min_max_apmc',function(){
		$('#min_max_commodity').val(0);
		var stateName = $("#min_max_state option:selected").text();
		var apmcName =$("#min_max_apmc option:selected").text();
		var from_date = $('#min_max_apmc_from_date').val();
		var to_date =$('#min_max_apmc_to_date').val();
		
			$.ajax({
	 		    type: 'POST',
	 		    url: 'http://enam.gov.in/NamWebSrv/rest/CommodityPrice/getMinMaxModelProducts',
	 		    dataType: "json",
	 		    data: {
	 		    	'language' : 'en',
	 		    	'stateName' : stateName,
	 		    	'apmcName' : apmcName,
	 		    	'fromDate' : from_date,
	 	 		    'toDate' : to_date
	 		    },
	 		    beforeSend: function(){
	 		    	$('#loader').modal({'show':true});	
	 		    },
	 		    complete: function(){},
	 		    success:function (response) {
	 		    	//console.log(response);
	 		    	var x = '<option value="0">Select Commodity</option>';
	 		    	$.each(response.listCommodity,function(key,value){
	 		    		x = x + '<option label="'+ value.commidityName +'" value="string:'+ value.commidityName +'">'+ value.commidityName +'</option>'; 
					});
	 		    	$('#min_max_commodity').html(x);
	 		    }
			});
			fetch_table_data();
			$('#min_max_no_of_list').val(start);
	});

</script>