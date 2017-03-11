<?php
class User_mdl extends CI_Model{
	
	
	function isLogin(){
		$login = false;
		if($this->session->userdata("loginname")){
			//check database if this username exites. prevent from user can change session value
			$logedname = $this->session->userdata("loginname");
			$this->db->where("username",$logedname);
			$q = $this->db->select("username")->get("tblusers");
			
			if($q->num_rows()==1){
				$login = true;
			}
			else{
				$login = false;
			}
			
		}
		return $login;
	}

	function getCurrentUserID(){
		if($this->isLogin()){
			$username = $this->session->userdata('loginname');
			$this->db->where('username',$username);
			$q = $this->db->get('tblusers');
			$result = $q->result();
			return $result[0]->userid;
		}
		else{
			return "";
		}
	}
	function getCurrentUserName(){
		if($this->isLogin()){
			$username = $this->session->userdata('loginname');
			$this->db->where('username',$username);
			$q = $this->db->get('tblusers');
			$result = $q->result();
			return $result[0]->username;
		}
		else{
			return "";
		}
	}
	function getCurrentUserEmail(){
		if($this->isLogin()){
			$username = $this->session->userdata('loginname');
			$this->db->where('username',$username);
			$q = $this->db->get('tblusers');
			$result = $q->result();
			return $result[0]->email;
		}
		else{
			return "";
		}
	}
	function getDBValue($tableName, $fieldName, $conditionField, $conditionValue){
		$this->db->select($fieldName);
		$this->db->where($conditionField, $conditionValue);
		$q = $this->db->get($tableName);
		if($q->num_rows()==1){
			$row = $q->result();
			return $row[0]->$fieldName;
		}
		else return "";
	}
	function userAuthentication($email, $password){
		$hash = md5($password);
		$authenticated = false;
		//Check if there is username and hash of password match in the table.
		//if so return TRUE and else return FALSE
		//if TRUE, also set session loginname = USERNAME
		$this->db->where("email",$email);
		$this->db->where("password",$hash);
		$q = $this->db->get("tblusers");
		if($q->num_rows()==1){
			$username = $this->getDBValue('tblusers','username','email',$email);
			$this->session->set_userdata("loginname",$username);
			$datestr = "%Y-%m-%d %H:%i:%s";
			$data = array(
				'lastlogin' => mdate($datestr,time())
			);
			$this->db->where("username",$username);
			$this->db->update('tblusers',$data);
			$authenticated = true;
		}
		else{
			$authenticated = false;
		}
		return $authenticated;
	}
	function checkUserDuplicate($username){
		$duplicated = false;
		$this->db->where("username",$username);
		$q = $this->db->get("tblusers");
		if($q->num_rows()>=1){
			$duplicated = true;
		}
		else{
			$duplicated = false;
		}
		return $duplicated;
	}
	
	function checkEmailDuplicate($email){
		$duplicated = false;
		$this->db->where("email",$email);
		$q = $this->db->get("tblusers");
		if($q->num_rows()>=1){
			$duplicated = true;
		}
		else{
			$duplicated = false;
		}
		return $duplicated;
	}
	function addUser($username,$lastname,$firstname,$password,$email){
		$datestr = "%Y-%m-%d";
		$date = mdate($datestr, time());
		$data=array(
			'username' => $username,
			'lastname' => $lastname,
			'firstname' => $firstname,
			'password' => md5($password),
			'email' => $email,
			'joineddated' => $date,
			'picture' => base_url()."data/profiles/default.png",
			'thum' => base_url()."data/profiles/thum/default.png"
		);
		$this->db->insert('tblusers',$data);
		$this->sendWelcome($email);
		return $this->db->insert_id();
	}
	function addUserByFacebook($username,$lastname,$firstname,$password,$email,$facebookid){
		$datestr = "%Y-%m-%d";
		$date = mdate($datestr, time());
		$data=array(
				'username' => $username,
				'lastname' => $lastname,
				'firstname' => $firstname,
				'password' => md5($password),
				'email' => $email,
				'joineddated' => $date,
				'picture' => base_url()."data/profiles/default.png",
				'thum' => base_url()."data/profiles/thum/default.png",
				'facebookid' => $facebookid
		);
		$this->db->insert('tblusers',$data);
		$this->sendWelcome($email);
		return $this->db->insert_id();
	}
	function sendWelcome($email){
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply', 'MColle');
		$this->email->to($email);
		$this->email->subject('Welcome to MColle');
		$this->email->message(
'Hello, 

You have registered with MColle. You can create card, upload your pictures that you have been somewhere.
Share with your friend.

Enjoy,
MColle
'
		);
		if($this->email->send()){
			return true;
		}
		else{
			return false;
		}
	}
	function sendPassword($email){
		$username = $this->getDBValue('tblusers', 'username', 'email', $email);
		$password = $this->passwordGenerator(5);
		$data = array(
			'password' => md5($password)
		);
		
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply', 'MColle');
		$this->email->to($email);
		
		
		$this->email->subject('New Password from MColle');
		$this->email->message('
Hello,

You have been reset your account at MColle.
Here is your new password: '.$password.'
Please use this email and new password to login again.

Thanks,
MColle
		');
		
		$this->db->where('username',$username);
		$this->db->update('tblusers',$data);
		if($this->email->send())
		{
			return true;
		}
		else
		{
			//show_error($this->email->print_debugger());
			return false;
		}
		
		
		
	}
	function passwordGenerator($length){
		list($usec,$sec) = explode(' ', microtime());
		$seed = (float) $sec + ((float)$usec*100000);
		srand($seed);
		$alpha = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		$token = "";
		for($i = 0; $i < $length; $i ++) {
			$token .= $alpha[rand(0, strlen($alpha))];
		}
		return $token;
	}
}
