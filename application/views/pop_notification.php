<div class="pop_top"></div>
<div class="pop_bottom">
	
	<?php foreach ($notifications as $aNote){?>
	<div class="notification">
		<?php $firendName = $this->user_mdl->getDBValue('tblusers','username','userid',$aNote->userid2)?>
		<div class="text"><a href="<?php echo site_url('profile/show/'.$firendName)?>"><?php echo $firendName ?></a> confirmed you as Friend </div>
		<div class="link"><a href="#" onclick="return remove_notification(this,<?php echo $aNote->notificationid?>);">Read</a></div>
	</div>
	<?php }?>
	<?php if(count($notifications)==0){?>
	<div class="notification">
		<div class="text">No Notification </div>
	</div>
	<?php }?>
	<hr class="space" />
</div>