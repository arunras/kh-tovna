<?php
class Setting_mdl extends CI_Model {
	function updateSetting($tableName, $data = array(), $conditionField, $conditionValue) {
		$this->db->where($conditionField, $conditionValue);
		$this->db->update($tableName, $data);
	}
	function checkPassword($password) {
		$user_id = $this->user_mdl->getCurrentUserID();
		$password2 = $this->user_mdl->getDBValue('tblusers', 'password', 'userid', $user_id);
		if($password == $password2){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function mailChangePasswd($email) {
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply', 'MColle');
		$this->email->to($email);
		$this->email->subject('Had Changed Password');
		$this->email->message('
Hello,

You have successfully changed your password.
From now, please use your new password to login

Thanks,
MColle
');
		$this->email->send();
	}
	function mailChangeEmail($email, $new_email) {
		$this->load->library('email');
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply', 'MColle');
		$listemail = array($email, $new_email);
		$this->email->to($listemail);
		$this->email->subject('You change email from mcolle');
		$this->email->message('
Hello,

You have successfully changed your email
From: '. $email . '		
To	: '. $new_email .'
From now, please use your new email to login

Thanks,
MColle

		');
		$this->email->send();
	}
}