<?php
class Browse_mdl extends CI_Model{
    
    
    function cards_by_category($categoryid){
        $cur_user =  $this->user_mdl->getCurrentUserID();
        $this->db->select('*');
        $this->db->from('tblcards');
        $this->db->or_where('(public',"1");
        $this->db->or_where('userid', $cur_user);
        $this->db->bracket('close');
        if($categoryid != 0) {
            $this->db->where('categoryid',$categoryid);
        }
        $this->db->order_by("carddate", "desc"); 
        $this->db->limit(6);
        $cards = $this->db->get();
        return $cards->result_array();

    }   

   function cards_total($categoryid){
       
       
       $cur_user =  $this->user_mdl->getCurrentUserID();
        $this->db->select('*');
        $this->db->from('tblcards');
        $this->db->or_where('(public',"1");
        $this->db->or_where('userid', $cur_user);
        $this->db->bracket('close');
        if($categoryid != 0) {
            $this->db->where('categoryid',$categoryid);
        }
        $this->db->order_by("carddate", "desc"); 
        
        $cards = $this->db->get();
        return $cards->num_rows();
       

   }
   function load_more($categoryid, $page){
        $cur_user =  $this->user_mdl->getCurrentUserID();
        $this->db->select('*');
        $this->db->from('tblcards');
        $this->db->or_where('(public',"1");
        $this->db->or_where('userid', $cur_user);
        $this->db->bracket('close');
        if($categoryid != 0) {
            $this->db->where('categoryid',$categoryid);
        }
        
        $this->db->order_by("carddate", "desc");
        if($page !=""){
            $num_per_page = 6;
            $start = $page*$num_per_page;
            $this->db->limit($num_per_page,$start);
        }
        $cards = $this->db->get();
        return $cards->result_array();
   }
   
