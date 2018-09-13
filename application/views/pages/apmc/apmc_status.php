<?php date_default_timezone_set("America/New_York"); 
$date = date("Y-m-d");
?>

<input type="hidden" id="previous_date" value="<?php echo date('Y-m-d', strtotime($date .' -1 day'));?>">
<input type="hidden" id="current_date" value="<?php echo $date;?>">

<section class="title-header-bg">
	<div class="text-center">
		<h3>APMC ONLINE STATUS</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / Apmc Online Status </span></div>

	</div>
</section> 



<div class="container-fuild" style="padding-left:4%;padding-right:4%;padding-top:40px;float:left;width:100%;">
	<div class="col-sm-12 well"><div class="col-md-4">From Date <input class="form-control" type="date" id="apmc_from_date" /></div>
	<div class="col-md-4">To Date <input class="form-control" type="date" id="apmc_to_date" /></div>
        <div class="col-md-4" style="padding-top:20px;"><input type="button" class="btn btn-success" value="Refresh" id="refresh"></div></div>
<div class="row">
<div class="col-md-12">
<div class="pull-left" style="font-size:15px;"><b>Your Search Result as follows:</b></div>
</div>
</div>

</div>

	

<section class="content-section" >
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;padding-top:20px;padding-bottom:35px;">
		<div class="row">
			<div class="col-md-12 video-gallery events-list">
				<table class="table table-bordered table-striped">
					<thead>
						<tr><th>S. No.</th><th>State</th><th>Total APMC</th><th>Online APMC</th><th>Status</th><th>Active APMC %</th></tr>
					</thead>
					<tbody id="apmc_online_status">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>	
</section>

<script>

$('#apmc_from_date').val($('#previous_date').val());
$('#apmc_to_date').val($('#current_date').val());
live_apmc_detail();

        $(document).on('click','#refresh',function(){
		live_apmc_detail();
        });

	$(document).on('change','#apmc_from_date,#apmc_to_date',function(){
		live_apmc_detail();
	});
	
	function live_apmc_detail(){
		var from_date = $('#apmc_from_date').val();
		var to_date = $('#apmc_to_date').val();		
		$.ajax({
	        type: 'POST',
	        url: 'http://www.enam.gov.in/NamWebSrv/rest/getActiveState',
	        dataType: "json",
	        data: {
	        	'language'	:'en',
				'fromDate'	:from_date,
				'toDate' : to_date,
				'orgId' : 1
	        },
	        beforeSend: function(){
	   $('#apmc_online_status').html('<p class="text-center"><b>Loading...</b></p>');
	        },
	        complete: function(){},
	        success:function (response) {
				var x = '';
				var c = 1;
				var color = '';
				$.each(response.listActiveState,function(key,value){
					if(value.activeApmc == '>=50% - <100%'){
						color = '<img style="width:25px;" alt="Green" src="http://sankalpekprayas.org/enam/assest/images/green.gif" />';
					}
					else if(value.activeApmc == '100%'){
						color = '<img style="width:25px;" alt="Dark Green" src="http://sankalpekprayas.org/enam/assest/images/dark-green.gif" />';
					}
					else if(value.activeApmc == '<50%'){
						color = '<img style="width:25px;" alt="Orange" src="http://sankalpekprayas.org/enam/assest/images/orange.gif" />';
					}
					else{
						color = '<img style="width:25px;" alt="Red" src="http://sankalpekprayas.org/enam/assest/images/red.gif" />';
					}
					x = x + '<tr><td align="center">'+ c +'</td><td align="center">'+ value.stateName +'</td><td align="center">'+ value.oprCount +'</td><td align="center">'+ value.activeCount +'</td><td style="text-align:center;">'+ color +'</td><td align="center">'+ value.activeApmc +'</td></tr>';
				c++; });
	        	$('#apmc_online_status').html(x);
	        }
		});
	}
</script>