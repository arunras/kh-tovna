<?php
class Browse extends CI_Controller{
    public function index(){
        $data['css'] = array('menu.css','map.css');
		$data['js'] = array();
        
        $this->load->model('browse_mdl');
        $this->session->set_userdata("viewtype","thum");
        //$data['card_info'] = $card_info;
        $data['title'] = "Memory BoX";
        $data['mainContent'] = "browse_view";
        $this->load->view('includes/content.php', $data);
    }
    
    public function cardsbycategory(){
        $this->load->model('browse_mdl');

        $categoryid = $this->input->post('categoryid');
        
        $cards = $this->browse_mdl->cards_by_category($categoryid);
        $card_info = $this->browse_mdl->arrray_cards($cards);
        $total_rows = $this->browse_mdl->cards_total($categoryid);

        $data['card_info'] = $card_info;
        $data['total_page'] = ceil($total_rows/6);
            
        $this->load->view('ajax_browse_view',$data);
    }
    public function morecards(){
        $this->load->model('browse_mdl');
        
        $categoryid = $this->input->post('categoryid');
        $page = $this->input->post('page');
        $total_page = $this->input->post('total_page');
        
        $cards = $this->browse_mdl->load_more($categoryid,$page);
        
        $card_info = $this->browse_mdl->arrray_cards($cards);
        
        $data['card_info'] = $card_info; 
        
        $this->load->view('browse_load_more_cards_view',$data);
    }
    public function popcarddetail(){
        
        $this->load->model('browse_mdl');

        $cardid = $this->input->post('cardid');
        $urlcard = $this->input->post('urlcard');
//        $cardid = 1;
//        $urlcard = "http://mcolle.localhost/browse/popcarddetail/1" ;
        
        $card = $this->browse_mdl->card_detail($cardid);
        $card_info = $this->browse_mdl->detail_array($card,$urlcard);
        
        if($card_info['carddate'] != null) {
            list($y, $m, $d) = explode("-", $card_info['carddate']);
            $card_info['carddate']= date("d M Y", mktime(0, 0, 0, $m, $d, $y));
        }
        $data['c'] = $card_info;
        $data['cur_user'] = $this->user_mdl->getCurrentUserID();
        $this->load->view('ajax_browse_detail_view', $data);
    }
    public function reviews(){
       $this->load->model('browse_mdl');
       
       $cardid = $this->input->post('cardid');
       $re_value = $this->input->post('re_value');
       $fieldname = $this->input->post('fieldname');
       $reviews = array('cardid'=> $cardid,
                        're_value'=> $re_value,
                        'fieldname'=> $fieldname
                  );
       $this->browse_mdl->reviews_card($reviews);
    }
    public function updateTitle(){
        $this->load->model('browse_mdl');
        
        $cardid = $this->input->post('cardid');
        $title = $this->input->post('title');
        $locationname = $this->input->post('locationname');
        
        $update_c = array('cardid'=> $cardid,
                          'title'=> $title,
                          'locationname'=> $locationname
                  );
        $this-> browse_mdl->update_title($update_c);
    }
    function addPhotos(){
        $this->load->library('qqFileUploader');
        $cardid = $_GET['c'];
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array("jpg","png","gif");
        // max file size in bytes
        $sizeLimit = 10 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        
        $result = $uploader->handleUpload($this->config->item('server_root').'/data/card/');
        
//        $result = $uploader->handleUpload('http://mcolle.localhost/data/card/');
        $this->load->model('browse_mdl');
        $this->browse_mdl->savePhotos($result,$cardid);
    }
    
    //RUN===
    function UpdateCardLocation(){
    	$this->load->model('browse_mdl');
    	$cardid = $this->input->get('cardid');
    	$latitude = $this->input->get('latitude');
    	$longitude = $this->input->get('longitude');
    	$city = $this->input->get('city');
    	$country = $this->input->get('country');
    	 
    	$result = $this->browse_mdl->updateCardLocation($cardid, $latitude, $longitude, $city, $country);
    	//echo $result;
    }
    //endRUN
    
    function deletephoto(){
        $this->load->model('browse_mdl');
        
        $picid = $this->input->post('picid');
        $this->browse_mdl->delete_photo($picid);
    }
        
}