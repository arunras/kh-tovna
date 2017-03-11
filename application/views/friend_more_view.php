<?php
$i = $iditems;
foreach($friendList as $aFriend) {
		
		
	if($aFriend->thum){
		$photoPath = $aFriend->thum;
	}
	else {
		$photoPath = base_url() . 'data/profiles/thum/default.png';
	}
	echo "
	<div class= 'items'>
	<a href='". $aFriend->userid ."' id='". $i ."' class='close'  onclick=' return unfriend(". $aFriend->userid .");' ><img src='". base_url() . "/images/close.gif' alt='UnFriend' /></a>
	<a href='". site_url('profile/show') .'/'. $aFriend->username ."'><img src='". $photoPath . "' width='75px' height = '75px' /></a>
	<div class='item-info'>
	<a href='". site_url('profile/show/'. $aFriend->username)."'>" . $aFriend->username . "</a>
	<p id='cards-num'>". $this->card_mdl->getNumCard($aFriend->userid) . " Cards</p>
	<p id='friends-num'>" . $this->friend_mdl->getNumFriend($aFriend->userid) . " Friends</p>
	</div>
	</div>";
	
	$i++;
}
?>