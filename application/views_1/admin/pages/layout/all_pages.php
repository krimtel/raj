<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">All Pages</h1>
	  <a href="<?php echo base_url();?>admin/admin/add_page" title="Add New Page" class="btn pull-right btn-info"> <i class="fa fa-plus"></i> Add New Page</a>
	   <form class="form-inline my-2 my-lg-0 mr-lg-2 pull-right">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search pages..." style="width:180px;">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button" style="padding:6px;margin-right:10px;">
                  Search page
                </button>
              </span>
            </div>
          </form>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
		<section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All Pages List</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped">
                <tr>
                  <th>S.No.</th>
                  <th>Page name</th>
                  <th>Action</th>
                </tr>
                <tbody>
					<?php
					$c = 1;
					foreach($pages as $page){ ?>
                		<tr>
                  			<td><?php echo $c;?></td>
                  			<td><?php echo $page['page_name']; ?></td>
                  			<td>
                  				<a title="Edit" href="<?php echo base_url();?>admin/admin/add_page/<?php echo$page['p_id'];?>" class="page_edit btn btn-info btn-flat"><i class="fa fa-pencil"></i></a>
                  				<a title="Delete" class="class_delete btn btn-info btn-flat"><i class="fa fa-trash"></i></a>
                  			</td>
                		</tr>
                	<?php $c++; } ?>
            	</tbody>
              </table>
            </div>
		</div>
		</section>
		</div>
		</section>
</div>