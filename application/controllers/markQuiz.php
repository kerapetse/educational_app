<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class MarkQuiz extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
  $this->load->library('javascript');
  $this->load->library('session');
		//$this->load->library('jquery');
	}
	function index()
	{ 
   if($this->session->userdata('logged_in'))
   {
     $this->load->model('Subjmodel');
     $result=$this->Subjmodel->markQuiz();

     if($result){ 

     }
    }else{
    //If no session, redirect to login page
      redirect('login', 'refresh');
    }
}


}//end of the controller


/* End of file login.php */
/* Location: ./application/controllers/login.php */
