<?php
class Friend extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('friend_mdl');
	}
	function index() {
		$data['title'] = 'Friend';
		$data['css'] = array('menu.css','friend.css'); 
		$data['js'] = array('friend.js');
		
		$this->load->model('friend_mdl');
		$this->load->model('card_mdl');
		
		$userid = $this->user_mdl->getCurrentUserID();
		$num_friend = $this->friend_mdl->getNumFriend($userid);
		
		$page = 1;
		$num_per_page =4;
		$total_page = ceil($num_friend/$num_per_page);
		$data['totalpage'] = $total_page;
		$friendIdArray =	$this->friend_mdl->getFriendsLimit($userid, $page, $num_per_page);
		
		$friendList = array();
		foreach($friendIdArray as $friendId) {
			$friendList[] = $this->friend_mdl->getUserInfo($friendId);	
		}
		
		$data['friendList'] = $friendList;
		$data['mainContent'] = "friend_view";
		$this->load->view('includes/content.php', $data);
	}
	function loadMore(){
		$this->load->model('friend_mdl');
		$this->load->model('card_mdl');
		
		$num_per_page = 4;
		$page = $this->input->post('page');
		$userid = $this->user_mdl->getCurrentUserID();
		$friendIdArray =	$this->friend_mdl->getFriendsLimit($userid, $page, $num_per_page);
		$friendList = array();
		foreach($friendIdArray as $friendId) {
			$friendList[] = $this->friend_mdl->getUserInfo($friendId);
		}
		
		$idItems = ($page-1)*$num_per_page;
		$data['iditems'] = $idItems;
		$data['friendList'] = $friendList;
		$this->load->view('friend_more_view',$data);
	}
	function addFriendRequest(){
		$receiver = $this->input->post('friendid');
		$adder = $this->user_mdl->getCurrentUserID();
		
		$this->load->helper('date');
		$datestr = "%Y-%m-%d %h:%i:%s";
		$daterequest = mdate($datestr, time());
		
		$data = array(
			'notificationtype' => 'friend_request',
			'userid1' => $adder,
			'userid2' => $receiver,
			'viewed' => '0',
			'datetime' => $daterequest
		);
		$this->db->insert('tblnotifications',$data);
	}
	function confirmRequest(){
		$adder =$this->input->post('friendid');
		$receiver = $this->user_mdl->getCurrentUserID();
		$q = $this->db->where('userid1',$adder)->where('userid2',$receiver)->get('tblnotifications');
		if($q->num_rows()==1){
			$row = $q->result();
			$row = $row[0];
			//echo $row->notificationid;
			$this->addFriend($row->notificationid);
		}
	}
	function cancelRequestFriend(){
		$receiver = $this->input->post('friendid');
		$adder = $this->user_mdl->getCurrentUserID();
		$this->db->where('userid1',$adder)->where('userid2',$receiver)->delete('tblnotifications');
	}
	function addFriend($notificationID){
		
		$this->db->where('notificationid',$notificationID);
		$notification = $this->db->get('tblnotifications');
		
		$notification = $notification->result();
		$notification = $notification[0];
		if($notification==""){
			redirect('404');
		}
		$currentID = $this->user_mdl->getCurrentUserID();
		$friendID = $notification->userid1;
		$sendrequest = $notification->datetime;
		
		$this->friend_mdl->addFriend($currentID,$friendID,$sendrequest);
		
		$this->db->where('notificationid',$notificationID);
		$this->db->delete('tblnotifications');	
		
		//add to notification
		$this->load->helper('date');
		$datestr = "%Y-%m-%d %h:%i:%s";
		$daterequest = mdate($datestr, time());
			
		$data = array(
								'notificationtype' => 'friend_confirmed',
								'userid1' => $friendID,
								'userid2' => $currentID,
								'viewed' => '0',
								'datetime' => $daterequest
		);
		$this->db->insert('tblnotifications',$data);
	}
	function unfriend() {
		$friendid = $this->input->post('friendid');
		$this->load->model('friend_mdl');
		$this->friend_mdl->unfriend($friendid);
	}
}