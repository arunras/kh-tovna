<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_more").click(function(e){
			e.preventDefault();
			//alert(this.href);
			//return false;
			var str=this.href;
			var n=str.lastIndexOf('/')+1;
			var profilename=str.substring(n,str.length);
		$.ajax({
				url:location.protocol + "//" + location.host + "/profile/more_friend",
				data:{fname: profilename},
				type:'POST',
				success:function(result){
					if(result =='false'){
						window.location = location.protocol + "//" + location.host + "/user/login/1";
					}
					else{
					$('#pop-more-friend').html(result);
					var maskHeight = $(document).height();
					var maskWidth = $(document).width();
					$('#mask').css({'width':maskWidth,'height':maskHeight});
					$('#mask').fadeIn(1000);
					$('#mask').fadeTo('slow',0.8);

					var winH = $(window).height();
					var winW = $(document).width();
	
					var id = $('#pop-more-friend');
					var id_width = id.width();
					var id_height = id.height();

					var id_scroll=$('.pop-image-scroll');
					var x = (winW/2) - (id_width/2);
					id_scroll.css('overflow-y','scroll');
					id_scroll.css('width',id_width-1);
					id_scroll.css('height',id_height-44);
					id.css('top',100);
					id.css('left',x);
					id.fadeIn(1000);
	
					}
				}
			});
		});
	});
</script>
<div id="pop-more-friend"></div>
<div id="profilepage-wraper">
	<div id="bgmypage">
		<div id="wrap-profile">
			<div id="col-profile">
				<div class="profile-image">
					<img src="<?php echo $userinfo->thum?>" width="88px">
				</div>
				<div class="profile-info">
					<h2><?php echo $userinfo->username?></h2>
					<div class="email">
						<a href="mailto:<?php echo $userinfo->email?>"><?php echo $userinfo->email?></a>
					</div>
					<div class="num-card"><?php echo $numCard;?> Cards</div>
					<div class="num-friend"><?php echo $numFriend?> Friends</div>
				</div>
			</div>
		<div id="col-btn">
			<?php if($isFriend==1){?>
				<a href="<?php echo $userinfo->userid?>" class="btn-remove"><div class="btn-remove"></div></a>
			<?php }
				else {
					if($isSendRequest==1){
						echo '<a href="'.$userinfo->userid.'" class="btn-cancel-friend"><div class="btn-cancel"></div></a>';
					}
					else{
						if($isConfirmFriend==1){
							echo '<a href="'.$userinfo->userid.'" class="btn-confirm-friend"><div class="btn-confirm"></div></a>';
						}
						else{
					?>
						<a href="<?php echo $userinfo->userid?>" class="btn-add"><div class="btn-add"></div></a>
				<?php 
						}
					}
				}?>
		</div>
		</div>
		<div class="friends">
			<h2>Friends (<?php echo $numFriend;?>)</h2>
			<?php foreach($friendlist as $afriend){?>
			<a href="<?php echo site_url('profile/show/'.$afriend->username);?>" id="1" title="<?php echo $afriend->username?>"><img src="<?php echo $afriend->thum?>" width="50px" height="50px" /></a>
			<?php }  if($numFriend>=4){?>			
			<a href="<?php echo $userinfo->username;?>" id="btn_more">more</a>
			<?php } /*end if($numFriend>=10)*/?>
		</div>
	</div>
</div>