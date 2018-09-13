<div class="content-wrapper">
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Training</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Training</h1>
 <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
    </section>
<section class="content" >
<div class="row">
	<div class="col-md-12 emandi-select ">
<div class="box box-primary">
<div class="box-header with-border">

			 			

<div class="col-md-3">
<select class="form-control" id="training_state_admin">
					<option value="0">Select State</option>
					<?php if(count($states)>0){ 
						foreach($states as $state){ ?>
							<option value="<?php echo $state['state_code']; ?>"><?php echo $state['name']; ?></option>
					<?php } } ?>
				</select>
</div>
<div class="col-md-3">
				<select class="form-control" id="training_apmc_admin">
					<option value="0">Select APMC</option>
				</select>
</div>
<div class="col-md-3">
				<select class="form-control" id="training_round_admin">
					<option value="0">Select Round</option>
					<option value="1">I</option>
					<option value="2">II</option>
				</select>
</div>
<div class="col-md-3">
				<button class="btn btn-success" id="training_search_admin">
					Search
				</button>
			</div>
</div>
<div class="box-body table-responsive no-padding">			
<div class="col-md-12" id="training_data_lists"> 

			</div>
</div></div></div>

	</div>	
</section>
</div>