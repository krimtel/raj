 <section class="title-header-bg">
	<div class="text-center">
		<h3>COMMODITY</h3>
        <div style="margin-top:12px;" class="text-center"><a href="http://sankalpekprayas.org/enam/" title=""><img style="margin-top:-6px;" alt="" src="http://sankalpekprayas.org/enam/assest/images/home-ico.png"></a> / <span id="bredcrum">Commodity</span></div>

	</div>
</section>

<section class="content-section o-content-sec">
<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
<div class="row">
<div class="col-md-12 commodity-filter-box">
<div class="pull-left"><span class="pull-left">View by</span> <select class="form-control" style="width:170px;margin:0 10px;float:left;"> `<option>Latest Arrival</option> </select></div>

	<div class="pull-right">
		<form class="pull-left"><input class="form-control" placeholder="Search commodity" id="commodity_search" type="text" /></form>
<select style="margin-left:15px;width:180px;" class="form-control pull-right" id="commodity_pages" class="form-contrl">
		<option value="0">Select page</option>
		<?php if(isset($commodity_list) && (count($commodity_list)>0)){ 
			for($i = 1;$i <= ceil($commodity_count[0]['total']/18); $i++){
					$v = ($i-1) * 18;
			?>
				<option value="<?php echo $v+18; ?>"><?php echo $i; ?></option>		
	<?php	}				
		 } ?>
	</select>
	</div>
</div>  

	
	<div class="row">
		<div class="commodity-list" id="commodity-list">
			<?php if(isset($commodity_list) && (count($commodity_list)>0)){ ?>
				<?php foreach($commodity_list as $commodity){ ?>
					<div class="col-md-2">
						<div class="comodity-pro-box">
							<h4><?php echo $commodity['commodity_name']; ?></h4>
							<img alt="" src="<?php echo base_url(); ?>assest/images/commodity-pro/<?php echo $commodity['image']; ?>" /> 
							<a class="commodity_modal" data-id="<?php echo $commodity['commodity_id']; ?>" href="javascript:void(0);"> View Quality Parameters</a>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<div class="modal" id="Wheat_gram" role="dialog" tabindex="-1">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header commodity-list-h">
<img id="commodity_title_image" style="float:left;margin-right:20px;" alt="" src="" /> 
<h4 class="modal-title"><span class="commo-p">Commodity Parameter - </span><span id="commodity_name"></span><br><span id="commodity_title"></span></h4>
<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button></div>

<div class="modal-body" id="commodity_desc"></div>
</div>
</div>
</div>
</section>

<script>
var baseUrl = $('#base_url').val();
$(document).on('click','.commodity_modal',function(){
	var id = $(this).data('id');
	$.ajax({
	        type: 'POST',
	        url: baseUrl+'Ajax_ctrl/commodity_parameter',
	        dataType: "json",
	        data: {
	        	'id' : id,
	        },
	        beforeSend: function(){
	        	$('#loader').modal({'show':true});	
	        },
	        complete: function(){},
	        success:function (response) {
				if(response.status == 200){
                                        $('#loader').modal('toggle');
					$('#commodity_name').html(response.data[0].comm_name);
					$('#commodity_title_image').attr('src',baseUrl+'assest/images/commodity-pro/'+response.data[0].comm_image);
					$('#commodity_title').html(response.data[0].comm_title);
					$('#commodity_desc').html(response.data[0].comm_desc);
					$('#Wheat_gram').modal('show');
				}
			}
	});
});

$(document).on('change','#commodity_pages',function(){
	var page_id = $('#commodity_pages').val();
	
	$.ajax({
	        type: 'POST',
	        url: baseUrl+'Dashboard_ctrl/commodity_limit/' + page_id,
	        dataType: "json",
	        data: {
	        	'page_id' : page_id,
	        },
	        beforeSend: function(){
	        	$('#loader').modal({'show':true});	
	        },
	        complete: function(){},
	        success:function (response) { $('#loader').modal('toggle');
	        	console.log(response);
				if(response.status == 200){
                                     
					var x = "";
					$.each(response.data,function(key,value){
						x = x + '<div class="col-md-2">'+
						'<div class="comodity-pro-box">'+
							'<h4>'+ value.commodity_name +'</h4>'+
							'<img alt="" src="<?php echo base_url(); ?>assest/images/commodity-pro/'+ value.image +'" /> '+
							'<a class="commodity_modal" data-id="'+ value.commodity_id +'" href="javascript:void(0);"> View Quality Parameters</a>'+
						'</div>'+
						'</div>';
					});
					$('#commodity-list').html(x);
				}
				else{
					$('#commodity-list').html('<p style="text-align:center;">No record Found.</p>');	
				}
			}
	});
});
</script>