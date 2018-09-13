<?php $group = $this->session->userdata('group_name'); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
	<a class="navbar-brand" title="Government of India" href="<?php echo base_url(); ?>"> <img style="width:45px;" alt="India" src="<?php echo base_url(); ?>assest/admin/logo.png" /></a>
					
    <!--<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>-->
    <div class="collapse navbar-collapse" id="navbarResponsive" >

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" style="display:none;">
		<a data-target="#navbarCollapse"  data-toggle="collapse" class="nav-menu-col desktop-hide">Menu</a>
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- Collection of nav links, forms, and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse" data-hover="dropdown" data-animations="fadeIn fadeInLeft fadeInUp fadeInRight" style="float:left;margin-top:5px;margin-bottom:5px;">
<ul class="nav navbar-nav menu-section1" <?php if(!isset($_SESSION['user_id'])){?>style="display: none;" <?php } ?>>
	<li>
		<a title="Home" class="" href="<?php echo base_url(); ?>admin/admin/dashboard"><i class="fa fa-home" aria-hidden="true"></i> HOME </a>
	</li>
	<?php if($group != 'subadmin'){ ?>
	<li class="dropdown">
			<a title="Master" href="#" data-toggle="dropdown" > <i class="fa fa-th"></i> MASTER <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a title="Users" href="<?php echo base_url(); ?>admin/admin/users" ><i class="fa fa-users" aria-hidden="true"></i> Users</a></li>
				<li><a title="Language" href="<?php echo base_url(); ?>admin/admin/language"><i class="fa fa-language" aria-hidden="true"></i> Language</a></li>
								<?php if($group=='admin'){?>
				<li><a title="Video Catagory" href="<?php echo base_url(); ?>admin/admin/video"><i class="fa fa-video-camera"></i>Video Catagory</a></li>
								<?php }?>				
			</ul>
	</li>
	<?php } ?>
	<li class="dropdown">
			<a title="Layout" href="#" data-toggle="dropdown" > <i class="fa fa-files-o"></i> Layout <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a title="Pages" href="<?php echo base_url(); ?>admin/admin/all_pages"> <i class="fa fa-clone" aria-hidden="true" ></i> Pages </a></li>
				<li><a title="Menu" href="<?php echo base_url(); ?>admin/admin/menus"> <i class="fa fa-ellipsis-h" aria-hidden="true" ></i> Menu </a></li>
			<!-- 	<li><a title="Menu" href="<?php //echo base_url(); ?>admin/admin/home_content"> <i class="fa fa-ellipsis-h" aria-hidden="true" ></i> Home Content </a></li> -->
			</ul>
	</li>
	<li class="dropdown">
			<a title="Widget" href="#" data-toggle="dropdown" > <i class="fa fa-th-large" aria-hidden="true" ></i> Components <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a title="News/Notice" href="<?php echo base_url(); ?>admin/admin/news"><i class="fa fa-file" aria-hidden="true" ></i> News/Notice </a></li>
				<li><a title="News/Links" href="<?php echo base_url(); ?>admin/admin/links"><i class="fa fa-link" aria-hidden="true" ></i> Quick Links </a></li>
				<li><a title="Events" href="<?php echo base_url(); ?>admin/admin/events"><i class="fa fa-calendar" aria-hidden="true" ></i> Events </a></li>
				<li><a title="Sliders" href="<?php echo base_url(); ?>admin/admin/slider"><i class="fa fa-image" aria-hidden="true" ></i> Slider </a></li>
				<li><a title="Widgets" href="<?php echo base_url(); ?>admin/admin/widgets"><i class="fa fa-delicious" aria-hidden="true" ></i> Widgets </a></li>
				<li><a title="Videos" href="<?php echo base_url(); ?>admin/admin/videos"><i class="fa fa-delicious" aria-hidden="true"></i> Videos </a></li>
                                <li><a title="Commodity" href="<?php echo base_url(); ?>admin/admin/commodity"><i class="fa fa-delicious" aria-hidden="true"></i> Commodity </a></li>
