<?php
class Card_mdl extends CI_Model{
	function createCard(){
		
	}
	function getNumCard($userid){
		$this->db->where("userid",$userid);
		$q = $this->db->get("tblcards");
		return $q->num_rows();
	}
	function createMapIcon($filename_source,$categoryname){

		$background_image_path = $this->config->item('images_path').'map_icon_'.$categoryname.'.png';
		$background_image = $this->loadImage($background_image_path);
			
 		$card_picture = $this->image_resize($filename_source, $this->getTypeImage($filename_source), 33, 33,1);
		imagecopymerge($background_image, $card_picture, 5.5, 5.5, 0, 0, 33, 33, 100);
		
		//header('Content-Type: image/png');
		$dest = $this->config->item('map_icon').$this->getFilename($filename_source);
		imagepng($background_image,$dest);
		//imagepng($card_picture);
		
		imagedestroy($background_image);
		imagedestroy($card_picture);
		return $dest;
	}
	function getTypeImage($filename){
		$type = explode('.', $filename);
		$type =$type[1];
		return $type;
	}
	function getFilename($filename){
		$tem = explode('/',$filename);
		return $tem[count($tem)-1];
	}
	function loadImage($filename){
		$type = explode('.', $filename);
		$type =$type[1];
		switch ($type) {
			case 'png':
				$img = imagecreatefrompng($filename);
				$blackimage = imagecolorallocate($img, 0, 0, 0);
				imagecolortransparent($img,$blackimage);
				imagealphablending($img, false);
				imagesavealpha($img, true);
				return $img;
			case 'gif':
				return imagecreatefromgif($filename);
			case 'jpg':
				return imagecreatefromjpeg($filename);
			case 'jpeg':
				return imagecreatefromjpeg($filename);
		}
	}
	
	function resizeImage($filename) {
		$config = array(
			'image_library' => 'gd2',
			'source_image' => $filename,
			'create_thumb' => false,
			'maintain_ratio' => false,
			'width' => 75,
			'height' => 75,
			'new_image' => $this->config->item('card_image_thum')
		);
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
		$fname = $this->getFilename($filename);
		return $this->config->item('card_image_thum').$fname;
	}
	
	
	/*
	* Resize image: php.net/manual
	*/
	function image_resize($src, $type, $width, $height, $crop=0){
	
		if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
		//$type = strtolower(substr(strrchr($src,"."),1));
		if($type == 'jpeg') $type = 'jpg';
		switch($type){
			case 'bmp': $img = imagecreatefromwbmp($src); break;
			case 'gif': $img = imagecreatefromgif($src); break;
			case 'jpg': $img = imagecreatefromjpeg($src); break;
			case 'png': $img = imagecreatefrompng($src); break;
			default : return "Unsupported picture type!";
		}
	
		// resize
		if($crop){
			if($w < $width or $h < $height) {
				if($w < $width) $width = $w;
				if($h < $height) $height = $h;
				//        return "Picture is too small!";
			}
			$ratio = max($width/$w, $height/$h);
			$h = $height / $ratio;
			$x = ($w - $width / $ratio) / 2;
			$w = $width / $ratio;
		}
		else{
			if($w < $width and $h < $height) {
				if($w < $width) $width = $w;
				if($h < $height) $height = $h;
				//        return "Picture is too small!";
			}
			$ratio = min($width/$w, $height/$h);
			$width = $w * $ratio;
			$height = $h * $ratio;
			$x = 0;
		}
	
		$new = imagecreatetruecolor($width, $height);
	
		// preserve transparency
		if($type == "gif" or $type == "png"){
			imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
			imagealphablending($new, false);
			imagesavealpha($new, true);
		}
	
		imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $w, $h);
	/*
		switch($type){
			case 'bmp': imagewbmp($new, $dst); break;
			case 'gif': imagegif($new, $dst); break;
			case 'jpg': imagejpeg($new, $dst); break;
			case 'png': imagepng($new, $dst); break;
		}
		*/
		return $new;
	}
	
	
	function addCard($datecreate,$title,$category,$description,$lat,$lng,$placename,$private,$cardimage,$cardmarker,$city,$country){
		
		$categoryid = $this->user_mdl->getDBValue('tblcategory','categoryid','categoryname',$category);
		$userid = $this->user_mdl->getCurrentUserID();
		$data = array(
			'title' => $title,
			'description' => $description,
			'categoryid' => $categoryid,
			'locationname' => $placename,
			'latitude' => $lat,
			'longitude' => $lng,
			'cardimage' => $cardimage,
			'cardmarker' => $cardmarker,
			'userid' => $userid,
			'city' => $city,
			'country' => $country,
			'public' => $private,
			'carddate' => $datecreate
		);
		$this->db->insert('tblcards',$data);
		return $this->db->insert_id();
		
	}
	function addCardPicture($filelist,$cardid){
		foreach ($filelist as $afile){
			$data = array (
			 	'filepath' => $afile,
			 	'cardid' => $cardid
			);
			$this->db->insert('tblcardpictures',$data);
		}
	}
	
	
	
	
	
	
