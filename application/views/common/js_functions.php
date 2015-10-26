<script>
/*
function showQues(topicid){ 
  if($('#toggle').html()=="+"){
    $('#toggle').html("-");
    url= "<?php echo site_url();?>/listquestions"; //alert(url);
  jQuery.ajax({
				  type: "POST",
				  url: url,
				  data: 'topicid='+ topicid,
				  cache: false,
				  success: function(response){ 
		  //if(response == 1){
      //document.write("<?php echo 'tesll' ?>");
      $('#'+topicid).append("<tr id=questions><td>"+response+"</td><td></td></tr>"); // add a row below the selected row
    //}
   }
  });
//alert('end');
  }else{
    $('#toggle').html("+");
  }
}*/
function markQuiz(){
    url= "<?php echo site_url();?>/markQuiz"; alert(url);
    
  jQuery.ajax({
				  type: "POST",
				  url: url,
				  data: 'topicid='+ topicid,
				  cache: false,
				  success: function(response){ 
		  //if(response == 1){
      //document.write("<?php echo 'tesll' ?>");
      $('#'+topicid).append("<tr id=questions><td>"+response+"</td><td></td></tr>"); // add a row below the selected row
    //}
   }
  });
}
</script>
