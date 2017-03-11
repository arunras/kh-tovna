<?php
class Card extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("card_mdl");
		$this->load->model("user_mdl");
	}
	
	function index(){
		
	}
	function create(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			if($this->user_mdl->isLogin()==false) echo 'false';
			else{
				$this->load->view('card_create_view');
			}
		}
		else{
			echo "Unproperly access";
		}
	}
	
	function saveCard() {
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('title','Card Title','trim|required');
		$this->form_validation->set_rules('place-name','Location name','trim|required');
		$this->form_validation->set_rules('date','Date','trim|required');
		
		if($this->form_validation->run() == TRUE){
			$date = $this->input->post('date');
			
			$tem = explode("/", $date);
			$date=$tem[2] . "-" . $tem[1] . "-" . $tem[0];
			
			
			
			$title= $this->input->post('title');
			
			$eat = $this->input->post('eat');
			$event = $this->input->post('event');
			$stay = $this->input->post('stay');
			$beauty = $this->input->post('beauty');
			$travel = $this->input->post('travel');
			$purchase = $this->input->post('purchase');
			$etc = $this->input->post('etc');
			
			$selectedCategory = 'etc';
			if($eat=="ON") $selectedCategory = 'eat';
			if($event=="ON") $selectedCategory = 'event';
			if($stay=="ON") $selectedCategory = 'stay';
			if($beauty=="ON") $selectedCategory = 'beauty';
			if($travel=="ON") $selectedCategory = 'travel';
			if($purchase=="ON") $selectedCategory = 'purchase';
			
			$description = $this->input->post('description');
			$lat = $this->input->post('latitude');
			$lng = $this->input->post('longitude');
			$city = $this->input->post('city');
			$country = $this->input->post('country');
			$place = $this->input->post('place-name');
			$public = $this->input->post('private');
			if($public=="") $public = 1;
			else $public = 0;
			$currenturl = $this->input->post('currenturl');
			
			//Prepare for uploading images
			$numFiles = $this->input->post('numFiles');
			
			$config['upload_path']   = $this->config->item('server_root').'/data/card/'; 
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = 1024 * 8;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload',$config);
			
			$fullpath_image_relative = array();
			$filepath_image = array();
			$filename = array();
			
			for($i=0 ; $i<$numFiles ; $i++){
	
				$upload = $this->upload->do_upload('upload'.$i);
				echo $this->upload->display_errors();
				if($upload == false) {continue;}
				else{
					$data = $this->upload->data();
					//$filenames[] =str_replace($this->config->item('server_root'), base_url(), $data['full_path']);
					$fullpath_image_relative[] = $data['full_path'];
					$fullpath_image[] = str_replace($this->config->item('server_root'), base_url(), $data['full_path']);
					$tem = explode('/', $data['full_path']);
					$filename[] = $tem[count($tem)-1];
				}
			}

			//Create marker
			$icon_marker = $this->card_mdl->createMapIcon($fullpath_image_relative[0],$selectedCategory);
			$icon_marker = str_replace($this->config->item('map_icon'), base_url().'data/map/', $icon_marker);
			
			$cardimage = $this->card_mdl->resizeImage($fullpath_image_relative[0]);
			$cardimage = str_replace($this->config->item('card_image_thum'), base_url().'data/card/thum/', $cardimage);
			
			$cardid = $this->card_mdl->addCard($date, $title, $selectedCategory, $description,$lat,$lng,$place,$public,$cardimage,$icon_marker,$city,$country);
			$this->card_mdl->addCardPicture($fullpath_image,$cardid);
			
			redirect($currenturl);
			//echo $cardid;
			
			//print_r($fullpath_image_relative);
			
			
			
			
			
			
			
			/*
			cardid	int	11	0	0	-1	0	0	0		0					-1	0
			title	text	0	0	-1	0	0	0	0		0	Title of card	utf8	utf8_general_ci		0	0
			description	text	0	0	-1	0	0	0	0		0	The descrition of card. What this card is about	utf8	utf8_general_ci		0	0
			categoryid	int	11	0	-1	0	0	0	0		0	This card belong to what category				0	0
			public	tinyint	4	0	-1	0	0	0	0		0	0 is private and 1 is public				0	0
			carddate	date	0	0	-1	0	0	0	0		0	Date YYYY-MM-DD				0	0
			locationname	text	0	0	-1	0	0	0	0		0	name of location	utf8	utf8_general_ci		0	0
			latitude	double	0	0	-1	0	0	0	0		0					0	0
			longitude	double	0	0	-1	0	0	0	0		0					0	0
			cardimage	text	0	0	-1	0	0	0	0		0		utf8	utf8_general_ci		0	0
			cardmarker	text	0	0	-1	0	0	0	0		0		utf8	utf8_general_ci		0	0
			userid	int	11	0	-1	0	0	0	0		0	This card belong to who				0	0
			*/
				
			
		}
		else {
			
		}
		
		
	}
	function testCreateThumnailCardPicture(){
		$filename = realpath('./data/profiles/thum/65d22a8b07f30efde9e7ebf3b95a6ae5.jpg');
		$this->card_mdl->createMapIcon($filename,'purchase');
	}
