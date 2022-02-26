<!DOCTYPE html>
<?php
   error_reporting(E_ALL ^ E_NOTICE);
   
   $MenuSelect = basename($_SERVER['PHP_SELF']); /* Returns The Current PHP File Name */
 
   
   if (isset($_COOKIE["id"]))
   {
       $id = $_COOKIE["id"];
   }
   if (isset($_COOKIE["loginame"]))
   {
       $loginame = $_COOKIE["loginame"];
   }
   if (isset($_COOKIE["CanSystemAdmin"]))
   {
       $CanSystemAdmin = $_COOKIE["CanSystemAdmin"];
   }
   
   include "dbhands.php";
   include "i_functions.php";
   
   $divmenuMTODAY = "style='margin-top:-20px' ";
   //if ($MenuSelect==='ptoday.php')     {$divmenuMTODAY="style='background-color:#5DADE2;' "; }
   $divmenuMTODAYimg = "src='images/Today.svg'";
   if ($MenuSelect === 'SAuser.php')
   {
       $divmenuMTODAY = "style='font-family: open sans;font-weight:600;background-color:rgba(255,180,1,0.5);margin-top:-20px;border-left: 6px solid #e74c3c;' ";
       $divmenuMTODAYimg = "src='images/TodaySelected.svg'";
   }
   $divmenuMALLITEMSimg = "src='images/AllItems.svg'";
   if ($MenuSelect === 'SAgroupmain.php')
   {
       $divmenuMALLITEMS = "style='font-family: open sans;font-weight:600;background-color:rgba(255,180,1,0.5);border-left: 6px solid #e74c3c;'";
       $divmenuMALLITEMSimg = "src='images/AllItemsSelected.svg'";
   }
   

   
   ?>
