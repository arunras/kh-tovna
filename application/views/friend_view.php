<?php ?>
<div id="friend">
	<div id="rows">
		<?php
			$i = 0;
			foreach($friendList as $aFriend) {
				if($aFriend->thum){
					$photoPath = $aFriend->thum;
				}
				else {
					$photoPath = base_url() . 'data/profiles/thum/default.png';
				}
				echo "
				<div class= 'items'>
				<a href='". $aFriend->userid ."' id='". $i ."' class='close' onclick=' return unfriend(". $aFriend->userid .");' ><img src='". base_url() . "/images/close.gif' alt='UnFriend' /></a>
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
		
	</div><div class="news_bottom"></div>
	<!-- 
	<div class="div_more" style="width:740px; margin:10px auto; text-align:center; height:40px; padding-right: 5px;">
		<span class="load_more" style="margin: 0px auto; width: 100px; display: inline-block; padding: 8px;">Load More... </span>
	</div>
	 -->
	<div class="div_paginate">
	    <input type="hidden" class="page" value="1" />
	    <input type="hidden" class="total_page" value="<?php echo $totalpage; ?>" />
    </div>
</div>