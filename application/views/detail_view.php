<link rel="stylesheet" href="css/browse.css" type="text/css" media="screen"/>
<link href="css/jquery.thumbnailScroller.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/css_browser_selector.js"></script>
<script type="text/javascript" src="js/browse.js"></script>
<script src="js/jquery-ui-1.8.13.custom.min.js"></script>

<!-- ============== pop =================-->
    <div style="width:100%; height: 100%; text-align: center;">
            <div  class="popup">
                <div id="popup_detail">
                    <!-- top -->
                    <div class="bar_eat"></div>
                    <div class="btn_close"></div>
                    <!-- end of top -- >
                    
                    <!-- middle -->
                    <div class="wrap_content">
                        <!-- first --->
                        <div class="block_1">
                            <!--left-->
                            <div class="left_side">
                                <div class="div_pro_pic">
                                    <img class="img_pro" src="../images/card_images/5.jpg"/>
                                </div>
                                <div class="c_info">
                                    <div class="title">Sakura </div>
                                    <div class="location">Ueno Park, Tokyo, Japan</div>
                                    <div class="c_date">26 May 2012</div>
                                </div>
                            </div>
                            <!--right-->
                            <div class="right_side">
                                
                                <!-- edit -->
                                <div class="div_edit" style=""><span class="edit">Edit</span></div>
                                <!-- fb-share  -->
                                <div class="fb_share">
                                    <?php
                                        $fb_url = 'https://www.facebook.com/sharer/sharer.php?u=http://khmer-news.org/';
								echo '<a href="'.$fb_url.'" onclick="return show_popup(\''.$fb_url.'\')" target="_blank"><img  style ="border:none;" src="../images/fb_share.png"></a>';
                                    ?>
                                </div>
                                <!-- g+ share -->
                                <div class="g_share">
                                   <?php 
                                      $url = "https://plus.google.com/share?url=http://khmer-news.org/";
                                      echo '<a href="'.$url.'" onclick="return show_popup(\''.$url.'\')" target="_blank"><img  style ="border:none;" width="16" height="16" src="../images/g.ico"></a>';
                                   ?>
                                </div>
                                <!-- fb-like -->
                                <div class="fb_like">
                                    <div id="fb-root"></div>
                                    <script>
                                    (function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s); js.id = id;
                                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                    fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));</script>
                                    <div class="fb-like" data-href="http://khmer-news.org/" data-send="false" data-layout="box_count" data-width="20" data-show-faces="false"></div>
                                </div>
                                
                                <!-- twitter -->
                                <div class="twitter_like">
                                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bit.ly/twitter-api-announce" data-counturl="http://khmer-news.org/" data-lang="en" data-count="vertical">Tweet</a>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                </div>
                                <!-- g+ like -->
                                <div class="g_like"><!-- Place this tag where you want the +1 button to render -->
                                    <div class="g-plusone" data-size="tall" data-href="http://khmer-news.org"></div>

                                    <!-- Place this render call where appropriate -->
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
                        
                        <!-- second --->
                        <div class="block_2">
                            <div class="big_pic">
                                <img class="img_big" src="../images/card_images/1.jpg" />
                            </div>
                            <div class="block_thumb">
                                <!-- scroll -->
                                <div id="tS3" class="jThumbnailScroller" style="margin-bottom:5px;">
                                    <div class="jTscrollerContainer">
                                        <div class="jTscroller">
                                            <a><img class="thumb" src="../images/card_images/4.jpg" /><input type="hidden" value="1"/></a>
                                            <a><img class="thumb" src="../images/card_images/1.jpg" /><input type="hidden" value="2"/></a>
                                            <a><img class="thumb" src="../images/card_images/3.jpg" /><input type="hidden" value="3"/></a>
                                            <a><img class="thumb" src="../images/card_images/5.jpg" /><input type="hidden" value="4"/></a>
                                            <a><img class="thumb" src="../images/card_images/2.jpg" /><input type="hidden" value="5"/></a>
                                            <a><img class="thumb" src="../images/card_images/3.jpg" /><input type="hidden" value="6"/></a>
                                            <a><img class="thumb" src="../images/card_images/1.jpg" /><input type="hidden" value="7"/></a>
                                            <a><img class="thumb" src="../images/card_images/5.jpg" /><input type="hidden" value="8"/></a>
                                            <a><img class="thumb" src="../images/card_images/1.jpg" /><input type="hidden" value="9"/></a>
                                            <a><img class="thumb" src="../images/card_images/2.jpg" /><input type="hidden" value="10"/></a>
                                            <a><img class="thumb" src="../images/card_images/3.jpg" /><input type="hidden" value="11"/></a>
                                            <a><img class="thumb" src="../images/card_images/4.jpg" /><input type="hidden" value="12"/></a>
                                            <a><img class="thumb" src="../images/card_images/5.jpg" /><input type="hidden" value="13"/></a>
                                        </div>
                                    </div>
                                    <a href="#" class="jTscrollerPrevButton"></a>
                                    <a href="#" class="jTscrollerNextButton"></a>
                                </div>
                                <!-- end scroll -->
                                <img src="../images/plus.png" width="40" height="40" />
                            </div>
                        </div>
                        <!-- end of second --->
                        
                        <!-- third --->
                        <div class="block_3">
                            <div class="interest">
                                <img class="img_visit_on" src="../images/btn_wanttovisit_on.png" height="42" />
                                <span class="num_want">3</span>
                            </div>
                            <div style="float:right; margin-right: 118px;">
                                <img class="img_havebeen_on" src="../images/btn_Ivbeenhere_on.png" height="42" />
                                <span class="num_havebeen">2</span>
                            </div>
                        </div>
                        <!-- end of third --->
                        <!-- four (map) --->
                        <div class="block_4">
                            <div class="block_map">
                                <img src="../images/map.png" width="624"/>
                            </div>
                        </div>
                         <!-- end of four (map) --->
                        <!-- five (fb comment) --->
                        <div class="block_5">
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                            fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            
                            <div class="fb-comments" data-href="http://camitss.com/" data-num-posts="2" data-width="622"></div>
                        </div>
                         <!-- end of five (fb comment) --->
                        
                    </div>
                    <!-- end of middle -->
                    
                    <!-- bottom -->
                    <div class="wrap_bottom"></div>
                    <!-- end of bottom -->
                </div> <!-- end of popup_detail -->
            </div> <!-- end of popup -->
<!-- =========== pop ============== -->
</div>
<script>
        jQuery.noConflict();
        (function($){
        window.onload=function(){
            $("#tS3").thumbnailScroller({ 
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
        }
        })(jQuery);
</script>
<script src="js/jquery.thumbnailScroller.js"></script>