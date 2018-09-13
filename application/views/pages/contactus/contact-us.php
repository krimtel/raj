<section class="title-header-bg">
	<div class="text-center">
		<h3>CONTACT US</h3>
        <div style="margin-top:12px;" class="text-center"><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>/assest/images/home-ico.png"></a> <span id="bredcrum"> / Contact Us </span></div>

	</div>
</section> 



<section class="content-section" style="min-height:300px;float:left;width:100%;padding:30px 0;">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
<div class="col-md-12">
					
<div class="row">
			<div class="col-md-4">
			<form class="contact-form" method="post" id="contact_us" name="contact_us" action="<?php echo base_url();?>admin/Video_ctrl/contact_mail">
   
			<div class="form-group" style="background-color:#eee;border:1px solid #ddd;padding:5px 10px;">
				<label for="usr" style="float:left;margin-right:30px;margin-top:9px;border-radius:5px;">Purpose to Contact Us</label>
				<div class="radio">
				  <label><input type="radio" name="optradio" id="optradio" value="general" checked>General Contact </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="optradio" id="optradio" value="Grievance">Grievance Redressal</label>
				</div>
			</div>
			<div class="form-group">
    <input placeholder="Name" type="text" class="form-control" id="con_us_name">	
  </div>
  <div class="form-group">
    <input placeholder="Conatct No." type="number" class="form-control" id="con_us_contact">
  </div>
  <div class="form-group">
    <textarea style="height:80px;" placeholder="Type your Address" class="form-control" id="con_us_add" rows="5" ></textarea>
  </div>
  <div class="form-group">
  <select class="form-control" id="con_us_stak">
<option value="0">Select Stakeholder</option>
<option value="farmer">Farmers</option>
    <option value="trader">Traders</option> 
  </select>
</div>
   <div class="form-group">
    <textarea style="height:80px;" placeholder="Discription" id="contact_desc" class="form-control" rows="5" ></textarea>
  </div>
  <div class="form-group">
    <input placeholder="Email Id" type="email" class="form-control" id="email">
  </div>
 <button id="contact_us_mail" type="button" class="btn btn-success">Submit</button>
  </form>
			</div>
			<div class="col-md-5" style="padding-left:4%;">
				
				<div class="address-sec"><h4>Small Farmer's Agri-Business Consortium</h4>
<span style="margin-top:10px;"><img style="margin-bottom:35px;margin-top:3px;" alt="Phone" src="<?php echo base_url(); ?>assest/images/icon4.png" /><b>NCUI Auditorium Building, 5th Floor, 3, Siri Institutional Area, August Kranti Marg, Hauz Khas, <br>New Delhi - 110016. <br></b></span>
<span><img alt="Phone" src="<?php echo base_url(); ?>assest/images/icon1.png" /> 1800 270 0224 </span><br>
<span><img alt="Fax" src="<?php echo base_url(); ?>assest/images/icon2.png" /> +91-11- 26862367 </span><br>
<span><img alt="Email" src="<?php echo base_url(); ?>assest/images/icon3.png" /> nam@sfac.in<br></span>
			</div>
			</div>
<div class="col-md-3 contact-info" style="padding-left:2%;display:none;">
<a href="" title="" ><img alt="" src="<?php echo base_url(); ?>assest/images/new-theme/contact-weather.jpg" /></a>
<a href="" title="" ><img alt="" src="<?php echo base_url(); ?>assest/images/new-theme/contact-info.jpg" /></a>
<a href="" title="" ><img alt="" src="<?php echo base_url(); ?>assest/images/new-theme/contact-commodity.jpg" /></a>
</div>
		</div>
	</div>
</section>
<div class="container-fluid" id="map" style="height:430px;">
		</div>
<script>
function initMap() {
var uluru = {lat:28.5494499, lng: 77.2001398};
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 12,
center: uluru
});
var marker = new google.maps.Marker({
position: uluru,
map: map
});
}


$(document).on('click','#contact_us_mail',function(){
			var baseUrl = $('#base_url').val();  
			 var email = $('#email').val();   
                          var con_us_name = $('#con_us_name').val();  
                           var con_us_contact = $('#con_us_contact').val(); 
                           var con_us_add =     $('#con_us_add').val();
                            var con_us_stak=     $('#con_us_stak').val();
                          var contact_desc = $('#contact_desc').val();
                         var mail_opt = $('input[name=optradio]:checked').val();
                          
			// alert(con_us_stak); 
			$.ajax({
				type: 'POST',
				url: baseUrl+'/Email_ctrl/contact_mail',
				dataType: "json",
				data: {
					'email'	: email,
                    'contact_desc': contact_desc,
                    'mail_opt'  : mail_opt,
                     'con_us_name' :  con_us_name ,
                     'con_us_contact' : con_us_contact ,
                     'con_us_add'     :  con_us_add ,
                     'con_us_stak'    :  con_us_stak
				},
				beforeSend: function(){
					$('#loader').modal({'show':true});	
				},
				complete: function(){},
				success:function (response) {
					console.log(response);
					$('#loader').modal('toggle');
                                         alert(response.msg);
					location.reload();
				}
			});
});

</script><script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPRk1qEWhM_3OdW4WfHbe9Do58LR8qv2k&callback=initMap">
</script>