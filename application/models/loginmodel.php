<?php
class Loginmodel extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
      //$this->load->database();
        date_default_timezone_set("Africa/Gaborone");
    }

    function login($table)
    {
        $username=  $this->input->post('username',TRUE);
        $password= $this->input->post('password',TRUE); 
        //$this->db->get('users');
        
        $this->db->where('password', md5($password));
        $this->db->where('idnum', $username);
        if($table=='students'){
           
          $query = $this->db->get('students'); //print_r($query->num_rows);
        }
        if($table=='users'){
          
          $query = $this->db->get('users'); //print_r($query->num_rows);
        }
        if($query->num_rows>0) {
          $data=array(
                    'last_logged' => date("Y-m-d H:i:s", time())
                   );
          $this->db->where('idnum', $username);
          $this->db->update($table, $data); //update when the user last logged in the system
          return $query->result();
        }else{
               return false;
           //$this->load->view('login');
           //$this->jquery->text('#error','Username or Password incorrect. Please try again!!');
           //$str="Username or Password incorrect. Please try again!!":
          //echo $str="<script>$('#error').text('Username or Password incorrect. Please try again!!');</script>";
           
        }
    }

}
