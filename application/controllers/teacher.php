<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Teacher extends CI_Controller {
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
       $this->load->model('mainmodel');
       $result=$this->mainmodel->getlist('users',2); //Teacher's privilige is given 2
       if($result){ 
        $i=0;
        $data['data']="<table id=tablestyle>";
        $data['data'].="<tr><th>Teacher Number</th><th>Teacher Name</th><th>Levels assigned</th><th>Subjects Teaching</th><th>Status</th><th>Action</th></th></tr>";
          foreach($result as $row){
            $data['data'].="<tr><td><a id=".$row->idnum." href='teacher/view?id=".$row->idnum."' >".$row->idnum."</a></td>";
            $data['data'].="<td>".$row->fname." , ".$row->sname."</td><td></t><td> </td><td></td>";
            $data['data'].="<td><a href=#>Edit</a> | <a href=#>delete</a></td></tr>";
          }

          $data['headers']=$this->load->view('common/headers',NULL,TRUE); //Headings
          $data['data'].=$data['headers']."</table>";
          
          $this->load->view('main', $data);
       }else{//No result
          $data['data']=$this->load->view('common/headers',NULL,TRUE); //Headings

          $data['data'].= "No Teachers in the system!";
          $data['data'].= "<a href=#>Add teacher</a>";
          #$data['data'].=$data['headers']."</table>";  
          $this->load->view('main', $data);
       }
     
          #echo $data['data'];    
         //$this->load->view('main', $data);
       }//end of IF privilege 
      }
     else
     {
     //If no session, redirect to login page
       redirect('login', 'refresh');
     }
    }
  function view(){
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $data['username'] = $session_data['id'];
      $data['privilege']=$session_data['privilege'];
      if($data['privilege']==1){
       $id=$this->input->get('id',TRUE);
       $this->load->model('mainmodel');
       $result=$this->mainmodel->getObj('students',$id,'idnum');
       $data['data']="<p>".anchor('teacher', 'Back to teachers\' list')."</p>";
       if($result){
         foreach($result as $row){
           $data['data'].="<span id='heading'>Staff Number: </span><span>".$row->idnum."</span> <span id='heading'>Names: ".$row->fname;
           $data['data'].=" </span><span>".$row->surname."</span><span  id='heading'> Gender: </span><span>".$row->gender."</span>";
           $data['data'].="<div><span id='heading'>DOB: </span><span>".$row->dob."</span></div>";
           $data['data'].="<div><span id='heading'>Last Logged: </span><span>".$row->last_logged."</span><span id='heading'> Subjects: </span><span>".$row->level."</span></div>";

           
            $this->load->view('main', $data);
          # echo $data['data'];

         }//end of foreach result      

       }else{


       }           
      }
    }

  }//End of function view
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */
