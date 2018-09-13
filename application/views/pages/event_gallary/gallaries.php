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
		<h3>EVENT GALLERY</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / Event Gallery </span></div>

	</div>
</section> 

 
<section class="content-section o-content-sec">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
			<div class="col-md-12 video-gallery events-list">
			<?php $cat= $this->uri->segment(2);
				if(isset($cat) && $cat != ''){?>
					 <h5><span><?php echo ucfirst($cat) ?></span></h5>
			<?php	}
				else{
					echo '<h5><span>All Events</span>';
				}
				?>
					<div class="pull-right search-btn">
						<input placeholder="Search Events..." type="text" id="event_search_gallery" /><i class="fa fa-search"></i>
						<select class="pull-left form-control" style="width:200px;" id="event_category_selector">
								<?php $cat= $this->uri->segment(2);
								if(isset($cat) && $cat != ''){ ?>
								    <option value="All">All Events</option>
								   <?php foreach($events_categories as $events_category){ ?>
								   <option value="<?php echo $events_category['event_category'];?>"<?php if($events_category['event_category']==$cat){echo"Selected";}?>><?php echo ucfirst($events_category['event_category']);?> </option>
								<?php } }else{ ?>
								
								<option value="All">All Events</option>
								<?php if(count($events_categories)>0){ ?>
									<?php foreach($events_categories as $events_category){
										if($events_category['event_category'] != ''){ ?>
										<option value="<?php echo $events_category['event_category'];?>"><?php echo ucfirst($events_category['event_category']);?></option>
										
									<?php } } ?>
								<?php } }?>
							
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
						$event_seq = 0;
						for($i = 0 ; $i <= $c ; $i = $i+4){
							if($i == 0){
								echo '<div class="item active">';
							}
							else{
								echo '<div class="item">';
							}
							
							for($j = $i; $j < $i+4; $j++){ 
								if($j < $c) { ?>
							<div class="col-md-3 events-de">
								<img class="event_inst" data-id="<?php echo $events[$j]['event_id']; ?>" data-content="<?php echo $events[$j]['event_content']; ?>" data-image="<?php echo $events[$j]['event_image']; ?>" data-sequence="<?php echo $event_seq;?>"  style="width:100%;" alt="<?php echo $events[$j]['title']; ?>" src="<?php echo base_url(); ?>/Event_gallary/<?php echo $events[$j]['event_image']; ?>" />
								<div class="register-user-box">
									<h5><?php echo $events[$j]['title']; ?></h5>
									<?php echo $events[$j]['event_content'];?>
<a data-id="<?php echo $events[$j]['event_id']; ?>" class="event_inst click-event-details"><b>Click to Details</b></a>
								</div>
							</div>	
					  <?php
					  			$event_seq = $event_seq + 1;
								}
								else{
									break;
								}
					   		}
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
							<!--<div id="eve_id"></div>
							<div id="modal_image"></div>
							<div id="modal_content" class="events-description"></div>
							<div id="eve_category"></div> -->
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							
							  		
							  <!-- Wrapper for slides -->
							 <div class="carousel-inner" role="listbox">
								<div class="item active" style="margin-top:15px;">
								<input type="hidden" id="eve_id" value="">
								<div id="modal_image"></div>

								<div id="modal_content"></div>
								</div>
							  </div>

							  
							</div>
							
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