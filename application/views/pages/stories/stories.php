<section class="title-header-bg">
	<div class="text-center">
		<h3><?php echo $title; ?></h3>
		<div class="bredcrum-list">
			<ul>
				<li><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / </li>
				<li><a href="" title=""><?php echo $title; ?></a></li>
			</ul>
		</div>
	</div>
</section>
<div class="container-fuild" style="padding-left:4%;padding-right:4%;min-height:400px;padding-top:50px;padding-bottom:35px;float:left;width:100%;">
	<div class="col-md-9 s-story-list">
		<?php
	if(isset($stories) && (count($stories))){
		$c = 0;
		foreach($stories as $story){ ?>
			<div class="row">
				<div class="col-md-12 s-story-list-box">
					<img alt="" src="<?php echo base_url();?>assest/images/s-story/<?php echo $story['story_image']; ?>" />
					<h4><?php echo $story['title']; ?></h4>
					<p><?php echo $story['success_content']; ?></p>
					<a class="read" data-id="<?php echo $c;?>" data-toggle="collapse" href="#read_<?php echo $c;?>">read more</a>
				</div>
			</div>
	<?php $c++ ; }
	 }?>
	</div>
	
	<div class="col-sm-3">
		<!-- site search -->
		<div class="side-bar-section">
			<div class="search-widget">
				<h3>SITE SEARCH</h3>
				<form id="site_search_form" name="f1" method="POST" action="<?php echo base_url();?>site_search">
					<input id="site_search" name="site_search" placeholder="Search here..." type="text" />
				</form>
				<i class="fa fa-search"></i>
			</div>
		</div>
		
		<!-- site  -->
		<div class="sidebar-link-widget">
			<ul>
				<li><a href="<?php echo base_url()?>apmcs" title="APMCs">APMCs</a></li>
				<li><a href="<?php echo base_url()?>farmers" title="FARMERS">FARMERS</a></li>
				<li><a href="<?php echo base_url()?>traders" title="TRADERS">TRADERS</a></li>
				<li><a href="<?php echo base_url()?>commission-agents" title="COMMISSION AGENTS">COMMISSION AGENTS</a></li>
				<li><a href="<?php echo base_url()?>fpos" title="FPOs">FPOs</a></li>
				<li><a href="<?php echo base_url()?>mandi-board" title="MANDI BOARD">MANDI BOARD</a></li>
				<li><a href="<?php echo base_url()?>logistic-providers" title="LOGISTIC PROVIDERS">LOGISTIC PROVIDERS</a></li>
			</ul>
		</div>
		
		<!-- subscribe -->
		<div class="side-bar-section">
			<div class="subcribe-widget">
				<h3>SUBSCRIBE eNAM</h3>
				<p>Send your email address to recieve latest information about the eNAM news and events.</p>
				<input placeholder="example@gmail.com" type="text" /> <input class="btn btn-success" style="margin-top:15px;" type="submit" />
			</div>
		</div>
		
		<!-- quick link -->
		<div class="quick-link-list">
			<ul>
				<?php if(count($links) > 0) { 
					foreach($links as $link){
						if($link['lang_id'] == $this->session->userdata('client_language') && $link['publish'] == 1){
		                $str = html_entity_decode($link['link_contect']);
						$regex = "/\[(.*?)\]/";
						$data['output'] = $str;
						preg_match_all($regex, $str, $matches);
						for($i =0; $i < count($matches[1]); $i++){
							
							$link['link_contect'] = str_replace($matches[0][$i],$this->substring->image_path(),$link['link_contect']);
						}
		?> 
						<li>
							<?php echo $link['link_contect']; ?>
						</li>			
				<?php } } } ?>
			</ul>
		</div>
		
	</div>
	
	
</div>

	<script>
	$(document).on('click','.read',function(){
		var id = $(this).data('id');
		$('#read_'+id).show();
	});
	</script>