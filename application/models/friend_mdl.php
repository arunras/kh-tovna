<?php
class Friend_mdl extends CI_Model{
	function getNumFriend($userid){
		$this->db->where('userid',$userid);
		$q = $this->db->get('tblfriends',$userid);
		$num = $q->num_rows();
		$this->db->where('frienduserid',$userid);
		$q = $this->db->get('tblfriends',$userid);
		$num = $num + $q->num_rows();
		return $num;
	}
	function getAllFriend($userid) {
		$this->db->where('userid', $userid);
		$q = $this->db->get('tblfriends');
		$friend_lists = array();
		foreach($q->result() as $row ) {
			$friend_lists[] = $row->frienduserid;
		}
		$this->db->where('frienduserid',$userid);
		$q = $this->db->get('tblfriends');
		foreach($q->result() as $row ) {
			$friend_lists[] = $row->userid;
		}
		return $friend_lists;
	}
	function getLimitFriend($userid) {
		$this->db->limit(0,3);
		$this->db->where('userid', $userid);
		$q = $this->db->get_where('tblfriends');
		$friend_lists = array();
		foreach($q->result() as $row ) {
			$friend_lists[] = $row->frienduserid;
		}
		$this->db->where('frienduserid',$userid);
		$q = $this->db->get('tblfriends');
		foreach($q->result() as $row ) {
			$friend_lists[] = $row->userid;
		}
		return $friend_lists;
	}
	function getFriendsLimit($userid, $page=1, $num_per_page=4) {
		$start = 0;
		if($page != ""){
			$start = ($page-1) * $num_per_page;
		}
		$q = $this->db->query("select * from tblfriends where userid=$userid union select * from tblfriends where frienduserid=$userid limit ".$start." , ".$num_per_page);
	
		$friend_lists = array();
		foreach($q->result() as $row ) {
			if($userid == $row->frienduserid) {
				$friend_lists[] = $row->userid;
			}
			if($userid == $row->userid) {
				$friend_lists[] = $row->frienduserid;
			}		
		}
		return $friend_lists;
	}
	function getUserInfo($userid) {
		$this->db->where('userid', $userid);
		$q = $this->db->get('tblusers', $userid);
		$row = $q->result();
		$row = $row[0];

		return $row;
	}
	function isFriend($userid1,$userid2){
		$q = $this->db->where('userid',$userid1)->where('frienduserid',$userid2)->get('tblfriends');
		$num = $q->num_rows();
		$q = $this->db->where('userid',$userid2)->where('frienduserid',$userid1)->get('tblfriends');
		$num = $num + $q->num_rows();
		if($num==1){
			return true;
		}
		else{
			return false;
		}
	}
	function isConfirmFriend($adder){
		$receiver = $this->user_mdl->getCurrentUserID();
		$q = $this->db->where('userid1',$adder)->where('userid2',$receiver)->get('tblnotifications');
		if($q->num_rows()==1) return true;
		else return false;
	}
	function isSendRequest($reciever){
		$adder = $this->user_mdl->getCurrentUserID();
		$q = $this->db->where('userid1',$adder)->where('userid2',$reciever)->get('tblnotifications');
		if($q->num_rows()==1) return true;
		else return false;
	}
	function addFriend($currentID,$friendID,$sendrequest){
		$this->load->helper('date');
		$datestr = "%Y-%m-%d %h:%i:%s";
	
		$datefriend = mdate($datestr, time());
	
		$data = array(
				'userid' => $friendID,
				'frienduserid' => $currentID,
				'sendrequest' => $sendrequest,
				'datefriend' => $datefriend,
				'acceptrequest' => $datefriend
		);
		$this->db->insert('tblfriends',$data);
	}
	function unfriend($friendid) {
		
		//1-userid and friendid
		$currentUserID = $this->user_mdl->getCurrentUserID();
		$q = $this->db->where('userid',$currentUserID)->where('frienduserid',$friendid)->get('tblfriends');
		if($q->num_rows()==1){
			$this->db->where('userid',$currentUserID)->where('frienduserid',$friendid)->delete('tblfriends');
			return ;
		}
		//2-friendid and userid
		$q = $this->db->where('userid',$friendid)->where('frienduserid',$currentUserID)->get('tblfriends');
		if($q->num_rows()==1){
			$this->db->where('userid',$friendid)->where('frienduserid',$currentUserID)->delete('tblfriends');
			return ;
		}
		/*
		$this->load->model('user_mdl');
		$currentUserId = $this->user_mdl->getCurrentUserID();
		$this->db->select('userid, frienduserid');
		$q = $this->db->get('tblfriends');
		foreach($q->result() as $row) {
			if($friendid == $row->userid && $currentUserId == $row->frienduserid) {
				$this->db->where('userid', $friendid);
				$this->db->delete('tblfriends');
			}
			if($friendid == $row->frienduserid && $currentUserId == $row->userid ) {
				$this->db->where('frienduserid', $friendid);
				$this->db->delete('tblfriends');
			}
			
		}
		*/
	}
}