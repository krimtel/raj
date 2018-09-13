<?php $group = $this->session->userdata('group_name'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<ol class="breadcrumb">
        <li><a title="Home" href="<?php echo base_url();?>admin/admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Menus</li>
    </ol>   
	<section class="content-header">
      <h1 class="pull-left">Menus</h1>
    </section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
		<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add Menu</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="menu_create_form" role="form" class="form-horizontal" method="POST" action="<?php echo base_url();?>admin/Menu_ctrl/menu_create">
			<div class="box-body">
				<div class="form-group">
					<label class="col-sm-3 control-label">Menu name</label>
					<div class="col-sm-9">
						<input id="menu_name" name="menu_name" type="text" class="form-control" placeholder="Enter new menu" />
						<div class="text-danger" id="menu_name_error" style="display:none;"></div>
					</div>
					<div class="col-sm-9"><input id="menu_id" name="menu_id" type="hidden" class="form-control" value=""></div>
				</div>
				<?php if($group != 'subadmin'){ ?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Sort Order</label>
					<div class="col-sm-9">
						<input id="menu_sort_order" name="menu_sort_order" type="number" class="form-control" placeholder="Enter sort order" />
						<div class="text-danger" id="menu_sort_order_error" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Select Parent menu</label>
					<div class="col-sm-9">
						<select class="form-control" name="menu_parent_dropdown" id="menu_parent_dropdown">
							<option value="0" selected>Please select Parent</option>
							<?php if(count($parent_menus) > 0){ 
								foreach($parent_menus as $parent_menu){ ?>
									<option value="<?php echo $parent_menu['id']; ?>"><?php echo $parent_menu['title']; ?></option>		
							<?php }
							} ?>
						</select>
					</div>
				</div>
				<div class="form-group" id="menu_menu_link_box">
					<label class="col-sm-3 control-label">Menu link</label>
					<div class="col-sm-9">
						<select class="form-control" name="menu_external_link" id="menu_external_link">
							<option value="-1" selected>Please select external link</option>
							<option value="0">Cms</option>
							<option value="1">External</option>
						</select>
						<div class="text-danger" id="menu_external_link_error" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group" id="menu_cms_url_box" style="">
					<label class="col-sm-3 control-label">Select Page</label>
					<div class="col-sm-9">
						<select class="form-control" name="menu_cems_link_select" id="menu_cems_link_select">
							<option value="0" selected>Please select page</option>
							<?php foreach($cms_pages as $cms_page){ ?>
								<option value="<?php echo $cms_page['p_id'];?>"><?php echo $cms_page['page_name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="form-group" id="menu_url_box">
					<label class="col-sm-3 control-label">Url</label>
					<div class="col-sm-9">
						<input type="text" id="menu_url_text" name="menu_url_text" class="form-control" placeholder="Enter external link" />
						<div class="text-danger" id="menu_url_text_error" style="display:none;"></div>
					</div>
				</div>
				<?php } ?>
			</div>
			</form>
			<div class="box-footer">
				<button id="menu_create" type="submit" class="btn pull-right btn-info">Save</button>
				<button id="menu_update" type="submit" class="btn pull-right btn-info" style="display: none;">Update</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
			</div>
		</div>
		</section>
		
		<?php if($group != 'subadmin'){ ?>
			<section class="col-lg-6 connectedSortable">
		<?php } else { ?>
			<section class="col-lg-3 connectedSortable">
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All Menus</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body menu-section-list">
			<?php foreach($menus as $menu) {
	      			if($menu['lang_id'] == 1 || $menu['lang_id'] == ''){
	      				if($menu['p_id'] == 0){
	      					echo '<ul class="">';
	      					if($menu['menu_name'] == ''){
	      						echo '<li class="menu_list_item" data-m_id="'.$menu['id'].'">'.$menu['title'].'</li>';
	      					}
	      					else{
	      						echo '<li>'.$menu['menu_name'].' <span class="pull-right"><a class="menu_list_item btn btn-info btn-flat " data-m_id="'.$menu['id'].'"><i class="fa fa-pencil"></i></a>';
								if($this->session->userdata('group_name') == 'admin'){	      						
	      							echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-info btn-flat  menu_list_item_delete" data-m_id="'.$menu['id'].'"><i class="fa fa-trash"></i></a></span></li>';
								}
								else{
									echo '</li>';
								}
	      					}
	      					$ic = 0;
	      					foreach($menus as $m1){
	      						if($m1['lang_id'] == 1 || $m1['lang_id'] == ''){
		      						if($m1['p_id'] == $menu['id']){
		      							if($ic == 0){
		      								echo '<ul '.$ic.'>';
		      							}
		      							$ic = 1;
		      							if($m1['menu_name'] == ''){
		      								echo '<li class="menu_list_item" data-m_id="'.$m1['id'].'">'.$m1['title'].'</li>';
		      							}
		      							else{
		      								echo '<li>'.$m1['menu_name'].' <span class="pull-right"><a class="btn btn-info btn-flat menu_list_item" data-m_id="'.$m1['id'].'"><i class="fa fa-pencil"></i></a>';
		      								if($this->session->userdata('group_name') == 'admin'){
		      									echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-info btn-flat menu_list_item_delete" data-m_id="'.$m1['id'].'"><i class="fa fa-trash"></i></a></span></li>';
		      								}
		      								else{
		      									echo '</li>';
		      								}
		      							}
		      							
		      						}
		      						else{
		      							continue;
		      						}
	      						}
	      					}
	      					echo '</ul>';
	      				}
	      				echo '</ul>';
	      			}
	      			
	      		}
	      	?>
            </div>
		</div>
		</section>
		<?php if($group == 'subadmin'){ ?>
		<section class="col-lg-3 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">All Menus (Hindi)</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>

			<div class="box-body menu-section-list">
				<?php foreach($menus as $menu) {
	      			if($menu['lang_id'] == $this->session->userdata('language') || $menu['lang_id'] == ''){
	      				if($menu['p_id'] == 0){
	      					echo '<ul>';
	      					if($menu['menu_name'] == ''){
	      						echo '<li>'.$menu['title'].'</li>';
	      					}
	      					else{
	      						echo '<li>'.$menu['menu_name'].' <span class="pull-right"><a class="btn btn-info btn-flat  menu_list_item_delete" data-m_id="'.$menu['id'].'"><i class=" fa fa-trash"></i></a></span></li>';
	      					}
	      					$ic = 0;
	      					foreach($menus as $m1){
	      						if($m1['lang_id'] == $this->session->userdata('language') || $m1['lang_id'] == ''){
		      						if($m1['p_id'] == $menu['id']){
		      							if($ic == 0){
		      								echo '<ul '.$ic.'>';
		      							}
		      							$ic = 1;
		      							if($m1['menu_name'] == ''){
		      								echo '<li>'.$m1['title'].'</li>';
		      							}
		      							else{
		      								echo '<li>'.$m1['menu_name'].' <span class="pull-right"><a class="btn btn-info btn-flat menu_list_item_delete" data-m_id="'.$menu['id'].'"><i class=" fa fa-trash"></i></a></span></li>';
		      							}					
		      						}
		      						else{
		      							continue;
		      						}
	      						}
	      					}
	      					echo '</ul>';
	      				}
	      				echo '</ul>';
	      			}
	      		}
	      	?>
            </div>			
		</div>
		</section>
		<?php } ?>
		</div>
		</section>
</div>