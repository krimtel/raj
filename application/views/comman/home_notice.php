<div class="focus-section">
	<div class="sidebar-header-title" style="margin-bottom:0;">e-NAM Latest News</div>
	<div class="focus-news">
		<marquee height="400" onMouseOut="start();" onMouseOver="stop();" direction="up" scrollamount="2">
			<?php if(count($newses)>0){ ?>
				<?php foreach($newses as $news) {
					$str = html_entity_decode($news['news_contect']);
					
					
					$regex = "/\[(.*?)\]/";
					$data['output'] = $str;
					preg_match_all($regex, $str, $matches);
					for($i =0; $i < count($matches[1]); $i++){
						$news['news_contect'] = str_replace($matches[0][$i],$this->substring->image_path(),$news['news_contect']);
					}
					
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
