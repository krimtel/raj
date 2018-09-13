<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add New Language</li>
    </ol>   
   <section class="content-header">
      <h1>Languages</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Add New Language</h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<form role="form" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
						  <label class="col-sm-3 control-label">New Language</label>
						  <div class="col-sm-9"><input type="text" id="language_name" class="form-control" placeholder="Enter new language">
						   <div id="language_response" class="response text-danger"></div></div>
			
						  <div class="col-sm-9"><input type="hidden" id="language_id" class="form-control" value=""></div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">Language Name In English</label>
						  <div class="col-sm-9"><input type="text" id="language_name_eng" class="form-control" placeholder="Enter new language">
						   <div id="language_response" class="response text-danger"></div></div>
			
						</div>
					</div>
					<div class="box-footer">
						<button id="language_update" type="button" class="btn pull-right btn-info" style="display:none;">Update</button>
						<button id="language_create" type="button" class="btn pull-right btn-info" disabled>Submit</button>
						<button type="reset" id="language_reset" class="btn btn-default pull-right btn-space">Cancel</button>
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
                <tr>
                  <th>S.No.</th>
                  <th>Language</th>
                  <th>Edit/Delete</th>
                </tr>
                <tbody id="class_display">
                	<?php if(isset($languages) && (count($languages) > 0)){
                		$c = 1;
                		foreach($languages as $language){ ?>
                		<tr>
	                		<td><?php echo $c; ?></td>
	                		<td><?php echo $language['l_name']; ?></td>
	                		<td>
	                		<a class="class_edit btn btn-info btn-flat language_edit" data-l_id="<?php echo $language['l_id']; ?>" data-l_name="<?php echo $language['l_name']; ?>" data-l_eng="<?php echo $language['l_eng']; ?>"><i class="fa fa-pencil"></i></a>
	                		<a class="class_delete btn btn-info btn-flat language_delete" data-l_id="<?php echo $language['l_id']; ?>" data-l_name="<?php echo $language['l_name']; ?>"><i class="fa fa-trash"></i></a>
	                		</td>
                		</tr>
                	<?php $c++; } } else {
                		
                	}?>
                	
            	</tbody>
              </table>
            </div>
		</div>
		</section>
		</div>
		</section>
</div>