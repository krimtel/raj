<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Events</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Videos</h1>
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
			  <h3 class="box-title">Add new Videos</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form name="video_form" id="video_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Video_ctrl/video_create">
			<div class="box-body">
			<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Video Url</label>
					<div class="col-sm-10">
						<input type="text" name="v_url" id="v_url" class="form-control">
						<div class="text-danger" id="v_url_error" style="display:none;"></div>
					</div>
				</div>
			<?php } ?>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Video Title</label>
					<div class="col-sm-10">
						<input type="text" name="v_title" id="v_title" class="form-control">
						<div class="text-danger" id="v_title_error" style="display:none;"></div>
					</div>
				</div>
				<?php if($group != 'subadmin') { ?>
				<div class="form-group">
				<label class="col-sm-2 control-label">Select Category</label>
				  <div class="col-sm-10">
				  	<select id="v_category" name="v_category" class="form-control">
				  		<option value="0">please select video category</option>
					  	<?php foreach($p_categories as $p_category){ ?>
					  		<?php if($p_category['p_id'] == 0){?>
					  			<option value="<?php echo $p_category['v_id'];?>"><?php echo $p_category['category_name']; ?></option>
					  		<?php } else { ?>
					  			<option value="<?php echo $p_category['v_id'];?>"><?php echo $p_category['p_name'].' -> '.$p_category['category_name']; ?></option>
					  		<?php } ?>
					  	<?php }?>
				  	</select>
				  	<div class="text-danger" id="v_category_error" style="display:none;"></div>
				  </div>
				</div>
				<?php }?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Video Content</label>
					<div class="col-sm-10">
						<textarea id="v_desc" name="v_desc" class="form-control" rows="10"></textarea>
						<div class="text-danger" id="v_desc_error" style="display:none;"></div>
						<input id="video_id" name="video_id" type="hidden" class="form-control" value="">
			            <script>
			                CKEDITOR.replace('v_desc');
			            </script>
					</div>
				</div>
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Sort Order</label>
					<div class="col-sm-10">
						<input type="text" id="v_order" name="v_order" class="form-control" placeholder="Enter sort order" value="999"/>
						<div class="text-danger" id="v_order_error" style="display:none;"></div>
					</div>
				</div>
				<?php } ?>
			</div>
				<div class="box-footer">
					<button id="video_create" type="button" class="btn pull-right btn-info">Save</button>
					<button id="video_update" type="button" class="btn pull-right btn-info" style="display: none;">Update</button>
					<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
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
			  <h3 class="box-title">All Videos</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body table-responsive">
				<table class="table table-hover">
					<tr>
						<th>Video</th>
						<th>Title</th>
						<th>Content</th>
						<?php if($group != 'subadmin') { ?>
							<th>Sort</th>
							<th>Publish</th>
							<th>Is Home</th>
							<?php } ?>
							<th> Actions </th>
					</tr>
					<tbody>
						<?php if(isset($videos) && (count($videos) > 0)){
								foreach($videos as $video){
									if($video['lang_id']==1){
										$find = 0;
										foreach($videos as $vid){
											if($vid['video_id'] == $video['video_id'] && $vid['lang_id'] == $this->session->userdata('language')){
												$find = 1;
											}
										}
										?>
										<tr class="<?php if(!$find){ echo "find"; } ?>">
										<?php $v = explode('/embed/',$video['v_url']); ?>
											<td> <img src='http://img.youtube.com/vi/<?php echo $v['1'];?>/0.jpg' height="100" width="100"></td>
											<td><?php echo $video['v_title'];?></td>
											<td><?php echo $video['v_content'];?></td>
											<?php if($group != 'subadmin'){ ?>
											
											<td><?php echo $video['sort'];?></td>
											<td><?php if($video['publish']){ ?>
	                                      <input class="video_published" data-video_id="<?php echo $video['video_id']?>" type="checkbox" checked>										
											<?php } else { ?>
												<input class="video_published" data-video_id="<?php echo $video['video_id']?>" type="checkbox">
											<?php } ?>
										</td>
										<td>
											<?php if($video['is_home']){ ?>
												<input class="video_is_home" data-video_id="<?php echo $video['video_id']?>" type="checkbox" checked />										
											<?php } else { ?>
												<input class="video_is_home" data-video_id="<?php echo $video['video_id']?>" type="checkbox" />
											<?php } ?>
										</td>
											<td><a class="btn btn-info btn-flat video_edit" data-video_id="<?php echo $video['video_id']?>"><i class="fa fa-pencil"></i></a> 
                                           <a class="btn btn-info btn-flat video_delete" data-video_id="<?php echo $video['video_id']?>"><i class="fa fa-trash"></i></a></td>
                                           <?php }
                                           else{ ?>
                                           	<td><a class="btn btn-info btn-flat video_tranlate" data-video_id="<?php echo $video['video_id']?>"><i class="fa fa-pencil"></i></a>
                                          <?php }
                                           ?>
										</tr>	
							
							<?php 		}
								}
							}
							?>
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
			  	<h3 class="box-title">All Videos (<?php echo $language['l_name']; ?>)</h3>
			<?php } ?>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body table-responsive">
				<table class="table table-hover">
					<tr>
						<th>Video</th>
						<th>Title</th>
						<th>Content</th>
						<th>Operation</th>
					</tr>
					<tbody>
						<?php if(isset($videos) && (count($videos) > 0)){ 
								foreach($videos as $video) { ?>
								<?php if($video['lang_id'] == $this->session->userdata('language')) { ?>
								<tr>
									<td><?php echo $video['v_url']; ?></td>
									<td><?php echo $video['v_title']; ?></td>
									<td><?php echo $video['v_content']; ?></td>
									<?php if($group != 'subadmin'){ ?>
										<td><?php echo $event['sort']; ?></td>
										<td>
											<?php if($news['publish']){ ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox" checked>										
											<?php } else { ?>
												<input class="event_published" data-event_id="<?php echo $event['event_id']?>" type="checkbox">
											<?php } ?>
										</td>
									
									<?php } ?>
									<td>
										<?php if($group == 'subadmin'){ ?>
											<td><a class="btn btn-info btn-flat  video_tranlate" data-video_id="<?php echo $video['video_id']?>"><i class="fa fa-pencil"></i></a>
										<?php }  ?>
											
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
