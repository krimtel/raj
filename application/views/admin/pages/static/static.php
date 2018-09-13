<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Static page</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Static page</h1>
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
			  <h3 class="box-title">Static Pages List</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body">
			  <ul class="list-group">
				  	<li class="list-group-item">
				  		<a href="javascript:void(0);" class = "static_page" data-sp_id="1">Header</a>
				 	</li>
				  	<li class="list-group-item">
				  		<a href="javascript:void(0);" class = "static_page" data-sp_id="2">Footer</a>
				  	</li>
			  </ul>
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
			  <h3 class="box-title">Page Content</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<input type="text" id="static_page_id" value="">
				<textarea id="static_page_desc" name="static_page_desc" class="form-control" rows="10"></textarea>
				<div class="text-danger" id="static_page_desc_error" style="display:none;"></div>
	            <script>
	                CKEDITOR.replace('static_page_desc');
	          	</script>
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
						<?php if(isset($events) && (count($events) > 0)){ 
								foreach($events as $event) { ?>
								<?php if($event['lang_id'] == $this->session->userdata('language')) { ?>
								<tr>
									<td><?php echo $event['event_content']; ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $event['sort']; ?></td>
										<td>
											<?php if($news['publish']){ ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked>										
											<?php } else { ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox">
											<?php } ?>
										</td>
										<td>
											<?php if($event['is_home']){ ?>
												<input class="is_home" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked>										
											<?php } else { ?>
												<input class="is_home" data-event_id="<?php echo $event['event_id']?>" type="checkbox">
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a class="event_tranlate" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-heartbeat"></i></a>
										<?php } else { ?>
											<a class="event_edit" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-pencil"></i></a> 
									    	<a class="event_delete" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-trash"></i></a>
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
