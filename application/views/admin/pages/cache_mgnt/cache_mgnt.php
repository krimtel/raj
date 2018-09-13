<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
         <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cache Management</li>
    </ol>   
   <section class="content-header">
      <h1>Cache Management</h1>
    </section>
	<!-- Main content -->
		
		<section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Select All Files</h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
					<div class="box-body">
						<div class="col-sm-12">
							<input id="select_all" type="checkbox"> Select All
							<span class="pull-right"><a class="btn btn-info btn-flat" id="clear_cache" href="javascript:void(0);">Clear Cache</a></span>
						</div>
						<hr><hr>
						<div class="form-group">
						<table class="table table-hover">
						<thead><tr><th>Select</th><th>Files</th><th>Delete</th></tr></thead>
						<tbody>
						<?php 
						if(isset($files) && count($files) > 0 ){
							foreach($files as $file){
								if (pathinfo($file, PATHINFO_EXTENSION) === 'txt'){
									$x = file_get_contents(base_url().'/software_files/'.$file);
									if(strlen($x)>0){
										$class = 'find';
									}
									else{
										$class = '';
									}
									
									echo '<tr><td><input class="checkbox" type="checkbox" name="check[]" value="'.$file.'"/></td>';
									echo '<td>'.$file.'</td>';
						        	echo "<td><a class='btn btn-info btn-flat file_clr' name='file_clr'  data-file= $file><i class='fa fa-trash'></i> </a></td></tr>";
						        	
						    	}
							}
						}
						?>
						</tbody>
						</table>
						</div>
					</div>
			</div>
		</section>
		
		
		</div>
		</section>
</div>