<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Components</li>
     </ol>   
	<section class="content-header">
      <h1>Components</h1>
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
					<h3 class="box-title">Add New Component</h3>
					<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
					</div>
				</div>
				<form name="widget_form" id="widget_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Widget_ctrl/widget_create">
					<div class="box-body">
	 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Name</label>
						  <div class="col-sm-10">
						  	<input type="text" class="form-control" name="widget_name" id="widget_name" placeholder="Enter name" value="" />
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Title</label>
						  <div class="col-sm-10">
						  	<input type="text" class="form-control" name="widget_title" id="widget_title" value="">
						  </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Content</label>
							<div class="col-sm-10">
								<textarea id="widget_content" name="widget_content" class="form-control" rows="10"></textarea>
								<input id="widget_id" name="widget_id" type="hidden" class="form-control" value="" />
			            		<script>
			                		CKEDITOR.replace('widget_content');
			            		</script>
							</div>
						</div>
					</div>
					
				</form>
				<div class="box-footer">
						<button id="widget_update" type="button" class="btn pull-right btn-info" style="display:none;">Update</button>
						<button id="widget_create" type="button" class="btn pull-right btn-success">Submit</button>
						<button id="widget_reset"  type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
					</div>
			</div>
		</section>
		
		<?php if($group == 'subadmin'){ ?>
		<section class="col-lg-4 connectedSortable">
		<?php } else {?>
		<section class="col-lg-6 connectedSortable">
		<?php } ?>
			<div class="box box-primary">
				<div class="box-header with-border">
			  		<h3 class="box-title">All Component List</h3>
			  		<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  		<i class="fa fa-minus"></i></button>
			  		</div>
				</div>
				<div class="box-body table-responsive no-padding">
              		<table class="table table-hover">
                		<tr>
                  			
                  			<th>Component Name</th>
                  			<th>Shortcode</th>
                  			<th>Content</th>
                  			<th>Edit/Delete</th>
                		</tr>
                		<tbody id="language_users_display">
						<?php if(isset($widget) && (count($widget)>0)){			
						foreach($widget as $widgets){ 
							if($widgets['lang_id'] == 1) {
							$find = 0;
							foreach($widget as $wid){
						
								if($wid['id'] == $widgets['id'] && $wid['lang_id'] == $this->session->userdata('language')){
									$find = 1;
								}
							}
							?> 
							<tr class="<?php if(!$find){ /*echo "find";*/ } ?>">
	                  			<td><?php echo $widgets['name']; ?></td>
	                  			<td><?php echo "[shortcode:enam:".$widgets['name']."]"; ?></td>
	                  			<td title="<?php echo $widgets['content'];?>"><?php echo $this->substring->trim_text($widgets['content'],15); ?></td>
	                  			
	                  			<td>
	                  				<a title="Edit" class="btn btn-info btn-flat widget_edit" data-widget_id="<?php echo $widgets['id']; ?>"><i class="fa fa-pencil"></i></a>
	                  				<a title="Delete" class="btn btn-info btn-flat widget_delete" data-widget_id="<?php echo $widgets['id']; ?>"><i class="fa fa-trash"></i></a>
	                  				
	                  			</td>
                			</tr>	
					<?php
							}
						}
				}?>
            		</tbody>
              </table>
            </div>
		</div>
	</section>
	<?php if($group == 'subadmin'){ ?>
	<?php if($group == 'subadmin'){ ?>
		<section class="col-lg-4 connectedSortable">
		<?php } else {?>
		<section class="col-lg-6 connectedSortable">
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
				<div class="box-body table-responsive no-padding">
              		<table class="table table-hover">
                		<tr>
                  			<th>Widget Name</th>
                  			<th>Content</th>
                  			<th>Edit/Delete</th>
                		</tr>
                		<tbody id="language_users_display">
						<?php if(isset($widget) && (count($widget)>0)){
						foreach($widget as $widgets){ 
						if($widgets['lang_id'] == $this->session->userdata('language')) { ?>
							<tr">
	                  			<td><?php echo $widgets['name']; ?></td>
	                  			<td title="<?php echo $widgets['content'];?>"><?php echo $this->substring->trim_text($widgets['content'],15); ?></td>
	                  			<td>
	                  				<a title="Edit" class="btn btn-info btn-flat widget_edit" data-widget_id="<?php echo $widgets['id']; ?>"><i class="fa fa-pencil"></i></a>
	                  				<a title="Delete" class="btn btn-info btn-flat widget_delete" data-widget_id="<?php echo $widgets['id']; ?>"><i class="fa fa-trash"></i></a>
	                  			</td>
                			</tr>	
					<?php } } }?>
            		</tbody>
              </table>
            </div>
		</div>
	</section>
	<?php } ?>
	
	</div>
	</section>
</div>
