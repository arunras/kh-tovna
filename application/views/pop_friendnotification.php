<div class="pop_top"></div>
<div class="pop_bottom">
	
	<?php foreach ($friendNotifications as $aNote){?>
	<div class="notification">
		<?php $firendName = $this->user_mdl->getDBValue('tblusers','username','userid',$aNote->userid1)?>
		<div class="text"><a href="<?php echo site_url('profile/show/'.$firendName)?>"><?php echo $firendName ?></a> add you as Friend </div>
		<div class="link"><a href="#" onclick="return add_friend(this,<?php echo $aNote->notificationid?>);">Accept</a></div>
	</div>
	<?php }?>
	<?php if(count($friendNotifications)==0){?>
	<div class="notification">
		<div class="text">No Friend request </div>
	</div>
	<?php }?>
	<hr class="space" />
	<a href="<?php echo site_url('friend');?>">See all friends    </a>
	<hr class="space" />
</div>