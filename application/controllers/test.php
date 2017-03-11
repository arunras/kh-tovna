<?php
class Test extends CI_Controller{
	function __construct(){
		parent::__construct();
		
	}
	function index(){
		echo $this->config->item('card_image');
		$this->load->view('test_view',array('error'=>''));
	}
	function saveImages(){
		$config['upload_path']   = $this->config->item('server_root').'/upload/'; //if the files does not exist it'll be created
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = 1024 * 8;
		$config['encrypt_name']  = TRUE;
		
		$this->load->library('upload',$config);
		
		
		for($i=1;$i<3;$i++){
			if(!$this->upload->do_upload('file'.$i)){
				$data['error'] = $this->upload->display_errors();
				$this->load->view('test_view',$data);
			}
			else{
				
			}
		}
	}
	function dateDemo(){
		$this->load->helper('date');
		$date = "12/2/2012";
		$tem = explode("/", $date);
		//print_r($tem);
		$date=$tem[2] . "-" . $tem[1] . "-" . $tem[0];
		echo $date;
	}
	function tetCreateMapIcon(){
		$this->load->model('card_mdl');
		$this->card_mdl->createMapIcon('D:/workspace/mcolle/data/card/6f64ef4412678abefdcb516836609869.jpg','eat');
	}
	
	function testResize($filename){
		$this->load->model('card_mdl');
		$this->card_mdl->resizeImage($filename);
	}
	function getCurrentUri(){
		//echo $this->uri->uri_string();
		echo base_url().$this->uri->uri_string()."?q=saved";
	}
	function isFriend($userid){
		$this->load->model('friend_mdl');
		$userid1 = $this->user_mdl->getCurrentUserID();
		echo "Result is ".$this->friend_mdl->isFriend($userid,$userid1);
	}
	function testB(){
		$this->db->or_where('(userd',2);
		$this->db->or_where('username','m');
		$this->db->bracket('close');
		$this->db->where('username','dd');
		$q = $this->db->get('tblusers');
		$row = $q->result();
		$row = $row[0];
		echo "<pre>";
		print_r($row);
		echo "</pre>";
	}
}