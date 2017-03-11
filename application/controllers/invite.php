<?php
class Invite extends CI_Controller{
	function __construct(){
		parent::__construct();
		$config = $this->config->load('facebook',true);
		$this->load->library('facebook',$config);
	}
	
	function test(){
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
	function getAllFriendFromFacebook(){
		// @todo - Add if it is request from ajax
		
		$status = "";
		$msg = "";
		
		$userid = $this->facebook->getUser();
		if($userid==0){
			$params = array(
			  'scope' => $this->config->item('facebook_scope'),
			  'redirect_uri' => site_url('mypage')
			);
			$url = $this->facebook->getLoginUrl($params);
			$status = "error_login";
			$msg = $url;
		}
		else{
			try{
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
				$status = "success";
				$msg = $this->load->view('invite_view',$data,true);
			}catch(FacebookApiException $e){
				$status = "error";
				$msg = $e->getMessage();
			}
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
	}
	function invite_friend(){
		// @todo - Add if it is request from ajax
		$status="";
		$msg = "";
		
		$facebookFrendId = $this->input->post('fid');
		$userid = $this->facebook->getUser();
		
		if($userid==0){
			$urlogin = $this->facebook->getLoginUrl($this->config->item('facebook_scope'));
			$status = "error_login";
			$msg = $urlogin;
		}
		else{
			$data = array(
				'link' => 'http://mcolle.phsaez.com',
				'message' => 'MColle is cool application! I can create card and upload pictures.'
			);
			try{
				$message = $this->facebook->api('/'.$facebookFrendId."/feed",'POST',$data);
				$status="success";
				$msg="";
			}catch(FacebookApiException $e){
				$status = "error";
				$msg = $e->getMessage();
			}
			
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
	}
	function pop_facebookRequest(){
		$userid = $this->facebook->getUser();
		if($userid==0){
			$params = array(
					  'scope' => $this->config->item('facebook_scope'),
			);
			$url = $this->facebook->getLoginUrl($params);
			redirect($url);
		}
		else{
			$data['js'] = array();
			$data['css'] = array();
			$data['title'] = "Close";
			$data['mainContent'] = "pop_facebookrequest";
			$this->load->view('includes/content.php', $data);
		}
	}
}