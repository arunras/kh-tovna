<?php if($this->uri->segment(3)=='1'){?>
<script type="text/javascript">
$(document).ready(function(){
	$('#errormessage').html("Please login first");
	
	var width_body = $(document).width();
	var width_message = $('#errormessage').width();
	var x = width_body/2 - width_message/2;
	
	$('#errormessage').css('left',x-15);
	
	$('#errormessage').css('visibility','visible');
	$('#errormessage').fadeIn(1000);
	$('#errormessage').delay(500).fadeOut(1000);
});
</script>
<?php } ?>
<?php if($this->uri->segment(3)=='failed'){?>
<script type="text/javascript">
$(document).ready(function(){
	$('#errormessage').html("Login failed, Check email or password");
	var width_body = $(document).width();
	var width_message = $('#errormessage').width();
	var x = width_body/2 - width_message/2;
	
	$('#errormessage').css('left',x-15);
	
	
	$('#errormessage').css('visibility','visible');
	$('#errormessage').fadeIn(1000);
	$('#errormessage').delay(500).fadeOut(1000);
});
</script>
<?php } ?>

<?php $currentMethod = $this->uri->segment(2);
if($currentMethod == "login"){
?>
<div id="register">
	<div id="errormessage"></div>
	<div id="colleft">
	<?php echo validation_errors(); ?>
	<?php echo form_open(site_url("user/authentication")); ?>
	<input type="text" name="email" id="email" placeholder="Email" style="width: 255px;"/><br/><br/>
	<input type="password" name="password" id="password" placeholder="Password" style="width: 255px;" /><br/><br/>
	<input type="image" src="<?php echo base_url()?>images/btn_signin.png" />
	
	</div>
	<div id="colright">
		<a href="<?php echo $urlFacebookLogin;?>"><img src="<?php echo base_url()?>images/btn_facebook.png"></a>
	</div>
</div> 
<div class="check-remember">
		<div class="wrap-checkbox">
			<span class="checkbox">
				<input type="checkbox" name="register" checked="checked" />
			</span>
		</div>
		<div class="rememberme">
			<h2>Remember me<br/>Or<a href="<?php echo base_url('user/register')?>"><span> Register</span></a></h2>
		</div>		
		<div>
			<a href="<?php echo site_url('user/forget')?>" id="forget" title="Forget password?">Forget Password?</a>
		</div>
	</div>
	<?php echo form_close(); ?>
<!--	 
<table>
	<tr>
		<td valign="middle" class="re-checkbox"><input type="checkbox" name="register" /></td>
		<td valign="middle">Remember Me<br/>Or Register</td>
	</tr>
</table>

-->
<?php }
else if($currentMethod=='register'){
?>

<div id="register">
	<div class="register-form">
		<div class="val-error">
		<?php echo validation_errors(); ?>
		</div>
		<?php echo form_open(site_url("user/register")); ?>
		<input type="text" name="first-name" id="first-name" placeholder="First name" value= "<?php echo set_value('first-name',$firstname); ?>" style="width: 300px;"/><br/><br/>
		<input type="text" name="last-name" id="last-name" placeholder="Last name" value= "<?php echo set_value('last-name',$lastname); ?>" style="width: 300px;"/><br/><br/>
		<input type="text" name="user-name" id="user-name" placeholder="User name" value= "<?php echo set_value('user-name',$username); ?>" style="width: 300px;"/><br/><br/>
		<input type="password" name="password" id="password" placeholder="Password" style="width: 300px;"/><br/><br/>
		<input type="text" name="email" id="email" placeholder="Email" value= "<?php echo set_value('email',$email); ?>" style="width: 299px;"/><br/><br/>
		<?php
		/*
			require_once('application/libraries/recaptchalib.php');
			echo recaptcha_get_html($publickey);
		*/
		?><br/>
		<input type="image" src="<?php echo base_url()?>images/btn_register.png" />
		
		<?php echo form_close(); ?>
	</div>
</div>


<?php }
else if($currentMethod=='forget'){?>
<div id="register">
<?php 
	echo form_open(site_url('user/forget'),'id="forget"');
	echo form_label('Regstered E-Mail','email');
	echo $message;
	echo validation_errors();
	echo "<br/>";
	echo form_input('email',set_value('email'),'id="email"');
	echo form_submit('Submit','Submit','id="submit"');
	echo form_close();
?>
</div> 

<?php }?>