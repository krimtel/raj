<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Password</li>
    </ol>   
   <section class="content-header">
      <h1>change Password</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Change Password</h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<?php echo $this->session->flashdata('message');?>
				<form role="form" class="form-horizontal" id="change_password" name="change_password" method="post" action="<?php echo base_url();?>admin/Auth/change_password">
					<?php 
				if(isset($u_detail) && (count($u_detail) > 0)){
					foreach( $u_detail as $user){
				?>
					<div class="box-body">
						<div class="form-group">
						  <label class="col-sm-3 control-label">Please Enter Old Password</label>
						  <div class="col-sm-9">
						  	<input type="password" id="o_pass" name="o_pass" class="form-control">
						   	<div class="text-danger" id="o_pass_error" style="display:none;"></div></div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">Enter New Password</label>
						  <div class="col-sm-9"><input type="password" id="n_pass" name="n_pass" class="form-control">
						   <div class="text-danger" id="n_pass_error" style="display:none;"></div></div>
						</div>
						<div class="form-group">
						  <label class="col-sm-3 control-label">Confirm New Password</label>
						  <div class="col-sm-9"><input type="password" id="c_n_pass" name="c_n_pass" class="form-control">
						   <div class="text-danger" id="c_n_pass_error" style="display:none;"></div></div>
						</div>
						</div>
						 <div class="col-sm-9"><input type="hidden" id="uid" name="uid" class="form-control" value="<?php echo $user['id'];?>"></div>
					</div>
					<div class="box-footer">
						<button id="change_password" name="change_password" type="button" class="btn pull-right btn-info">Update</button>
						<button type="reset" id="language_reset" class="btn btn-default pull-right btn-space">Cancel</button>
					</div>
					<?php 
					}
				}
					?>
				</form>
			</div>
		</section>
		</div>
		</section>
</div>