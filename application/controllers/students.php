<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Students extends CI_Controller {
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
       $result=$this->mainmodel->getlist('students',null);
       if($result){ 
        $i=0;
        $data['data']="<table id=tablestyle>";
        $data['data'].="<tr><th>Student Number</th><th>Student Name</th><th>Level</th><th>Status</th><th>Action</th></th></tr>";
          foreach($result as $row){
            $data['data'].="<tr><td><a id=".$row->idnum." href='students/view?id=".$row->idnum."' >".$row->idnum."</a></td>";
            $data['data'].="<td>".$row->fname."</td><td>".$row->level."</td><td></td>";
            $data['data'].="<td>".anchor('students/editstudent/?idnum='.$row->idnum,'Edit')."| <a href=#>delete</a></td></tr>";
          }

          $data['headers']=$this->load->view('common/headers',NULL,TRUE); //Headings
          $data['data'].=$data['headers']."</table>";
          
          $this->load->view('main', $data);
       }else{//No result
          $data['error']= "No Student in the system!";
          $data['error']= "<a href=#>Add Student</a>";  
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

       $id=$this->input->get('id',TRUE); //get the subject code
       $this->load->model('mainmodel');
       $result=$this->mainmodel->getObj('students',$id,'idnum');


       $data['data']="<p>".anchor('students', 'Back to Students list')."</p>";
       if($result){
         foreach($result as $row){
           $data['data'].="<span id='heading'>Student Number: </span><span>".$row->idnum."</span> <span id='heading'>Student Names: </span><span>".$row->fname;
           $data['data'].=" </span><span>".$row->surname."</span><span  id='heading'> Gender: </span><span>".$row->gender."</span>";
           $data['data'].="<div><span id='heading'>DOB: </span><span>".$row->dob."</span></div>";
           $data['data'].="<div><span id='heading'>Level: </span><span>".$row->level."</span> <span id='heading'>Last Logged: </span><span>".$row->last_logged."</span></div>";
           $data['data'].="<div><span id='heading'>Number of tests taken: </span> </div><div><span id='heading'>Date of last test taken: </span></div>";
           $data['data'].=anchor("students/editstudent/?idnum=".$row->idnum, "Edit Student Information");        
            $this->load->view('main', $data);
          # echo $data['data'];

         }//end of foreach result      

       }else{


       }           
      }
    }

  }//End of function view
  function editstudent(){
    if($this->session->userdata('logged_in')){
      $session_data = $this->session->userdata('logged_in');
      $data['username'] = $session_data['id'];
      $data['privilege']=$session_data['privilege'];
     
       $studentnum=$this->input->get('idnum',TRUE); //get the student name
      if($data['privilege']==1){  

        $this->load->model('mainmodel');
        $result=$this->mainmodel->getObj('students',$studentnum,'idnum'); //student details
       
        $subject_results=$this->mainmodel->getObj('subjects_enrolled',$studentnum,'studentidnum');//Subjects student enrolled for

        $subjects_results=$this->mainmodel->getlist('subjects',null);//List of all Subjects

        $data['data']="<p>".anchor('students', 'Back to Students list')."</p>";

        if($result){
          foreach($result as $row){
            $data['data'].=form_open('students/studentinfo');
            $data['data'].="<div><span>First Names: </span><span><input type='text' name='firstname' value=".$row->fname."></span>";
            $data['data'].=" <span>Surname: </span><span><input type='text' name='surname' value=".$row->surname."></span></div>";
            $data['data'].="<div><span>Student Number: </span><span>".$studentnum."</span></div>";
            $data['data'].="<div><span>Password: </span><span>".form_password('password', $row->password)."</span>";
            $data['data'].="<span> Confrim Password: </span><span>".form_password('password', $row->password)."</span></div>";

            $levels=array(
                       '1'=>'Level 1',
                       '2'=>'Level 2',
                       '3'=>'Level 3',
                       '4'=>'Level 4',
                       '5'=>'Level 5',
                       '6'=>'Level 6',
                       '7'=>'Level 7'
                     );
            $data['data'].="<div><span>Level: </span><span>".form_dropdown('levels',$levels,$row->level)."</span></div>";
            $subjects=array(); 
            if($subjects_results!=FALSE){
               $data['data'].="<div><span>Subjects: ";
              foreach($subjects_results as $subjrow){ 
                $checked=FALSE;
                if($subject_results){
                  foreach($subject_results as $row){
                     if($row->subjcode==$subjrow->subject_code){ 
                        $checked=TRUE; //if the student has subject enrolled mark it as checked
                     }
                   }
                 }
                  $data['data'].="<br>&nbsp&nbsp".$subjrow->subject_name." </span><span>".form_checkbox('subjects',$subjrow->subject_code, $checked)."</span><span>Teacher: </span> <span>".form_dropdown('teachers');
                
              }
            }else{//Else no subjects in the database
             $data['data'].="<span>No subjects in the system.</span>";

            }

            
            $data['data'].="</form>";
          }
        }else{
           $data['data'].="Error occurred!!";
        }
        $this->load->view('main', $data);
      }else{ //Else No privilege

      }
    }else{ //Else not logged in
     //If no session, redirect to login page
       redirect('login', 'refresh');
    }
  }//End of edit student function  
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */
