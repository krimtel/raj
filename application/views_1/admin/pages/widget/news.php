<?php //print_r($this->session->all_userdata()); die;?>
<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">News</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">News</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        
        <?php if($group == 'subadmin'){ ?>
			<section class="col-lg-4 connectedSortable">
		<?php } else { ?>
			<section class="col-lg-6 connectedSortable">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New News/Notice</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<p class="text-danger"><?php echo $this->session->flashdata('message'); ?></p>
			<form name="news_form" id="news_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/News_ctrl/news_create">
			<div class="box-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">News Description</label>
					<div class="col-sm-10">
						<textarea id="news_desc" name="news_desc" class="form-control" rows="10" placeholder="Enter description"></textarea>
						<div class="text-danger" id="news_desc_error" style="display: none;"></div>
						<input id="news_id" name="news_id" type="hidden" class="form-control" value="" />
			            <script>
			                CKEDITOR.replace('news_desc');
			            </script>
					</div>
				</div>
				
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Sort Order</label>
					<div class="col-sm-10">
						<input type="text" id="news_order" name="news_order" class="form-control" placeholder="Enter sort order" value="999" />
						<div id="news_order_error" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<?php } ?>
				
			</div>
				<div class="box-footer">
					<button id="news_create" type="button" class="btn pull-right btn-info">Save</button>
					<button id="news_update" type="button" class="btn pull-right btn-info" style="display: none;">Update</button>
					<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
				</div>
			</form>
			</form>
			
		</div>
		
		</section>
		
		<?php if($group == 'subadmin'){ ?>
			<section class="col-lg-4 connectedSortable">
		<?php }else { ?>
			<section class="col-lg-6 connectedSortable">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All News</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<table class="table">
					<tr>
						<th>News</th>
						<?php if($group != 'subadmin'){ ?>
							<th>Sort</th>
							<th>Publish</th>
						<?php } ?>
						<th>Action</th>
					</tr>
					<tbody>
						<?php if(isset($newses) && (count($newses) > 0)){
								foreach($newses as $news) { ?>
								<?php if($news['lang_id'] == 1) {
									$find = 0;
									foreach($newses as $new){
										if($new['news_id'] == $news['news_id'] && $new['lang_id'] == $this->session->userdata('language')){
											$find = 1;
										}
									}
								?>
								<tr class="<?php if(!$find){ echo "find"; } ?>">
									<td ><?php echo $news['news_contect']; ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $news['sort']; ?></td>
										<td>
											<?php if($news['publish']){ ?>
												<input class="news_published" data-news_id="<?php echo $news['news_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="news_published" data-news_id="<?php echo $news['news_id']?>" type="checkbox" />
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a class="btn btn-info btn-flat news_tranlate" data-news_id="<?php echo $news['news_id']?>"><i class="fa fa-language"></i></a>
										<?php } else { ?>
											<a class="btn btn-info btn-flat news_edit" data-news_id="<?php echo $news['news_id']?>"><i class="fa fa-pencil"></i></a> 
									    	<a class="btn btn-info btn-flat news_delete" data-news_id="<?php echo $news['news_id']?>"><i class="fa fa-trash"></i></a>
										<?php } ?>
									</td>
								</tr>
						<?php } } }?>
					</tbody>
				</table>
            </div>

			
		</div>
		</section>
		
		<?php if($group == 'subadmin'){ ?>
			<section class="col-lg-4 connectedSortable" style="display: block;">
		<?php } else { ?>
			<section class="col-lg-4 connectedSortable" style="display: none;">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			<?php if(isset($language)){ ?>
			  	<h3 class="box-title">All Menus (<?php echo $language['l_name']; ?>)</h3>
			<?php } ?>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<table class="table">
					<tr>
						<th>News</th>
						<?php if($group != 'subadmin'){ ?>
							<th>Sort</th>
							<th>Publish</th>
						<?php } ?>
						<th>Action</th>
					</tr>
					<tbody>
						<?php if(isset($newses) && (count($newses) > 0)){ 
								foreach($newses as $news) { ?>
								<?php if($news['lang_id'] == $this->session->userdata('language')) { ?>
								<tr>
									<td><?php echo $news['news_contect']; ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $news['sort']; ?></td>
										<td>
											<?php if($news['publish']){ ?>
												<input class="news_published" data-news_id="<?php echo $news['news_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="news_published" data-news_id="<?php echo $news['news_id']?>" type="checkbox" />
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a title="" class="btn btn-info btn-flat news_tranlate" data-news_id="<?php echo $news['news_id']?>"><i class="fa fa-language"></i></a>
										<?php } else { ?>
											<a title="Edit" class="btn btn-info btn-flat news_edit" data-news_id="<?php echo $news['news_id']?>"><i class="fa fa-pencil"></i></a> 
									    	<a title="Delete" class="btn btn-info btn-flat news_delete" data-news_id="<?php echo $news['news_id']?>"><i class="fa fa-trash"></i></a>
										<?php } ?>
									</td>
								</tr>
						<?php } } }?>
					</tbody>
				</table>
            </div>

			
		</div>
		</section>
		</div>
		</section>
</div>
