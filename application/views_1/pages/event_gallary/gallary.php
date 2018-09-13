<section class="content-section" style="background-color:#fff;padding:20px 0;float:left;width:100%;">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
			<div class="col-md-12 video-gallery">
				<h5><span>All Events</span>
					<div class="pull-right search-btn">
						<select class="pull-left">
							<option>Select Category</option>
							<option>National Events</option>
							<option>State Events</option>
						</select>
					</div>
				</h5>
				
				<div class="row">
			<?php if(isset($videos) && count($videos)>0){?>
				<?php $c = 1; foreach($videos as $video){ ?>
				<div class="col-md-3">
					<div class="row elearn-v-box">
						<div class="col-md-12">
<div class="thum"><?php $v = explode('/embed/',$video['v_url']); ?>
						<div class="rahul_youtube" id="iframe1_v_<?php echo $c;?>" data-id="<?php echo $c;?>" data-v_id="iframe1_v_<?php echo $c;?>" data-v_url="<?php echo $video['v_url']; ?>" style="background:url('http://img.youtube.com/vi/<?php echo $v[1];?>/0.jpg') center no-repeat;cursor:pointer;height:172px;width:280px;background-size:cover;"></div>

<img alt="" style="width:64px;"  data-v_id="iframe_v_<?php echo $c;?>" data-v_url="<?php echo $video['v_url']; ?>" data-pid="<?php echo $c;?>" class="play-img" src="<?php echo base_url();?>assest/images/new-theme/icon/play-ico.png" />
<div id="iframe_v_<?php echo $c;?>" style="display:none;"></div></div>
</div>
						<div class="col-md-12 video-g-details" >
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
			<div class="col-md-12 video-gallery">
				<h5><span>Categoty Video</span></h5>
				<div class="row">
			<?php if(isset($videos) && count($videos)>0){?>
				<?php $c = 1; foreach($videos as $video){ ?>
				<div class="col-md-3">
					<div class="row elearn-v-box">
						<div class="col-md-12">
<div class="thum"><?php $v = explode('/embed/',$video['v_url']); ?>
						<div class="rahul_youtube" id="iframe1_v_<?php echo $c;?>" data-id="<?php echo $c;?>" data-v_id="iframe1_v_<?php echo $c;?>" data-v_url="<?php echo $video['v_url']; ?>" style="background:url('http://img.youtube.com/vi/<?php echo $v[1];?>/0.jpg') center no-repeat;cursor:pointer;height:172px;width:280px;background-size:cover;"></div>

<img style="width:64px;" alt="" data-v_id="iframe_v_<?php echo $c;?>" data-v_url="<?php echo $video['v_url']; ?>" data-pid="<?php echo $c;?>" class="play-img" src="<?php echo base_url();?>assest/images/new-theme/icon/play-ico.png" />
<div id="iframe_v_<?php echo $c;?>" style="display:none;"></div></div>
</div>
						<div class="col-md-12 video-g-details" >
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
</section>