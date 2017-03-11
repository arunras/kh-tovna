<?php
class Mypage extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('card_mdl');
		$this->load->model('user_mdl');
		$this->load->model('mypage_mdl');
		$this->load->model('friend_mdl');
		
	}
	function index(){
		if($this->user_mdl->isLogin()==true){
			$data['title'] = "My Page";
			$data['js'] = array('mypage.js','ajaxfileupload.js','jquery.Jcrop.min.js','invite.js');
			$data['css'] = array('mypage.css','skin.css', 'jquery.Jcrop.min.css','invite.css');
			
			$data['mainContent'] = "mypage_view";
			$userid = $this->user_mdl->getCurrentUserID();
			$data['userinfo'] = $this->mypage_mdl->getUserInformation($userid);
			$data['numCard'] = $this->card_mdl->getNumCard($userid);
			$this->load->view('includes/content.php', $data);
		}
		else{
			redirect(site_url('user/login/1'));
		}
	}
}