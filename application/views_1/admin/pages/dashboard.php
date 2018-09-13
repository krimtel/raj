<?php date_default_timezone_set("Asia/Calcutta"); ?>
<title>Dashboard</title>
<div class="main-content-sec container-fluid">
<!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>


<div class="content-sec">
	<div class="row dashborad-setting">
	<div class="col-md-4" style="margin-top:20px;">
		<div class="section-box">
			<h3 class="parentname">Welcome <?php echo $this->session->userdata('username'); ?>!</h3>
			
			<div class="dashboard-date-sett">
				<div class="date-box"><span class="date"><?php echo date('d');?></span><span class="month-y"><span><?php echo date('l');?></span><br><?php echo date('M');?>, <?php echo date('Y');?></span></div>
				<div class="date-img-box"><img class="calender-img" alt="" src="../assest/images/calender.png" /></div>
			</div>
		</div>
	<?php if($this->ion_auth->is_admin()){ ?>
	<div class="section-box">
		<div class="box-header-t box-header-primary"><span>User List</span></div>
		<div class="box-body-sec">
			<table class="table table-striped" style="background-color:#e4e4e4;border:1px solid #eee;">
				<?php if(isset($users) && count($users)>0){ ?>
						<?php $c = 1; foreach($users as $user){ ?>
							<tr>
							  <td><?php echo $c ;?>.</td>
							  <td class="text-center"><?php echo $user['username']; ?></td>
							</tr>		
						<?php $c++; } ?>
					<?php } else { ?>
						<tr><td>No language Found.</td></tr>
					<?php } ?>
					<tr>
						<td colspan="3"><a href="<?php echo base_url(); ?>/admin/admin/users"><i class="fa fa-th-large"></i> View All</a></td>
					</tr>
			</table>
		</div>
	</div>
		<div class="section-box">
			<div class="box-header-t box-header-primary"><span> Language</span></div>
			<div class="box-body-sec">
				<table class="table table-striped" style="background-color:#e4e4e4;border:1px solid #eee;">
					<?php if(isset($languages) && count($languages)>0){ ?>
						<?php $c = 1; foreach($languages as $language){ ?>
							<tr>
							  <td><?php echo $c ;?>.</td>
							  <td class="text-center"><?php echo $language['l_name']; ?></td>
							</tr>		
						<?php $c++; } ?>
					<?php } else { ?>
						<tr><td>No language Found.</td></tr>
					<?php } ?>
					<tr>
						<td colspan="4"><a href="<?php echo base_url(); ?>/admin/admin/language"><i class="fa fa-th-large"></i> View All</a></td>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>
		<div class="section-box">
			<div class="box-header-t box-header-primary"><span>Pages</span></div>
			<div class="box-body-sec">
			<table class="table table-striped" style="background-color:#e4e4e4;border:1px solid #eee;">
			<tbody>
					<?php if(isset($pages) && count($pages)>0){ ?>
						<?php $c = 1; foreach($pages as $page){ ?>
							<tr>
							  <td><?php echo $c ;?>.</td>
							  <td class="text-center"><?php echo $page['page_name']; ?></td>
							</tr>		
						<?php $c++; } ?>
					<?php } else { ?>
						<tr><td>No Page Found.</td></tr>
					<?php } ?>
					<tr>
						<td colspan="3"><a href="<?php echo base_url(); ?>/admin/admin/all_pages"><i class="fa fa-th-large"></i> View All</a></td>
					</tr>
				</tbody>
				</table>
			</div>
			<div class="section-box">
		<div class="box-header-t box-header-primary"><span>Events</span></div>
		<div class="box-body-sec">
		<table class="table table-striped" style="background-color:#e4e4e4;border:1px solid #eee;">
			<tbody>
				<?php if(isset($events) && count($events)>0){ ?>
						<?php $c = 1; foreach($events as $event){ ?>
							<tr>
							  <td><?php echo $c ;?>.</td>
							  <td class="text-center"><?php echo $event['title']; ?></td>
							</tr>		
						<?php $c++; } ?>
					<?php } else { ?>
						<tr><td>No Page Found.</td></tr>
					<?php } ?>
				<tr>
					<td colspan="5"><a href="<?php echo base_url(); ?>/admin/admin/events"><i class="fa fa-th-large"></i> View All</a></td>
				</tr>
			</tbody>
		</table>
		</div>
		</div>
		</div>
		
		</div>
		<div class="col-md-4">
		<div class="section-box">
			<div class="box-header-t box-header-primary"><span>Video List</span></div>
			<div class="box-body-sec">
			<table class="table table-striped" style="background-color:#e4e4e4;border:1px solid #eee;">
			<tbody>
				<?php $c = 1; foreach($videos as $video){ ?>
					<tr>
                  		<td><?php echo $c ;?>.</td>
                  		<td>
                  			<?php 
                  				$x = explode('/embed/',$video['v_url']);
                  			?>
                  			<img style="border:1px solid #999;width:50px;height:50px;" src="https://img.youtube.com/vi/<?php echo $x[1]; ?>/0.jpg">
                  		</td>
                  		<td><?php echo $video['v_title']; ?></td>
                  		
                	</tr>
				<?php $c++; } ?>
					<tr>
						<td colspan="5"><a href="<?php echo base_url();?>/admin/admin/videos"><i class="fa fa-th-large"></i> View All</a></td>
					</tr>
			</tbody>
		</table>
			</div>
		</div>
		<div class="section-box">
			<div class="box-header-t box-header-primary"><span>Slider List</span></div>
			<div class="box-body-sec">
					 <table class="table table-striped" style="background-color:#e4e4e4;border:1px solid #eee;">
			<tbody>
				<?php $c = 1; foreach($sliders as $slider){ ?>
				<?php if($slider['lang_id'] == $this->session->userdata('language')){ ?>
	                <tr>
	                  <td> <?php echo $c; ?>.</td>
					  <td><img src="<?php echo base_url().'/slider_gallary/'.$this->session->userdata('language').'/'.$slider['slider_image']; ?>" style="border:1px solid #999;width:50px;height:50px;"/></td>
	                  <td><?php echo $slider['alt_tag']; ?></td>
	                </tr>
				<?php $c++; } } ?>
				<tr>
					<td colspan="5"><a href="<?php echo base_url(); ?>/admin/admin/slider"><i class="fa fa-th-large"></i> View All</a></td>
				</tr>
			</tbody>
		</table>
			</div>
		</div>
		
		<div class="section-box">
			<div class="box-header-t box-header-primary"><span>News</span></div>
			<div class="box-body-sec">
				<marquee style="height:290px;background-color:#e4e4e4;" class="notice-board" direction="up" scrollamount="3" onmouseover="stop();" onmouseout="start();" >
					<ul class="dash-news-sec">
					<?php if(isset($newses) && count($newses)>0){ ?>
						<?php foreach($newses as $news){ ?>
							<li><?php echo $news['news_contect'];?></li>
						<?php } ?>
					<?php } else { ?>
						<li>No news found.</li>
					<?php } ?>
					</ul>
				</marquee>
				<div class="view-all-box"><a href="<?php echo base_url(); ?>/admin/admin/news"><i class="fa fa-th-large"></i> View All</a></div>
			</div>
		</div>

		</div>
		<div class="col-md-4">
			
			<div class="section-box">
				<div class="box-header-t box-header-primary"><span>Recent Activites</span></div>
				<div class="box-body-sec">
					<a href="#">
                <img style="width:100%;" class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=610" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">Rahul Kumar</a></h6>
                <p class="card-text small">These waves are looking pretty good today!
                  <a href="#">#surfsup</a>
                </p>
              </div>
              <hr class="my-0">
			   <a href="#">
                <img style="width:100%;" class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=180" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">Manish</a></h6>
                <p class="card-text small">Another day at the office...
                  <a href="#">#workinghardorhardlyworking</a>
                </p>
              </div>
              <hr class="my-0">
			  <a href="#">
                <img style="width:100%;" class="card-img-top img-fluid w-100" src="https://unsplash.it/700/450?image=281" alt="">
              </a>
              <div class="card-body">
                <h6 class="card-title mb-1"><a href="#">Snita</a></h6>
                <p class="card-text small">Nice shot from the skate park!
                  <a href="#">#kickflip</a>
                  <a href="#">#holdmybeer</a>
                  <a href="#">#igotthis</a>
                </p>
              </div>
			  <div class="view-all-box"><a href="recent-activites.html"><i class="fa fa-th-large"></i> View All</a></div>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>