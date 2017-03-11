<?php
class Setting extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		$data['title'] = "Control your setting";
		$data['js'] = array('setting.js');
		$data['css'] = array('menu.css', 'setting.css');

		
		$data['mainContent'] = "setting_view";
		$this->load->view('includes/content.php', $data);
	}
	function general(){
		//$this->index();	
	}
	function profile(){
		$data['title'] = "Profile setting";
		$data['js'] = array('setting.js');
		$data['css'] = array('setting.css');
		$user_id = $this->user_mdl->getCurrentUserID();
		
		$this->db->where('userid',$user_id);
		$q = $this->db->get('tblusers');
		if($q->num_rows()<=0){
			redirect('404');
		}
		$row = $q->result();
		$row = $row[0];
		$data['userinfo'] = $row;
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('first-name','Firstname','trim|required');
		$this->form_validation->set_rules('last-name','Lastname','trim|required');
		$this->form_validation->set_rules('old-password','Current password','trim|callback_comparePassword');
		$this->form_validation->set_rules('new-password','New password', 'trim|min_length[4]');
		
		if($this->form_validation->run()){
			$user_id = $row->userid;
			$first_name = $this->input->post('first-name');
			$last_name = $this->input->post('last-name');
			$new_password = $this->input->post('new-password');
			$this->load->model('setting_mdl');
			if(!$new_password) {
				$value = array(
						'firstname' => $first_name,
						'lastname'	=> $last_name,
				);
				$this->setting_mdl->updateSetting('tblusers', $value, 'userid', $user_id);
				redirect(site_url('setting/profile'));
			}
			else {
				$email = $row->email;
				$value = array(
						'firstname' => $first_name,
						'lastname'	=> $last_name,
						'password'	=> md5($new_password),
				);
				$this->setting_mdl->updateSetting('tblusers', $value, 'userid', $user_id);
				$this->setting_mdl->mailChangePasswd($email);
				redirect(site_url('setting/profile?s=success'));
			}
		}
		else {
			
		}
		$data['mainContent'] = "setting_view";
		$this->load->view('includes/content.php', $data);
	}
	
	function email(){
		$data['title'] = "Email setting";
		$data['js'] = array('setting.js');
		$data['css'] = array('menu.css', 'setting.css');
		
		$this->load->model('setting_mdl');
		$user_id = $this->user_mdl->getCurrentUserID();
		$data['email'] = $this->user_mdl->getDBValue('tblusers', 'email' , 'userid', $user_id);
		$email = $data['email'];
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		
		if($this->form_validation->run()) {
			$new_email = $this->input->post('email');
			$val = array(
				'email' => $new_email,		
			);
			if($email != $new_email){
				$this->setting_mdl->updateSetting('tblusers', $val, 'userid', $user_id);
				$this->setting_mdl->mailChangeEmail($email, $new_email);
				redirect(site_url('setting/email?s=success'));
			}
		}
		else {
			
		}
		$data['mainContent'] = "setting_view";
		$this->load->view('includes/content.php', $data);
	}
	function comparePassword($password) {
		$this->load->model('setting_mdl');
		if($password){
			$exists = $this->setting_mdl->checkPassword(md5($password));
			if($exists){
				return TRUE;
			}
			else {
				$this->form_validation->set_message("comparePassword", "Your old password is not valid.");
				return FALSE;
			}
		}
	}
}