<?php
class Mainmodel extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
      //$this->load->database();
    }

    function main()
    {
        $username=  $this->input->post('username',TRUE);
        $password= $this->input->post('password',TRUE); 
       
        //$this->db->get('users');
        $this->db->where('employeenum', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users'); 
        if($query->num_rows>0) {
          return $query->result();
        }else{
               return false;
           //$this->load->view('login');
           //$this->jquery->text('#error','Username or Password incorrect. Please try again!!');
           //$str="Username or Password incorrect. Please try again!!":
          //echo $str="<script>$('#error').text('Username or Password incorrect. Please try again!!');</script>";
           
        }
    }
//this fuction takes table name and the variable to search on the table
  function getlist($table,$variable){
    if($variable!=null){  
      $this->db->where('privileges', $variable);
    }
    $query = $this->db->get($table); 
    if($query->num_rows>0) { 
      return $query->result();
    }else{ 
               return FALSE;
    }
  }
  //this function takes table name, id and variable( column name to look for)
  function getObj($table, $id, $variable){

    $this->db->where($variable, $id);
    $query = $this->db->get($table);

    if($query->num_rows>0) {
      return $query->result();
    }else{
               return FALSE;
    }
  }

}
