<?php
class Test_login_fb extends CI_Controller{
	function __construct(){
		parent::__construct();
		//parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		$config = $this->config->load('facebook',true);
		$this->load->library('facebook',$config);
	}
	function index(){
		
		$userid = $this->facebook->getUser();
		
		if($userid==0){
			$url = $this->facebook->getLoginUrl(array('scope'=>'email,publish_stream'));
			echo "<a href='$url'>Login with FB</a>";
		}
		else{
			$user = $this->facebook->api('/me');
			echo "<pre>";
			print_r($user);
			echo "</pre>";
			echo $user['id'];exit();
			$friends = $this->facebook->getFriends($user->id);
			echo "<pre>";
			print_r();
			echo "</pre>";
		}
	}
	function getFriend(){
		$userid = $this->facebook->getUser();
		
		if($userid==0){
			$url = $this->facebook->getLoginUrl(array('scope'=>'email, publish_stream'));
			echo "<a href='$url'>Login with FB</a>";
		}
		else{
			$friends = $this->facebook->api('/me/friends');
			$friends = $friends['data'];
			$allFriends = array();
			foreach($friends as $friend){
				//list('id','friendname','picture') = array();
				$aFriend = array();
				$aFriend['name'] = mb_convert_encoding($friend['name'],'UTF-8');
				$aFriend['id'] = $friend['id'];
				$aFriend['picture'] = "https://graph.facebook.com/".$friend['id']."/picture";
				$allFriends[] = $aFriend;
				//echo "<img src='https://graph.facebook.com/".$friend['id']."/picture' />";
			}
			sort($allFriends);
			$data['friends'] = $allFriends;
			$this->load->view('test_view',$data);
		}

	}
	function postFB(){
		$userid = $this->facebook->getUser();
		if($userid==0){
			$url = $this->facebook->getLoginUrl(array('scope'=>'email, publish_stream'));
			echo "<a href='$url'>Login with FB</a>";
		}
		else{
			try{
				$friends = $this->facebook->api('/1785637036/feed', 'POST', array('message' => 'Tested from MColle'));
				var_dump($friends);
			}catch (Exception $e){
				echo $e->getMessage();
			}
		}
	}
	function sendMessage(){
		$userid = $this->facebook->getUser();
		
		if($userid==0){
			$url = $this->facebook->getLoginUrl(array('scope'=>'email, publish_stream'));
			echo "<a href='$url'>Login with FB</a>";
		}
		else{
		try{
			$friends = $this->facebook->api('/100000276013292/feed', 'POST', array('message' => 'Tested from MColle'));
						var_dump($friends);
			}catch (Exception $e){
			echo $e->getMessage();
			}
			}
	}
}