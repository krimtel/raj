<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Events</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Events</h1>
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
			  <h3 class="box-title">Add New Event</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form name="event_form" id="event_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Event_ctrl/event_create">
			<div class="box-body">
			<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Event Photo</label>
					<div class="col-sm-10">
						<input type="file" name="userFiles" id="userFiles" class="form-control">
						<div class="text-danger" id="userfile_error" style="display:none;"></div>
					</div>
				</div>
			<?php } ?>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Event Title</label>
					<div class="col-sm-10">
						<input type="text" name="event_title" id="event_title" class="form-control">
						<div class="text-danger" id="event_title_error" style="display:none;"></div>
					</div>
				</div>
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Please Select Category</label>
			   <div class="col-sm-10">
			   	<select class="col-sm-2 form-control" id="event_category" name="event_category">
			   	<div class="text-danger" id="event_category_error" style="display:none;"></div>
			   		<option value="national">National Level </option>
			   		<option value="state">State Level </option>
			   		<option value="Event3_eNAM_GLIMPSES">Event3 eNAM GLIMPSES Level </option>
			   	</select>
			   </div>
			   </div>
			   <?php } ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Event Description</label>
					<div class="col-sm-10">
						<textarea id="event_desc" name="event_desc" class="form-control" rows="10"></textarea>
						<div class="text-danger" id="event_desc_error" style="display:none;"></div>
						<input id="event_id" name="event_id" type="hidden" class="form-control" value="" />
			            <script>
			                CKEDITOR.replace('event_desc');
			            </script>
					</div>
				</div>
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Sort Order</label>
					<div class="col-sm-10">
						<input type="text" id="event_order" name="event_order" class="form-control" placeholder="Enter sort order" value="999"/>
						<div class="text-danger" id="event_order_error" style="display:none;"></div>
					</div>
				</div>
				<?php } ?>
			</div>
				<div class="box-footer">
					<button id="event_create" type="button" class="btn pull-right btn-info">Save</button>
					<button id="event_update" type="button" class="btn pull-right btn-info" style="display: none;">Update</button>
					<button type="reset" id="event_reseet" class="btn btn-default pull-right btn-space">Cancel</button>
				</div>
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
			  <h3 class="box-title">All Events</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body" id="event_box_list">
				<table class="table events-edit-bg">
					<tr>
						<th>Image</th>
						<th>Event</th>
						<th>Category</th>
						<?php if($group != 'subadmin') { ?>
							<th>Sort</th>
							<th>Publish</th>
							<th>Show Homepage</th>
						<?php } ?>
						<th>Action</th>
					</tr>
					<tbody>
						<?php if(isset($events) && (count($events) > 0)){ 
								foreach($events as $event) { ?>
								<?php if($event['lang_id'] == 1) {
									$find=0;
									foreach($events as $even){
										if($even['event_id'] == $event['event_id'] && $even['lang_id'] == $this->session->userdata('language')){
											$find = 1;
										}
									}
									?>
								<tr class="<?php if(!$find){ echo "find"; } ?>">
									
									<td><img width="90" src="<?php echo base_url()."Event_gallary/".$event['event_image']; ?>"></td>
									<td ><?php echo substr($event['title'],0,100); ?></td>
									<td><?php echo $event['event_category']; ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $event['sort']; ?></td>
										<td>
											<?php if($event['publish']){ ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox" />
											<?php } ?>
										</td>
										<td>
										<?php if($event['is_home']){ ?>
												<input class="is_home" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="is_home" data-event_id="<?php echo $event['event_id']?>" type="checkbox" />
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a class="btn btn-info btn-flat event_tranlate" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-language"></i></a>
										<?php } else { ?>
											<a class="btn btn-info btn-flat event_edit" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-pencil"></i></a> 
									    	<a class="btn btn-info btn-flat event_delete" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-trash"></i></a>
										<?php } ?>
									</td>
								</tr>
						<?php } } }?>
					</tbody>
				</table>
            </div>
			<div class="well">
					<select class="col-sm-2" id="event_page_counter"></select>
					
					<select class="col-sm-2" id="event_is_home">
						<option value="NULL">IS HOME</option>
						<option value="1">YES</option>
						<option value="0">NO</option>
					</select>
					
					<select class="col-sm-2" id="event_is_active">
						<option value="NULL">IS ACTIVE</option>
						<option value="1">YES</option>
						<option value="0">NO</option>
					</select>
					<input type="text" id="event_search"/>
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
			  	<h3 class="box-title">All Events (<?php echo $language['l_name']; ?>)</h3>
			<?php } ?>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<table class="table">
					<tr>
						<th>Image</th>
						<th>Event</th>
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
									<td><img width="90" src="<?php echo base_url()."Event_gallary/".$event['event_image']; ?>"></td>
									<td><?php echo substr($event['title'],0,100); ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $event['sort']; ?></td>
										<td>
											<?php if($news['publish']){ ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox" />
											<?php } ?>
										</td>
										<td>
											<?php if($event['is_home']){ ?>
												<input class="is_home" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="is_home" data-event_id="<?php echo $event['event_id']?>" type="checkbox" />
											<?php } ?>
										</td>
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<a class="event_tranlate" data-event_id="<?php echo $event['event_id']?>"><i class="fa fa-language"></i></a>
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
