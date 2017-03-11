<?php
class Notification extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('notification_mdl');
	}
	function showFriendNotification(){
		$currentUserIDLogin = $this->user_mdl->getCurrentUserID();
		$data['friendNotifications'] = $this->notification_mdl->getFriendNotification($currentUserIDLogin);
		
		$this->load->view('pop_friendnotification',$data);
	}
	function showNotification(){
		$currentUserID = $this->user_mdl->getCurrentUserID();
		$data['notifications'] = $this->notification_mdl->getNotification($currentUserID);
		$this->load->view('pop_notification',$data);
	}
	function remove_notification(){
		$note_id = $this->input->post('ni');
		$this->db->where('notificationid',$note_id)->delete('tblnotifications');
	}
}