<div class="main-content-section" style="padding-top:1px;">
<section class="title-header-bg">
	<div class="text-center">
		<h3><?php echo $page_title; ?></h3>
		<!--<div class="bredcrum-list">
			<ul>
				<li><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / </li>
				<li><span id="bredcrum"></span></li>
			</ul>
		</div>-->
<div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / <span id="bredcrum"></span></div>
	</div>
</section>
 
<div class="container-fuild" style="padding-left:4%;padding-right:4%;min-height:400px;padding-top:50px;padding-bottom:35px;float:left;width:100%;">
	 <?php /* 2 column right =============================*/?>
	 	 <?php if($page_layout == 3){ ?>
	<div class="row">
	<div class="col-md-9 col-sm-9" style="padding-right:35px;">
		<div class="col-md-12 col-sm-12">
			<?php print_r($output); ?>
		</div>
	</div>
	<div class="col-md-3 col-sm-3">
		<?php if(isset($page_contents[0]['col'])){ ?>
			<?php foreach ($page_contents[0]['col'] as $page_content){
				if($page_content['section'] == 'right_col'){
					if($page_content['widget_id'] < 0){
						if($page_content['widget_id'] == -1){
							print_r($news_page);
						}
						else if($page_content['widget_id'] == -2){
							print_r($slider_page);
						}
						else if($page_content['widget_id'] == -3){
							print_r($quickLinks_page);
						}
						else if($page_content['widget_id'] == -7){
							print_r($search_page);
						}
						else if($page_content['widget_id'] == -8){
							print_r($subscribe_page);
						}
					}
					else{
						if($page_content['section'] == 'right_col'){ ?>
								<div class="mid-top-space natinal-agricul-market pad" style="display:none;"> 
									<h3 class="events-title"><span><?php echo $page_content['name']; ?></span></h3>
			 						<div class="commodity-list"> 
			 							<div class="box_cont">
											<div style="text-align:justify">
												<?php echo $page_content['content']; ?>
			 								</div>
			 							</div>
			 						</div> 
			 					</div>
						<?php }
					} 
				}
			}
		} ?>
		
	</div>
	</div> 
	 <!--  3 column layout ============================*/ -->
	 <?php } else if($page_layout == 4){?>
	<div class="row">
	<div class="col-md-3 col-sm-3">
		
		<?php if(isset($page_contents[0]['col'])){ ?>
			<?php foreach ($page_contents[0]['col'] as $page_content){
				if($page_content['section'] == 'left_col'){
					if($page_content['widget_id'] < 0){
						if($page_content['widget_id'] == -1){
							print_r($news_page);
						}
						else if($page_content['widget_id'] == -2){
							print_r($slider_page);
						}
						else if($page_content['widget_id'] == -3){
							print_r($quickLinks_page);
						}
						else if($page_content['widget_id'] == -7){
							print_r($search_page);
						}
						else if($page_content['widget_id'] == -8){
							print_r($subscribe_page);
						}
						
					}
					else{
						if($page_content['section'] == 'left_col'){ ?>
								<div class="mid-top-space natinal-agricul-market pad" style="display:none;"> 
									<h3 class="events-title"><span><?php echo $page_content['name']; ?></span></h3>
			 						<div class="commodity-list"> 
			 							<div class="box_cont">
											<div style="text-align:justify">
												<?php echo $page_content['content']; ?>
			 								</div>
			 							</div>
			 						</div> 
			 					</div>
						<?php }
					} 
				}
			}
		} ?>
		
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="col-md-12 col-sm-12">
			<?php print_r($output); ?>
		</div>
	</div>
	<div class="col-md-3 col-sm-3">
		
		<?php if(isset($page_contents[0]['col'])){ ?>
			<?php foreach ($page_contents[0]['col'] as $page_content){
				if($page_content['section'] == 'right_col'){
					if($page_content['widget_id'] < 0){
						if($page_content['widget_id'] == -1){
							print_r($news_page);
						}
						else if($page_content['widget_id'] == -2){
							print_r($slider_page);
						}
						else if($page_content['widget_id'] == -3){
							print_r($quickLinks_page);
						}
						else if($page_content['widget_id'] == -7){
							print_r($search_page);
						}
						else if($page_content['widget_id'] == -8){
							print_r($subscribe_page);
						}
					}
					else{
						if($page_content['section'] == 'right_col'){ ?>
								<div class="mid-top-space natinal-agricul-market pad" style="display:none;"> 
									<h3 class="events-title"><span><?php echo $page_content['name']; ?></span></h3>
			 						<div class="commodity-list"> 
			 							<div class="box_cont">
											<div style="text-align:justify">
												<?php echo $page_content['content']; ?>
			 								</div>
			 							</div>
			 						</div> 
			 					</div>
						<?php }
					} 
				}
			}
		} ?>
		
	</div>
	</div>
	<?php } elseif($page_layout == 1){ ?>
	<?php /* 1 column layout ********************************/?>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<?php print_r($output); ?>
		</div>
	</div>
	<br/><br/>
	<?php } elseif($page_layout == 2){ ?>
	<div class="row">
	<div class="col-md-3 col-sm-3">
		<?php if(isset($page_contents[0]['col'])){ ?>
			<?php foreach ($page_contents[0]['col'] as $page_content){
				if($page_content['widget_id'] < 0){
					if($page_content['widget_id'] == -1){
						print_r($news_page);
					}
					else if($page_content['widget_id'] == -2){
						print_r($slider_page);
					}
					else if($page_content['widget_id'] == -3){
						print_r($quickLinks_page);
					}
					else if($page_content['widget_id'] == -7){
						print_r($search_page);
					}
					else if($page_content['widget_id'] == -8){
						print_r($subscribe_page);
					}
				}
				else{
					if($page_content['section'] == 'left_col'){ ?>
							<div class="mid-top-space natinal-agricul-market pad" style="display:none;"> 
								<h3 class="events-title"><span><?php echo $page_content['name']; ?></span></h3>
		 						<div class="commodity-list"> 
		 							<div class="box_cont">
										<div style="text-align:justify">
											<?php echo $page_content['content']; ?>
		 								</div>
		 							</div>
		 						</div> 
		 					</div>
					<?php }
				} 
			}
		} ?>
	</div>
	<div class="col-md-9 col-sm-9" style="padding-left:35px;">
		<?php print_r($output);?>
	</div>
	</div>
	<br/><br/>
	<?php } else {?>
	<?php /* 2column with right */ ?>
	<div class="row">
	<div class="col-md-9 col-sm-9">
		<div class="mid-top-space natinal-agricul-market pad">
			<h3 class="events-title"><span>National Agriculture Market</span></h3>
			<div class="commodity-list">
				<div class="box_cont">
					<div style="text-align:justify">
						<p>National Agriculture Market (NAM) is a pan-India electronic trading portal which networks the existing APMC mandis to create a unified national market for agricultural commodities.</p>
						<p>The NAM Portal provides a single window service for all APMC related information and services. This includes commodity arrivals & prices, buy & sell trade offers, provision to respond to trade offers, among other services. While material flow (agriculture produce) continue to happen through mandis, an online market reduces transaction costs and information asymmetry. </p>
						<p>Agriculture marketing is administered by the States as per their agri-marketing regulations, under which, the State is divided into several market areas, each of which is administered by a separate Agricultural Produce Marketing Committee (APMC) which imposes its own marketing regulation (including fees). This fragmentation of markets, even within the State, hinders free flow of agri commodities from one market area to another and multiple handling of agri-produce and multiple levels of mandi charges ends up escalating the prices for the consumers without commensurate benefit to the farmer. </p>
						<p>NAM addresses these challenges by creating a unified market through online trading platform, both, at State and National level and promotes uniformity, streamlining of procedures across the integrated markets, removes information asymmetry between buyers and sellers and promotes real time price discovery, based on actual demand and supply, promotes transparency in auction process, and access to a nationwide market for the farmer, with prices commensurate with quality of his produce and online payment and availability of better quality produce and at more reasonable prices to the consumer.
						</p>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-3">
		<?php print_r($quickLinks); ?>
	</div>
	</div>
	<?php } ?>
</div>
</div>


<?php 
$c = 1;
		$url_array ='';
		while($this->uri->segment($c) != ''){
			$url_array.= $this->uri->segment($c).'/';
			$c = $c + 1;
		}
		$url_array = strtolower(rtrim($url_array,"/ "));
		?>
<script>
var baseUrl = $('#base_url').val();
$.ajax({
	type: 'post',
	url: baseUrl+'Ajax_ctrl/menu_activate/<?php echo $url_array;?>',
	dataType: "json",
	data:{},
	beforeSend: function(){},
	complete: function(){},
	success: function (response){
		if(response.status == 200){
			console.log(response);
			if (typeof response.data[0].id !== 'undefined') {
				$('#menuid_'+response.data[0].id).addClass('active');	
			}
			if (typeof response.data[0].p_id !== 'undefined') {
				$('#menuid_'+response.data[0].p_id).addClass('active');
			}
		    $('#bredcrum').html(response.bredcrum);	
		}
                else{
			$('#bredcrum').html(response.bredcrum);	
		}
	}
});
</script>
