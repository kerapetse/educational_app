<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Test extends CI_Controller {

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
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
     if($data['privilege']==1){
       $this->load->model('Subjmodel');
       $result=$this->Subjmodel->load();
     
      if($result){ 
        $i=0;
        $data['table']="<table>";
        $data['table'].="<th><tr><td>Subject Code</td><td>Subject Name</td><td>Action</td></tr></th>";
          foreach($result as $row){
            $data['table'].="<tr><td><a id=".$row->subject_code." href='view?code=".$row->subject_code."' >".$row->subject_code."</a></td><td>".$row->subject_name."</td>";
            $data['table'].="<td><a href=#>Edit</a><td><a href=#>delete</a></td></tr>";
          }
          $data['table'].="</table>";
        }else{
          $data['error']= "No Subjects in the system!";
          $data['error']= "<a href=#>Add subject</a>";
        }      
         $this->load->view('main', $data);
       }//end of IF privilege 
      }
     else
     {
     //If no session, redirect to login page
       redirect('login', 'refresh');
     }
    }
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */
