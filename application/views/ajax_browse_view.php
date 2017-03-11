<?php
    //print_r($card_info);
    $card_count = count($card_info);
    
        if($card_count >0) {   
            
            for($i=0; $i< $card_count; $i++){
               // echo $card_info[$i]['cardimage'];
                echo '<div class="card '.$card_info[$i]['cat_class'].'" onclick = "click_card('.$card_info[$i]['cardid'].')" title="">
                            <input type="hidden" value="'.$card_info[$i]['cardid'].'" />';
                    echo ' <div class="bg_base_top"></div>
                            <div class="bg_base_middle"></div>
                            <div class="bg_base_bottom"></div>
                            <div class="block_pop">
                                <div class="bg_top"></div>
                                <div class="bg_middle"></div>
                                <div class="bg_bottom"></div>
                                <img class="img_card" src ="'.$card_info[$i]['cardimage'].'"/>
                                <span class="short_text"><div class="desc_text">'.$card_info[$i]['title'].'</div></span>
                            </div>';
                echo '</div>';    
            }
            echo '<div class="ajax_paginate" style="display:none;">
                     <input type="hidden" class ="total_page" value="'.$total_page.'" />
                  </div>';
        }