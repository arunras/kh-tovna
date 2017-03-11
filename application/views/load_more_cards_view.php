<?php
$card_count = count($card_info);
        if($card_count >0) {   
            for($i=0; $i< $card_count; $i++){
                echo '<div class="card '.$card_info[$i]['cat_class'].'">
                           <input type="hidden" value="'.$card_info[$i]['cardid'].'" />';
                    echo ' <div class="bg_base_top"></div>
                            <div class="bg_base_middle"></div>
                            <div class="bg_base_bottom"></div>
                            <div class="block_pop">
                                <div class="bg_top"></div>
                                <div class="bg_middle"></div>
                                <div class="bg_bottom"></div>
                                <img class="img_card" src ="../'.$card_info[$i]['filepath'].'"/>
                                <span class="short_text"><div class="desc_text">'.$card_info[$i]['title'].'</div></span>
                            </div>';
                echo '</div>';
            }
        }
