<?php
class Home extends CI_Controller{
	var $default=0;
	var $rows_per_page=10;
	public function index(){
		
		$this->session->set_userdata("viewtype","map");
		$data['title'] = "Memory BoX";
		$data['css'] = array('menu.css', 'skin.css');//,'map.css'
		$data['js'] = array('call_ajax.js');

		//Check if there is any cookie available 
		if($this->user_mdl->isLogin()==FALSE){
			$this->load->library('encrypt');
			$this->load->helper('cookie');
			$username = $this->encrypt->decode($this->input->cookie('n'));
			$password = $this->encrypt->decode($this->input->cookie('p'));
			$this->user_mdl->userAuthentication($username, $password);
		}
		
		
		
		$data['mainContent'] = "home_view";
		$data['test'] = ' dsfsdf' ;
		$this->load->view('includes/content.php', $data);
	}
	function getData(){
		$type = $this->input->post("type");
		echo $type;
	}
	//rosa
	function displayPicture_ROSA(){
		$card_type = $this->input->get('cardtype');
		
		//$q=$this->db->query("select c.cardimage from tblcards c INNER JOIN tblcategory g ON g.categoryid=c.categoryid where g.categoryname='$card_type'");
		if($card_type!='All'){
			//$q=$this->db->query("select c.cardid, c.cardimage, g.categoryname from tblcards c INNER JOIN tblcategory g ON g.categoryid=c.categoryid where g.categoryname='$card_type'");
			$q=$this->db->query("SELECT cardid, cardimage, categoryname FROM vcards WHERE categoryname='$card_type'");
		}
		else{
			//$q=$this->db->query("select c.cardid, c.cardimage, g.categoryname from tblcards c INNER JOIN tblcategory g ON g.categoryid=c.categoryid");
			$q=$this->db->query("SELECT cardid, cardimage, categoryname FROM vcards");
		}
		//$q=$this->db->query("select cardimage from vcards");
		/*$total_records=$sql->num_rows();
		$pages=ceil($total_records/$this->rows_per_page);
		
		$start=$this->default*$this->rows_per_page;
		$limit=$this->rows_per_page+$start;
		$this->db->select('cardimage');
		$q=$this->db->get("tblcards",$limit,$this->rows_per_page);
		if($this->default>0){
			$this->default=$this->default-1;		
		}
		else if($this->default<$pages){ $this->default=$this->default+1;}
		*/
		$countrow=$q->num_rows();
		header('Content-Type: text/xml');
		echo '<data>';
		echo '  <total>' . $countrow . '</total>';
		foreach($q->result() as $row){
			echo '  <cardid>' .$row->cardid. '</cardid>';
			echo '  <cardimage>' .$row->cardimage. '</cardimage>';
			echo '  <categoryname>' .$row->categoryname. '</categoryname>';
		}
		echo '</data>';
	}
	
	function getCardCarousel(){
		$card_type = $this->input->get('cardtype');
		/*
		$first = max(0, intval($this->input->get('first')) - 1);
		$last  = max($first + 1, intval($this->input->get('last')) - 1);
		$length = $last - $first + 1;
		*/
		$this->db->select('cardid, cardimage,, categoryname');
		if($card_type!='All'){
			$this->db->where('categoryname', $card_type);
		}
		$q = $this->db->get('vcards');//,10,0
		
		/*
		print_r($q->result());
		exit();
		*/
		$total_card=$q->num_rows();
		//$selected = array_slice($q->result(), $first, $length);
		
		header('Content-Type: text/xml');
		echo '<cards>';
		echo '  <total>' . $total_card . '</total>';
		foreach($q->result() as $card){
			echo '<card>';
				echo '<cardid>' .$card->cardid. '</cardid>';
				echo '<cardimage>' .$card->cardimage. '</cardimage>';
				echo '<categoryname>' .$card->categoryname. '</categoryname>';
			echo '</card>';
		}
		echo '</cards>';
		//return $q->result();
	}
	/*function jsonData(){
		$arr=array();
		$q=$this->db->query("select c.cardimage from tblcards c INNER JOIN tblcategory g ON g.categoryid=c.categoryid where g.categoryname='Eat'");
		foreach($q->result() as $row){
			$arr[]=$row->cardimage;
		}
		echo json_encode($arr);
	}*/
	//rosa
}