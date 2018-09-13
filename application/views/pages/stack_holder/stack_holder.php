<section class="title-header-bg">
	<div class="text-center">
		<h3>STAKHOLDERS DATA</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / Market Data / Stakholders Data</span></div>

	</div>
</section>

<section class="content-section o-content-sec">
<div class="container-fuild" style="padding-left:4%;padding-right:4%;padding-bottom:35px;">
<div class="row">
<div class="col-md-12 video-gallery events-list">
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th style="text-align:center;">S. No.</th>
			<th style="text-align:center;">State</th>
			<th style="text-align:center;">Trader</th>
			<th style="text-align:center;">Commission Agent</th>
			<th style="text-align:center;">Service Provider</th>
			<th style="text-align:center;">Seller Farmer</th>
		</tr>
	</thead>
	<tbody id="stack_holder_data">
	</tbody>
</table>
</div>
</div>
</div>
</section>
<script>


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
 
$.ajax({
	        type: 'POST',
	        url: 'http://www.enam.gov.in/NamWebSrv/rest/getPortalUserRegisteredState',
	        dataType: "json",
	        data: {
	        	'language'	:'en'
	        },
	        beforeSend: function(){
				$('#stack_holder_data').html('<td colspan="6" style="text-align:center;"><p><b>Loading...</b></p></td>');
	        },
	        complete: function(){},
	        success:function (response) {
				var x = '';
				var c = 1;
				var buyer = 0;
                var commission_agent = 0;
                var service_provider = 0;
                var seller = 0;
				$.each(response.portalUserStateList,function(key,value){
                     buyer = parseInt(buyer + parseInt(value.trader));
                     commission_agent = parseInt(commission_agent + parseInt(value.commsionAgent));
                     service_provider = parseInt(service_provider + parseInt(value.serviceProvider));
                     seller = parseInt(seller + parseInt(value.farmer));
					 farmer = number_formate(value.farmer);
					 trader = number_formate(value.trader);
					 commsionAgent = number_formate(value.commsionAgent);
					 serviceProvider = number_formate(value.serviceProvider);
					x = x + '<tr><td align="center">'+ c +'</td><td align="center">'+ value.stateName +'</td><td align="center">'+ trader +'</td><td align="center">'+ commsionAgent +'</td><td align="center">'+ serviceProvider +'</td><td align="center">'+ farmer +'</td></tr>';
				c++; });
				buyer = number_formate(buyer.toString());
				commission_agent = number_formate(commission_agent.toString());
				service_provider = number_formate(service_provider.toString());
				seller = number_formate(seller.toString());
x = x + '<tr><td style="text-align:center;" colspan="2"><b>Total</b></td><td align="center"><b>'+ buyer +'</b></td><td align="center"><b>'+ commission_agent +'</b></td><td align="center"><b>'+ service_provider +'</b></td><td align="center"><b>'+ seller +'</b></td></tr>' 
	        	$('#stack_holder_data').html(x);
	        }
		});
</script>