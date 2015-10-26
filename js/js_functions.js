function showQues(object,obj){ //alert(obj.length);
  toggle=object.id.split("_"); 
  if($('#toggle'+toggle[1]).html()=="+"){
    $('#toggle'+toggle[1]).html("-");
    
    //$('#toggle').each(function)(index){ $('#toggleQuestion').css("display","inline"); });
    if(obj.length != undefined){ //alert('test1');
      $('#'+obj[0].id).each(function(index) { //alert('test');
        $('tr[id|='+obj[0].id+']').show('slow'); //Show all the hide elements

      });
     }else{ //alert('test');
      $('#'+obj.id).each(function(index) { //alert('test');
        $('tr[id|='+obj.id+']').show('slow'); //Show all the hidden elements

      });
     }
    
  }else{

    $('#collapsed'+toggle[1]).each(function(index) { //iterate through answers too and hide them if they are shown.
      $('tr[id|=collapsed'+toggle[1]+']').hide('slow');
    })
     //$('#'+category+'__list').css('display')=='none')
     //alert($('#collapsed'+toggle[1]).css('display')) 
    //$('#toggleQuestion').css("display","none");
    if(obj.length != undefined){ 
      $('#'+obj[0].id).each(function(index) { //alert('test');
        $('tr[id|='+obj[0].id+']').hide('slow'); //hide all the showing elements

      });
     }else{
      $('#'+obj.id).each(function(index) { //alert('test');
        $('tr[id|='+obj.id+']').hide('slow'); //hide all the showing elements

      });      
     }
      //toggle('toggle_1','collapsed1');
      $('#toggle'+toggle[1]).html("+");
  }
}
function toggler(object,obj){ //alert('objlength');
  // if(obj.length == 'undefined'){
    //alert('testo');
   //}
 // temp = object.id.split("_"); //alert(temp[1]);

  toggleID=obj[0].id;
  if($('#'+object.id).html()=="+"){
     
    $('#'+object.id).html("-");
    
    //$('#toggle').each(function)(index){ $('#toggleQuestion').css("display","inline"); });
    $('#'+toggleID).each(function(index) { //alert('test');
      $('tr[id|='+toggleID+']').show('slow');
    });
    
  }else{ 
     //$('#toggleQuestion').css("display","none");
    $('#'+toggleID).each(function(index) {
      $('tr[id|='+toggleID+']').hide('slow');
      
    });
    $('#'+object.id).html("+");
  } 
}
