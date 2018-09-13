<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add New Language</li>
    </ol>   
   <section class="content-header">
      <h1>Video Categories</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Add New video category</h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<form id="video_cat_form" role="form" method="POST" class="form-horizontal" name="video_cat_form" action="<?php echo base_url();?>admin/Video_ctrl/category_create">
					<div class="box-body">
						<div class="form-group">
						  <label class="col-sm-3 control-label">Category Name</label>
						  <div class="col-sm-9">
						  	<input type="text" id="v_category_name" name="v_category_name" class="form-control" placeholder="Enter category name">
						   	<div id="v_category_name_error" class="response text-danger" style="display: none;"></div>
						   </div>
						  <div class="col-sm-9"><input type="hidden" id="v_cat_id" name="v_cat_id" class="form-control" value=""></div>
						</div>
						
						<div class="form-group">
						  <label class="col-sm-3 control-label">Select parent</label>
						  <div class="col-sm-9">
						  	<select id="v_category_parent_drop_down" name="v_category_parent_drop_down" class="form-control">
						  		<option value="0">please select video parent category</option>
							  	<?php foreach($p_categories as $p_category){ ?>
							  		<option value="<?php echo $p_category['v_id'];?>"><?php echo $p_category['category_name']; ?></option>
							  	<?php }?>
						  		
						  	</select>
						   	<div id="v_category_parent_drop_down_error" class="response text-danger" style="display: none;"></div>
						   </div>
						</div>
					</div>
					<div class="box-footer">
						<button id="v_category_update" type="button" class="btn pull-right btn-info" style="display:none;">Update</button>
						<button id="v_category_create" type="button" class="btn pull-right btn-info">Submit</button>
						<button type="reset" id="v_category_reset" class="btn btn-default pull-right btn-space">Cancel</button>
					</div>
				</form>
			</div>
		</section>
		<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All Language List</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<thead>
					<tr>
                  <th>S.No.</th>
                  <th>Category</th>
                  <th>Edit/Delete</th>
					</tr>
				</thead>
					<tbody>
					
              <?php foreach($categories as $category){
	      				if($category['p_id'] == 0){

	      					if($category['category_name'] != ''){
	      						echo '<tr><td>01.</td><td class="v_cat_list_item" data-vc_id="'.$category['v_id'].'">'.$category['category_name'].'</td><td><a href="javascript:void(0);" class="btn btn-info btn-flat video_cat_delte" data-vid="'.$category['v_id'].'"><i class="fa fa-trash"></i></a></td></tr>';
	      					}
	      					$ic = 0;
	      					foreach($categories as $m1){
	      						if($m1['p_id'] == $category['v_id']){
	      							if($ic == 0){
	      								echo '<ul '.$ic.'>';
	      							}
	      							$ic = 1;
	      							if($m1['category_name'] != ''){
	      								echo '<tr><td>01</td><td class="v_cat_list_item" data-vc_id="'.$m1['v_id'].'">'.$m1['category_name'].'</td><td><a href="javascript:void(0);" class="btn btn-info btn-flat video_cat_delte" data-vid="'.$category['v_id'].'"><i class="fa fa-trash"></i></a></td></tr>';
	      							}
	      						}
	      						else{
	      							continue;
	      						}
	      					}
	      				}
	      		}
	      		?>
					</tbody>
				</table>
            </div>
		</div>
		</section>
		</div>
		</section>
</div>