<li><a title="Success Stories" href="<?php echo base_url(); ?>admin/admin/success_story"><i class="fa fa-delicious" aria-hidden="true"></i> Success Story </a></li>
<li><a title="Heading" href="<?php echo base_url(); ?>admin/admin/heading"><i class="fa fa-delicious" aria-hidden="true"></i> Headings </a></li>
			</ul>
	</li>
	<li class="dropdown">
			<a title="System" href="#" data-toggle="dropdown" > <i class="fa fa-th-large" aria-hidden="true" ></i> System <b class="caret"></b></a>
			<ul class="dropdown-menu">
	<?php if($this->ion_auth->is_admin()){ ?>
	<li>
		<a title="Cache Files" href="<?php echo base_url();?>admin/admin/cache_mgnt"> <i class="fa fa-files-o"></i> Cache Management</a>
	</li>
	<?php } ?>
	<li>
		<a title="lang_file" href="<?php echo base_url();?>admin/admin/lang_file"> <i class="fa fa-files-o"></i> Language File</a>
	</li>
	</ul>
	</li>
	</div>

	
      <ul class="navbar-nav ml-auto" style="list-style:none;padding:0px;float:right;margin-top:13px;">
        <li class="nav-item t-li">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for..." style="width:180px;">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button" style="padding:9px;margin-right:10px;">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <?php if($this->ion_auth->is_admin()){ ?>
        <li class="t-li">
        	<select id="user_language" class="form-control">
        		<?php if(isset($language)){ ?>
					<option id="<?php echo $language['l_id'];?>"><?php echo $language['l_name']; ?></option>        			
        		<?php } else { ?>
        			<option id="1">English</option>
        		<?php }?>
        	</select>
        </li>
        <?php } ?>
        <li class="t-li">
        	<div class="dropdown" style="<?php if(!isset($_SESSION['user_id'])){?>display:none;<?php } ?>">
  				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    			<a class="dropdown-toggle profile waves-effect" data-toggle="dropdown" aria-expanded=""><i class="fa fa-bell"></i> Notification</a> <span class="caret"></span>
  				</button>
  			 	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1" style="min-height:80px;">
	        		<div id="user_notification"> No Record Found</div>	 
        	  	</div>
			</div>
       	</li>
        
        
         <li class="t-li">
        	<div class="dropdown" style="<?php if(!isset($_SESSION['user_id'])){?>display:none;<?php } ?>">
  				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    			<a class="dropdown-toggle profile waves-effect" data-toggle="dropdown" aria-expanded="">  <img style="width:17px;" src="<?php if($this->session->userdata('photo')){ echo base_url(); ?>User_gallary/<?php echo  $this->session->userdata('photo'); } else{ echo base_url();?>User_gallary/deaf-user.png<?php }?>" alt="User" class="img-circle" /> </a>
    				<span class="caret"></span>
  				</button>
  			 	<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
	        		<!--<li>
	            		<a><?php //echo $this->session->userdata['first_name'];?></a>
	        		 </li> -->
	        		<li>
	        			<a href="<?php echo base_url('admin/User_profile_ctrl/profile/').$this->session->userdata('user_id');?>">
	            		<i class="fa fa-fw fa-user"></i> Edit Profile</a>
	        		 </li> 
	        		<li> 
	        			<a href="<?php echo base_url('admin/User_profile_ctrl/change_password/').$this->session->userdata('user_id');?>">
	            		<i class="fa fa-fw fa-edit"></i> Change Password</a>
	        		 </li>
	        		<li class="nav-item">
	          			<a class="nav-link" data-toggle="modal" data-target="" href="<?php echo base_url();?>admin/Auth/logout">
	            		<i class="fa fa-fw fa-sign-out"></i> Logout</a> 
	        		</li> 
        	  </ul>
			</div>
       	</li>
      </ul>
    </div>
  </nav>
