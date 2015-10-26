<?php
include('common/header.php');
 // echo userdata('logged_in');
  if(@$form!=""){
    //for($i=0; $i<3; $i++){
      
     echo $form;
    //}
  }else{
    echo $error;
  }
?>
<?php
include('common/footer.php');
?>
