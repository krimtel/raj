<div class="quick-link-list">
	<ul>
		<?php if(count($links) > 0) { 
			foreach($links as $link){ ?> 
				<li>
					<?php echo $link['link_contect']; ?>
				</li>			
		<?php } } ?>
	</ul>
</div>