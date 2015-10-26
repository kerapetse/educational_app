<?php
class Subjmodel extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
      //$this->load->database();
    }
    //List all subjects 
    function load()
    {
        //select all fields in the subjects table  
        $query = $this->db->get('subjects');

        if($query->num_rows>0) {
          return $query->result();
        }else{
               return false;         
        }
    }
   #Get table data
   function getinfo($tablename,$id){
     $query = $this->db->get_where($tablename, array('id' => $id)); 
     if($query->num_rows>0) {
 
       return $query->result();

     }else{
       return false;
     }

   }
   #Get a subject according to a given ID
   function getSubject(){
     

     $subject_code=$this->input->get('subjcode',TRUE);
     $query = $this->db->get_where('subjects', array('subject_code' => $subject_code)); 
     if($query->num_rows>0) {
 
       return $query->result();

     }else{
       return false;
     }
   }
    //Function to list topics for a given subject code
    function listtopics(){
       
        $subjcode= $this->input->get('code', TRUE);
        //select all fields in the subjects table
        $this->db->where('subjcode', $subjcode);  
        $query = $this->db->get('sylabus');

        if($query->num_rows>0) {
          return $query->result();
        }else{
               return false;         
        }
    }
    // Get a list of all questions in the DB.
    function getquestions($topicid){
        $subjcode= $this->input->get('code', TRUE);
        $topic_id=$topicid;

        //select all fields in the subjects table
        $this->db->select('questions.id,questions.question,questions.topic_id,questions.answer_id');
        $this->db->from('questions');
        $this->db->join('sylabus', 'sylabus.id = questions.topic_id');
        $this->db->where('sylabus.subjcode', $subjcode);
        $this->db->where('questions.topic_id', $topicid);   
        $query = $this->db->get();
       # print_r($query->result());
        if($query->num_rows>0) {
          return $query->result();
        }else{
               return false;         
        }
    }
    function listquestions(){
        $topicid=$this->input->post('topicid', TRUE);
        //select all fields in the subjects table
        $this->db->where('topic_id', $topicid);  
        $query = $this->db->get('questions');
//print_r($query1);
        if($query->num_rows>0) {
          return $query->result();
        }else{
               return false;         
        }
    }
    function getans(){
        $topicid=$this->input->post('topicid', TRUE);
        //select all fields in the subjects table
        $this->db->select('answers.id,answers.question_id,answers.answer');
        $this->db->from('answers');
        $this->db->join('questions', 'questions.id = answers.question_id');
        $this->db->order_by('answer','RANDOM'); //answers to be randomly displayed
        $query = $this->db->get();
//print_r($query2);
        if($query->num_rows>0) {
          return $query->result();
        }else{
               return false;         
        }
    }
    //function for creating questions for the student
    function getStudentQues(){
        $subjcode= $this->input->get('subjcode', TRUE);
        //select all fields in the subjects table
        //$this->db->select('questions.id,questions.question,questions.topic_id, answers.id as ans_id, answers.answer');
        $this->db->select('questions.id,questions.question,questions.topic_id,sylabus.subjcode');
        $this->db->from('questions');
        //$this->db->where('topic_id'
        //$this->db->join('answers', 'answers.question_id = questions.id');
        $this->db->join('sylabus', 'sylabus.id = questions.topic_id');
        $this->db->where('subjcode',$subjcode);
        $this->db->order_by('question','RANDOM');  
        $query = $this->db->get();
        //print_r($query1);
        if($query->num_rows>0) {
          return $query->result();
        }else{
          return false;
        }
         
   }
   function markQuiz(){

   }
   

  /**Adding or Modifying data in the database */

   function editSubject(){ #insert subject into the database
     $subjcode=  $this->input->post('subjcode',TRUE);
     $subjname= $this->input->post('subjname',TRUE);
     $description= $this->input->post('description',TRUE);
     
     $data = array(
        'subject_code' => $subjcode,
        'subject_name' => $subjname,
        'description' => $description
     );
    return $this->db->insert('subjects', $data); 


   }
   
   function updateSubject(){ #Alter subject information
     $subjectid= $this->input->post('subjid',TRUE); 
     $data = array(
               'subject_code' => $this->input->post('subjcode',TRUE),
               'subject_name' => $this->input->post('subjname',TRUE),
               'description' => $this->input->post('description',TRUE)
            );

     $this->db->where('subjectid', $subjectid);
     return $this->db->update('subjects', $data); 

   }
   function deleteSubject(){ #Delete Subject


   }

   function insertinfo($tablename,$tabledata){ #insert info into the table
     //$subjcode=$this->input->post('subjcode',TRUE);
     
     return $this->db->insert($tablename, $tabledata); 
   }
   function updateinfo($tablename,$tabledata,$id){ #Alter table info
     $this->db->where('id', $id);
     return $this->db->update($tablename, $tabledata);

   }

}
