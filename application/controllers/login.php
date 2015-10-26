<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
  $this->load->library('javascript');
		//$this->load->library('jquery');
  $this->load->library('session');
	}
	function index()
	{



		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		#$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
  $this->form_validation->set_rules('password', 'Password', 'required');
		#$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
//		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login');
		}
		else
		{

    
    $username =$_POST['username'];
    $password =$_POST['password'];

    $this->load->model('Loginmodel');  

    $result=$this->Loginmodel->login('users');	 
    $sess_array = array(); //print_r($result);
    if($result){ 
      foreach($result as $row){ 
        $sess_array = array(
           'id' => $row->idnum,
           'username' => $row->sname,
           'privilege' => $row->privileges
       ); 
        $this->session->set_userdata('logged_in',$sess_array);
        //$session_data=$this->session->userdata('logged_in');
        //$data['privilege']=$session_data['privilege'];
        //$data['username']=$session_data['id']; 
         redirect('main', 'refresh');
        //$this->load->view('main',$data);

      }
    }else{
      $data['title'] = 'Login';
      $data['error']='Username or Password incorrect!!';
      $this->load->view('login', $data);
      //echo "<script>alert(document.getElementById('error').innerHTML()); </script>";

      
    } 
			//$this->load->view('formsuccess');
		}
	}
 function studentlogin(){ 

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		#$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
  $this->form_validation->set_rules('password', 'Password', 'required');
		#$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
//		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login');
		}
		else
		{

    
    $username =$_POST['username'];
    $password =$_POST['password'];

    $this->load->model('Loginmodel');  

    $result=$this->Loginmodel->login('students'); //Query students table
    $sess_array = array(); print_r($result);
    if($result){ 
      foreach($result as $row){ 
        $sess_array = array(
           'id' => $row->idnum,
           'username' => $row->fname,
           'privilege' => 3
       ); 
        $this->session->set_userdata('logged_in',$sess_array);
        //$session_data=$this->session->userdata('logged_in');
        //$data['privilege']=$session_data['privilege'];
        //$data['username']=$session_data['id']; 
         redirect('main', 'refresh');
        //$this->load->view('main',$data);

      }
    }else{
      $data['title'] = 'Login';
      $data['error']='Username or Password incorrect!!';
      $this->load->view('login', $data);
      //echo "<script>alert(document.getElementById('error').innerHTML()); </script>";

      
    }
   }

 }
 function logout(){
   $this->session->sess_destroy();

   redirect('login', 'refresh');

 }
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */
