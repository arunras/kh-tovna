<!DOCTYPE html>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta name="keywords" content="Cambodia, Phnom Penh, Auto, Car, Shop, Buy, Price, Good, High, Quality,">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">

<title><?php echo $title?></title>
<link rel="stylesheet" href="<?php echo base_url();?>css/default.css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css/header.css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css/card.css" media="all" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<!-- RUN -->
<link rel="stylesheet" href="<?php echo base_url();?>css/map.css" media="all" />
<!-- <link rel="stylesheet" href="<?php echo base_url();?>css/skin.css" media="all" /> -->
<!-- RUN -->
<?php foreach ($css as $acss){
echo '<link rel="stylesheet" href="'.base_url().'css/'.$acss.'" />';
}?>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/js.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/card.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/save_card.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" ></script>
<!--RUN-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/maplib_infobox.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/maplib_progressBar.js"></script>
<!--endRUN-->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.jcarousel.min.js"></script>
<?php foreach ($js as $ajs){
echo '<script type="text/javascript" src="'.base_url().'js/'.$ajs.'"></script>';
}?>

<script type="text/javascript">
$(document).ready(function(){
	$('a.btn_create').click(function(e){
		e.preventDefault();
		$.ajax({
			url:location.protocol + "//" + location.host + "/card/create",
			data:{currenturl: this.href},
			type:'POST',
			success:function(msg){
				if(msg == 'false'){
					window.location = location.protocol + "//" + location.host + "/user/login/1";
				}
				else{
					$('#pop-create-card').html(msg);
					
					var maskHeight = $(document).height();
					var maskWidth = $(document).width();
					$('#mask').css({'width':maskWidth,'height':maskHeight});
					$('#mask').fadeIn(1000);
					$('#mask').fadeTo('slow',0.8);

					var winH = $(window).height();
					var winW = $(document).width();
	
					var id = $('#pop-create-card');
					var id_width = id.width();
					var id_height = id.height();

					var x = (winW/2) - (id_width/2);
					var y = (winH/2) - (id_height/2);

					id.css('top',10);
					id.css('left',x);
					id.fadeIn(1000);
				}
			}
		});
	});
	$('#s').focus(function(){
		$(this).removeClass('normal');
		if(this.value == this.defaultValue){
			this.value = "";
		}
		else{
			
		}
	});
	$('#s').blur(function(){
		
		if(this.value == this.defaultValue || this.value == ''){
			this.value = this.defaultValue;
			$(this).addClass('normal');
		}
		else{
			$(this).removeClass('normal');
		}
	});

	//$('#pop-profileuploader').draggable();
	//$('#pop-create-card').draggable();
});
</script>
<?php 
$sms = $this->input->get('g');
if($sms == "logout"){
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#message').html("You have been logged out");
	var width_body = $(document).width();
	var width_message = $('#message').width();
	var x = width_body/2 - width_message/2;
	
	$('#message').css('left',x);
	
	$('#message').css('visibility','visible');
	$('#message').fadeIn(1000);
	$('#message').delay(500).fadeOut(1000);
});
</script>
<?php } ?>

<?php 
//if savecard success
$sms = $this->input->get('q');
if($sms == "saved"){
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#message').html("Your card have been saved");
	var width_body = $(document).width();
	var width_message = $('#message').width();
	var x = width_body/2 - width_message/2;
	
	$('#message').css('left',x);
	
	$('#message').css('visibility','visible');
	$('#message').fadeIn(1000);
	$('#message').delay(2000).fadeOut(1000);
});
</script>
<?php } ?>

<?php 
	$currentController = $this->uri->segment(1); // "" means default controller
	$sectionSelected = $this->session->userdata("cat");
	if(!$sectionSelected) $this->session->set_userdata("cat","all");
?>

</head>
<body>
<div id="message"></div>
<div id="mask"></div>

<div id="pop-create-card">

</div>
<div id="pop_notification">
	
</div>
<div id="pop_profilemenu">
	<div class="pop_top"></div>
	<div class="pop_bottom">
		<a href="<?php echo site_url('mypage')?>" title="Go to my page">My Page   </a>
		<a href="<?php echo site_url('setting');?>" title="Setting">My Setting</a>
		<a href="<?php echo site_url('user/logout');?>">Logout    </a>
		<hr class="space" />
	</div>
