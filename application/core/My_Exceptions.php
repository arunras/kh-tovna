<?php
class My_Exceptions extends CI_Exceptions{
	var $CI="";
	function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
	}
	
	function log_exception($severity, $message, $filepath, $line)
	
	{
		$severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
	
		log_message('error', 'Severity: '.$severity.' --> '.$message. ' '.$filepath.' '.$line, TRUE);
	
		if($this->CI->config->item('base_url') == 'http://mcolle.localhost') {
			
			$this->CI->load->library('email');
			$this->CI->email->set_newline("\r\n");
			$uri = $this->CI->uri->uri_string();
	
			$this->CI->email->from('no-reply', 'APP Error');
        	$this->CI->email->to('smaemenglim@gmail.com');
	
			$this->CI->email->subject('APP Error [severity: '.$severity.']');
			$this->CI->email->message("From ".$this->CI->session->userdata('loginname')."\n".'Severity: '.$severity.' --> '.$message. ' '.$filepath.' '.$line."\n"." From URL: ".$uri);
	
			//$this->CI->email->send();
		}
	}
	
	
	function show_404($page = '', $log_error = TRUE)
	{
		$heading = "404 Page Not Found";
		$message = "The page you requested was not found.";
	
		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', '404 Page Not Found --> '.$page);
		}
		
		//Email to Developer
		$this->CI->load->library('email');
		$this->CI->email->set_newline("\r\n");
        $uri = $this->CI->uri->uri_string();  
        $this->CI->email->from('no-reply', 'APP Error');
        $this->CI->email->to('smaemenglim@gmail.com');
        $this->CI->email->subject('APP Error [Page Not Found]');
        $this->CI->email->message("From ".$this->CI->session->userdata('loginname')."\n"."Page not Found. From URL: ".$uri);
        //$this->CI->email->send();
	
		echo $this->show_error($heading, $message, 'error_404', 404);
		exit;
	}
}