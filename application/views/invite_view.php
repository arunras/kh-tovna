<div class="invite-top"><a href="#" onclick="return close_upload_form()">&nbsp;</a></div>
<div class="invite-middle">
<div class="invite-content">
<?php foreach($friends as $friend){?>
	<div class="fb-wraper">
		<div class="fb-picture"><a target="_blank" href="http://www.facebook.com/profile.php?id=<?php echo $friend['id']?>"><img src="<?php echo $friend['picture']?>" /></a></div>
		<div class="fb-text"><?php echo $friend['name']?> <br/><br/><a href="" onclick="return invite_friend(<?php echo $friend['id']?>)">Invite</a></div>
	</div>
<?php }?>
</div>
</div>
<div class="invite-bottom"></div>