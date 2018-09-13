<div class="main-content-sec container-fluid">
	<ol class="breadcrumb">
    	<li class="breadcrumb-item">
			<a href="#">Dashboard</a> 
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
  	</ol>  
   	<hr>
    <div class="col-sm-offset-4 col-sm-4" style="border:solid #caf7f3 2px; border-top-left-radius:8px;">
		<div class="offset-3 col-6 card card-body">
	    	<p class="text-danger"><?php echo $this->session->flashdata('message'); ?></p>
	      	<form name="login_form" method="POST" action="<?php echo base_url();?>admin/Auth/login"> 
				<div class="form-group">
			    	<label for="formGroupExampleInput">Identity</label>
			    	<input type="text" name="identity"  class="form-control" id="identity" autocomplete="off" placeholder="Enter email id" />
			    	<div id="identity_err" class="text-danger" style="display:none;"></div>
			    	<?php echo form_error('identity'); ?>
			  	</div>
			  
		  		<div class="form-group">
		    		<label for="formGroupExampleInput2">Password</label>
		    		<input type="password" name="password" class="form-control" id="password" placeholder="Password" />
		    		<div id="password_err" class="text-danger" class="form-control" style="display: none;"></div>
		     		<?php echo form_error('password'); ?>
		  		</div>
			  
		  		<div class="form-group">
		    		<input type="submit" class="btn btn-success btn-space" value="Login" />
		    		<input type="reset" class="btn btn-light" value="Cancel" />
		  		</div>
			</form>   
		</div>
    </div>
</div>