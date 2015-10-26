<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Main extends CI_Controller {

  var $base;
  var $css;

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
  $this->load->library('javascript');
  $this->load->library('session');

   #Getting the properties from the config file
   $this->base = $this->config->item('base_url');
   $this->css = $this->config->item('css');
		//$this->load->library('jquery');
	}
	function index()
	{ 

  $data['css'] = $this->css;
  $data['base'] = $this->base;

   if($this->session->userdata('logged_in'))
   { //print_r($this->session->userdata('logged_in'));
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id']; 
     $data['privilege']=$session_data['privilege'];
     if($data['privilege']==1){// User logged has admin rights
       $this->load->model('Subjmodel');
       $result=$this->Subjmodel->load();
     
      if($result){ 
        $i=0;
        $data['table']="<table>";
        $data['table'].="<th><tr><td>Subject Code</td><td>Subject Name</td><td>Action</td></tr></th>";
          foreach($result as $row){
            $data['table'].="<tr><td><a id=".$row->subject_code." href='view?code=".$row->subject_code."' >".$row->subject_code."</a></td><td>".$row->subject_name."</td>";
            $data['table'].="<td>".anchor('subject/editSubject?subjcode='.$row->subject_code, 'Edit')."</a><td><a href=#>delete</a></td></tr>";
          }
          $data['table'].="<tr><td></td><td></tr>";
          $data['table'].="<tr><td></td><td>".anchor('subject/addSubject','Add Subject')."</td></tr>";
          $data['table'].="</table>";
        }else{
          $data['error']= "No Subjects in the system!";
          $data['error']= "<a href=#>Add subject</a>";
        }      
         $this->load->view('main', $data);
       }//end of IF privilege 
       if($data['privilege']==3){ //if user logged is a student
         $this->load->model('Subjmodel');
         $result=$this->Subjmodel->load();
         $data['table']="<table>";
         $data['table'].="<th><tr><td>Subject Code</td><td>Subject Name</td><td>Action</td></tr></th>";
          foreach($result as $row){
            $data['table'].="<tr><td><a id=".$row->subject_code." href='view?code=".$row->subject_code."' >".$row->subject_code."</a></td><td>".$row->subject_name."</td>";
            $data['table'].="<td>".anchor('view/quiz?subjcode='.$row->subject_code,'Take a Test')."</tr>";
          }
          $data['table'].="</table>"; 
          $this->load->view('main', $data);
       }
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
