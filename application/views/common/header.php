<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css"> 
    <!--<base href= <?php echo "$base"; ?> > -->
   <!--<link rel="stylesheet" type="text/css" href="<?php echo "$base/$css";?>"> -->
    <script type="text/javascript" src="<?php echo base_url();?>js/js_functions.js" ></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery-2.1.1.min.js" ></script>
    <title>PSLE Exam Preparation System</title>
    <?php
      if(@$username!=""){ 
        require_once('js_functions.php');
      }
    ?>
  </head>
  <body>
  <div id='main-wrapper'>
    <div id='status'>
      <h2>Welcome - <?php echo $username; ?></h2>
      <?php if($privilege==3){ echo anchor("login/logout","Logout");}else{ echo anchor("login/logout","Logout");} ?>
    </div>
    <?php
    if($privilege==1){
     #$this->load->view('common/headers');
     }
    ?>
