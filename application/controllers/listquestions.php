<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class ListQuestions extends CI_Controller {
  var $base;
  var $css;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
  $this->load->library('javascript');
  $this->load->library('session');
		//$this->load->library('jquery');
   #Getting the properties from the config file
   $this->base = $this->config->item('base_url');
   $this->css = $this->config->item('css');
	}
	function index()
	{
  $data['css'] = $this->css;
  $data['base'] = $this->base;

   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
     if($data['privilege']==1){
       $this->load->model('Subjmodel');
       $result=$this->Subjmodel->listquestions();
     
      if($result){ 
        $i=0;
        $data['table']="<table id='tablestyle'>";
        $data['table'].="<th><tr><td>Subject Code</td><td>Subject Name</td><td>Action</td></tr></th>";
          foreach($result as $row){
            $data['table'].="<tr><td><a id=".$row->question." href='view?id=".$row->id."' >".$row->question."</a></td><td>"."</td>";
            $data['table'].="<td><a href=#>Edit1</a><td><a href=#>delete1</a></td></tr>";
          }
          $data['table'].="</table>";
        }else{
          $data['error']= "No Subjects in the system!";
          $data['error']= "<a href=#>Add subject</a>";
        }  
          echo $data['table'];    
         //$this->load->view('main', $data);
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
