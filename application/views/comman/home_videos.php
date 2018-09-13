<div class="focus-section">
	<div class="sidebar-header-title" style="margin-bottom:0;">e-NAM Latest Videos</div>
	<div class="focus-news">
		<marquee height="400" onMouseOut="start();" onMouseOver="stop();" direction="up" scrollamount="2">
			<?php //if(count($newses)>0){ ?>
				<?php //foreach($newses as $news) {
					//if($news['lang_id'] == $this->session->userdata['client_language']){
						//if(strlen( $news['news_contect']>100))
						//{
						?>
						<div class="focus-news-feilds">
							<p><?php //echo substr($news['news_contect'],0,100).".."; ?></p>
					<?php 
						//}
						//else{
						?>	
						<div class="focus-news-feilds">
						<p><?php // echo $news['news_contect'];
						//}
					//}
					?>
					</div>
				<?php //} ?>
			<?php //} else { ?>
				no videos.
			<?php //} ?>
		</marquee>
	</div>
</div>
