<?php
class Notification_mdl extends CI_Model{
	
	function getFriendNotification($currentLoginUserID){
		$this->db->where('notificationtype','friend_request');
		$this->db->where('viewed','0');
		$this->db->where('userid2',$currentLoginUserID);
		$q = $this->db->get('tblnotifications');
		return $q->result();
	}
	function getNumFriendNotification($currentLoginUserID){
		$this->db->where('notificationtype','friend_request');
		$this->db->where('viewed','0');
		$this->db->where('userid2',$currentLoginUserID);
		$q = $this->db->get('tblnotifications');
		return $q->num_rows();
	}
	function getNumNotification($currentLoginUserID){
		$this->db->where('notificationtype','friend_confirmed');
		$this->db->where('viewed','0');
		$this->db->where('userid1',$currentLoginUserID);
		$q = $this->db->get('tblnotifications');
		return $q->num_rows();
	}
	function getNotification($currentLoginUserID){
		$this->db->where('notificationtype','friend_confirmed');
		$this->db->where('viewed','0');
		$this->db->where('userid1',$currentLoginUserID);
		$q = $this->db->get('tblnotifications');
		return $q->result();
	}
}