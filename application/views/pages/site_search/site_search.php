<section class="content-section" >
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;padding-top:20px;padding-bottom:35px;">
		<div class="row">
			<div class="col-md-12">

<div class="side-bar-section">
	<div class="search-widget">
		<h3>SITE SEARCH</h3>
		<form id="site_search_form" name="f1" method="POST" action="<?php echo base_url();?>site_search">
			<input id="site_search" name="site_search" value="<?php echo $text;?>" placeholder="Search here..." type="text" />
		</form>
		<i class="fa fa-search"></i>
	</div>
</div>

<?php
if(isset($suggestions)){ ?>
	<?php foreach ($suggestions as $suggestion){
		if($suggestion['is_static'] == '0'){ ?>
                        <h3><?php echo $suggestion['title']; ?></h3>
			<h5><a href="<?php echo base_url().$suggestion['cms_url']; ?>"><?php echo base_url().$suggestion['cms_url']; ?></a></h5>
			<p><?php echo $this->substring->trim_text($suggestion['page_body'],300) ?></p>
   <?php } else { ?>
                        <h3><?php echo $suggestion['title']; ?></h3>
   			<h5><a href="<?php echo base_url().$suggestion['url']; ?>"><?php echo base_url().$suggestion['url']; ?></a></h5>
			<p><?php echo $this->substring->trim_text($suggestion['page_body'],300) ?></p>
   <?php }?>		
<?php }
}
else{ ?>
	<p class="text-center">No Record Found. Please search with diffrent keywords.</p>  
<?php }
?>
</div>
</div>
</div>
</section>