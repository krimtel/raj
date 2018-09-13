<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">News</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">home title</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        
	<section class="col-sm-offset-2 col-lg-8">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Home Page title's</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<p class="text-danger"><?php echo $this->session->flashdata('message'); ?></p>
			<form name="news_form" id="news_form" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/News_ctrl/news_create">
			<div class="box-body">
				<div class="form-group">
					<div class="col-sm-12">
						<textarea id="title_body" name="title_body" class="form-control" rows="10" placeholder="Enter description"><?php print_r($file_body); ?></textarea>
						<div class="text-danger" id="news_desc_error" style="display: none;"></div>
					</div>
				</div>
				
			</div>
				<div class="box-footer">
					<button id="title_update" type="button" class="btn pull-right btn-info">Update</button>
					<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
				</div>
			</form>
		</div>
		</div>
		</section>
</div>
