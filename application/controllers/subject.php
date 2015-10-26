<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Subject extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');



  $this->load->library('javascript');
  $this->load->library('session');
		//$this->load->library('jquery');
	}
	function index(){
	  
	}
	function addSubject()
	{ 
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];


      if($data['privilege']==1){
        $this->form_validation->set_rules('subjcode', 'Subject Code', 'required');
        $this->form_validation->set_rules('subjname', 'Subject Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');        

        if ($this->form_validation->run() == FALSE) {
          echo validation_errors(); 
          $data['form']=form_open('subject/addSubject');
          $data['form'].='<table>';
          $data['form'].='<tr><td>Edit/Add Subject Information</td></tr>';
          $data['form'].='<tr><td>Subject Code: <input type="text" name="subjcode" value="'.set_value("subjcode");
          $data['form'].='" ></td><td>Subject Name: <input type="text" name="subjname" value="'.set_value("subjname").'" ></td>';
          $data['form'].='<tr><td>Description: <textarea rows="4" cols="50" name=description>'.set_value("description").'</textarea></td><td>Teachers:'.form_checkbox().' <td></tr>';
          $data['form'].='<tr><td></td><td></td><td><input type="submit" value="Submit" /></td<td>'.anchor('main','<input type=button id=cancel value=\'Cancel\' />').'</td></tr>';
          $data['form'].="</table></form>";

          $this->load->view('subject', $data);
        }else{
          $this->load->model('Subjmodel');
          $result=$this->Subjmodel->editSubject(); 

          if($result==1){
            redirect('main','refresh');
          }else{
           //redirect(
          }         
        }
      
      }else{
        
         }
      }
      else
      {
       //If no session, redirect to login page
       redirect('login', 'refresh');
     }
   }
  function editSubject(){
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];


      if($data['privilege']==1){

       $this->load->model('Subjmodel');
       $result=$this->Subjmodel->getSubject(); 
       
       
       
       $this->form_validation->set_rules('subjcode', 'Subject Code', 'required');
       $this->form_validation->set_rules('subjname', 'Subject Name', 'required');
       $this->form_validation->set_rules('description', 'Description');        

        //if ($this->form_validation->run() == FALSE) {
       $subject_code=$this->input->get('subjcode',TRUE);
       #$teachers_results=$this->mainmodel->getObj('teacher_responsibilities','subjcode',$subject_code);//List of all Teachers
        $this->load->model('mainmodel');
        $teachers_results=$this->mainmodel->getlist('teacher_responsibilities',null);//List of all teachers
        if ($this->form_validation->run() == FALSE) {
          echo validation_errors();
          foreach($result as $row){ 

            $data['form']=form_open('subject/editSubject');
            $data['form'].='<table>';
            $data['form'].='<tr><td>Edit/Add Subject Information</td></tr>';
            $data['form'].='<tr><td><input type="hidden" name="subjid" value="'.$row->subjectid.'"</td><td>Subject Code: <input type="text" name="subjcode" value="'.$row->subject_code;
            $data['form'].='" ></td><td>Subject Name: <input type="text" name="subjname" value="'.$row->subject_name.'" ></td>';
            $data['form'].='<tr><td>Description: <textarea rows="4" cols="50" name=description>'.$row->description.'</textarea></td>'; 
            if($teachers_results){
              foreach($teachers_results as $teacher_row){ 
                $data['form'].='<td>Teachers: '.form_checkbox('teachers',$teacher_row->idnum).'<br></td></tr>';
              }
     
            }     


            $data['form'].='<tr><td></td><td></td><input type=hidden value=1 name=save><td><input type="submit" value="Submit" /></td<td>'.anchor('main','<input type=button id=cancel value=\'Cancel\' />').'</td></tr>';
            $data['form'].="</table></form>";
          }
          $this->load->view('subject', $data);
        }else{ 
          $this->load->model('Subjmodel');
          $result=$this->Subjmodel->updateSubject(); 

          if($result==1){
            redirect('main','refresh');
          }else{ echo "Error";
           //redirect(
          }         
        }
      
      }else{
        
         }
      }
      else
      {
       //If no session, redirect to login page
       redirect('login', 'refresh');
     }


  }
  function deletesubject(){
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];


      if($data['privilege']==1){

      }else{
       echo "You do not have the right to perform this transaction";
      }
    }else{
       //If no session, redirect to login page
       redirect('login', 'refresh');
    }
  }
  function addtopic(){
   if($this->session->userdata('logged_in'))
   {

     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
     $subjcode=$this->input->get('subjcode', TRUE);

    array('error' => ' ' );

      if($data['privilege']==1){
        $this->form_validation->set_rules('topic', 'Topic', 'required');
        
        if ($this->form_validation->run() == FALSE) {
          #echo $error;
          $data['form']=form_open_multipart('subject/addtopic');
          $data['form'].='<table>';
          $data['form'].='<tr><td>Edit/Add Topic Information - '.$subjcode.'</td></tr>';
          $data['form'].='<tr><td><input type="hidden" name="subjcode" value="'.$subjcode.'"</td></tr>';
          $data['form'].='<tr><td>Topic: <textarea cols="50" rows="4" name="topic" ></textarea></td><td>Upload notes: <input type="file" name="userfile" size="20" /></td></tr>';
          $data['form'].='<tr><td></td><td><input type="submit" value="Submit" /></td<td>'.anchor('subject/view?code='.$subjcode,'<input type=button id=cancel value=\'Cancel\' />').'</td></tr>';
           $data['form'].="</table></form>";

           $this->load->view('subject', $data); #display information
         }else{
		         $config['upload_path'] = './uploads/'; //type if file allowed to be uploaded
		         $config['allowed_types'] = 'txt'; //A folder to upload the files to
          # $config['allowed_types'] = 'txt'; 
          # $config['upload_path'] = './uploads/'; 
           $this->load->library('upload', $config); 
           $this->upload->addtopic(); exit;
           print_r(array('upload_data' => $this->upload->data()));
           #$this->upload->data()); 
exit;

          // if ( ! $this->upload->addtopic()){
             $error = array('error' => $this->upload->display_errors());
              print_r($error); exit;

           //}



           $this->load->model('Subjmodel');

           $tabledata = array(
               'topic' => $this->input->post('topic',TRUE),
               'subjcode' => $this->input->post('subjcode',TRUE)
            );          
           $subjcode=$this->input->post('subjcode', TRUE);
           $result=$this->Subjmodel->insertinfo('sylabus',$tabledata);
           if($result==1){
             redirect('subject/view?code='.$subjcode,'refresh');
            }else{
              echo "Error";
            }
           //$this->load->view('subject', $data); #display information
         }
      }else{
       echo "You do not have the right to perform this transaction";
      }
    }else{
       //If no session, redirect to login page
       redirect('login', 'refresh');
    }

  }
  function edittopic(){
   if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
     $subjcode=$this->input->get('subjcode', TRUE);

     $id=$this->input->get('id', TRUE);

      if($data['privilege']==1){
        $this->load->model('Subjmodel');
        $result=$this->Subjmodel->getinfo('sylabus',$id);

        $this->form_validation->set_rules('topic', 'Topic', 'required');

        if ($this->form_validation->run() == FALSE) {
          if($result!=false){
            $data['form']=form_open('subject/edittopic');
            $data['form'].='<table>';
            foreach($result as $row){ 
              $data['form'].='<tr><td>Edit Topic Information - '.$row->subjcode.'</td></tr>';
              $data['form'].='<tr><td><input type="hidden" name="id" value="'.$row->id.'"</td><td><input type="hidden" name="subjcode" value="'.$row->subjcode.'"</td></tr>';
              $data['form'].='<tr><td>Topic: <textarea cols="50" rows="4" name="topic" >'.$row->topic.'</textarea></td></tr>';
            }
            $data['form'].='<tr><td></td><td><input type="submit" value="Submit" /></td<td>'.anchor('subject/view?code='.$subjcode,'<input type=button id=cancel value=\'Cancel\' />').'</td></tr>';
             $data['form'].="</table></form>";

             $this->load->view('subject', $data); #display information
          }else{
            echo "Error: No result";
          }

        }else{
          #
           $this->load->model('Subjmodel');

           $tabledata = array(
               'topic' => $this->input->post('topic',TRUE),
               'subjcode' => $this->input->post('subjcode',TRUE)
            );
            $id=$this->input->post('id', TRUE);
            $subjcode=$this->input->post('subjcode', TRUE);  
            $result=$this->Subjmodel->updateinfo('sylabus',$tabledata,$id);
            if($result==1){
              redirect('view?code='.$subjcode,'refresh');
            }else{
              echo 'Error: ';
            }
        }
      }else{
        echo 'Permission denied to perform this transaction';
      }
    }else{
       //If no session, redirect to login page
       redirect('login', 'refresh');

    }

  }
  function addquestion(){
   if($this->session->userdata('logged_in'))
   { 
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
     $subjcode=$this->input->get('code', TRUE);

     //$id=$this->input->get('id', TRUE);

      if($data['privilege']==1){
          $this->load->model('Subjmodel');
          $result=$this->Subjmodel->listtopics();
           
        $this->form_validation->set_rules('topic', 'Topic', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['form']=form_open('subject/addquestion');
            $data['form'].='<table>';
             
              $data['form'].='<tr><td>Add Question - '.$subjcode.'</td></tr>';
              $data['form'].='<tr><td><input type="hidden" name="subjcode" value="'.$subjcode.'"</td></tr>';
              $data['form'].='<tr><td>Question: <textarea cols="50" rows="4" name="question" ></textarea></td></tr>';
              $options=array();#an array to collect topics information
              foreach($result as $row){
              //  $options = array(
                //  $row->id  => $row->topic
                //);                 
                 $options[$row->id] = $row->topic; #create an array of topics to be dispalyed on the dropdown menu
                
               }
            $data['form'].='<tr><td>Topic</td><td>'.form_dropdown('topics', $options, '').'</tr></td>';
            $data['form'].='<tr><td>Answers(Please enter one correct answer and 3 wrong answers)</td></tr>';
            $data['form'].='<tr><td>Answer 1</td><td><input type=text name=answer1><input type=radio name=status_1>correct<td></tr>';
            $data['form'].='<tr><td>Answer 2</td><td><input type=text name=answer2><input type=radio name=status_2>correct<td></tr>';
            $data['form'].='<tr><td>Answer 3</td><td><input type=text name=answer3><input type=radio name=status_3>correct<td></tr>';
            $data['form'].='<tr><td>Answer 4</td><td><input type=text name=answer4><input type=radio name=status_4>correct<td></tr>';
            $data['form'].='<tr><td></td><td><input type="submit" value="Submit" /></td<td>'.anchor('view?code='.$subjcode,'<input type=button id=cancel value=\'Cancel\' />').'</td></tr>';
            $data['form'].='</table></form>';
     
            $this->load->view('subject', $data); #load data to the view
        }else{
            //form validated
           $tabledata = array(
               'question' => $this->input->post('question',TRUE),
               'subjcode' => $this->input->post('subjcode',TRUE)
            ); 
          $this->load->model('Subjmodel');
          $result=$this->Subjmodel->insertinfo('questions',$id);
            if($result==1){
              redirect('view?code='.$subjcode,'refresh');
            }else{
              echo 'Error: ';
            }
        }
      }else{

           //no priviliges
      }
   }else{
       //not logged in
     }

  }
	function view()
	{ 
  //$data['css'] = $this->css;
  //$data['base'] = $this->base;
   if($this->session->userdata('logged_in'))
   {
     
     $subjcode=$this->input->get('code', TRUE);
  
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
      if($data['privilege']==1){
        $this->load->model('Subjmodel');

        //Get a list of topics
        $result=$this->Subjmodel->listtopics();
         
       //Get a list of questions for each topic
       # $questions_result=$this->Subjmodel->getquestions();

        //Get a list of all answers for questions of this topic
        $ans_result=$this->Subjmodel->getans();        

        $letters=array('A','B','C','D');//letters to be assigned to answers
        //$letter_pos=0;//position of pointer on letters array

        $data['data']="<div class='headers'>
                           <ul>
                             <li>".anchor('subject/view','Syllabus')."</li>
                             <li>".anchor('subject/quizes/','Quizes')."</li>
                           </ul>
        </div> ";



        if($result){ //if topic found
          $i=1;
          $question_num=1;
          $data['data'].="<p>".anchor('main','Go back to Subjects')."</p><p>Subject Code: <b>".$subjcode."</b>";
          $data['data'].="<table id='tablestyle'>";
          $data['data'].="<tr><th>Number</th><th>Topic</th><th>Action</th></tr>";
          foreach($result as $row){//Make a row of topics for the concerned subject
            $data['data'].="<tr id=topic_{$i} ><td><span id=toggle{$i} onClick=showQues(topic_{$i},toggletopic_{$row->id});><b>+</b></span>".$i."</td><td>".$row->topic."</td>";
            $data['data'].="<td>".anchor('subject/edittopic?id='.$row->id.'&subjcode='.$subjcode,'Edit Topic')."</a> | <a href=#>delete</a></td></tr>"; //print_r($questions_result);
            $data['data'].="<tr><td>".anchor('#', 'Add Notes')."</td></tr>";

            $i++;
          }//end of foreachtopic result
          $data['data'].="<tr><td></td><td></td><td>".anchor('subject/addtopic?subjcode='.$subjcode,'Add Topic')."</td></tr>";
         /* $atts = array(
                        'width'      => '800',
                        'height'     => '600',
                        'scrollbars' => 'yes',
                        'status'     => 'yes',
                        'resizable'  => 'yes',
                        'screenx'    => '0',
                        'screeny'    => '0'
                      );

 $data['data'].="<tr><td></td><td></td><td>".anchor_popup('views/', 'Click Me!', $atts)."</td></tr>"; */
          $data['data'].="</table>";
         }else{
           $data['data']= anchor('main','Go back to Subjects')."<br>No Topics in the system!";
           $data['data'].= "<br>".anchor('subject/addtopic?subjcode='.$subjcode,'Add topics');
          }      
        $this->load->view('main', $data);
       }
      }
      else
      {
       //If no session, redirect to login page
       redirect('login', 'refresh');
     }
   }
  function quizes(){
   if($this->session->userdata('logged_in'))
   {
     
     $subjcode=$this->input->get('code', TRUE);
  
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
      if($data['privilege']==1){
        $this->load->model('Subjmodel');

        //Get a list of topics
        $result=$this->Subjmodel->listtopics();
         
       //Get a list of questions for each topic
       # $questions_result=$this->Subjmodel->getquestions();

        //Get a list of all answers for questions of this topic
        $ans_result=$this->Subjmodel->getans();        

        $letters=array('A','B','C','D');//letters to be assigned to answers
        //$letter_pos=0;//position of pointer on letters array
        $data['data']="<div class='headers'>
                           <ul>
                             <li>".anchor('subject/view','Syllabus')."</li>
                             <li>".anchor('subject/quizes/','Quizes')."</li>
                           </ul>
        </div> ";



        if($result){ //if topic found
          $i=1;
          $question_num=1;
          $data['data'].="<p>".anchor('main','Go back to Subjects')."</p><p>Subject Code: <b>".$subjcode."</b>";
          $data['data'].="<table>";
          $data['data'].="<tr><th>Number</th><th>Topic</th><th>Action</th></tr>";
          foreach($result as $row){//Make a row of topics for the concerned subject
            $data['data'].="<tr id=topic_{$i} ><td><span id=toggle{$i} onClick=showQues(topic_{$i},toggletopic_{$row->id});><b>+</b></span>".$i."</td><td>".$row->topic."</td>";
            $data['data'].="<td>".anchor('subject/edittopic?id='.$row->id.'&subjcode='.$subjcode,'Edit Topic')."</a> | <a href=#>delete</a></td></tr>"; //print_r($questions_result);

             //Get a list of questions for each topic
                $questions_result=$this->Subjmodel->getquestions($row->id);

             if($questions_result!=false){  
               foreach($questions_result as $ques_row){
                 if($row->id==$ques_row->topic_id){ //Match each topic with its questions
                   $letter_pos=0;//pointer's postion on the letters array
                   $data['data'].="<tr id=toggletopic_{$row->id}><td></td><td><span id=toggle_{$question_num}  onClick=toggler(this,collapsed".$ques_row->id."); >+</span> Question ".$question_num." - ".$ques_row->question."</td><td>Edit</td></tr>";
                   if($ans_result){  //echo print_r($ques_row);   //echo $ans_result;                 
                     foreach($ans_result as $ans_row){    //echo $ans_row->question_id;  //Make a row of answers for each question            
                       if($ques_row->id==$ans_row->question_id){
                         $data['data'].="<tr  id='collapsed".$ques_row->id."' ><td></td><td id='left-space'>";
                         $data['data'].="<input type='radio' name=".$ques_row->id." value=''";
                         if($ans_row->id==$ques_row->answer_id){
                           $data['data'].=" checked "; //Check the correct answer for this question
                         }
                         $data['data'].="> ".$letters[$letter_pos].". ".$ans_row->answer."</td></tr>";
                          $letter_pos++;
                       }
                     }
                    }
                 }
                $question_num++;
               }
                 $data['data'].="<tr><td>".anchor('subject/addquestion?code='.$subjcode,'Add Question')."</td></tr>";
             }else{//Else No question found for this topic
               $data['data'].="<tr><td></td><td class='nosubj'>No question(s) added for this topic!!</td><td>".anchor('subject/addquestion?code='.$subjcode,'Add Question')."</tr>";
              }
            $i++;
          }
          $data['data'].="<tr><td></td><td></td><td>".anchor('subject/addtopic?subjcode='.$subjcode,'Add Topic')."</td></tr>";
         /* $atts = array(
                        'width'      => '800',
                        'height'     => '600',
                        'scrollbars' => 'yes',
                        'status'     => 'yes',
                        'resizable'  => 'yes',
                        'screenx'    => '0',
                        'screeny'    => '0'
                      );

 $data['data'].="<tr><td></td><td></td><td>".anchor_popup('views/', 'Click Me!', $atts)."</td></tr>"; */
          $data['data'].="</table>";
         }else{
           $data['error']= anchor('main','Go back to Subjects')."<br>No Topics in the system!";
           $data['error'].= "<br>".anchor('subject/addtopic?subjcode='.$subjcode,'Add topics');
          }      
        $this->load->view('main', $data);
       }
      }
      else
      {
       //If no session, redirect to login page
       redirect('login', 'refresh');
     }


  }
  //Prepare and display quiz
  function quiz(){
    if($this->session->userdata('logged_in')){
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['id'];
     $data['privilege']=$session_data['privilege'];
     $subjcode=$this->input->get('subjcode', TRUE);
     

      $this->load->model('Subjmodel');    

      $questions_result=$this->Subjmodel->getStudentQues();

        //Get a list of all answers for questions of this topic
      $ans_result=$this->Subjmodel->getans();

      $letters=array('A','B','C','D');//letters to be assigned to answers
      $question_num=1;
      $data['data']="<p>Subject Code: <b>".$subjcode."</b></p><p><b>Multiple Qestions</b></p>";

      $answers=array();

      if($questions_result){ 
        $data['data'].=form_open('login/studentlogin');//create a table to diplay questions and answers
        foreach($questions_result as $row){
          $letter_pos=0;//for each question set this to zero
          $data['data'].="<div id=question>".$question_num.". ".$row->question."</div>";
          foreach($ans_result as $ans_row){ 
            if($ans_result){ 
              if($row->id==$ans_row->question_id){
                $data['data'].="<div id='left-space'>";
                //$data['data'].="<input type='radio' name=".$row->id."_".$answers."[]"." value=''> ".$letters[$letter_pos].". ".$ans_row->answer."</td>";
                $data['data'].="<input type='hidden' name='qnumber' value=''>";                
                $data['data'].="<input type='radio' name=".$row->id." value=''> ".$letters[$letter_pos].". ".$ans_row->answer."</td>";
                $data['data'].="<span id=mark></span></div>";
                $letter_pos++;
              }
             }
          }//end of foreach for looping through answers
          $question_num++;
        }//end of looping through question array result
        $data['data'].="<div><input type=button id=submit onClick=markQuiz() value='Submit'/> ";
        $data['data'].=anchor('main','<input type=button id=cancel value=\'Cancel\' />')."</div>";
        $data['data'].="</form>";
        $this->load->view('main',$data);
      }//end of if result
    }else{
    //If no session, redirect to login page
      redirect('login', 'refresh');
    }
 }

}//end of the controller


/* End of file login.php */
/* Location: ./application/controllers/login.php */
