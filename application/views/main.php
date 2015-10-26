<?php
include('common/header.php');
 // echo userdata('logged_in');
  if(@$data!=""){
    //for($i=0; $i<3; $i++){
      
     echo $data;
    //}
  }else{
    echo $error;
  }
?>
<?php
include('common/footer.php');
?>
