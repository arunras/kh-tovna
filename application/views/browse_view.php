<div id="browse">
    
    <link rel="stylesheet" href="<?php echo base_url();?>css/browse.css" type="text/css" media="screen"/>
    <link href="<?php echo base_url();?>css/jquery.thumbnailScroller.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>js/jquery.ba-hashchange.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/css_browser_selector.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/browse.js"></script>
    
    <style>
        div#footer {
            display: none;
        }
    </style>
    
    <div class="" style="width:100%; height: 100%; margin-top: 30px;">
        <div class="div_wrap"></div>
        
        <div class="div_more" style="width:740px; margin:10px auto; text-align:center; height:40px;padding-right: 5px;">
             <span class="load_more" style=" margin: 0 auto;width: 100px; display: none;padding: 8px 8px 8px 8px;">Load More...  </span>
        </div>
        
        <div class="div_paginate">
            <input type="hidden" class="page" value="" />
            <input type="hidden" class="total_page" value="" />
        </div>
       
    </div>
    
<!--popup-->
    <div id="mask_detail"></div>
    <div id="pop_card_detail"></div>
<!--popup-->
</div>
 



