<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add User</li>
     </ol>   
	<section class="content-header">
      <h1 class="pull-left">User</h1>
      <a href="javascript:void(0);" class="btn btn-warning pull-right" id="new_user_register" title="Register New User">Register New User</a>

    </section>
	
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add New User</h3>
					<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
					</div>
				</div>
				<form role="form" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
						  <label class="col-sm-3 control-label">Name</label>
						  <div class="col-sm-9">
						  	<select class="form-control" name="users_list_drop_down" id="users_list_drop_down">
						  		<option value="0">Select user</option>
						  		<?php if(isset($users) && (count($users) > 0)){ 
						  			foreach($users as $user){ ?>
						  			<option value="<?php echo $user['id']; ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
						  		<?php } } ?>
						  	</select>
						  </div>
						</div>
						<div class="form-group" id="users_language_drop_down_box" style="display: none;">
							<label class="col-sm-3 control-label">Select Language</label>
							<div class="col-sm-9">
								<select class="form-control" name="users_language_drop_down" id="users_language_drop_down">
									<option value="0" selected>Please select language</option>
									<?php if(isset($languages) && (count($languages)>0)){ 
										foreach($languages as $language){ ?>
											<option value="<?php echo $language['l_id']; ?>"><?php echo $language['l_name']; ?></option>	 
									<?php } } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button id="users_language_update" type="button" class="btn pull-right btn-info" style="display:none;">Update</button>
						<button id="users_language_create" type="button" class="btn pull-right btn-success">Submit</button>
						<button id="users_language_reset"  type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
					</div>
				</form>
			</div>
		</section>
		<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All User List</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Users</th>
                  <th>Language</th>
                  <th>Mail/Sms</th>
                  <th>Edit/Delete</th>
                </tr>
                <tbody id="language_users_display">
					<?php if(isset($users_lang) && (count($users_lang)>0)){
						$c = 1;
						foreach($users_lang as $user_lang){ ?> 
							<tr>
	                  			<td><?php echo $c; ?></td>
	                  			<td><?php echo $user_lang['first_name'].' '.$user_lang['last_name']; ?></td>
	                  			<td><?php echo $user_lang['l_name']; ?></td>
	                  			<td><a href="javascript:void(0);" class="user_mail" data-uname="<?php echo $user_lang['first_name'].' '.$user_lang['last_name']; ?>" data-uid="<?php echo $user_lang['id']; ?>" data-mail_id="<?php echo $user_lang['email']; ?>"><?php echo $user_lang['email']; ?></a></td>
	                  			<td>
	                  				<a class="class_edit btn btn-info btn-flat user_edit" data-u_id="<?php echo $user_lang['id']; ?>" data-lang_id="<?php echo $user_lang['l_id']; ?>"><i class="fa fa-pencil"></i></a>
	                  				<a class="class_delete btn btn-info btn-flat user_delete" data-u_id="<?php echo $user_lang['id']; ?>"><i class="fa fa-trash"></i></a>
	                  			</td>
                			</tr>	
					<?php $c = $c + 1; }
					}?>
            	</tbody>
              </table>
            </div>
		</div>
		</section>
		</div>
	</section>
</div>