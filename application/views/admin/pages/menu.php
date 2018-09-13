<style>
.accordion .card-header:after {
    font-family: 'FontAwesome';  
    content: "\f068";
    float: right; 
}
.accordion .card-header.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\f067"; 
}
</style>

<div class="main-content-sec container-fluid">
<!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Menus</li>
      </ol>
        <select class="pull-rigth">
        	<?php if(isset($laguages)){
        		foreach($laguages as $laguage){
        		?>
        		<option value="<?php echo $laguage['l_id']; ?>"><?php echo $laguage['l_name']; ?></option>
        	<?php } } ?>
        </select>
      
      <div class="row">
	  	  <div class="col-8 card card-body bg-light">
	    	<div id="menu_menu" style="display: block;">
		    	<form id="menu_menu">
		    	  <div class="form-group">
				    <label for="formGroupExampleInput">Auto Genrated</label>
				    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
				  </div>
				  <div class="form-group">
				    <label for="menuname">Menu Name</label>
				    <input type="text" class="form-control" id="menuname" placeholder="Example input">
				  </div>
				  <div class="form-group">
				    <label for="menuparent">Select Parent</label>
				    <select class="form-control" id="menu_menu_parent">
				    	<option value="0">Select Parent</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <input type="submit" class="btn btn-success" value="Submit">
				    <input type="reset" class="btn btn-warning" value="Cancel">
				  </div>
				</form> 
			</div> 	
		
		  </div>
	      <!-- Right side panel showing the tree view of menus -->
	      <div class="col-4 card card-body bg-light">
	      	<?php foreach($menu as $key => $value) {
	      			echo $value;
	      		}
	      	?>
	      	<a href="javascript:void(0);" id="add_menu" data-mid="0">Click to Add More Menu.</a>
	      </div>
      </div>
</div>