/*RUN*/
	function getCardJsonData(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			/*
			$centerLat = $this->input->get('centerLat');
			$centerLng = $this->input->get('centerLng');
			*/
			$card_type = $this->input->get('cardtype');
			$swLat = $this->input->get('swLat');
			$swLng = $this->input->get('swLng');
			$neLat = $this->input->get('neLat');
			$neLng = $this->input->get('neLng');
		
			//$cards = $this->card_mdl->getCard($centerLat, $centerLng);// 11.52643,104.921215
			$cards = $this->card_mdl->getCardInViewPort($card_type, $swLat, $swLng, $neLat, $neLng);// 11.52643,104.921215
			$json = '{"cards":'.json_encode($cards).'}';
			echo $json;
		//}
		//else{
			//echo "Unproperly access";
		//}
	}
	function getMyCardJsonData(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$swLat = $this->input->get('swLat');
		$swLng = $this->input->get('swLng');
		$neLat = $this->input->get('neLat');
		$neLng = $this->input->get('neLng');
		$cards = $this->card_mdl->getMyCardInViewPort($swLat, $swLng, $neLat, $neLng);// 11.52643,104.921215
		$json = '{"cards":'.json_encode($cards).'}';
		echo $json;
		//}
		//else{
		//echo "Unproperly access";
		//}
	}
	//getMyFriendJsonData
	function getMyFriendCardJsonData(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$swLat = $this->input->get('swLat');
		$swLng = $this->input->get('swLng');
		$neLat = $this->input->get('neLat');
		$neLng = $this->input->get('neLng');
		$cards = $this->card_mdl->getMyFriendCardInViewPort($swLat, $swLng, $neLat, $neLng);// 11.52643,104.921215
		$json = '{"cards":'.json_encode($cards).'}';
		echo $json;
		//}
		//else{
		//echo "Unproperly access";
		//}
	}
	//getMyFriendJsonData
	function getMyFriendCardJsonData_TEMP(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$swLat = $this->input->get('swLat');
		$swLng = $this->input->get('swLng');
		$neLat = $this->input->get('neLat');
		$neLng = $this->input->get('neLng');
		$cards = $this->card_mdl->getMyFriendCardInViewPort($swLat, $swLng, $neLat, $neLng);// 11.52643,104.921215
		$json = '{"cards":'.json_encode($cards).'}';
		echo $json;
		//}
		//else{
		//echo "Unproperly access";
		//}
	}
	//getWantVisitJsonData
	function getWantVisitCardJsonData(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$swLat = $this->input->get('swLat');
		$swLng = $this->input->get('swLng');
		$neLat = $this->input->get('neLat');
		$neLng = $this->input->get('neLng');
		$cards = $this->card_mdl->getWantVisitCardInViewPort($swLat, $swLng, $neLat, $neLng);// 11.52643,104.921215
		$json = '{"cards":'.json_encode($cards).'}';
		echo $json;
		//}
		//else{
		//echo "Unproperly access";
		//}
	}
	//getBeenHereJsonData
	function getBeenHereCardJsonData(){
		//if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$swLat = $this->input->get('swLat');
		$swLng = $this->input->get('swLng');
		$neLat = $this->input->get('neLat');
		$neLng = $this->input->get('neLng');
		$cards = $this->card_mdl->getBeenHereCardInViewPort($swLat, $swLng, $neLat, $neLng);// 11.52643,104.921215
		$json = '{"cards":'.json_encode($cards).'}';
		echo $json;
		//}
		//else{
		//echo "Unproperly access";
		//}
	}
/*endRUN*/
}