   public function card_detail($cardid){
       
       $this->db->select('*');
       $this->db->from('tblcards');
       $this->db->where('cardid', $cardid);
       $card = $this->db->get();
       
       return $card->row_array();
   }
   function get_one_photo($cardid) {
       $this->db->select('cardpictureid, filepath, description');
       $this->db->from('tblcardpictures');
       $this->db->where('cardid',$cardid);
       $this->db->limit(1);
       $card_pic = $this->db->get();
       return $card_pic->row_array();
   }
   public function card_photos($cardid){
       $this->db->select('cardpictureid, filepath, description');
       $this->db->from('tblcardpictures');
       $this->db->where('cardid',$cardid);
       $images = $this->db->get();
       
       return $images->result_array();
   }
   public function card_owner($userid) {
       $this->db->select('lastname, firstname, thum');
       $this->db->from('tblusers');
       $this->db->where('userid',$userid);
       
       $user = $this->db->get();
       return $user->row_array();
   }
   public function card_review($cardid) {
       
       $this->db->select_sum('want');
       $this->db->select_sum('beenhere');
       $this->db->from('tblreviews');
       $this->db->where('cardid', $cardid);
       $reviews = $this->db->get();
       return $reviews->row_array();
   }
   public function check_user_review($cardid,$fieldname){
       
       $cur_user =  $this->user_mdl->getCurrentUserID();
       $this->db->select('reviewid');
       $this->db->from('tblreviews');
       $this->db->where('cardid',$cardid);
       $this->db->where('userid',$cur_user);
       $this->db->where($fieldname,1);
       $re_user = $this->db->get();
      
       if ($re_user->num_rows() > 0) {
           return TRUE;
       }
        else {
                return FALSE;
       }
   }
   public function user_review($cardid){
       $cur_user =  $this->user_mdl->getCurrentUserID();
       $this->db->select('reviewid');
       $this->db->from('tblreviews');
       $this->db->where('cardid',$cardid);
       $this->db->where('userid',$cur_user);
       $re_user = $this->db->get();
       
       if ($re_user->num_rows() > 0) {
           return TRUE;
       }
        else {
                return FALSE;
       }
   }
   public function reviews_card($reviews){
      
       if($this->user_review($reviews['cardid'])) {
           $data = array($reviews['fieldname']=> $reviews['re_value']);
           $this->db->update('tblreviews',$data, array('cardid'=>$reviews['cardid'], 'userid'=> $this->user_mdl->getCurrentUserID()));
       }
       else {
           
           $data = array($reviews['fieldname']=> $reviews['re_value'],
                         'cardid' => $reviews['cardid'],
                         'userid' => $this->user_mdl->getCurrentUserID()
                         );
           
           $this->db->insert('tblreviews', $data); 
       }
   }
   public function update_title($card){
       $data = array('title'=>$card['title'], 'locationname'=>$card['locationname']);
       $this->db->update('tblcards', $data, array('cardid' => $card['cardid']));
   }
   public function delete_photo($picid){
       $this->db->delete('tblcardpictures', array('cardpictureid' => $picid)); 
   }
   public function getUsername($userid){
       $this->db->select('username');
       $this->db->from('tblusers');
       $this->db->where('userid',$userid);
       $username = $this->db->get();
       return $username->row()->username;
       
   }
   public function savePhotos($result,$cardid){
       $result['path'] = str_replace($this->config->item('server_root'), base_url(), $result['path']);
       
       $data = array('filepath'=>$result['path'], 'cardid'=>$cardid);
       $this->db->insert('tblcardpictures',$data);
       $result['id'] = $this->db->insert_id();
       echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
   }
   public function detail_array($arr_card,$urlcard){
       $count = count($arr_card);
       $card_info = array();
       if($count > 0){
           $card_info = array();
           if($arr_card['categoryid']== 1) {
                $cat_class = 'eat';
            }
            else if($arr_card['categoryid']== 2){
                $cat_class = 'event';
            }
            else if($arr_card['categoryid']== 3){
                $cat_class = 'travel';
            }
            else if($arr_card['categoryid']== 4){
                $cat_class = 'stay';
            }
            else if($arr_card['categoryid']== 5){
                $cat_class = 'purchase';
            }
            else if($arr_card['categoryid']== 6){
                $cat_class = 'beauty';
            }
            else{
                $cat_class = 'etc';
            }
           
            $card_info = array('cardid'=>$arr_card['cardid'], 
                                'title'=>$arr_card['title'], 
                                'description'=>$arr_card['description'], 
                                'categoryid'=>$arr_card['categoryid'],
                                'public'=>$arr_card['public'],
                                'carddate'=>$arr_card['carddate'],
                                'locationname'=>$arr_card['locationname'],
                                'latitude'=>$arr_card['latitude'],
                                'longitude'=>$arr_card['longitude'],
                                'city'=>$arr_card['city'],
                                'country'=>$arr_card['country'],
                                'cardimage'=> $arr_card['cardimage'],
                                'cardmarker'=> $arr_card['cardmarker'],
                                'userid'=>$arr_card['userid'],
                                'username'=>$this->getUsername($arr_card['userid']),
                                'cat_class'=>$cat_class,
                                'images' => $this->card_photos($arr_card['cardid']),
                                'big_img' => $this->get_one_photo($arr_card['cardid']),
                                'user' => $this->card_owner($arr_card['userid']),
                                'reviews' => $this->card_review($arr_card['cardid']),
                                'urlcard' => $urlcard,
                                'check_want' => $this->check_user_review($arr_card['cardid'], 'want'),
                                'check_beenhere' => $this->check_user_review($arr_card['cardid'], 'beenhere'),
                                'map' => $this->map_info($arr_card['cardid'])
            );
       }
       return $card_info;
   }
   function map_info($cardid) {
       $this->db->select('*');
       $this->db->where('cardid', $cardid);
       $map = $this->db->get('vcards');
       return $map->result();
   }
    function arrray_cards($cards){
        $card_info = array();
        $count = count($cards);
        if($count > 0) {
                    
                    foreach ($cards as $row){
                        
                        if($row['categoryid']== 1) {
                            $cat_class = 'eat';
                        }
                        else if($row['categoryid']== 2){
                            $cat_class = 'event';
                        }
                        else if($row['categoryid']== 3){
                            $cat_class = 'travel';
                        }
                        else if($row['categoryid']== 4){
                            $cat_class = 'stay';
                        }
                        else if($row['categoryid']== 5){
                            $cat_class = 'purchase';
                        }
                        else if($row['categoryid']== 6){
                            $cat_class = 'beauty';
                        }
                        else{
                            $cat_class = 'etc';
                        }
                        
                        array_push($card_info, array('cardid'=>$row['cardid'], 
                                                     'title'=>$row['title'], 
                                                     'description'=>$row['description'], 
                                                     'categoryid'=>$row['categoryid'],
                                                     'public'=>$row['public'],
                                                     'carddate'=>$row['carddate'],
                                                     'locationname'=>$row['locationname'],
                                                     'latitude'=>$row['latitude'],
                                                     'longitude'=>$row['longitude'],
                                                     'city'=>$row['city'],
                                                     'country'=>$row['country'],
                                                     'cardimage'=> $row['cardimage'],
                                                     'cardmarker'=> $row['cardmarker'],
                                                     'userid'=>$row['userid'],
                                                     'cat_class'=>$cat_class
                                                     
                                                    ));
                    }
                    
                }
                return $card_info;
    }
    
    //RUN===
    function updateCardLocation($cardid, $latitude, $longitude, $city, $country){
    	//$data = $latitude.', '.$longitude.', '.$city.', '.$country;
		$data = array(
				'latitude' => $latitude,
				'longitude' => $longitude,
				'city' => $city,
				'country' => $country
				);
		$this->db->where('cardid',$cardid);
		$result = $this->db->update('tblcards', $data);
		//return $result;
    }
    //endRUN
    
}
