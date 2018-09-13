<style>
#myImg {

    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
	top:-10%;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
 <section class="title-header-bg">
	<div class="text-center">
		<h3><?php echo $title; ?></h3>
		<div class="bredcrum-list">
			<ul>
				<li><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / </li>
				<li><a href="" title="">NAM</a> / </li>
				<li><a href="" title=""><?php echo $title; ?></a></li>
			</ul>
		</div>
	</div>
</section>
<section class="content-section" style="background-color:#fff;padding:20px 0;float:left;width:100%;">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
			<div class="col-md-12 video-gallery events-list">
				<h5><span>All Events</span>
					<div class="pull-right search-btn">
						<input placeholder="Search videos..." type="text" id="event_search_gallery" /><i class="fa fa-search"></i>
						<select class="pull-left" id="event_category_selector">
							<option value="All">Select Events Category</option>
							<?php if(count($events_categories)>0){ ?>
								<?php foreach($events_categories as $events_category){
									if($events_category['event_category'] != ''){ ?>
									<option value="<?php echo $events_category['event_category'];?>"><?php echo $events_category['event_category'];?></option>
								<?php } } ?>
							<?php } ?>
						</select>
					</div>
				</h5>
				
				<!--<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<div class="item active">
							<?php //if((count($events) > 0) && (isset($events))){ ?>
							<?php //$c=1; foreach($events as $event){
							//if($c < 5){
								//$event_title = strlen($event['title']) > 50 ? substr($event['title'],0,50)."..." : $event['title'];
							?>
							<div class="col-md-3 events-de">
								<img id="myImg" style="width:100%;" alt="<?php //echo $event['title']; ?>" src="<?php //echo base_url(); ?>/Event_gallary/<?php //echo $event['event_image']; ?>" />
								<div class="register-user-box">
									<h5><?php //echo $event_title; ?></h5>
									<?php //echo $event['event_content'];?>
								</div>
							</div>
						<?php //$c++; } } ?>
						<?php //} else { ?>
							<div class="well text-danger">No Events Found.</div>
						<?php //}?>
				  	</div>
				</div> -->
				
			
			
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<?php
						
						$c = count($events);
						$counter = 1;
						for($i = $counter; $i<$c; $i++){
							if($i == 1){
								echo '<div class="item active">';
							}
							else{
								echo '<div class="item">';
							}
						
							for($j=$i;$j<$i+4;$j++){
							if($c > $j){
								
							?>
							<div class="col-md-3 events-de">
								<img class="event_inst" data-id="<?php echo $events[$j]['event_id']; ?>" data-title="<?php echo $events[$j]['title']; ?>" data-content="<?php echo $events[$j]['event_content']; ?>" data-image="<?php echo $events[$j]['event_image']; ?>" style="width:100%;" alt="<?php echo $events[$j]['title']; ?>" src="<?php echo base_url(); ?>/Event_gallary/<?php echo $events[$j]['event_image']; ?>" />
								<div class="register-user-box">
                                                                        <h5><?php echo $events[$j]['title']; ?></h5>
									<?php echo $events[$j]['event_content'];?>
								</div>
							</div>	
					  <?php
					  $counter++; } }
					  	echo '</div>';		
						}
						?>
				</div>

				
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				  <i class="fa fa-angle-left"></i>
				  <span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">
				  <i class="fa fa-angle-right"></i>
				  <span class="sr-only">Next</span>
				</a>
			  </div>
			
			
			<div class="modal fade" id="event_instance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-body" >
					<button style="position:absolute;top:0px;right:0;" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i></button>
					<div id="modal_image"></div>
					<div id="modal_content" class="events-description"></div>
				  </div>
				</div>
			  </div>
		</div>
			
				<script>
				var base =	$('#base_url').val();
				
					
				</script>				
			</div>
		</div>
	</div>
</section>