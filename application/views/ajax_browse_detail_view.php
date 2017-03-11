
<link href="<?php echo base_url();?>css/jquery.thumbnailScroller.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/browse_detail.css" rel="stylesheet" type="text/css" />


<script src="<?php echo base_url();?>js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.2.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/css_browser_selector.js"></script>

<script src="<?php echo base_url();?>js/jquery-ui-1.8.13.custom.min.js"></script>

<script src="<?php echo base_url();?>js/browse_detail.js"></script>

<!--RUN-->
<script type="text/javascript">
	var json = <?php echo '{"card":'.json_encode($c['map']).'}';?>;
</script>
<script type="text/javascript" src="<?php echo base_url();?>js/maplib_progressBar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/map_detail.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/map_toggle_event.js"></script>
<!--RUN-->
<?php
	//$json_map = json_encode($c['map']);
	//print_r($json_map);
?>
<div class="popup">
        <input type ="hidden" id="current_cardid" value="<?php echo $c['cardid'];?>" />
        <input type ="hidden" id="cur_userid" value="<?php echo $cur_user;?>" />
        <input type ="hidden" id="card_userid" value="<?php echo $c['userid'];?>" />
	<div id="popup_detail">
		<!--top -->
		<div class="bar_<?php echo $c['cat_class']; ?>"></div>
		<div class="btn_close" onclick="close_detail()"></div>
		<!-- end top -- >

        <!-- middle -->
		<div class="wrap_content">
			<!--first -->
			<div class="block_1">
				<!--left-->
				<div class="left_side">
                                    <div class="div_pro_pic">
                                        <a href="<?php echo site_url("profile/show/" . $c['username']); ?>"> <img class="img_pro" src="<?php echo $c['user']['thum']; ?>" /></a>
                                    </div>
                                    <div class="c_info">
                                        <div class="edit_card">
                                            <?php 
                                                    echo '<input style="width:71%;" id="title" class="txt_title" type="text" value="'.$c['title'].'" /><label class="red_star1">*</label>';
                                                    echo '<input id="btn_save"  style ="margin-left:8px; width:66px;" type="submit" value="Save" />';
                                                    echo '<input style="width:71%;" id="location" type="text" class="txt_location" value="'.$c['locationname'].'" /><label class="red_star2">*</label>'; 
                                                    echo '<input id="btn_cancel"  style ="margin-left:8px;" type="submit" value="Cancel" />';
                                           
                                            ?>
                                        </div>
                                        <div class="title"><?php echo $c['title']; ?></div>
                                        <div class="location"><?php echo $c['locationname']; ?></div>
                                        <div class="c_date"><?php echo $c['carddate']; ?></div>
                                    </div>
				</div>
				<!-- right-->
				<div class="right_side">
                                    
					<!--edit -->
                                        <?php 
                                            
                                            if($cur_user == $c['userid']) {
                                                echo '<div class="div_edit">
                                                        <span class="edit">Edit</span>
                                                      </div>';
                                                
                                            } 
                                        ?>
					
					<!-- fb-share  -->
					<div class="fb_share">
					<?php
					$fb_url = 'https://www.facebook.com/sharer/sharer.php?u='.$c['urlcard'];
					echo '<a href="'.$fb_url.'" onclick="return show_popup(\''.$fb_url.'\')" target="_blank"><img  style ="border:none;" src="../images/fb_share.png"></a>';
					?>
					</div>
					<!-- g+ share -->
					<div class="g_share">


					<?php
					$url = "https://plus.google.com/share?url=".$c['urlcard'];
					echo '<a href="'.$url.'" onclick="return show_popup(\''.$url.'\')" target="_blank"><img  style ="border:none;" width="16" height="16" src="../images/g.ico"></a>';
					?>
					</div>
					<!-- fb-like -->
					<div class="fb_like">
						<div id="fb-root"></div>
						<script>
                                                    $(document).ready(function(){
                                                       (function(d, s, id) {
                                                            var js, fjs = d.getElementsByTagName(s)[0];
                                                            if (d.getElementById(id)) return;
                                                            js = d.createElement(s); js.id = id;
                                                            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                                        fjs.parentNode.insertBefore(js, fjs);
                                                        }(document, 'script', 'facebook-jssdk'));
                                                                        try{
                                                                                FB.XFBML.parse(); 
                                                                        }catch(ex){}
                                                    });
                                                </script>
						<div class="fb-like" data-href="<?php echo $c['urlcard'];?>" data-send="false" data-layout="box_count" data-width="20" data-show-faces="false"></div>
					</div>

					<!-- twitter -->
					<div class="twitter_like">
                                            <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://bit.ly/twitter-api-announce" data-counturl="<?php echo $c['urlcard'];?>" data-lang="en" data-count="vertical">Tweet</a>
                                            <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
					</div>
					<!-- g+ like -->
					<div class="g_like">
						<div class="g-plusone" data-size="tall" data-href="<?php echo $c['urlcard'];?>"></div>
						<script type="text/javascript">
                                                window.___gcfg = {lang: 'en-GB'};

                                                (function() {
                                                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                    po.src = 'https://apis.google.com/js/plusone.js';
                                                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                })();
                                                </script>
					</div>

				</div>
			</div>
			<!-- end of first -->

			<!--second --->
			<div class="block_2">
				<div class="big_pic">
					<img class="img_big" src="<?php if(count($c['big_img']) >0){ echo $c['big_img']['filepath']; } ?>" />
				</div>
				<div class="block_thumb">
					<!-- scroll -->
					<div id="tS3" <?php if($cur_user == $c['userid']) { echo 'style="height:355px;margin-bottom: 5px;"';} ?> class="jThumbnailScroller" >
						<div class="jTscrollerContainer">
							<div class="jTscroller">
							<?php
							foreach ($c['images'] as $m){
                                                            if($m['filepath'] != "") {
                                                                echo '<a>
                                                                        <img class="thumb" src="'.$m['filepath'].'" /><input type="hidden" value="'.$m['cardpictureid'].'" />';
                                                                        if($cur_user == $c['userid']) {
                                                                            echo '<span class="delete_img" ></span>';
                                                                        }
                                                                echo '</a>';
                                                            }
							}
							?>
							</div>
						</div>
					</div>
					<!-- end scroll -->
                                        <?php if($cur_user == $c['userid']) { echo '<div id="upload_photo"><img class="img_add" src="'.base_url().'/images/plus.png" width="40" height="40" /></div>';
                                                echo '<script src="'.base_url().'js/fileuploader_ou.js" type="text/javascript"></script>';
                                        ?>
<!--                                            <script>        
                                                function createUploader(){
                                                    var cardid = jQuery('div.popup').find('input#current_cardid').val();
                                                    var cur_user = jQuery('div.popup').find('input[type=hidden]#cur_userid').val();
                                                    var card_user = jQuery('div.popup').find('input[type=hidden]#card_userid').val();
                                                    var uploader = new qq.FileUploader({
                                                        element: document.getElementById('upload_photo'),
                                                        action: location.protocol + "//" + location.host + "/browse/addPhotos",
                                                        params: {
                                                                c: cardid
                                                            },

                                                        debug: true,
                                                        onComplete: function(id, fileName, responseJSON){
                                                             //alert(responseJSON.id);
                                                             var thumb = '<a><img class="thumb" src="'+responseJSON.path+'" /><input type="hidden" value="'+responseJSON.id+'" />';
                                                                if(cur_user == card_user) {
                                                                    thumb += '<span class="delete_img" ></span>'; 
                                                                }
                                                             thumb += '</a>';
                                                             
                                                             jQuery('div#tS3').find('div.jTscroller').append(thumb);
                                                             //alert(jQuery('div#tS3').find('div.jTscroller').html());
                                                             
                                                             // show big pic
                                                                jQuery('img.thumb').click(function(){
                                                                    var img_src = jQuery(this).attr('src')
                                                                    //alert(img_src);
                                                                // alert(jQuery('div.block_2 div.big_pic').html());
                                                                    jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src',img_src);
                                                                });
                                                             
                                                             // delelet
                                                             jQuery('span.delete_img').click(function(){
                                                                var picid = jQuery(this).siblings('input[type=hidden]').val();
                                                                var src_delete = jQuery(this).siblings('img').attr('src');
                                                                var src_big = jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src');
                                                                var a_delete = jQuery(this).parent('a');
                                                                if(confirm('Are you sure want to delete?')) {
                                                                    jQuery.ajax({
                                                                        type: 'post',
                                                                        url: location.protocol + "//" + location.host + "/browse/deletephoto",
                                                                        data: {picid : picid},
                                                                        success: function(){
                                                                                a_delete.remove(); 
                                                                                if(src_delete == src_big){
                                                                                    var new_src = "";
                                                                                    jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src','');

                                                                                    new_src = jQuery('div.jTscroller').first('a').find('img.thumb').attr('src');
                                                                                    if(new_src != null){
                                                                                        jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src', new_src);
                                                                                    }
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                                else {return;}

                                                             });
                                                             
                                                             // end delete
                                                             
                                                             
                                                        }

                                                        debug: true,
                                                        onComplete: function(id, fileName, responseJSON){
                                                             //alert(responseJSON.id);
                                                             var thumb = '<a><img class="thumb" src="'+responseJSON.path+'" /><input type="hidden" value="'+responseJSON.id+'" />';
                                                                if(cur_user == card_user) {
                                                                    thumb += '<span class="delete_img" ></span>'; 
                                                                }
                                                             thumb += '</a>';
                                                             jQuery('div#tS3').find('div.jTscroller').append(thumb);
                                                             
                                                             // show big pic
                                                                jQuery('img.thumb').click(function(){
                                                                    var img_src = jQuery(this).attr('src')
                                                                    //alert(img_src);
                                                                // alert(jQuery('div.block_2 div.big_pic').html());
                                                                    jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src',img_src);
                                                                });
                                                             
                                                             // delelet
                                                             jQuery('span.delete_img').click(function(){
                                                                var picid = jQuery(this).siblings('input[type=hidden]').val();
                                                                var src_delete = jQuery(this).siblings('img').attr('src');
                                                                var src_big = jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src');
                                                                var a_delete = jQuery(this).parent('a');
                                                                if(confirm('Are you sure want to delete?')) {
                                                                    jQuery.ajax({
                                                                        type: 'post',
                                                                        url: location.protocol + "//" + location.host + "/browse/deletephoto",
                                                                        data: {picid : picid},
                                                                        success: function(){
                                                                                a_delete.remove(); 
                                                                                if(src_delete == src_big){
                                                                                    var new_src = "";
                                                                                    jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src','');

                                                                                    new_src = jQuery('div.jTscroller').first('a').find('img.thumb').attr('src');
                                                                                    if(new_src != null){
                                                                                        jQuery('div.block_2 div.big_pic').find('img.img_big').attr('src', new_src);
                                                                                    }
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                                else {return;}

                                                             });
                                                             
                                                             // end delete
                                                             
                                                             
                                                        }

                                                    });           
                                                }
                                                // in your app create uploader as soon as the DOM is ready
                                                // don't wait for the window to load  
                                                window.onload = createUploader;     
                                            </script> -->
                                        <?php
                                              } 
                                        ?>
				</div>
			</div>
			<!-- end of second --->

			<!-- third --->
			<div class="block_3">
                                <?php 
                                    if($c['check_want']){ $check_want= "wanttovisit";} else { $check_want = 'wanttovisit_on';} 
                                    if($c['check_beenhere']){ $check_beenhere= "Ivbeenhere";} else { $check_beenhere = 'Ivbeenhere_on';}  
                                ?> 
				<div class="interest">
                                    <?php echo '<img class="'.$check_want.'" src="'.base_url().'/images/btn_'.$check_want.'.png" height="42" />'; ?>
                                        <span class="num_want">
                                            <?php
                                            if(count($c['reviews']['want']) > 0) { echo $c['reviews']['want']; }
                                            else { echo "0"; }
                                            ?> 
                                        </span>
				</div>
				<div class="beenhere" style="float: right; margin-right: 118px;">
                                    <?php echo '<img class="'.$check_beenhere.'" src="'.base_url().'/images/btn_'.$check_beenhere.'.png" height="42" />'; ?>
                                            <span class="num_havebeen">
						<?php
						if(count($c['reviews']['beenhere']) > 0) { echo $c['reviews']['beenhere']; } 
                                                else { echo  "0"; }
						?> 
                                            </span>
				</div>
			</div>
			<!--end of third --->
                        
			<!-- four (map) --->
			<!-- RUN Map ===-->
			<div class="block_4">
				<?php 
                                    $getDirection = '<a href="http://maps.google.com/maps?saddr=&daddr='.$c['latitude'].','.$c['longitude'].'" target="_new"><div id="btnDirection" title="Direction"></div></a>';
				?>
				<div id="mapCanvasDetail">Map Detail</div>
				<div id="mapBarBottomBox">

                                    <div id="ibtnMapExpand"><div id="iexpandCollapseIcon"></div></div>
                                    <div id="btnDirection" title="Direction"><a href="#" target="_new"></a></div>
                                    <div id="btnMyLocation" title="My Location" onclick="showMyLocation()"></div>

					<div id="ibtnMapExpand"><div id="iexpandCollapseIcon"></div></div>
					<?php echo $getDirection;?>
					<div id="btnMyLocation" title="Location" onclick="setMarkerToCenterMap();clickMarker();"></div>

				</div>
				<div id=mapDetailDataBox>
                    <label for="ilatitude">Lat: </label>
                    <input type="text" id="ilatitude" name="latitude" readonly="readonly" placeholder="latitude"/>
                    <label for="ilongitute">Lng: </label>
                    <input type="text" id="ilongitude" name="longitude" readonly="readonly" placeholder="longitude"/>
					<input type="text" id="icity" name="city" readonly="readonly" placeholder="city" />
                    <input type="text" id="icountry" name="country" readonly="readonly" placeholder="country" />
                    <input type="text" id="iaddress" name="address" readonly="readonly" placeholder="address" size="106"/>
				</div>
			</div>
			<!-- endRUN Map ===-->
			<!-- end of four (map) --->
                        
			<!-- five (fb comment) --->
			<div class="block_5">
                            <div id="fb-root"></div>
                            <script>
                            var cid = null;
                                $(document).ready(function(){
                                   // alert('aa');
                                        (function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return;
                                        js = d.createElement(s); js.id = id;
                                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                        fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));
                                        try{ FB.XFBML.parse(); }catch(ex){}
                                        
                                        jQuery("#tS3").thumbnailScroller({ 
                                            scrollerType:"hoverPrecise", 
                                            scrollerOrientation:"vertical", 
                                            scrollSpeed:2, 
                                            scrollEasing:"easeOutCirc", 
                                            scrollEasingAmount:800, 
                                            acceleration:4, 
                                            scrollSpeed:800, 
                                            noScrollCenterSpace:10, 
                                            autoScrolling:0, 
                                            autoScrollingSpeed:2000, 
                                            autoScrollingEasing:"easeInOutQuad", 
                                            autoScrollingDelay:500 
                                       });
                                        
                                       initializeDetail();
                                });
                               // alert(cid);
                            </script>
                            <div class="fb-comments" data-href="<?php echo $c['urlcard'];?>"data-num-posts="2" data-width="620" style="margin-left: 120px;"></div>
			</div><!--end of five (fb comment) --->
		</div><!--end of middle -->

		<!--bottom -->
		<div class="wrap_bottom"></div>
		<!-- end of bottom -->
	</div><!--end of popup_detail -->
</div><!-- end of popup -->

<!-- =========== pop ============== -->

<script>
     jQuery.noConflict();
</script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.thumbnailScroller.js"></script>
