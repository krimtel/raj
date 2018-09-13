<header class="header-section" style="position: fixed; width: 100%; z-index: 99;" />
	<div class="container-fuild" style="padding-left:2%;padding-right:2%;">
		<div class="col-lg-6 col-sm-6">
			<div class="india-logo">
				<img alt="India" src="<?php echo base_url(); ?>/assest/images/new-theme/g-logo.png" />
				<img style="border-left:1px solid #eee;" alt="India" src="<?php echo base_url(); ?>/assest/images/new-theme/logo.png" />
			</div>
		</div>
			
		<div class="col-lg-6 col-sm-6">
			<div class="header-right-section">
				<div class="header-right-list">
					<span><b>Call us</b></span>
					<span><b>1800 270 0224</b></span>
				</div>
				<div class="header-right-list" style="border-right:0px;">
					<a href="other_register.html" title="Registration"><img alt="Help No" src="<?php echo base_url(); ?>/assest/images/new-theme/registrations.png" />
					<span><b>Registration</b></span></a>
				</div>
				<div class="header-right-list" >
					<a class="border" href="/NAM/faces/common/welcome.jspx" title="Login"><img alt="Help No" src="<?php echo base_url(); ?>/assest/images/new-theme/login-user.png" />
					<span><b>Login Here</b></span></a>
				</div>
				<div class="header-right-list" style="border-right:0px;">
					<span>Languages</span>
					<select id="language_selector" style="border:0px; color:#000;margin-top:-23px;">
						<?php if($this->session->userdata('client_language') != ''){ 
							$session_lang = $this->session->userdata('client_language'); 
						} else { $session_lang = ''; }?>
						<?php foreach($languages as $language){ 
							if($session_lang != ''){ ?>
								<?php if($language['l_id'] == $session_lang){ ?>
									<option value="<?php echo $language['l_id']; ?>" selected><?php echo $language['l_name']; ?></option>
								<?php } else {?>
								<option value="<?php echo $language['l_id']; ?>"><?php echo $language['l_name']; ?></option>
								<?php } ?>
							<?php } else { ?>
								<option value="<?php echo $language['l_id']; ?>"><?php echo $language['l_name']; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</header>