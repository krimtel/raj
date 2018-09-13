<div class="latest-news focus-section pull-left" style="width:19%;padding-right:2px;"> 
<?php print_r($quickLinks); ?>
</div>
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width:60%;float:left;">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
	<?php 
	$c = 1;
	if($this->session->userdata('client_language') != ''){
		$language = $this->session->userdata('client_language');
	}
	else{
		$language = 1;
	}
	
	foreach ($sliders as $slider){ ?>
		<?php if($slider['lang_id'] == $language){ ?>
		<div class="item <?php if($c== 1){ echo "active";} ?>">
			<img src="<?php echo base_url(); ?>Slider_gallary/<?php  if($this->session->userdata('client_language')){ echo $this->session->userdata('client_language'); } else { echo '1';}?>/<?php echo $slider['slider_image'];?>" alt="img1"/ >
		</div>
	<?php $c++;} } ?>
      
    </div>

    <!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <img src="<?php echo base_url(); ?>assest/images/slider/large_left.png" />
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
     <img src="<?php echo base_url(); ?>assest/images/slider/large_right.png" />
    </a>
</div>
<div class="latest-news" style="float:right;padding-left:2px;">
		<div class="sidebar-header-title" style="font-size:14px;"><span class="e-text-news"><?php echo $this->lang->line('announcements');?></span></div>
		<div  class="focus-news">		
			<marquee height="219" onMouseOut="start();" onMouseOver="stop();" direction="up" scrollamount="2">
				<?php if(count($newses)>0){ ?>
				<?php foreach($newses as $news) {
					if($news['lang_id'] == $this->session->userdata['client_language']){
						if(strlen( $news['news_contect']>100))
						{
						?>
						<div class="focus-news-feilds">
							<p><?php echo substr($news['news_contect'],0,100).".."; ?></p>
					<?php 
						}
						else{
						?>	
						<div class="focus-news-feilds">
						<p><?php  echo $news['news_contect'];
						}
					}
					?>
					</div>
				<?php } ?>
			<?php } else { ?>
				no news.
			<?php } ?>
			</marquee>
		</div>
	</div>