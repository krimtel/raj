<section class="title-header-bg">
	<div class="text-center">
		<h3><?php echo $title; ?></h3>
		<div class="bredcrum-list">
			<ul>
				<li><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / </li>
				<li><a href="" title="">NAM</a> / </li>
				<li><a href="" title=""><?php echo $title; ?></a></li>
			</ul>
		</div>
	</div>
</section>

<section class="content-section o-content-sec">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
			<div class="col-md-12 video-gallery">
			<div class="row">
				<div class="col-md-9 singal-video-details">
					<?php if(isset($videos1) && count($videos1)>0){
								foreach($videos1 as $vid){
									$url = $vid['v_url']."?rel=0&autoplay=1";
						?>
					<h4><?php echo	$vid['v_title']; ?> </h4>
					
						<iframe src="<?php echo $url; ?>" height='400px' width='100%'>  </iframe>
				<!--	<img src="<?php //echo $url; ?>" />  -->
					<p><?php echo $vid['v_content'];  ?></p>
						<?php	}
									}
					?>
				</div>
			<div class="col-md-3">
				<div class="singal-v-detail-side-v">
				<h4 style="margin-top:0px;margin-bottom:15px;">Availabel Videos</h4>
			<?php if(isset($videos) && count($videos)>0){?>
				<?php $c = 1; foreach($videos as $video){ ?>						
					<div class="row elearn-v-box" style="margin-bottom:1px;">
						<div style="background-color:#eee;float:left;border-bottom:1px solid #ddd;padding:8px 0;">
							<div class="col-md-6">
							<div class="thum" ><?php $v = explode('/embed/',$video['v_url']); ?>
								<a href="<?php echo base_url();?>elearning/id/<?php echo $video['video_id'];?>">
								<img alt="" style="width:32px;"class="play-img-gallery" src="<?php echo base_url();?>assest/images/new-theme/icon/play-ico.png" />
								<div style="background:url('http://img.youtube.com/vi/<?php echo $v[1];?>/0.jpg') center no-repeat;cursor:pointer;height:74px;width:120px;background-size:cover;"></div>
								</a>
							</div>
						</div>
						<div class="col-md-6 video-g-details side-video-list" style="padding-left:0px;" >
						<h5><b><?php echo $video['v_title']; ?></b></h5>
						<!--<div class="discrip"><?php //echo substr($video['v_content'],0,150); ?></div>-->
						<p>1025 Views - <?php echo $video['created_at']; ?></p></div>
					</div>
					</div>
				
				<?php $c++; } ?>
			<?php } else{ ?>
					No Videos.
			<?php } ?>
			</div>
			</div>
				</div>
			</div>
			
		</div>
	</div>
</section>
<script src="#" type ="javascript">
	$(document).ready(function(){
		$(document).on('click','.videoplay',function(){
			$('#videoplay').hide();
		});
	});
</script>