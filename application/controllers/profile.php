<?php
class Profile extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('mypage_mdl');
		$this->load->model('card_mdl');
		if($this->user_mdl->isLogin()==false){
			redirect(site_url('user/login/1'));
		}
	}
function show($profilename){
		//$profilename = $this->uri->segment(2);
		$data['css'] = array('profile.css','mypage.css');
		$data['js'] = array('friend.js');
		//echo $this->user_mdl->getCurrentUserID();
		//echo $this->user_mdl->getDBValue('tblusers','username','username',$profilename);
		if($this->user_mdl->getDBValue('tblusers','userid','username',$profilename) == $this->user_mdl->getCurrentUserID()){
			redirect(site_url('mypage'));
		}
		if($this->user_mdl->checkUserDuplicate($profilename)==1){
			$data['title'] = $profilename;
			$data['userinfo'] = $this->mypage_mdl->getUserInformationByUsername($profilename);
			$userid = $data['userinfo']->userid;
			//To DO
			$data['numCard'] = $this->card_mdl->getNumCard($userid);
			$this->load->model('friend_mdl');
			$data['numFriend'] = $this->friend_mdl->getNumFriend($userid);
			
			$friendlist = $this->friend_mdl->getAllFriend($userid);
			$data['friendlist'] = array();
			
			$currentUserLogin = $this->user_mdl->getCurrentUserID();
			$data['isFriend'] = $this->friend_mdl->isFriend($userid,$currentUserLogin);
			$data['isSendRequest'] = $this->friend_mdl->isSendRequest($userid);
			$data['isConfirmFriend'] = $this->friend_mdl->isConfirmFriend($userid);
			foreach ($friendlist as $afriendid){
				$data['friendlist'][] = $this->friend_mdl->getUserInfo($afriendid);
			}
			
			$data['mainContent'] = "profile_view";
			$this->load->view('includes/content.php', $data);
		}
		else{
			redirect('404');
		}
	}
	function more_friend(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$profilename =$this->input->post('fname');
			$this->load->model('friend_mdl');
			$userid=$this->mypage_mdl->getUserInformationByUsername($profilename);
			$userid = $userid->userid;
			$friendidarray=$this->friend_mdl->getAllFriend($userid);
			//$data['numFriend'] = $this->friend_mdl->getNumFriend($userid);
			$friendlistAll = array();
			foreach ($friendidarray as $friendid){
				$friendlistAll[]=$this->friend_mdl->getUserInfo($friendid);
			}
			$data['friendlistAll']=$friendlistAll;
			$this->load->view('pop_more_friend',$data);
		}
		else{
				
			echo "Unproperly access";
		}
	
		//data['friendlist'] = from db
		/*
		 * 1- All friend 's ID
		* 2- User info from tbluser by each ID
		* 3- Add these info to array
		*/
	}
	function changeProfile(){
		if($this->input->is_ajax_request()){
			$filename = $this->input->get('filename');
			$data['error'] = "";
			$data['filename'] = $filename;
			$this->load->view('profile_change_form',$data);
		}
		else{
			redirect('404');
		}
	}
	function saveCropPicture(){
			
			$x = $this->input->post('x');
			$y = $this->input->post('y');
			$w = $this->input->post('w');
			$h = $this->input->post('h');
			$filename = $this->input->post('filename');
			
			$tem = explode('/', $filename);
			$filename_thum = $this->config->item('server_root').'/data/profiles/thum/'.$tem[count($tem)-1];
					
			$targ_w = $targ_h = 150;
			$jpeg_quality = 90;
		
			$src = $filename;
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
			imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
		
			imagejpeg($dst_r,$filename_thum,$jpeg_quality);
			
			$filename_thum = str_replace($this->config->item('server_root')."/", base_url(), $filename_thum);
			
			$this->mypage_mdl->updatePictureProfile($this->user_mdl->getCurrentUserID(),$filename,$filename_thum);
			redirect(site_url('mypage'));
			
	}
	function uploadPicture(){
		if($this->input->is_ajax_request()){
		   $status = "";
		   $msg = "";
		   $file_element_name = 'userfile';
		   
		   if ($status != "error")
		   {
		      $config['upload_path'] = './data/profiles/';
		      $config['allowed_types'] = 'gif|jpg|png|jpeg';
		      $config['max_size']  = 1024 * 8;
		      $config['encrypt_name'] = TRUE;
		 
		      $this->load->library('upload', $config);
		 
		      if (!$this->upload->do_upload($file_element_name))
		      {
		         $status = 'error';
		         $msg = $this->upload->display_errors('', '');
		      }
		      else
		      {
		         $data = $this->upload->data();
		         $status = "success";
		         $msg = $data['file_name'];
		      }
		      @unlink($_FILES[$file_element_name]);
		   }
		   echo json_encode(array('status' => $status, 'msg' => $msg));
	}
	}
	
}