</div>
<div id="container">
	<div id="topbg"> 
	<div id="top">
		<div id="topleft">
			<a href="<?php echo base_url(); ?>">
			<img src="<?php echo base_url();?>images/logo.png" /></a>
		</div>
		<div id="topright">
			<table width="100%">
				<tr height="65px" align="right"><td>
					<div id="searchwrapper">
					<form action="">
						<input type="text" class="searchbox normal" id="s" name="s" value="Press Enter" />
						<input type="image" src="<?php echo base_url();?>/images/b_search.png" class="searchbox_submit" value="" />
					</form>
					</div>
				</td></tr>
				<tr>
				<td align="right">
					<?php if($this->user_mdl->isLogin()==false){?>
					<div id="nav-pro">
						<a href="<?php echo base_url().$this->uri->uri_string()?>" class="btn_create" title="Create your card"></a>
						<a href="<?php echo site_url('user/login')?>" class="btn_login" title="Log in to your account"></a>
					</div>
					<?php }
					else{
					?>
					<div id="nav-pro-logged">
						<a href="" class="notification" title="Notification">
						<?php 
						$numNote = $this->notification_mdl->getNumNotification($this->user_mdl->getCurrentUserID());
						if($numNote!=0){
						?>
						<span style="
							color:white;
							font-size:11px;
							position:absolute;
							left:15px;
							top:-5px;
							padding:3px 5px 3px 5px;
							background:red;">
							<?php echo $numNote;?>
							</span>
						<?php 
						}
						?>
						&nbsp;
						</a>
						<a href="" class="friend" title="Friend request">
						<?php 
						$num = $this->notification_mdl->getNumFriendNotification($this->user_mdl->getCurrentUserID());
						if($num!=0){
						?>
						<span style="
							color:white;
							font-size:11px;
							position:absolute;
							left:15px;
							top:-5px;
							padding:3px 5px 3px 5px;
							background:red;">
							<?php echo $num?>
							</span>
						<?php 
						}
						?>&nbsp;</a>
						<a href="<?php echo base_url().$this->uri->uri_string()?>" class="btn_create" title="Create your card"></a>
						<a href="<?php echo site_url('mypage')?>"><img src="<?php echo $this->user_mdl->getDBValue('tblusers','thum','username',$this->session->userdata('loginname'));?>" width="25px" id="small-profile" /></a>
						<a href="<?php echo site_url('mypage')?>" class="profile-name" ><span><?php echo $this->session->userdata('loginname');?></span></a>
					</div>
					
					<?php
					}?>
				</td></tr>
			</table>
		</div>
	</div>
	<p class="clear" />
	</div>
	<?php
	$showMenu=array("browse","","home");
	//echo in_array($currentController, $showMenu);
	if(in_array($currentController, $showMenu)){
	?>
	<div id="bgmenu">
		<div id="menu">
			<div class="item">
				<a href="#all" title="All" id="all" class="all"></a>
				<a href="#eat" title="Eat" id="eat" class="eat"></a>
				<a href="#event" title="Event" id="event" class="event"></a>
				<a href="#travel" title="Travel" id="travel" class="travel"></a>
				<a href="#stay" title="Stay" id="stay" class="stay"></a>
				<a href="#purchase" title="Purchase" id="purchase" class="purchase"></a>
				<a href="#beauty" title="Beauty" id="beauty" class="beauty"></a>
				<a href="#etc" title="Etc" class="etc" id="etc"></a>
				<a href="<?php echo base_url();?>browse" title="View in Thumnail" class="thum <?php if($this->session->userdata('viewtype')=="thum") echo "thumseleted"; ?>" id="thum"></a>
				<a href="<?php echo base_url();?>" title="Map view" class="map <?php if($this->session->userdata('viewtype')=="map") echo "mapseleted"; ?>" id="map"></a>
			</div>
			<p class="clear"/>
		</div>
	</div>
	
	<?php 
	}
	else
	{
	?>
	
	<?php }?>