<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php print_r($head); ?>
<?php if($this->session->userdata('client_language') == 1)
			$class = 'english';
			else
				$class = 'hindi'; 
?>
 <body id="enamHome" class="default-theme font-A <?php echo $class; ?>"> 
  
<?php if(isset($header)){ print_r($header); } ?>
<?php if(isset($navigation)){ print_r($navigation);} ?>
<input type="hidden" id="base_url" value="<?php echo base_url();?>" />
<?php if(isset($main_contant)){print_r($main_contant);} ?>
<?php if(isset($footer)){ print_r($footer);} ?>
</body>
</html>