<!doctype html>
<html lang=''>
   <head>
      <meta charset='utf-8'>
      <title>Team Pod</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=0.8">
      <link rel="stylesheet" type="text/css" href="newstyle.css">
      </link>
      <script src="multiselect.min.js"></script>
            <link type="text/css" href="multiselect.css?v=23454" rel="stylesheet" />
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
      <style>.company_title{ margin-top: 20px; color: #da591c; } </style>
   </head>
   <body style="text-align: center;">
      <form action="" name="TaskMgmt"   method="post" enctype="multipart/form-data" target="_self" >
         <input type=hidden name="MenuSelect" />
         <div class="divheader" >
            <div style="float:left;height:67px; margin:0px 90px 0px 30px;width:0%"> 
               <a class="clientname bbhd-logo" href="https://teampod.co.uk">
               <img style="float:left;margin:23px 0px 0px 0px;" alt="Bamtus" src="https://teampod.co.uk/wp-content/uploads/2021/06/TeabPod-Logo25x.png">
               <?php

                    $query55= "SELECT  CliRecRef FROM `tUser`where RefUSR='$id' ";
                    $sql55 = mysqli_query($mysqli, $query55);
                    $row55 = mysqli_fetch_array($sql55);
                    $CliRecRef = $row55["CliRecRef"];

                    $query56= "SELECT  CliName FROM `tClient`where CliRecRef ='$CliRecRef' ";
                    $sql56 = mysqli_query($mysqli, $query56);
                    $row56 = mysqli_fetch_array($sql56);
                    $CliName = $row56["CliName"];
    
                ?>
                </a>
                </div>
                <div style="text-align:center;">
                    <h3 class="company_title" ><?php echo $CliName; ?>  </h3>
                </div>
            <div class="loginname" id="rightheader" style="float:right;margin-top:-60px">
               <span style="vertical-align: middle;"><label class="lbl"><?php echo $loginame; ?></label>&nbsp;&nbsp;</span>
               <a class="topicons" href='SAusermgmt.php' target='_self' title="Personal Profile"><img src="images/Profile.svg" height="40" style="vertical-align:middle;margin:10px 16px 0px 0px;" />  </a>
               <a class="topicons" onclick="popup('popUpDiv','invite_friends','')" title="Invite Friends"><img src="images/Email.svg" height="40" style="vertical-align:middle;margin:10px 16px 0px 0px;" />  </a>
             <?php if ($CanSystemAdmin == 1)
            { ?>
               <a class="topicons" href='ptoday.php' target='_self' title="Task Management"><img src="images/TaskManagement.svg" height="40" style="vertical-align:middle;margin:10px 16px 0px 0px;" />  </a>
            <?php } ?>
               <a class="topicons" href='https://teampod.co.uk/TeamPod/index.php'  title="Signout"><img src="images/Logout.svg" height="40" style="vertical-align:middle;margin:10px 40px 0px 0px;" /></a>  
            </div>
         </div>
      </form>
      <style type="text/css">
          .hide1{
              display: none;
          }
          .show1{
             display: block;
          }
      </style>
      <div class="sidenav">
         <a href="#" title="Today"  onclick="window.location.href='SAuser.php';" <?php echo $divmenuMTODAY; ?> ><img class="webicon" width="20px" <?php echo $divmenuMTODAYimg ?> /> <span class="navlabel">&nbsp HR Manager</span> <img class="mobicon" width="50px" <?php echo $divmenuMTODAYimg ?> /> </a>
         <a href="#" title="All Items" onclick="window.location.href='SAgroupmain.php'" <?php echo $divmenuMALLITEMS; ?> ><img class="webicon" width="20px" <?php echo $divmenuMALLITEMSimg ?> /><span class="navlabel"> &nbspTask Manager</span> <img class="mobicon" width="50px" <?php echo $divmenuMALLITEMSimg ?> /></a>
       
         <br clear="all"/>
         <a class="toplinks" href='SAusermgmt.php' target='_self' title="Personal Profile"><img src="images/Profile.svg" width="50px" style="vertical-align:middle" />  </a>
         <a class="toplinks" onclick="popup('popUpDiv','invite_friends','')" target='_self' title="Invite Friends"><img src="images/Email.svg" height="50px" style="vertical-align:middle" />  </a>
         <a class="toplinks" href='https://teampod.co.uk/TeamPod/index.php' target='_blank' title="Signout"><img src="images/Logout.svg" height="50px" style="vertical-align:middle" /></a>         
      
      </div>
      <script>
         /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
         var dropdown = document.getElementsByClassName("dropdown-btn");
         var i;
         
         for (i = 0; i < dropdown.length; i++) {
           dropdown[i].addEventListener("click", function() {
           this.classList.toggle("active");
           var dropdownContent = this.nextElementSibling;
           if (dropdownContent.style.display === "block") {
           dropdownContent.style.display = "none";
           } else {
           dropdownContent.style.display = "block";
           }
           });
         }
         
        
         var complex = <?php echo json_encode($AllTasksTagList); ?>;
         if(complex!=null&&complex.length>0){
                 data=complex;
                 $(function() {
                         $(".sTaskTag").autocomplete({
                                 source: data,
                                 focus: function(event, ui) {
                                         // prevent autocomplete from updating the textbox
                                         event.preventDefault();
                                         // manually update the textbox
                                         $(this).val(ui.item.label);
                                 },
                                 select: function(event, ui) {
                                         // prevent autocomplete from updating the textbox
                                         event.preventDefault();
                                         // manually update the textbox and hidden field
                                         $(this).val(ui.item.label);
                                         $(".sTaskTag").val(ui.item.value);
                                         //$("#sTRecRef-value").val(ui.item.value);
                                 }
                         });
                 });
         }
                 
         
        function inviteCheckEmail()
        {
            var letters = /^[a-zA-Z]+(\s{1}[a-zA-Z]+)*$/;  
            var x=document.getElementById('NewUserEmail').value;
            var atpos=x.indexOf("@");
            var dotpos=x.lastIndexOf(".");

            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
              {
          
                alert("Please enter proper email address");
                return false;
                }
                NewUserEmail=document.getElementById('NewUserEmail').value;  
                var dataString = "NewUserEmail=" + NewUserEmail + "&cat=sendInviteEmail" ;
                //alert(dataString);
                $.ajax({  
         		type: "POST",  
         		url: "ajaxcalls.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		   
         		    console.log(response);
         		    alert(response);
                    document.location='ptoday.php';
           		}
            	});
            }
            
       
        function UseLicense()
         {  
            //alert('inside function'); 
            var checkBox = document.getElementById("click");
            //alert(checkBox);
            if (checkBox.checked == true)
            {
                var dataString = "cat=useLicense" ;
                //alert(dataString);
                $.ajax({  
         		type: "POST",  
         		url: "ajaxcalls.php",  
         		data: dataString,
         		success: function(response)
         		{   console.log(response);
         		    //alert(response);
                    document.location='ptoday.php';
           		}
            
                });
            }
         
         }
         
         
         function addtag(rowid) {
             var forid = "sTaskTag"+ rowid;
             tag = document.getElementById(forid).value;
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             if (tag ==="") {
                 alert ("Please enter Tag!");
             } else {
             
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value;    
             
             var dataString = "ForTaskid=" + taskid + "&ForCalid=" + cid + "&tag=" + tag + "&row=" + rowid + "&cat=addtag" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		   // fortagid = "tasktags" + rowid;
         		   // document.getElementById(fortagid).innerHTML =response;
         		     var fordiv='tab-4'+rowid;
                    var activeclass = 'clockstarticon4'+rowid;
                     document.getElementById(fordiv).style.display = "none";
                     $('#'+activeclass).removeClass('active'); 
                     $(".successmsg").html('Tag added Successfully!').fadeIn(500);
         			$(".successmsg").html('Tag added Successfully!').fadeOut(2000);
         			
         			//location.reload();
         		    
         		}
         		
         	});
             }
         }
         
         function removetag(rowid,id) {
             
             var r = confirm("Remove tag?");
             if (r == true) {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             var dataString = "ForTaskid=" + taskid + "&tagid=" + id + "&row=" + rowid + "&cat=removetag" ;
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    fortagid = "tasktags" + rowid;
         		    document.getElementById(fortagid).innerHTML =response;
         		    $(".successmsg").html('Tag Removed!').fadeIn(500);
         			$(".successmsg").html('Tag Removed!').fadeOut(2000);
         		}
         		
         	});
             }
         }
         
         function addstartnote(rowid) {
             var forid = "StartNote"+ rowid;
             note = document.getElementById(forid).value;
             if (note ==="") {
                 alert ("Please enter Notes!");
             } 
             else {
                 
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             noteid = document.getElementById("notid"+rowid).value; 
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
         
             var dataString = "ForTaskid=" + taskid + "&ForCalid=" + cid + "&note=" + note + "&noteid=" + noteid + "&cat=addstartnote" ;
                //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    document.getElementById(forid).value ="";
         		    var fordiv='tab-1'+rowid;
                    var activeclass = 'clockstarticon1'+rowid;
                     document.getElementById(fordiv).style.display = "none";
                     $('#'+activeclass).removeClass('active');                     
                     $(".successmsg").html('Note added Successfully!').fadeIn(500);
         			$(".successmsg").html('Note added Successfully!').fadeOut(2000);
         		    
         		}
         		
         	});
         	
             }
         }
         
         function newnote(rowid) {
             var forid = "NewNote"+ rowid;
             note = document.getElementById(forid).value;
             if (note ==="") {
                 alert ("Please enter Notes!");
             } 
             else {
             noteupTimeTakenid ="noteupTimeTaken"+rowid;    
             noteupTimeTaken = document.getElementById(noteupTimeTakenid).value;
             noteupTimeTaken = noteupTimeTaken.replace(".",":");
             if(noteupTimeTaken.includes(":"))
             {
                 var hour= noteupTimeTaken.substr(0, noteupTimeTaken.indexOf(':')); 
                 var mins= noteupTimeTaken.substr(noteupTimeTaken.indexOf(':')+1,noteupTimeTaken.length);
             }
             else
             {
                 var hour= noteupTimeTaken;
                 var mins = 00;
             }
             if(hour<24 && mins < 60)
             {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value;
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             var dataString = "ForTaskid=" + taskid + "&ForCalid=" + cid + "&noteupTimeTaken=" + noteupTimeTaken + "&note=" + note + "&cat=addnewnote" ;
             //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    document.getElementById(forid).value ="";
         		     var fordiv='tab-6'+rowid;
                    var activeclass = 'clockstarticon6'+rowid;
                     document.getElementById(fordiv).style.display = "none";
                     $('#'+activeclass).removeClass('active'); 
                     $(".successmsg").html('Note added Successfully!').fadeIn(500);
         			$(".successmsg").html('Note added Successfully!').fadeOut(2000);
         		    
         		}
         		
         	});
             }
             else{
                 alert("Hours can't be greater than 23 and Minutes can't be greater than 59. Format to enter time is HH:MM");
                 location.reload();
             }	
             }
         }
         
         function newsubnote(rowid,srowid) {
             var forid = "NewNote"+ rowid + "-" + srowid;
             note = document.getElementById(forid).value;
             if (note ==="") {
                 alert ("Please enter Notes!");
             } 
             else {
             noteupTimeTakenid ="noteupTimeTaken"+rowid+ "-" + srowid;  
             noteupTimeTaken = document.getElementById(noteupTimeTakenid).value;
             noteupTimeTaken = noteupTimeTaken.replace(".",":");
             if(noteupTimeTaken.includes(":"))
             {
                 var hour= noteupTimeTaken.substr(0, noteupTimeTaken.indexOf(':')); 
                 var mins= noteupTimeTaken.substr(noteupTimeTaken.indexOf(':')+1,noteupTimeTaken.length);
             }
             else
             {
                 var hour= noteupTimeTaken;
                 var mins = 00;
             }
             if(hour<24 && mins < 60)
             {    
             forstid = "EditSubTaskRef-"+rowid+"-"+srowid;
             subtaskid = document.getElementById(forstid).value;
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value;
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&ForCalid=" + cid + "&noteupTimeTaken=" + noteupTimeTaken + "&note=" + note + "&cat=addnewsubnote" ;
             //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    document.getElementById(forid).value ="";
         		    document.getElementById("noteupTimeTaken"+rowid+ "-" + srowid).value ="";
         		    var fordiv='sub-tab-4'+rowid+srowid;
                  
                     document.getElementById(fordiv).style.display = "none";
                     var activeclass = 'subaddattach'+rowid+'-'+srowid;
                     $('#'+activeclass).removeClass('active');
                     $(".successmsg").html('Note added Successfully!').fadeIn(500);
         			$(".successmsg").html('Note added Successfully!').fadeOut(2000);
         		    
         		}
         		
         	});
             }
             else{
                 alert("Hours can't be greater than 23 and Minutes can't be greater than 59. Format to enter time is HH:MM");
                 location.reload();
             }
             }
         }
         
         function reassignuser(rowid) {
             var forid = "ForRefUSR"+ rowid;
             userid = document.getElementById(forid).value;
             
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             
             forsid = "EditScheduleRef"+rowid;
             ForScheduleid = document.getElementById(forsid).value;
             
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             foroptid = "reassignopt"+rowid;
             optid = document.getElementById(foroptid).value;
             
             var dataString = "ForTaskid=" + taskid + "&userid=" + userid + "&ForScheduleid=" + ForScheduleid + "&ForCalid=" + cid + "&optid=" + optid + "&cat=reassignuser" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		    var fordiv='divnewuser-'+rowid;
                    
                     //$(".successmsg").html('Reassigned Successfully!').fadeIn(500);
         			//$(".successmsg").html('Reassigned Successfully!').fadeOut(2000);
         		    alert('Reassigned Successfully!');
         		    location.reload();
         		}
         		
         	});
         
         }
         
         function loadsubgrp() {
             group = document.getElementById('MainGroup').value;
             var dataString = "group=" + group + "&cat=loadsubgrp" ;
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{
                    console.log(response);
         			$("#subgroup").html(response);
         		}
         		
         	});
         }
         
         function loadsubgrp1(rowid) {
             group = document.getElementById('eMainGroup'+rowid).value;
             var dataString = "group=" + group + "&cat=loadsubgrp1" ;
             alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{
         			$("#eSubGroup"+rowid).html(response);
         		}
         		
         	});
         }
         
         
         function reassign(rowid) {
          
          var selected = [];
             ForRefUSR = "ForRefUSR"+rowid;
         for (var option of document.getElementById(ForRefUSR).options) {
          if (option.selected) {
             selected.push(option.value);
         }
         }
         selectedusers = "selectedusers"+rowid;
         document.getElementById(selectedusers).value = selected;
         
         fortid = "EditTaskRef"+rowid;
         taskid = document.getElementById(fortid).value; 
             
         forsid = "EditScheduleRef"+rowid;
         ForScheduleid = document.getElementById(forsid).value;
             
         forcid = "EditCalendarRef"+rowid;
         cid = document.getElementById(forcid).value;
         
         foroptid = "reassignopt"+rowid;
         optid = document.getElementById(foroptid).value;
         
         var dataString = "ForTaskid=" + taskid + "&userid=" + selected + "&ForScheduleid=" + ForScheduleid + "&ForCalid=" + cid + "&optid=" + optid +  "&cat=reassign" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		    var fordiv='divnewuser-'+rowid;
                    // document.getElementById(fordiv).style.display = "none";
                      var fordiv='tab-9'+rowid;
                    var activeclass = 'clockstarticon9'+rowid;
                     document.getElementById(fordiv).style.display = "none";
                     $('#'+activeclass).removeClass('active'); 
                     //$(".successmsg").html('Reassigned Successfully!').fadeIn(500);
         			//$(".successmsg").html('Reassigned Successfully!').fadeOut(2000);
         		    alert('Reassigned Successfully!');
         		    location.reload();
         		    //console.log(response);
         		}
         		
         	});
         	
         }
         
         
         function reassignsub(rowid,srowid) {
          
          var selected = [];
             ForRefUSR = "ForRefUSR"+rowid+'-'+srowid;
         for (var option of document.getElementById(ForRefUSR).options) {
          if (option.selected) {
             selected.push(option.value);
         }
         }
         
         forstid = "EditSubTaskRef-"+rowid+'-'+srowid;
         subtaskid = document.getElementById(forstid).value; 
         
         fortid = "EditTaskRef"+rowid;
         taskid = document.getElementById(fortid).value; 
             
         forsid = "EditScheduleRef"+rowid;
         ForScheduleid = document.getElementById(forsid).value;
             
         forcid = "EditCalendarRef"+rowid;
         cid = document.getElementById(forcid).value;
         
         
         var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&userid=" + selected + "&ForScheduleid=" + ForScheduleid + "&ForCalid=" + cid +  "&cat=reassignsub" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		    var fordiv='sub-tab-6'+rowid+srowid;
                  
                     document.getElementById(fordiv).style.display = "none";
                     var activeclass = 'clockstarticon8'+rowid+'-'+srowid;
                     $('#'+activeclass).removeClass('active');
         		    alert('Reassigned Successfully!');
         		   // location.reload();
         		}
         		
         	});
         	
         }
         
         function reassignsubuser(rowid,srowid) {
             var forid = "ForRefUSR"+ rowid +'-'+srowid;
             userid = document.getElementById(forid).value;
             
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             
             forsid = "EditScheduleRef"+rowid;
             ForScheduleid = document.getElementById(forsid).value;
             
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             forstid = "EditSubTaskRef-"+rowid+'-'+srowid;
             subtaskid = document.getElementById(forstid).value; 
             
             var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&userid=" + userid + "&ForScheduleid=" + ForScheduleid + "&ForCalid=" + cid + "&cat=reassignsubuser" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		    var fordiv='divnewuser-'+rowid;
                     document.getElementById(fordiv).style.display = "none";
         		    alert('Reassigned Successfully!');
         		    location.reload();
         		}
         		
         	});
         
         }
         
         
         function addendnote(rowid) {
             var forid = "EndNote"+ rowid;
             note = document.getElementById(forid).value;
             if (note =="") {
                 alert ("Please enter Notes!");
             } 
             else {
                 
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             noteid = document.getElementById("notid"+rowid).value; 
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             
             var dataString = "ForTaskid=" + taskid + "&ForCalid=" + cid + "&note=" + note + "&noteid=" + noteid + "&cat=addendnote" ;
             
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    document.getElementById(forid).value ="";
         		    var fordiv='tab-10'+rowid;
                     document.getElementById(fordiv).style.display = "none";
                     document.getElementById("ntaskid"+rowid).value ="";
                     document.getElementById("notid"+rowid).value ="";
                     var fordiv='clockstarticon1'+rowid;
                    document.getElementById(fordiv).style.display = "none";
                    var fordiv='clockstarticon10'+rowid;
                    document.getElementById(fordiv).style.display = "none";
                    var fordiv='clockstarticon2'+rowid;
                    document.getElementById(fordiv).style.display = "inline";
                     var activeclass = 'clockstarticon2'+rowid;
                     $('#'+activeclass).removeClass('active');   
                     $(".successmsg").html('Note added Successfully!').fadeIn(500);
         			$(".successmsg").html('Note added Successfully!').fadeOut(2000);
         		    
         		}
         		
         	});
         	
             }
         }
         
         
         function addsubendnote(rowid,srowid) {
             var forid = "EndNote"+ rowid+'-'+srowid;
             note = document.getElementById(forid).value;
             if (note =="") {
                 alert ("Please enter Notes!");
             } 
             else {
             
             forstid = "EditSubTaskRef-"+rowid+"-"+srowid;
             subtaskid = document.getElementById(forstid).value; 
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             noteid = document.getElementById("notid"+rowid+"-"+srowid).value; 
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             
             var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&ForCalid=" + cid + "&note=" + note + "&noteid=" + noteid + "&cat=addsubendnote" ;
             //alert(dataString);
             $.ajax({  
         		type: "GET",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    document.getElementById(forid).value ="";
         		     
                     document.getElementById("ntaskid"+rowid+"-"+srowid).value ="";
                     document.getElementById("notid"+rowid+"-"+srowid).value ="";
                     var fordiv='sub-tab-2'+rowid+srowid;
                     document.getElementById(fordiv).style.display = "none";
                     var activeclass = 'endtimeicon'+rowid+'-'+srowid;
                     $('#'+activeclass).removeClass('active');  
                     $(".successmsg").html('Note added Successfully!').fadeIn(500);
         			$(".successmsg").html('Note added Successfully!').fadeOut(2000);
         		    
         		}
         		
         	});
         	
             }
         }
         
         function regroup(rowid) {
             maingroupid = "eMainGroup"+ rowid;
             maingroup = document.getElementById(maingroupid).value;
             subgroupid = "eSubGroup"+ rowid;
             subgroup = document.getElementById(subgroupid).value;
             
             oldmaingroupid = "MainGroup"+ rowid;
             oldmaingroup = document.getElementById(oldmaingroupid).value;
             oldsubgroupid = "SubGroup"+ rowid;
             oldsubgroup = document.getElementById(oldsubgroupid).value;
             
             if (oldmaingroup==maingroup && oldsubgroup==subgroup) {
                 $(".successmsg").html('No Change in Groups!').fadeIn(500);
         		$(".successmsg").html('No Change in Groups!').fadeOut(2000);
             } else {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             
             var dataString = "ForTaskid=" + taskid + "&oldmaingroup=" + oldmaingroup + "&oldsubgroup=" + oldsubgroup + "&maingroup=" + maingroup + "&subgroup=" + subgroup + "&cat=regroup" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    document.getElementById(oldmaingroupid).value =maingroup;
         		    document.getElementById(oldsubgroupid).value =subgroup;
         		   // groupdetails = "groupdetails"+rowid;
         		    //document.getElementById(groupdetails).innerHTML =response;
         		    var fordiv='tab-3'+rowid;
                    var activeclass = 'clockstarticon3'+rowid;
                    document.getElementById(fordiv).style.display = "none";
                    $('#'+activeclass).removeClass('active');  
                    $(".successmsg").html('Regrouped Successfully!').fadeIn(500);
         			$(".successmsg").html('Regrouped Successfully!').fadeOut(2000);
         		}
         		
         	});
             }
         }
         
         function addfile(rowid) {
             sDocNoteid = "sDocNote"+ rowid;
             sDocNote = document.getElementById(sDocNoteid).value;
             
             AttachDocid = "AttachDoc"+ rowid;
             AttachDoc = document.getElementById(AttachDocid).files[0];
             AttachDocid1 = "#AttachDoc"+ rowid;
             //var file_data = $(AttachDocid1).files.files[0];
            
             
             if (sDocNote=="") {
                 alert ("Please enter supporting Notes!");
             } else if (AttachDoc=="") {
                 alert ("Please attach file!");
             } else {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             var file_data = $(AttachDocid1).prop('files')[0];
             var form_data = new FormData();                  
             form_data.append('attachfile', file_data);
             form_data.append('ForTaskid', taskid);
             form_data.append('ForCalid', cid);
             form_data.append('note', sDocNote);
             form_data.append('cat', 'addfile');
             
             //var dataString = "ForTaskid=" + taskid + "&note=" + sDocNote + "&attachfile=" + file_data + "&cat=addfile" ;
         //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: form_data,
         		dataType: 'text', // what to expect back from the PHP script
         		cache: false,
         		contentType: false,
         		processData: false,
         
         		success: function(response)
         		{   
         		    document.getElementById(sDocNoteid).value ="";
         		    document.getElementById(AttachDocid).value ="";
         		     var fordiv='tab-5'+rowid;
                    var activeclass = 'clockstarticon5'+rowid;
                     document.getElementById(fordiv).style.display = "none";
                     $('#'+activeclass).removeClass('active');
                     $(".successmsg").html(response).fadeIn(500);
         			$(".successmsg").html(response).fadeOut(2000);
         			//alert(response);
         		}
         		
         	});
             }
         
         
         }
         
         function addsubfile(rowid,srowid) {
             sDocNoteid = "sDocNote"+ rowid+'-'+srowid;
             sDocNote = document.getElementById(sDocNoteid).value;
             
             AttachDocid = "AttachDoc"+ rowid+'-'+srowid;
             AttachDoc = document.getElementById(AttachDocid).files[0];
             AttachDocid1 = "#AttachDoc"+ rowid+'-'+srowid;
             //var file_data = $(AttachDocid1).files.files[0];
            
             
             if (sDocNote=="") {
                 alert ("Please enter supporting Notes!");
             } else if (AttachDoc=="") {
                 alert ("Please attach file!");
             } else {
             forstid = "EditSubTaskRef-"+rowid+'-'+srowid;
             subtaskid = document.getElementById(forstid).value; 
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             var file_data = $(AttachDocid1).prop('files')[0];
             var form_data = new FormData();                  
             form_data.append('attachfile', file_data);
             form_data.append('ForTaskid', taskid);
             form_data.append('ForSTaskid', subtaskid);
             form_data.append('ForCalid', cid);
             form_data.append('note', sDocNote);
             form_data.append('cat', 'addsubfile');
             
             //var dataString = "ForTaskid=" + taskid + "&note=" + sDocNote + "&attachfile=" + file_data + "&cat=addfile" ;
         //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: form_data,
         		dataType: 'text', // what to expect back from the PHP script
         		cache: false,
         		contentType: false,
         		processData: false,
         
         		success: function(response)
         		{   
         		    document.getElementById(sDocNoteid).value ="";
         		    document.getElementById(AttachDocid).value ="";
         		   var fordiv='sub-tab-3'+rowid+srowid;

                     document.getElementById(fordiv).style.display = "none";
                     var activeclass = 'subaddattach'+rowid+'-'+srowid;
                     $('#'+activeclass).removeClass('active'); 
                     $(".successmsg").html(response).fadeIn(500);
         			$(".successmsg").html(response).fadeOut(2000);
         			//alert(response);
         		}
         		
         	});
             }
         
         
         }
         
         function completetask(rowid) {
             upTimeTaken ="upTimeTaken"+rowid;
             if (document.getElementById(upTimeTaken).value=='')
             {
                 document.getElementById(upTimeTaken).focus();
                 document.getElementById(upTimeTaken).style.borderColor = "red";
                 $(".successmsg").html('Please enter Time taken to complete the task').fadeIn(500);
         		$(".successmsg").html('Please enter Time taken to complete the task').fadeOut(2000);
             } else {
                 document.getElementById(upTimeTaken).style.borderColor = "#999";
             }
             NewCompNote ="NewCompNote"+rowid;
             if (document.getElementById(NewCompNote).value=='')
             {
                 document.getElementById(NewCompNote).focus();
                 document.getElementById(NewCompNote).style.borderColor = "red";
                 $(".successmsg").html('Please enter Notes to complete the task').fadeIn(500);
         		$(".successmsg").html('Please enter Notes taken to complete the task').fadeOut(2000);
             } else {
                 document.getElementById(NewCompNote).style.borderColor = "#999";
             }
             
             if (document.getElementById(upTimeTaken).value!='' && document.getElementById(NewCompNote).value!='')
             {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             forcid = "EditCalendarRef"+rowid;
             calid = document.getElementById(forcid).value; 
             timetaken = document.getElementById(upTimeTaken).value; 
             notes = document.getElementById(NewCompNote).value; 
             timetaken = timetaken.replace(".",":");
             if(timetaken.includes(":"))
             {
                 var hour= timetaken.substr(0, timetaken.indexOf(':')); 
                 var mins= timetaken.substr(timetaken.indexOf(':')+1,timetaken.length);
             }
             else
             {
                 var hour= timetaken;
                 var mins = 00;
             }
             if(hour<24 && mins < 60)
             {
             var dataString = "ForTaskid=" + taskid + "&ForCalid=" + calid + "&upTimeTaken=" + timetaken + "&NewCompNote=" + notes + "&cat=completetask" ;
             //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   

                    location.reload();
         		}
         		
         	});
             }
             else{
                 alert("Hours can't be greater than 23 and Minutes can't be greater than 59. Format to enter time is HH:MM");
                 location.reload();
             }
             }
         }
         
         function completesubtask(rowid,srowid) {
             upTimeTaken ="upTimeTaken"+rowid+'-'+srowid;
             if (document.getElementById(upTimeTaken).value=='')
             {
                 document.getElementById(upTimeTaken).focus();
                 document.getElementById(upTimeTaken).style.borderColor = "red";
                 $(".successmsg").html('Please enter Time taken to complete the Sub task').fadeIn(500);
         		$(".successmsg").html('Please enter Time taken to complete the Sub task').fadeOut(2000);
             } else {
                 document.getElementById(upTimeTaken).style.borderColor = "#999";
             }
             NewCompNote ="NewCompNote"+rowid+'-'+srowid;
             if (document.getElementById(NewCompNote).value=='')
             {
                 document.getElementById(NewCompNote).focus();
                 document.getElementById(NewCompNote).style.borderColor = "red";
                 $(".successmsg").html('Please enter Notes to complete the Sub task').fadeIn(500);
         		$(".successmsg").html('Please enter Notes taken to complete the Sub task').fadeOut(2000);
             } else {
                 document.getElementById(NewCompNote).style.borderColor = "#999";
             }
             
             if (document.getElementById(upTimeTaken).value!='' && document.getElementById(NewCompNote).value!='')
             {
             forstid = "EditSubTaskRef-"+rowid+'-'+srowid;
             subtaskid = document.getElementById(forstid).value; 
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value; 
             forcid = "EditCalendarRef"+rowid;
             calid = document.getElementById(forcid).value; 
             timetaken = document.getElementById(upTimeTaken).value; 
             notes = document.getElementById(NewCompNote).value; 
             timetaken = timetaken.replace(".",":");
             if(timetaken.includes(":"))
             {
                 var hour= timetaken.substr(0, timetaken.indexOf(':')); 
                 var mins= timetaken.substr(timetaken.indexOf(':')+1,timetaken.length);
                // alert(hour);
                 //alert(mins);
             }
             else
             {
                 var hour= timetaken;
                 var mins = 00;
             }
             if(hour<24 && mins < 60)
             {
              var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&ForCalid=" + calid + "&upTimeTaken=" + timetaken + "&NewCompNote=" + notes + "&cat=completesubtask" ;
             //alert(dataString);
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
                    location.reload();
         		}
         		
         	});
             }
             else{
                 alert("Hours can't be greater than 23 and Minutes can't be greater than 59. Format to enter time is HH:MM");
                 location.reload();
             }
             }
         }
         
         function addsubtask() {
         subname= document.getElementById("sTaskName").value;
         if(subname == "") {
             alert("Please enter Sub Task!");
             return false;
         }
         usercount= document.getElementById("usermultiple").value;
         if (usercount > 1) {
         var selected = [];
         for (var option of document.getElementById("ForRefUSRSTsk").options) {
          if (option.selected) {
             selected.push(option.value);
         }
         }
         } else {
             selected = document.getElementById("ForRefUSRSTsk").value;
         }
         
         taskid        = document.getElementById("taskidsub").value;
         subdescr      = document.getElementById("TaskDescription").value;
         priority      = document.getElementById("priority").value;
         ForCalendarid = document.getElementById("calendaridsub").value;
         var dataString = "ForTaskid=" + taskid + "&taskdescr=" + subdescr + "&priority=" + priority + "&ForCalendarid=" + ForCalendarid + "&subname=" + subname + "&selected=" + selected + "&cat=addsubtask" ;
         //alert(dataString);
         $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    //console.log(response);
         		    //popup('popUpDiv');
                     alert('Task updated Successfully!');
                     location.reload();
         		}
         		
         	});
         	
         
         }
         
         function updatetask(taskid) {
             taskdescr = document.getElementById("taskdescr").value;
             priority = document.getElementById("priority").value;
             chkPrivateTaskchk=document.getElementById('chkPrivateTask');
             if (chkPrivateTaskchk.checked == true) { chkPrivateTask ="1"; } else { chkPrivateTask ="0";  } 
             
             var dataString = "ForTaskid=" + taskid + "&taskdescr=" + taskdescr + "&priority=" + priority + "&private=" + chkPrivateTask + "&cat=updatetask" ;
             
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    popup('popUpDiv');
                     alert('Task updated Successfully!');
                     location.reload();
         		}
         		
         	});
         }
         
         function notestyle(style,noteid) {
             note = "note" + noteid;
             document.getElementById(note).style.fontWeight  = "400"; 
             document.getElementById(note).style.color  = "black";
             document.getElementById(note).style.textDecoration = "none";
             document.getElementById(note).style.fontStyle  = "normal"; 
             
             var dataString = "ForTaskNote=" + noteid + "&style=" + style + "&cat=notestyle" ;
             
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		     if (style == "B") { document.getElementById(note).style.fontWeight  = "900";          }
                      if (style == "C") { document.getElementById(note).style.color  = "red";               }
                      if (style == "U") { document.getElementById(note).style.textDecoration = "underline"; }
                      if (style == "I") { document.getElementById(note).style.fontStyle  = "italic";        }
         		}
         	});
             
             
         }
         
         function quicktask(rowid) {
             if (document.getElementById("ForCompany").value=='')
             {
                 document.getElementById("ForCompany").focus();
                 document.getElementById("ForCompany").style.borderColor = "red";
                 alert('Please enter Company to create the task');
             } 
             else if (document.getElementById("sTaskName").value==''){
                 document.getElementById("ForCompany").style.borderColor = "#999";
                 document.getElementById("sTaskName").focus();
                 document.getElementById("sTaskName").style.borderColor = "red";
                 alert('Please enter Task Name to create the task');
             }
             else {
                 document.getElementById("TaskDescription").style.borderColor = "#999";
             task = document.getElementById("sTaskName").value; 
             company = document.getElementById("ForCompany").value; 
             descr = document.getElementById("TaskDescription").value; 
             
             var dataString = "company=" + company + "&task=" + task + "&descr=" + descr + "&cat=quicktask" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    popup('popUpDiv');
                     alert('Task added Successfully!');
                     location.reload();
         		}
         		
         	});
             }
         }
         
         function reschedulefuture(rowid){
             newfstartdate1="StartDate"+rowid;
             newfstartdate = document.getElementById(newfstartdate1).value;
             newfduedate1="DueDate"+rowid;
             newfduedate = document.getElementById(newfduedate1).value;
             if (newfstartdate > newfduedate) {
             alert("Start Date can not be greater than Due Date !");
             }   
             
         }
         
         function reschedulecurrent(rowid) {
             forcid = "EditCalendarRef"+rowid;
             calid = document.getElementById(forcid).value;
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value;
             newsid ="NewStartDate"+rowid;
             newstartdate = document.getElementById(newsid).value;
             newdid ="NewDueDate"+rowid;
             newduedate = document.getElementById(newdid).value;
             
             if (newstartdate > newduedate) {
                 alert("Start Date can not be greater than Due Date !");
         	return false;
             }
             
             oldsid ="OldStartDate"+rowid;
             oldstartdate = document.getElementById(oldsid).value;
             olddid ="OldDueDate"+rowid;
             oldduedate = document.getElementById(olddid).value;
             
             
             var dataString = "ForCalid=" + calid + "&ForTaskid=" + taskid  + "&newstartdate=" + newstartdate + "&newduedate=" + newduedate + "&oldstartdate=" + oldstartdate + "&oldduedate=" + oldduedate + "&cat=reschedulecurrent" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		        alert ('Rescheduled current Task!'); 
         		        location.reload();
         		}
         		
         	});
         }
         
         function showschedule(id,type) {
             a = "divreschdulecurr-"+id;
             b = "divreschdulefuture-"+id;
             document.getElementById(a).style.display = "none";
             document.getElementById(b).style.display = "none";
             
             if (type == "divreschdulecurr" || type == "divreschdulefuture")
             {
             var fordiv=type+'-'+id;
             document.getElementById(fordiv).style.display = "block";
             }
             
             if (type == "removecurrent") {
             var txt;
             var r = confirm("Are you sure, you want to delete current Schedule?");
             if (r == true) {
                 //alert ("You pressed OK!");
                 forcid = "EditCalendarRef"+id;
                 calid = document.getElementById(forcid).value;
                 fortid = "EditTaskRef"+id;
                 taskid = document.getElementById(fortid).value;
                 newstartdate ="NewStartDate"+id;
                 var dataString = "ForCalid=" + calid + "&ForTaskid=" + taskid + "&cat=deletecurrent" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		    if (response.includes("Schedule Deleted")) {
         		        //$(".successmsg").html('Scheduled is Deleted !').fadeIn(500);
         			    //$(".successmsg").html('Scheduled is Deleted !').fadeOut(2000);
         		        alert ('Scheduled is Deleted !'); 
         		        location.reload();
         		    }
         		    else {
         		        alert ('Scheduled is NOT Deleted, please check and try again !');
         		    }
         		    
         		}
         		
         	});
             } 
            }
            
            if (type == "removefuture") {
             var txt;
             var r = confirm("Are you sure, you want to delete all future Schedules?");
             if (r == true) {
                 forcid = "EditCalendarRef"+id;
                 calid = document.getElementById(forcid).value;
                 fortid = "EditTaskRef"+id;
                 taskid = document.getElementById(fortid).value;
                 newstartdate ="NewStartDate"+id;
                 var dataString = "ForCalid=" + calid + "&ForTaskid=" + taskid + "&cat=deletefuture" ;
         
             $.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    
         		    if (response.includes("Schedule Deleted")) {
         		        alert ('All Future Schedules are Deleted !'); 
         		        location.reload();
         		    }
         		    else {
         		        alert ('Schedules are NOT Deleted, please check and try again !');
         		    }
         		    
         		}
         		
         	});
             } 
            }
         }
         
         function selecteduser(id) {
             var selected = [];
             ForRefUSR = "ForRefUSR"+id;
         for (var option of document.getElementById(ForRefUSR).options) {
          if (option.selected) {
             selected.push(option.value);
         }
         }
         selectedusers = "selectedusers"+id;
         btnSaveNewUser = "btnSaveNewUser"+id;
         document.getElementById(selectedusers).value = selected;
         document.getElementById("AddNewBtnClick").value='YES';
         document.getElementById(btnSaveNewUser).value='_';
         document.getElementById("TaskMgmt").submit();
         }
         
         function startclock(divid,tdid) {
            var fordiv='divstarttime-'+tdid;
            document.getElementById(fordiv).style.display = "block";
         }
         
         
         function showdiv(divid,tdid) {
             
             if (divid == "divstarttime") {
             var x = document.getElementsByClassName("ntaskid");
             var i;
             var ntaskid='';
             for (i = 0; i < x.length; i++) {
                 if (x[i].value!="") {
                 ntaskid = x[i].value;
                 }
             }    
             
             if(ntaskid!=""){
                 alert("End the Previously started Task#"+ntaskid+"!");
                 return false;
             }
             }
             
             if (divid == "divcomplete") {
             
             var subtaskcount='subgroupcount-'+tdid;
             a = document.getElementById('subgroupcount-'+tdid).value;    
             if (a > 0) {
                 for (i = 0; i < a; i++) {
                     subgroupstatus= "subgroupstatus-"+tdid+'-'+i;
                     if (document.getElementById(subgroupstatus).value!="Completed") {
                         alert ("Please complete all Sub Task!");
                         return false;
                     }
                 }
             }
             }
             
             var fordiv='divnewdate-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divnewuser-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divnewnote-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divcomplete-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='diveditgroup-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divstarttime-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divendtime-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divedittags-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             var fordiv='divaddattach-'+tdid;
             document.getElementById(fordiv).style.display = "none";
             
             if (divid !="divstarttime") {
         	var fordiv=divid+'-'+tdid;
             document.getElementById(fordiv).style.display = "block";
             } 
             
             if (divid == "divstarttime") {
                 var fordiv='clockstarticon'+tdid;
                 document.getElementById(fordiv).style.display = "inline";
                 var fordiv='starttimeicon'+tdid;
                 document.getElementById(fordiv).style.display = "none";
                 
                 fortid = "EditTaskRef"+tdid;
                 taskid = document.getElementById(fortid).value; 
                 forcid = "EditCalendarRef"+tdid;
                 cid = document.getElementById(forcid).value;
                 var dataString = "ForTaskid=" + taskid + "&ForCalid=" + cid + "&cat=starttime" ;
             
                 $.ajax({  
             		type: "POST",  
             		url: "ptaskload.php",  
             		data: dataString,
             		success: function(response)
             		{   
             		    fornoteid = "notid"+tdid;
             		    noteid = response.substring(response.indexOf("_") + 1);
             		    document.getElementById(fornoteid).value=noteid;
             		    fortaskid = "ntaskid"+tdid;
             		    document.getElementById(fortaskid).value=taskid;
             		    document.getElementById("endtimeicon"+tdid).style.display = "inline";
                         $(".successmsg").html('Task Started Successfully!').fadeIn(500);
             			$(".successmsg").html('Task Started Successfully!').fadeOut(2000);
             		    
             		}
             		
             	});
             	
             
             }
         }
         
         function showsubdiv(divid,tdid,stdid) {
             
             if (divid == "divsubstarttime") {
             var x = document.getElementsByClassName("subntaskid");
             var i;
             var ntaskid='';
             for (i = 0; i < x.length; i++) {
                 if (x[i].value!="") {
                 ntaskid = x[i].value;
                 }
             }    
             
             if(ntaskid!=""){
                 alert("End the Previously started Sub Task#"+ntaskid+"!");
                 return false;
             }
             }
          
          
            
             
             if (divid == "divsubstarttime") {
                 var fordiv='clockstarticon'+tdid+'-'+stdid;;
                 document.getElementById(fordiv).style.display = "inline";
                 var fordiv='starttimeicon'+tdid+'-'+stdid;;
                 document.getElementById(fordiv).style.display = "none";
            
            
                 forstid = "EditSubTaskRef-"+tdid+"-"+stdid;
                 subtaskid = document.getElementById(forstid).value; 
                 fortid = "EditTaskRef"+tdid;
                 taskid = document.getElementById(fortid).value; 
                 forcid = "EditCalendarRef"+tdid;
                 cid = document.getElementById(forcid).value;
                 var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&ForCalid=" + cid + "&cat=substarttime" ;
             
                 $.ajax({  
             		type: "POST",  
             		url: "ptaskload.php",  
             		data: dataString,
             		success: function(response)
             		{   
             		    fornoteid = "notid"+tdid+'-'+stdid;
             		    noteid = response.substring(response.indexOf("_") + 1);
             		    document.getElementById(fornoteid).value=noteid;
             		    fortaskid = "ntaskid"+tdid+'-'+stdid;
             		    document.getElementById(fortaskid).value=subtaskid;
             		    document.getElementById("endtimeicon"+tdid+"-"+stdid).style.display = "inline";
                         $(".successmsg").html('SubTask Started Successfully!').fadeIn(500);
             			$(".successmsg").html('SubTask Started Successfully!').fadeOut(2000);
             		    
             		}
             		
             	});
             	
             
             }
             
         }
         
         /* popup */
         
         function popup(windowname,page,rowid,srowid) {
         	
         	if (page == 'invite_friends') {
         	dataString="cat=invitepopup";
         	//alert(dataString);
         	$.ajax({  
         	    type: "POST",  
         		url: "invitefriends.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    $(".popup").html(response).show();
         		}
         		
         	});
             blanket_size(windowname,page);
           window_pos(windowname);
           toggle('blanket');
           toggle(windowname);
            }
         	
         	if (page == 'addtask') {
         	dataString="cat=quicktaskpopup";
         	$.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    $(".popup").html(response).show();
         		}
         		
         	});
             blanket_size(windowname,page);
           window_pos(windowname);
           toggle('blanket');
           toggle(windowname);
            }
            
            if (page == 'addsubtask') {
         	dataString="ForCalendarid=" + rowid + "&cat=subtaskpopup";
         	$.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
                    document.getElementById("subtaskbox").style.display = "block";
         		    $("#subtaskbox").html(response);

         		}
         		
         	});
            }
            
            if (page == 'tasknotes') {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value;
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             
             var dataString = "ForTaskid=" + taskid + "&ForCalid=" + cid + "&cat=tasknotes";
         	$.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    $(".popup").html(response).show();
         		}
         		
         	});
         	 blanket_size(windowname,page);
           window_pos(windowname);
           toggle('blanket');
           toggle(windowname);
            }
            if (page == 'subtasknotes') {
             fortid = "EditTaskRef"+rowid;
             taskid = document.getElementById(fortid).value;
             forcid = "EditCalendarRef"+rowid;
             cid = document.getElementById(forcid).value;
             forstid = "EditSubTaskRef-"+rowid+'-'+srowid;
             staskid = document.getElementById(forstid).value;
             
             var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + staskid + "&ForCalid=" + cid + "&cat=subtasknotes";
         	$.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    $(".popup").html(response).show();
         		}
         		
         	});
         	 blanket_size(windowname,page);
           window_pos(windowname);
           toggle('blanket');
           toggle(windowname);
            }
            
            if (page == 'calendar') {
            
             
             var dataString = "ForTaskid=" + rowid + "&cat=tasknotes";
         	$.ajax({  
         		type: "POST",  
         		url: "ptaskload.php",  
         		data: dataString,
         		success: function(response)
         		{   
         		    $(".popup").html(response).show();
         		}
         		
         	});
         	 blanket_size(windowname,page);
           window_pos(windowname);
           toggle('blanket');
           toggle(windowname);
            }
            
          	
         	
         }
         function toggle(div_id) {
         	var el = document.getElementById(div_id);
         	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
         	else {el.style.display = 'none';}
         }
         
         function blanket_size(popUpDivVar,page) {
         
         	if (typeof window.innerWidth != 'undefined') {
         		viewportheight = window.innerHeight;
         	} else {
         		viewportheight = document.documentElement.clientHeight;
         	}
         	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
         		blanket_height = viewportheight;
         	} else {
         		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
         			blanket_height = document.body.parentNode.clientHeight;
         		} else {
         			blanket_height = document.body.parentNode.scrollHeight;
         		}
         	}
         	var blanket = document.getElementById('blanket');
         	blanket.style.height = blanket_height + 'px';
         	var popUpDiv = document.getElementById(popUpDivVar);
         	popUpDiv_height=blanket_height/2-200;//100 is half popup's height
         	popUpDiv.style.top = '100px';
         	popUpDiv.style.left = '400px';
         	
         }
         function window_pos(popUpDivVar) {
         	if (typeof window.innerWidth != 'undefined') {
         		viewportwidth = window.innerHeight;
         	} else {
         		viewportwidth = document.documentElement.clientHeight;
         	}
         	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
         		window_width = viewportwidth;
         	} else {
         		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
         			window_width = document.body.parentNode.clientWidth;
         		} else {
         			window_width = document.body.parentNode.scrollWidth;
         		}
         	}
         	var popUpDiv = document.getElementById(popUpDivVar);
         	//window_width=window_width/2-250;//250 is half popup's width
         	
         	if (window_width < 900){
         	popUpDiv.style.left = '60px';
         	} else {
         	    popUpDiv.style.left = '200px';
         	}
         }
         
         let clock = () => {
           let date = new Date();
           let hrs = date.getHours();
           let mins = date.getMinutes();
           let secs = date.getSeconds();
           let period = "AM";
           if (hrs == 0) {
             hrs = 12;
           } else if (hrs >= 12) {
             hrs = hrs - 12;
             period = "PM";
           }
           hrs = hrs < 10 ? "0" + hrs : hrs;
           mins = mins < 10 ? "0" + mins : mins;
           secs = secs < 10 ? "0" + secs : secs;
         
           let time = `${hrs}:${mins}:${secs}:${period}`;
           document.getElementById("clock").innerHTML = time;
           setTimeout(clock, 1000);
         };
         
         function closefilter() {
             document.getElementById("sidenav1").style.display = "none";
         }
         function openfilter() {
             document.getElementById("sidenav1").style.display = "block";
         }

        function subbox(id) {
             document.getElementById("subtaskbox").style.display = "block";
             $("#task_id").html(id);
         }

         function tasknotes() {
             document.getElementById("tasknotes").style.display = "block";
             
         }
        

         function subtasknotes(id) {
             document.getElementById("subtasknotes").style.display = "block";
             
         }
          function subtasknotesclosefilter() {
             document.getElementById("subtasknotes").style.display = "none";
         }

         function quickboxclosefilter() {
             document.getElementById("quickbox1").style.display = "none";
         }

         function subtaskclosefilter() {
             document.getElementById("subtaskbox").style.display = "none";
         }
         function quickboxfilter() {
             document.getElementById("quickbox1").style.display = "block";
         }
         //clock();
         
           function fnTypeFilterRow() {
           var input, filter, table, tr, td, i, txtValue;
               input = document.getElementById("myInput");
               var countcell = $("#CountCells").val();

               filter = input.value.toUpperCase();
               var a = 0;
               var b = 0;
               var c = 0;
               if(input!=""){
                    for (var i=0;i<countcell;i++){  
                        var text = $("#title"+i).html();
                        var main = $("#maintask"+i).html();
                        var result = text.toLowerCase();
                        var result1 = main.toLowerCase();
                        var input1 = filter.toLowerCase();
                        var  position1 = result.search(input1);
                        var  position2 = result1.search(input1);
                        if(parseInt(position1)+parseInt(position2) >= 0 ){
                            $("#dv-"+i).removeClass("hide1");
                            $("#dv-"+i).addClass("show1");
                            if($("#dv-"+i).attr('class')=="maintab-box show1"||$("#dv-"+i).attr('class')=="maintab-box t1 show1"){
                                a = parseInt(a)+1;
                            }
                            if($("#dv-"+i).attr('class')=="maintab-box t2 show1"){
                                b = parseInt(b)+1;
                            }
                            if($("#dv-"+i).attr('class')=="maintab-box t3 show1"){
                                c = parseInt(c)+1;
                            }
                            

                        }else if(position1==0||position2==0){
                            $("#dv-"+i).removeClass("hide1");
                            $("#dv-"+i).addClass("show1"); 
                             if($("#dv-"+i).attr('class')=="maintab-box show1"||$("#dv-"+i).attr('class')=="maintab-box t1 show1"){
                                a = parseInt(a)+1;
                            }
                            if($("#dv-"+i).attr('class')=="maintab-box t2 show1"){
                               b = parseInt(b)+1;
                            }
                            if($("#dv-"+i).attr('class')=="maintab-box t3 show1"){
                                c = parseInt(c)+1;
                            }
                            console.log($("#dv-"+i).attr('class'));
                        }else{
                            $("#dv-"+i).removeClass("show1");
                            $("#dv-"+i).addClass("hide1");
                        }

                         
                            var items = $(".t1 show1");
                            var numItems = items.length;
                            var perPage = 20;

                            items.slice(perPage).hide();

                            $('#pagination-container2').pagination({
                                items: numItems,
                                itemsOnPage: perPage,
                                prevText: "&laquo;",
                                nextText: "&raquo;",
                                onPageClick: function (pageNumber) {
                                    var showFrom = perPage * (pageNumber - 1);
                                    var showTo = showFrom + perPage;
                                    items.hide().slice(showFrom, showTo).show();
                                }
                            });

                            var items2 = $(".t3 show1");
    var numItems2 = items2.length;
    var perPage2 = 20;

    items2.slice(perPage2).hide();

    $('#pagination-container3').pagination({
        items: numItems2,
        itemsOnPage: perPage2,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber2) {
            var showFrom2 = perPage2 * (pageNumber2 - 1);
            var showTo2 = showFrom2 + perPage2;
            items2.hide().slice(showFrom2, showTo2).show();
        }
    });

     var items1 = $(".t2 show1");
    var numItems1 = items1.length;
    var perPage1 = 20;

    items1.slice(perPage1).hide();

    $('#pagination-container1').pagination({
        items: numItems1,
        itemsOnPage: perPage1,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber1) {
            var showFrom1 = perPage1 * (pageNumber1 - 1);
            var showTo1 = showFrom1 + perPage1;
            items1.hide().slice(showFrom1, showTo1).show();
        }
    });


                            $("#odcount").html(a);
                            $("#tdcount").html(b);
                            $("#tmcount").html(c);

                        
               }else{
                  for (var i=0;i<countcell;i++){  
                     $("#dv-"+i).css("display","block");
                  }
               }
         }
      </script>
   </body>
   <html>
      <!--css popup window 1-->
      <div style="display: none;" id="blanket"></div>
      <div style="display: none;" id="popUpDiv">
         <a href="" ><img style="float:right" alt="" src="images/Close.svg" /></a><br /><br />
         <div class="popup"></div>
      </div>
      <!--css popup window 1 close-->