/*RUN*/
//Haversine formula
//3959 for Miles
//6371 for kilometers
//Given lat=37, long = -122
//20 locations 
//radius of 25 miles
//Google SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;
//centerLat = 37;
//centerLng = -122;
//radius = 25;
//km = 6371;
//HaversineFormula = "( 3959 * acos( cos( radians(37) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(-122) ) + sin( radians(37) ) * sin( radians( latitude ) ) ) )";

//SELECT cardid, title, latitude, longitude, HaversineFormula AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;

	function getCardInDistance($centerLat, $centerLng){
		$radius = 2; //5km
		$km = 6371; //for kilometers
		$HaversineFormula = "($km*acos(cos(radians($centerLat))*cos(radians(latitude))*cos(radians(longitude)-radians($centerLng))+sin(radians($centerLat))*sin(radians(latitude))))";
		
		//$this->db->select('cardid, title, latitude, longitude,'.$HaversineFormula.' AS distance');
		$this->db->select('location_id, location_name, latitude, longitude,'.$HaversineFormula.' AS distance');
		$this->db->having(array('distance <' => $radius));
		$this->db->order_by('distance','ASC');
		//$q = $this->db->get('tblcards',10,0);
		$q = $this->db->get('tbllocations');//,10,0
		return $q->result();
	}
	function getCardInViewPort($card_type, $swLat, $swLng, $neLat, $neLng){
		//$this->db->select('location_id, location_name, latitude, longitude,');
		$this->db->select('cardid, title, latitude, longitude, cardmarker, cardimage, locationname, city, country, categoryid, categoryname, username');
		if($card_type!='All'){
			$this->db->where('categoryname', $card_type);
		}
		//$this->db->where('public =', 1);
		$this->db->where('latitude >', $swLat);
		$this->db->where('latitude <', $neLat);
		$this->db->where('longitude >', $swLng);
		$this->db->where('longitude <', $neLng);
		$q = $this->db->get('vcards');//,10,0
		return $q->result();
	}
	//getMyCardInViewPort
	function getMyCardInViewPort($swLat, $swLng, $neLat, $neLng){
		$userid = $this->user_mdl->getCurrentUserID();
		//$this->db->select('location_id, location_name, latitude, longitude,');
		$this->db->select('cardid, title, latitude, longitude, cardmarker, cardimage, locationname, city, country, categoryid, categoryname, username');

		$this->db->where('userid =', $userid);
		$this->db->where('latitude >', $swLat);
		$this->db->where('latitude <', $neLat);
		$this->db->where('longitude >', $swLng);
		$this->db->where('longitude <', $neLng);
		$q = $this->db->get('vcards');//,10,0
		return $q->result();
	}
	//getMyFriendCardInViewPort
	function getMyFriendCardInViewPort($swLat, $swLng, $neLat, $neLng){
		$userid = $this->user_mdl->getCurrentUserID();
		/*
		$user1 = $this->db->select('frienduserid')->from('tblfriends')->where('userid',$userid)->_compile_select();
		$this->db->_reset_select();
		$user2 = $this->db->select('userid')->from('tblfriends')->where('userid',$userid)->_compile_select();
		$this->db->_reset_select();
		*/
		$q=$this->db->query("SELECT vcards.cardid, vcards.title, vcards.latitude, vcards.longitude, vcards.cardmarker, vcards.cardimage, vcards.locationname, vcards.city, 
							vcards.country, vcards.categoryid, vcards.categoryname, vcards.username 
							FROM vcards
							JOIN (
						    SELECT tblfriends.frienduserid AS friend_id 
						    FROM tblfriends
						    WHERE tblfriends.userid = '$userid'
						    UNION
						    SELECT tblfriends.userid AS friend_id 
						    FROM tblfriends
						    WHERE tblfriends.frienduserid = '$userid'
							) AS T1 ON vcards.userid = T1.friend_id
							WHERE vcards.public='1' AND vcards.latitude>'$swLat' AND vcards.latitude<'$neLat' AND vcards.longitude>'$swLng' AND vcards.longitude<'$neLng'
							ORDER BY vcards.cardid DESC");
		return $q->result();
		/*
		$this->db->select('cardid, title, latitude, longitude, cardmarker, cardimage, locationname, city, country, categoryid, categoryname, username');
		$this->db->where('userid =', $userid);
		$this->db->where('latitude >', $swLat);
		$this->db->where('latitude <', $neLat);
		$this->db->where('longitude >', $swLng);
		$this->db->where('longitude <', $neLng);
		$q = $this->db->get('vcards');//,10,0
		*/
	}
	//getMyFriendInViewPort
	function getMyFriendCardInViewPort_TEMP($swLat, $swLng, $neLat, $neLng){
		$userid = $this->user_mdl->getCurrentUserID();
		//$this->db->select('location_id, location_name, latitude, longitude,');
		$this->db->select('cardid, title, latitude, longitude, cardmarker, cardimage, locationname, city, country, categoryid, categoryname, username');
	
		$this->db->where('userid =', $userid);
		$this->db->where('latitude >', $swLat);
		$this->db->where('latitude <', $neLat);
		$this->db->where('longitude >', $swLng);
		$this->db->where('longitude <', $neLng);
		$q = $this->db->get('vcards');//,10,0
		return $q->result();
	}
	//getWantVisitInViewPort
	function getWantVisitCardInViewPort($swLat, $swLng, $neLat, $neLng){
		$userid = $this->user_mdl->getCurrentUserID();
		//$this->db->select('location_id, location_name, latitude, longitude,');
		$this->db->select('cardid, title, latitude, longitude, cardmarker, cardimage, locationname, city, country, categoryid, categoryname, username');

		$this->db->where('userid =', $userid);
		$this->db->where('want =', 1);
		$this->db->where('latitude >', $swLat);
		$this->db->where('latitude <', $neLat);
		$this->db->where('longitude >', $swLng);
		$this->db->where('longitude <', $neLng);
		$q = $this->db->get('vreviews');//,10,0
		return $q->result();
	}
	//getBeenHereInViewPort
	function getBeenHereCardInViewPort($swLat, $swLng, $neLat, $neLng){
		$userid = $this->user_mdl->getCurrentUserID();
		//$this->db->select('location_id, location_name, latitude, longitude,');
		$this->db->select('cardid, title, latitude, longitude, cardmarker, cardimage, locationname, city, country, categoryid, categoryname, username');
		
		$this->db->where('userid =', $userid);
		$this->db->where('beenhere =', 1);
		$this->db->where('latitude >', $swLat);
		$this->db->where('latitude <', $neLat);
		$this->db->where('longitude >', $swLng);
		$this->db->where('longitude <', $neLng);
		$q = $this->db->get('vreviews');//,10,0
		return $q->result();
	}
/*endRUN*/
}