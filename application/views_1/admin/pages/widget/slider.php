<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Events</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Sliders</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        
        <?php if($group != 'subadmin'){ ?>
		<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Slider</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form name="slider_form" id="slider_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Slider_ctrl/slider_create">
			<div class="box-body">
			<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Slider Photo</label>
					<div class="col-sm-9">
						<div><img width="40" id="image_upload_preview" /></div>
						<input type="file" name="userFiles" id="userFiles" class="form-control">
						<div class="text-danger" id="userfile_error" style="display:none;"></div>
					</div>
				</div>
			<?php } ?>
				
			  	<div class="form-group">
					<label class="col-sm-3 control-label">Alt Tag</label>
					<div class="col-sm-9">
						<input type="text" name="slider_alt" id="slider_alt" class="form-control">
						<div class="text-danger" id="slider_alt_error" style="display:none;"></div>
					</div>
				</div>
				
			
				  <input id="slider_id" name="slider_id" type="hidden" class="form-control" value="">
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Sort Order</label>
					<div class="col-sm-9">
						<input type="text" id="slider_order" name="slider_order" class="form-control" placeholder="Enter sort order" value="999"/>
						<div class="text-danger" id="slider_order_error" style="display:none;"></div>
					</div>
				</div>
				<?php } ?>
			</div>
				<div class="box-footer">
					<button id="slider_create" type="button" class="btn pull-right btn-info">Save</button>
					<button id="slider_update" type="button" class="btn pull-right btn-info" style="display: none;">Update</button>
					<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
				</div>
			</form>
		</div>
		</section>
		<?php } ?>
		<?php if($group == 'subadmin'){ ?>
			<section class="col-lg-6 connectedSortable">
		<?php }else { ?>
			<section class="col-lg-6 connectedSortable">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All Sliders</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<?php if((isset($sliders)) && (count($sliders) > 0)){ ?>
				<table class="table">
					<tr>
						<th>Alt Tag</th>
						<th>Image</th>
						<?php if($group != 'subadmin') { ?>
							<th>Sort</th>
							<th>Publish</th>
						<?php } ?>
						<th> Actions </th>
					</tr>
						<tbody>
							<?php 
							if(isset($sliders) && count($sliders) > 0){
							foreach($sliders as $slider){?>
								<?php if($slider['lang_id'] == 1){
									$find = 0;
									foreach($sliders as $slide){
										if($slide['slider_id'] == $slider['slider_id'] && $slide['lang_id'] == $this->session->userdata('language')){
											$find = 1;
										}
									}
									?>
								<tr class="<?php if(!$find){ echo "find"; } ?>">
									<td><?php echo $slider['alt_tag']; ?></td>
									<td><img alt="" width="50" src="<?php echo base_url();?>Slider_gallary/1/<?php echo $slider['slider_image'];?>" /></td>
									<?php if($group == 'admin'){ ?>
										<td> <?php echo $slider['sort']?></td>
										
										<?php if($slider['publish'] == '1') {?>
											<td><input  class="slider_published" data-slider_id="<?php echo $slider['s_id']; ?>" type="checkbox" checked /></td>
										<?php } else {?>
											<td><input class="slider_published" data-slider_id="<?php echo $slider['s_id']; ?>" type="checkbox" /></td>
										<?php } ?>
									<?php } ?>
									<td>
									<?php if($group == 'subadmin'){ ?>
										<a href="javascript:void(0);" class="btn btn-info btn-flat slider_tranlate" data-slider_id="<?php echo $slider['s_id'];?>"><i class="fa fa-language"></i></a>
									<?php } else { ?>
										<a href="javascript:void(0);" class="btn btn-info btn-flat slider_edit" data-slider_id="<?php echo $slider['s_id'];?>"><i class="fa fa-pencil"></i></a>
										<?php if($group == 'admin'){ ?>
										<a href="javascript:void(0);" class="btn btn-info btn-flat slider_delete" data-slider_id="<?php echo $slider['s_id']; ?>"><i class="fa fa-trash"></i></a>
									<?php } } ?>
										
									</td>
								</tr>
						<?php } } } ?>
						</tbody>
				</table>
				<?php }else {?> 
					<div>No slider found.</div>
				<?php }?>
            </div>
		</div>
		</section>
		<?php if($group == 'subadmin'){ ?>
		<?php if($group == 'subadmin'){ ?>
			<section class="col-lg-6 connectedSortable">
		<?php }else { ?>
			<section class="col-lg-6 connectedSortable">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			<?php if(isset($language)){ ?>
			  	<h3 class="box-title">All Sliders (<?php echo $language['l_name']; ?>)</h3>
			  <?php }?>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body">
				<?php if((isset($sliders)) && (count($sliders) > 0)){ ?>
				<table class="table">
					<tr>
						<th>Image</th>
						<th>Alt Tag</th>
						<?php if($group != 'subadmin') { ?>
							<th>Sort</th>
							<th>Publish</th>
						<?php } ?>
						<th>Action</th>
					</tr>
						<tbody>
							<?php 
							if(isset($sliders)  && count($sliders) > 0){
							foreach($sliders as $slider){?>
								<?php if($slider['lang_id'] == $this->session->userdata('language')){ ?>
								<tr>
									<td><img alt="" width="50" src="<?php echo base_url();?>Slider_gallary/<?php echo $this->session->userdata('language');?>/<?php echo $slider['slider_image'];?>" /></td>
									<td> <?php echo $slider['alt_tag']?></td>
									<?php if($group != 'subadmin') { ?>
										<td> <?php echo $slider['sort']?></td>
										<?php if($slider['publish'] == '1') {?>
											<td><input class="slider_published" data-slider_id="<?php echo $slider['s_id']; ?>" type="checkbox" checked /></td>
										<?php } else {?>
											<td><input class="slider_published" data-slider_id="<?php echo $slider['s_id']; ?>" type="checkbox" /></td>
										<?php } ?>
									<?php }?>
									<td>
										<a href="javascript:void(0);" class="slider_edit" data-slider_id="<?php echo $slider['s_id'];?>"><i class="fa fa-language"></i></a>
										<?php if($group != 'subadmin') { ?>
											<a href="javascript:void(0);" class="slider_delete" data-slider_id="<?php echo $slider['s_id']; ?>"><i class="fa fa-trash"></i></a>
										<?php } ?>
									</td>
								</tr>
						<?php } } }?>
						</tbody>
				</table>
				<?php }else {?> 
					<div>No slider found.</div>
				<?php }?>
            </div>
		</div>
		</section>
		<?php } ?>
		</div>
	</section>
</div>
