<div class="container-fuild" style="float:left;width:100%;background-color:#e6e6e6;padding:10px 4% 12px 4%;">
	<?php print_r($slider); ?>
</div>
<section class="content-section" style="background-color:#fff;padding:20px 0;float:left;width:100%;">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
<div class="col-sm-3 video-sec wow fadeInLeft" data-wow-delay="0.5s" style="width:21%;" >
			<div class="sidebar-header-title"><span class="e-text"><?php echo $this->lang->line('enam');?> <?php echo $this->lang->line('elearningvideos');?></span></div>
			<div class="row">
			<?php if(isset($videos) && count($videos)>0){?>
				<?php $c = 1; foreach($videos as $video){ ?>
				<div class="col-md-12">
					<div class="row elearn-v-box">
						<div class="col-md-12" style="padding-right:0px;">
<div style="border:1px solid #d6d3d3;float:left;padding:3px;"><?php $v = explode('/embed/',$video['v_url']); ?>
						<div class="rahul_youtube" id="iframe1_v_<?php echo $c;?>" data-id="<?php echo $c;?>" data-v_id="iframe1_v_<?php echo $c;?>" data-v_url="<?php echo $video['v_url']; ?>" style="background:url('http://img.youtube.com/vi/<?php echo $v[1];?>/0.jpg') center no-repeat;cursor:pointer;height:125px;width:229px;background-size:cover;"></div>
<h3><?php echo $video['v_title']; ?></h3>
<img style="width:64px;"  data-v_id="iframe_v_<?php echo $c;?>" data-v_url="<?php echo $video['v_url']; ?>" data-pid="<?php echo $c;?>" class="play-img" src="<?php echo base_url();?>assest/images/new-theme/icon/play-ico.png" />
<div id="iframe_v_<?php echo $c;?>" style="display:none;"></div></div>
</div>
						<div class="col-md-7" style="padding-left:0px;margin-left:-7px;display:none;">
						<h3><b><?php echo $video['v_title']; ?></b></h3>
						<div class="discrip"><?php echo substr($video['v_content'],0,150); ?></div>
						<p>1025 Views - <?php echo $video['created_at']; ?></p></div>
					</div>
				</div>
				<?php $c++; } ?>
			<?php } else{ ?>
					No Videos.
			<?php } ?>
			</div>
		</div>
<div class="about-sec col-lg-5 col-sm-5 wow fadeInUp" data-wow-delay="0.5s" style="width:45.666667%;">
<div class="sidebar-header-title"><span class="e-text"><?php echo $this->lang->line('enam');?> OVERVIEW</span></div>
<?php print_r($home_body[0]['content']); ?>
</div>
		
		<div style="display:none;" class="col-lg-3 col-sm-3 wow fadeInUp events-box" data-wow-delay="0.5s" >
			<div style="width:110%;" class="sidebar-header-title"><span class="e-text"><?php echo $this->lang->line('enam');?> <?php echo $this->lang->line('news&events');?></span></div>
			<?php if((count($events) > 0) && (isset($events))){ ?>
				<?php $c=1; foreach($events as $event){ 
					if($c < 3){
					$event_title = strlen($event['title']) > 50 ? substr($event['title'],0,50)."..." : $event['title'];
					?>
					<div class="events-de">
						<div class="register-user-box">
							<b><?php echo $event_title; ?></b>
							<b><?php //echo $event['event_content'];?> </b>
						</div>
						<img style="width:100%;" alt="<?php echo $event['title']; ?>" src="<?php echo base_url(); ?>/Event_gallary/<?php echo $event['event_image']; ?>" />
					</div>
				<?php $c++; } } ?>
			<?php } else { ?>
				<div class="well text-danger">No Events Found.</div>
			<?php }?>
		</div>
		
		<div class="col-lg-4 col-sm-4 home-n wow fadeInRight" data-wow-delay="0.5s">
                       
			<div class="focus-section">
<div class="sidebar-header-title"><span><?php echo $this->lang->line('enam');?> <?php echo $this->lang->line('important_link');?></span></div>

                        <?php if($this->session->userdata('client_language') == 1) {?>
                           <img style="width:100%;" src="<?php echo base_url();?>/assest/images/new-theme/map.jpg">
			<?php } else {?>
 		           <img style="width:100%;" src="<?php echo base_url();?>/assest/images/new-theme/hindi-map.jpg">
<?php } ?>
<a href="#" class="map-detail-btn">Note: Click on the states to view details</a>				
<div class="booklet-section" style="display:none;">
					<ul>
						<li><a title="eNAM Booklet" href=""><img alt="Logistic Details" src="<?php echo base_url();?>assest/images/new-theme/icon/booklet.png" /> <span><?php echo $this->lang->line('download');?></span><br><?php echo $this->lang->line('eNAM_Booklet');?></a></li>
						<li><a title="Guidelines  Manual" href="guide.html"><img alt="Logistic Details" src="<?php echo base_url();?>assest/images/new-theme/icon/guideline.png" /><span><?php echo $this->lang->line('registration');?></span><br><?php echo $this->lang->line('guidelines_manual');?></a></li>
					</ul>
				</div>
</div>
		</div>
	</div></div>
</section>