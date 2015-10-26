<!DOCTYPE html>
<html>
<head>
<?php //echo $library_src;?>
<?php //echo $script_head;?>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css">
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-2.1.1.min.js" ></script>
<title>Login</title>
<?php
  if(@$error!=''){?>
    <script>
     alert('test');
   </script>
<?php  }?>
</head>
<body>

<?php // echo validation_errors(); ?>
<div id=login>
  <?php echo uri_string();
    if(uri_string()=='login'){
      echo form_open('login'); 
    }
    if(uri_string()=='login/studentlogin'){
      echo form_open('login/studentlogin');
    }
   ?> 
    <table>

      <tr><td><span><b>Username: </b></span></td><td><input type="text" name="username" value="<?php echo set_value('username'); ?>" size="20" /></td></tr>
      <tr><td><span><b>Password: <b></span></td><td><input type="password" name="password" value="<?php echo set_value('password'); ?>" size="20" /></td></tr>
      <tr><td><div id=error><span><?php echo form_error('username'); ?></span><span><?php echo form_error('password'); ?></span> </div></td></tr>
      <?php if(@$error!=''){ echo "<tr><td><div id=error>".$error."</div></div></td></tr>"; }?>
<!--
<h5>Password Confirm</h5>
<?php echo form_error('passconf'); ?>
<input type="text" name="passconf" value="<?php echo set_value('passconf'); ?>" size="50" />

<h5>Email Address</h5>
<?php echo form_error('email'); ?>
<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" />
-->
      <tr><td></td><td></td><td><input type="submit" value="Submit" /></td></tr>
    </table>
  </form>
</div>
</body>
</html>
