<?php //print_r($this->session->all_userdata()); die;?>
<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Links</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Links</h1>
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
			  <h3 class="box-title">Add New Links</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form name="link_form" id="link_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Links_ctrl/link_create">
			<div class="box-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">Link content</label>
					<div class="col-sm-10">
						<textarea id="link_desc" name="link_desc" class="form-control" rows="10"></textarea>
						<div class="text-danger" id="link_desc_error" style="display: none;"></div>
						<input id="link_id" name="link_id" type="hidden" class="form-control" value="" />
			            <script>
			                CKEDITOR.replace('link_desc');
			            </script>
					</div>
				</div>
				
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Sort Order</label>
					<div class="col-sm-10">
						<input type="text" id="link_order" name="link_order" class="form-control" value="999" placeholder="Enter sort order" />
						<div class="text-danger" id="link_order_error" style="display: none;"></div>
					</div>
				</div>
				<?php } ?>
				
			</div>
			</form>
			<div class="box-footer">
				<button id="link_create" type="submit" class="btn pull-right btn-info">Save</button>
				<button id="link_update" type="submit" class="btn pull-right btn-info" style="display: none;">Update</button>
				<button type="reset" id="link_reset" class="btn btn-default pull-right btn-space">Cancel</button>
			</div>
		</div>
		</section>
		
		<?php if($group == 'subadmin'){ ?>
			<section class="col-lg-4 connectedSortable">
		<?php }else { ?>
			<section class="col-lg-6 connectedSortable">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All Links</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<table class="table">
					<tr>
						<th>Links</th>
						<?php if($group != 'subadmin'){ ?>
							<th>Sort</th>
							<th>Publish</th>
						<?php } ?>
						<th>Action</th>
					</tr>
					<tbody>
						<?php if(isset($links) && (count($links) > 0)){ 
								foreach($links as $link) { ?>
								<?php if($link['lang_id'] == 1) {
									$find=0;
									foreach($links as $lin){
										if($lin['link_id'] == $link['link_id']  && $lin['lang_id'] == $this->session->userdata('language')){
											$find = 1;
										}
									}
									?>
								<tr class="<?php if(!$find){ echo "find"; } ?>">
									<td><?php echo $link['link_contect']; ?></td>
									
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $link['sort']; ?></td>
										<td>
											<?php if($link['publish']){ ?>
												<input class="link_published" data-link_id="<?php echo $link['link_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="link_published" data-link_id="<?php echo $link['link_id']?>" type="checkbox" />
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a class="btn btn-info btn-flat link_tranlate" data-link_id="<?php echo $link['link_id']?>"><i class="fa fa-language"></i></a>
										<?php } else { ?>
											<a class="btn btn-info btn-flat link_edit" data-link_id="<?php echo $link['link_id']?>"><i class="fa fa-pencil"></i></a> 
									    	<a class="btn btn-info btn-flat link_delete" data-link_id="<?php echo $link['link_id']?>"><i class="fa fa-trash"></i></a>
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
						<th>Links</th>
						<?php if($group != 'subadmin'){ ?>
							<th>Sort</th>
							<th>Publish</th>
						<?php } ?>
						<th>Action</th>
					</tr>
					<tbody>
						<?php if(isset($links) && (count($links) > 0)){ 
								foreach($links as $link) { ?>
								<?php if($link['lang_id'] == $this->session->userdata('language')) { ?>
								<tr>
									<td><?php echo $link['link_contect']; ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $link['sort']; ?></td>
										<td>
											<?php if($link['publish']){ ?>
												<input class="link_published" data-link_id="<?php echo $link['link_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="link_published" data-link_id="<?php echo $link['link_id']?>" type="checkbox" />
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a title="" class="link_tranlate" data-link_id="<?php echo $link['link_id']?>"><i class="fa fa-language"></i></a>
										<?php } else { ?>
											<a title="Edit" class="link_edit" data-news_id="<?php echo $link['link_id']?>"><i class="fa fa-pencil"></i></a> 
									    	<a title="Delete" class="link_delete" data-news_id="<?php echo $link['link_id']?>"><i class="fa fa-trash"></i></a>
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
