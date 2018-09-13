 <section class="title-header-bg">
	<div class="text-center">
		<h3><?php echo $title; ?></h3>
		<div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / <span id="bredcrum">eLearning Videos</span></div>
	</div>
</section>
<section class="content-section o-content-sec">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
			<div class="col-md-12 video-gallery">
				<h5>
					<?php if($this->uri->segment(2) == ''){	 ?>
						<span>All Videos</span>
					<?php } else {
								if(urldecode($this->uri->segment(2)) == 'Others Video')
								{ ?>
									<span><?php echo urldecode($this->uri->segment(2));?> </span>
							<?php	}
							else{
					?>
						<span><?php echo urldecode($this->uri->segment(2));?> Videos</span>
					<?php } } ?>
					<div class="pull-right search-btn">
						<input id="video_search_learing" placeholder="Search Videos..." type="text" /><i class="fa fa-search"></i>	
						<select class="pull-left form-control" style="width:200px;" id="elearing_cat_selector">
							<option value="All">All Videos</option>
							<?php if(count($video_categories)>0){
								foreach($video_categories as $video_category){ ?>
								<?php if($this->uri->segment(2) != ''){ ?>
									<?php if($this->uri->segment(2) == $video_category['category_name']){ ?>
										<option value="<?php echo $video_category['category_name']; ?>" selected><?php echo $video_category['category_name']; ?></option>
									<?php } else {?>
										<option value="<?php echo $video_category['category_name']; ?>"><?php echo $video_category['category_name']; ?></option>
									<?php } ?>
								<?php } else { ?>
									<option value="<?php echo $video_category['category_name']; ?>"><?php echo $video_category['category_name']; ?></option>
								<?php } ?>
							<?php } } ?>
						</select>
					</div>
				</h5>
			</div>
						
			<div class="col-md-12" id="video_lists">
<div class="row">
			<?php if(isset($videos) && count($videos)>0){?>
				<?php $c = 1; foreach($videos as $video){ ?>
				<div class="col-md-3">
					<div class="row elearn-v-box" style="min-height:277px;">
						<div class="col-md-12">
							<div class="thum"><?php $v = explode('/embed/',$video['v_url']); ?>
								<div class="v-g-imag"  data-video_id="<?php echo $video['video_id']; ?>" style="background:url('http://img.youtube.com/vi/<?php echo $v[1];?>/0.jpg') center no-repeat;"></div>
								<a href="<?php echo base_url();?>elearning/id/<?php echo $video['video_id'];?>">
								<img alt="" style="width:64px;"class="play-img-gallery" src="<?php echo base_url();?>assest/images/new-theme/icon/play-ico.png" />
								</a>
								<div id="iframe_v_<?php echo $c;?>" style="display:none;"></div>
							</div>
						</div>
						<div class="col-md-12 video-g-details" >
							<div style="background-color:#efefef;padding:0 8px;float:left;width:100%;border:1px solid #e2e2e2;"><h5><b><?php echo $video['v_title']; ?></b></h5>
							<p>1025 Views - <?php echo $video['created_at']; ?></p></div>
						</div>
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
</section>