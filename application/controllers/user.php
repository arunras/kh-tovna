<?php
class User extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("user_mdl");
	}
	public function index(){
		if($this->user_mdl->isLogin()) redirect(site_url(base_url()));
		else redirect(site_url('user/login'));
	}
	function login($logfirst = 0){
		
		//Login using facebook
		$config = $this->config->load('facebook',true);
		$this->load->library('facebook',$config);
		$userfb = $this->facebook->getUser();
		$data['urlFacebookLogin'] = ""; 
		if($userfb == 0 ){
			$url = $this->facebook->getLoginUrl(array('scope'=>'email'));
			$data['urlFacebookLogin'] = $url;
		}
		else{
			$userfb = $this->facebook->api('/me');
			if($this->user_mdl->getDBValue('tblusers','username','facebookid',$userfb['id'])!=""){ //already authrized App in Facebook
				$username = $this->user_mdl->getDBValue('tblusers','username','email',$userfb['email']);
				$this->session->set_userdata("loginname",$username);
				$datestr = "%Y-%m-%d %H:%i:%s";
				$data = array(
					'lastlogin' => mdate($datestr,time())
				);
				$this->db->where("username",$username);
				$this->db->update('tblusers',$data);
				redirect(base_url());
			}
			else if($this->user_mdl->checkEmailDuplicate($userfb['email'])==true){
				//if login in FB have the same email in db. ie: that email is already registered in db and she/he want to login by FB
				//Just update Facebook ID in db only
				$this->db->where('email',$userfb['email']);
				$this->db->update('tblusers',array('facebookid'=>$userfb['id']));

				$username = $this->user_mdl->getDBValue('tblusers','username','email',$userfb['email']);
				$this->session->set_userdata("loginname",$username);
				$datestr = "%Y-%m-%d %H:%i:%s";
				$data = array(
								'lastlogin' => mdate($datestr,time())
				);
				$this->db->where("username",$username);
				$this->db->update('tblusers',$data);
				redirect(base_url());
			}
			else if($this->user_mdl->checkUserDuplicate($userfb['username'])==1){ //username is the same
				//echo 'The same username';
				//exit();
				$lastname = $userfb['last_name'];
				$firstname = $userfb['first_name'];
				$username = $userfb['username'];
				$email = $userfb['email'];
				
				$data = array(
					'lastname' => $lastname,
					'firstname' => $firstname,
					'username' => $username,
					'email' => $email
				);
				$this->db->insert('tblusertemps',$data);
				$id = $this->db->insert_id();
				//$this->register1($lastname,$firstname,$username,$email);
				redirect(site_url('user/register/'.$id));
			}
			else{ //new user
				$username = $userfb['username'];
				$lastname = $userfb['last_name'];
				$firstname = $userfb['first_name'];
				$password = '12345';
				$email = $userfb['email'];
				$facebookid = $userfb['id'];
				$this->user_mdl->addUserByFacebook($username,$lastname,$firstname,$password,$email,$facebookid);
				
				$this->session->set_userdata("loginname",$username);
				$datestr = "%Y-%m-%d %H:%i:%s";
				$data = array(
						'lastlogin' => mdate($datestr,time())
				);
				$this->db->where("username",$username);
				$this->db->update('tblusers',$data);
				redirect(base_url());
			}
		}
		
		//$this->session->set_userdata('loginname','lim');
		
		//$logfirst = 0 means No Error
		//$logfirst = 1 show message "Please login first"
		//$logfirst = 2 login failed
		if($this->user_mdl->isLogin()==TRUE){
			redirect(site_url());
		}
		if($logfirst==1){
			
		}
		$data['css'] = array('register.css');
		$data['js'] = array();
		$data['title'] = "Please login to your account";
		$data['mainContent'] = "user_view";
		$this->load->view('includes/content.php', $data);
	}
	function register($temtableID=""){ //$temtableID is refering to tbluserstemps which store user info temporary. will be deleted after insert success
		if($this->user_mdl->isLogin()==TRUE){
			redirect(site_url());
		}
		$data['css'] = array('register.css');
		$data['js'] = array();
		
		$data['lastname'] = "";
		$data['firstname'] = "";
		$data['username'] = "";
		$data['email'] = "";
		
		if($temtableID !=""){
			$q = $this->db->where('userid',$temtableID)->get('tblusertemps');
			if($q->num_rows()==1){
				$row = $q->result();
				$row = $row[0];
				$data['lastname'] = $row->lastname;
				$data['firstname'] = $row->firstname;
				$data['username'] = $row->username;
				$data['email'] = $row->email;
				$this->db->where('userid',$temtableID)->delete('tblusertemps');
			}
		}
		
		$this->load->library("form_validation");
		$this->load->config('recaptcha');	
		$this->form_validation->set_rules("first-name", "First name", "trim|required");
		$this->form_validation->set_rules("last-name", "Last name", "trim|required");
		$this->form_validation->set_rules("user-name", "User name", "trim|required|min_length[4]|alpha|callback_checkUser");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[4]");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email|callback_checkMail");
		$data['publickey'] = $this->config->item('recaptcha_public_key');
		
		if($this->form_validation->run()==true){
			$username = $this->input->post("user-name");
			$lastname = $this->input->post("last-name");
			$firstname = $this->input->post("first-name");
			$password = $this->input->post("password");
			$email = $this->input->post("email");
			$this->user_mdl->addUser($username, $lastname, $firstname, $password, $email);
			redirect(site_url("user/login"));
		}
		else{
			$data['title'] = "Welcome to MemoryBoX";
			$data['mainContent'] = "user_view";
			$this->load->view('includes/content.php', $data);
		}
	}
	function authentication(){
		$password = $this->input->post("password");
		$username = $this->input->post("email");
		$remember = $this->input->post('register');
		if($this->user_mdl->userAuthentication($username, $password)){
			if($remember == 'on'){
				$this->load->library('encrypt');
				$this->input->set_cookie('n',$this->encrypt->encode($username));
				$this->input->set_cookie('p',$this->encrypt->encode($password));
			}
			redirect(base_url());
		}
		else{
			redirect(site_url('user/login/failed'));
		}
	}
	function forget(){
		if($this->user_mdl->isLogin()==TRUE){
			redirect(site_url());
		}
		$data['css'] = array('register.css');
		$data['js'] = array();
		
		$data['title'] = "Forget Password";
		$data['mainContent'] = "user_view";
		$data['message']="<span></span>";
		
		$email = $this->input->post('email');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_checkEmailExistForgetPassword');
		if($this->form_validation->run()){
			$this->user_mdl->sendPassword($email);
			$data['message'] = '<span>Password have been sent to '.$email.'</span>';
		}
		$this->load->view('includes/content.php', $data);
	}
	function logout(){
		$this->session->unset_userdata('loginname');
		$this->load->helper('cookie');
		delete_cookie('n');
		delete_cookie('p');
		
		$config = $this->config->load('facebook',true);
		$this->load->library('facebook',$config);
		
		$userid = $this->facebook->getUser();
		if($userid!=0){
			$urlLogout = $this->facebook->getLogoutUrl(array('next'=>base_url()."?g=logout"));
			redirect($urlLogout);
		}
		else{
			redirect(base_url()."?g=logout");
		}
	}
	
	function checkEmailExistForgetPassword($email){
		$exists = $this->user_mdl->checkEmailDuplicate($email);
		if($exists==1){
			return true;
		}
		else{
			$this->form_validation->set_message("checkEmailExistForgetPassword","Email have not registered yet");
			return false;
		}
	}
	
	function checkUser($username) {
		$exists = $this->user_mdl->checkUserDuplicate($username);
		if($exists==1){
			$this->form_validation->set_message("checkUser","Username already exists");
			return false;
		}
		else{
			return true;
		}
	}
	function checkMail($email) {
		$exists = $this->user_mdl->checkEmailDuplicate($email);
		if($exists==1){
			$this->form_validation->set_message("checkMail", "Email already exists");
			return false;
		}
		else {
			return true;
		}
	}
	//RUN
	function getCurrentUser(){
		if($this->input->is_ajax_request()){
			if($this->user_mdl->isLogin()){
				echo $this->user_mdl->getCurrentUserID();
			}
			else{
				echo 0;
			}
		}
		else{
			redirect('404');
		}
	}
	//endRUN
	
}