<header class="header-section" style="width: 100%; z-index: 99;height:108px;" />
	<div class="container-fuild" style="padding-left:2%;padding-right:2%;">
		<div class="col-lg-8 col-sm-8">
			<div class="india-logo">
				<img style="width:355px;margin-left:8px;margin-right:7px;" alt="India" src="<?php echo base_url(); ?>/assest/images/new-theme/g-logo.png" />
<img style="width:136px;margin-right:22px;" alt="SFAC" src="<?php echo base_url(); ?>/assest/images/new-theme/sfac-logo.png" />
<div style="border-right:1px solid #eee;height:86px;float:left;">&nbsp;</div>
			<img style="width:273px;margin-left:22px;" alt="India" src="<?php echo base_url(); ?>/assest/images/new-theme/enam-logo.png" />
	         

			</div>
		</div>
			
		<div class="col-lg-4 col-sm-4">
			<div class="header-right-section">
				<div class="header-right-list" style="clear:both;padding:10px 0px;border-bottom:1px solid #eee;border-right:0px;">
<div class="pull-left"><span><b><?php echo $this->lang->line('call_us');?></b></span>
					<span><b>1800 270 0224</b></span></div>
<div class="pull-left" style="margin-left:80px;">
<span><?php echo $this->lang->line('language');?></span>
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
				<div class="header-right-list" style="border-right:0px;">
					<a href="other_register.html" title="Registration"><img alt="Help No" src="<?php echo base_url(); ?>/assest/images/new-theme/registrations.png" />
					<span><b><?php echo $this->lang->line('registration');?></b></span></a>
				</div>
				<div class="header-right-list" style="border-right:0px;" >
					<a class="border" href="/NAM/faces/common/welcome.jspx" title="Login"><img alt="Help No" src="<?php echo base_url(); ?>/assest/images/new-theme/login-user.png" />
					<span><b><?php echo $this->lang->line('login');?></b></span></a>
				</div>

			</div>
		</div>
	</div>
</header>