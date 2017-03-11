<?php
class Mypage_mdl extends CI_Model{
	function getUserInformation($userid){
		$this->db->where('userid',$userid);
		$q = $this->db->get("tblusers");
		if($q->num_rows()==1){
			$row = $q->result();
			return $row[0];
		}
		return "";
	}
	function getUserInformationByUsername($username){
		$this->db->where('username',$username);
		$q = $this->db->get("tblusers");
		if($q->num_rows()>=1){
			$row = $q->result();
			return $row[0];
		}
		return "";
	}
	function updatePictureProfile($userid,$picture, $thum){
		$data = array(
			'picture' => $picture,
			'thum' => $thum
		);
		
		$this->db->where('userid',$userid);
		$this->db->select('picture,thum');
		$q = $this->db->get('tblusers');
		$row = $q->result();
		$row = $row[0];
		$imagepath = $row->picture;
		$thum = $row->thum;
		$imagepath = str_replace(base_url(), $this->config->item('server_root')."/", $imagepath);
		$thum = str_replace(base_url(), $this->config->item('server_root')."/", $thum);
		if(file_exists($imagepath)){
			//echo $imagepath;
			unlink($imagepath);
		}
		if(file_exists($thum)){
			//echo $thum;
			unlink($thum);
		}
		//exit();
		
		$this->db->where('userid',$userid);
		$this->db->update('tblusers',$data);
	}
}