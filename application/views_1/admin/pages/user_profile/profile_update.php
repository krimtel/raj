<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Profile Update</li>
    </ol>   
   <section class="content-header">
      <h1>Profile</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title"> User Profile</h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<form role="form" class="form-horizontal" id="profile_form" name="profile_form" method="post"enctype="multipart/form-data" action="<?php echo base_url();?>admin/User_profile_ctrl/profile_update">
				<?php 
				if(isset($u_detail) && (count($u_detail) > 0)){
					foreach( $u_detail as $user){
				?>
					<div class="box-body">
						<div class="form-group">
						  <label class="col-sm-3 control-label">First Name</label>
						  <div class="col-sm-9">
						  	<input type="text" id="f_name" name="f_name" class="form-control" value="<?php echo $user['first_name'];?>">
						   	<div class="text-danger" id="f_name_error" style="display:none;"></div></div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">Last Name</label>
						  <div class="col-sm-9"><input type="text" id="l_name" name="l_name" class="form-control" value="<?php echo $user['last_name'];?>">
						   <div class="text-danger" id="l_name_error" style="display:none;"></div></div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">Contact No.</label>
						  <div class="col-sm-9"><input type="text" id="contact" name="contact" class="form-control" value="<?php echo $user['phone'];?>">
						   <div class="text-danger" id="contact_error" style="display:none;"></div></div>
						</div>
						<div class="form-group">
					<label class="col-sm-3 control-label">Profile Photo</label>
					<div class="col-sm-6">
						<input type="file" name="userFiles" id="userFiles" class="form-control">
						<div class="text-danger" id="userfile_error" style="display:none;"></div>
					</div>
					<div class="col-sm-3">
						<img width="40" id="image_upload_preview" />
						<img width="100" class="img-circle" src="<?php echo base_url()."User_gallary/".$user['photo']; ?>" id="myImg">
					</div>
				</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">Email</label>
						  <div class="col-sm-9"><input type="email" id="email" name="email" readonly="readonly" class="form-control" value="<?php echo $user['email'];?>">
						   <div class="text-danger" id="email_error" style="display:none;"></div></div>
						</div>
						 <div class="col-sm-9"><input type="hidden" id="uid" name="uid" class="form-control" value="<?php echo $user['id'];?>"></div>
					</div>
				<?php 
					}
				?>
			<?php 	}
				?>
					<div class="box-footer">
						<button id="profile_update" type="button" class="btn pull-right btn-info">Update</button>
						<button type="reset" id="language_reset" class="btn btn-default pull-right btn-space">Cancel</button>
					</div>
				</form>
			</div>
		</section>
		</div>
		</section>
</div>