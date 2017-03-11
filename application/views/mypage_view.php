<div id="pop-profileuploader">
</div>
<div id="pop-profilechanger">
	<a href="#" onclick="return pop_profilechanger()" title="Change your picture">Change</a>
</div>
<div id="profile-wraper">
<div id="bgmypage">
	<div id="col-profile">
		<div class="profile-image">
			<img src="<?php echo $userinfo->thum?>" width="88px" />
		</div>
		<div class="profile-info">
			<h2><?php echo $this->session->userdata('loginname')?>(<?php echo $userinfo->lastname." ".$userinfo->firstname;?>)</h2>
			<div class="email"><a href="mailto:<?php echo $userinfo->email?>"><?php echo $userinfo->email?></a></div>
			<div class="num-card"><?php echo $numCard;?> Cards</div>
			<div class="num-friend"><a href= <?php site_url() ?>"friend" ><?php echo $this->friend_mdl->getNumFriend($userinfo->userid);?> Friends</a></div>
		</div>
	</div>
	<div id="col-review">
		<div id="part-left">
			<div id="imycard" class="bookmark"></div>
			<div id="iwantvisit" class="want-visit"></div>
		</div>
		<div id="part-right">
			<div id="imyfriend" class="my-friend"></div>
			<div id="ibeenhere" class="been-here"></div>
		</div>
	</div>
	<div id="col-last">
		<div id="thum-map">
			<div class="thum"></div>
			<div class="map"></div>	
		</div>
		<div class="invite-friend" title="Invite your friend from Facebook to join"></div>
		<div class="search-cancel"><input type="text" size="" name="search_cancel" id="search_cancel" placeholder="Search your card" onkeyup="autoComplete();"/></div>
	</div>
</div>
</div>
<p class="clear" />


<!-- INCLUDE -->
<script type="text/javascript" src="js/map_runlib.js"></script>
<script type="text/javascript" src="js/map_mypage.js"></script>
<script type="text/javascript" src="js/map_mypage_menu_event.js"></script>
<script type="text/javascript" src="js/map_mypage_thumbnail.js"></script>
<script type="text/javascript" src="js/map_mypage_search.js"></script>
<script type="text/javascript" src="js/map_popup_event.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/browse.css" type="text/css" media="screen"/>
<!-- /INCLUDE -->

<p class="clear" ></p>
<div id="mapContainer">
<div id="mapTop"></div>
<div id="mapBox">
<div id="mapCanvasMypage">
	Map
</div>
</div>
<div id="mapBottom"></div>
<div id="mycarousel" class="jcarousel-skin-ie7"> 
    <ul>
      <!-- The content will be dynamically loaded in here -->
    </ul>
</div>

</div>

<!--popup-->
<div id="mask_detail"></div>
<div id="pop_card_detail"></div>
<!--popup-->