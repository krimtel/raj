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
	 
	<script>
	$(document).on('click','.read',function(){
		var id = $(this).data('id');
		$('#read_'+id).show();
	});
	</script>
	</div>
</div>
