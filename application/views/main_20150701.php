<?php
include('common/header.php');
 // echo userdata('logged_in');
  if(@$table!=""){
    //for($i=0; $i<3; $i++){
      
     echo $table;
    //}
  }else{
    echo $error;
  }
?>
<?php
include('common/footer.php');
?>
