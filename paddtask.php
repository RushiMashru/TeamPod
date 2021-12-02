<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
   error_reporting (E_ALL ^ E_NOTICE);
   include("taskheader.php");
   
   //echo 'print coockies= '; print_r($_COOKIE);
   if(isset($_COOKIE["name"]))           { $loginame=$_COOKIE["name"]; }
   if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
   if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }
   //echo '<br>UserID='.$id.'...UserName='.$loginame.'...SysAdmin='.$CanSystemAdmin.'...AccessLevel='.$AccessLevel ;
   GLOBAL $AccessLevel;
   
   $AllTasksNameList = array();                                           
       $query1="SELECT distinct `TaskGroup`, `TaskTitle` FROM `tTasks` WHERE Status='ACT' ORDER BY `TaskTitle`";
       $sql1 = mysqli_query($mysqli, $query1);
       while($row1=mysqli_fetch_array($sql1))                        
       {
           $AllTasksNameList[]=array(
               'value'=>'',
              // 'label'=> ucfirst(strtolower($row1['TaskGroup']))." - ".ucfirst(strtolower($row1['TaskTitle']))
               'label'=> ucfirst(strtolower($row1['TaskTitle']))
               );
       } 
                   
   ?>
<html>
   <head>
      <title>Tasks On Cloud</title>
      <meta charset="UTF-8">
      <link rel="shortcut icon" type="image/png" href="../images/icontask.png"/>
      <link rel="stylesheet" type="text/css" href="../focinc/newstyle.css">
      </link>
      <!--Requirement jQuery-->
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <!--Load Script and Stylesheet -->
      <script type="text/javascript" src="jquery.simple-dtpicker.js"></script>
      <link type="text/css" href="jquery.simple-dtpicker.css" rel="stylesheet" />
      <!---->
      <!-- --------------- START Auto Complete Text from Array -->
      <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-darkness/jquery-ui.min.css" rel="stylesheet">
      <!-- DO NOT USE, As it is already used in Date Validation <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  -->
      <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
      <script>
         var complex = <?php echo json_encode($AllTasksNameList); ?>;
         data=complex;
         $(function() {
                 $("#sTaskName").autocomplete({
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
                                 $("#sTRecRef").val(ui.item.value);
                                 //$("#sTRecRef-value").val(ui.item.value);
                         }
                 });
         });
         
         var complex2 = <?php echo json_encode($AllTasksGroupList); ?>;
         data2=complex2;
         $(function() {
                 $("#sTaskGroup").autocomplete({
                         source: data2,
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
                                 $("#sTaskGroup").val(ui.item.value);
                                 //$("#sTaskGroup-value").val(ui.item.value);
                         }
                 });
         });
         
         
      </script>
      <!-- --------------- END Auto Complete Text from Array -->
      <script>
         $(document).ready(function(){
             $('#RepeatSchedule').on('change', function() {
                $(".card").css("height","818px");
               if ( this.value == 'Weekly')
                 { 
                     $(".card").css("height","880px");
                     $("#DivSelectDay").css("display","flex"); 
                     var my_date  = document.getElementById('StartDate').value;
                      my_date = my_date.substr(3, 2)+"-"+my_date.substr(0, 2)+"-"+my_date.substr(6);
                     var d = new Date(my_date);
                     day = d.getDay();
                     
                     //var my_date = "2014-06-03 07:59:48";
                     //my_date = my_date.replace(/-/g, "/"); 
                     
                     
                      var ele=document.getElementsByName('cbxDays[]');  
                         for(var i=0; i<ele.length; i++){  
                             if (i==day-1) {
                             ele[i].checked=true;  
                             }
                             //alert (ele[i].value)
                         }
                         if (day==0) {
                             ele[6].checked=true;
                         }
                     
                 }
               else
                 { $("#DivSelectDay").css("display","none"); }
               if ( this.value == '')
                   { $("#DivSelectRepeat").css("display","flex"); }
               else
                   { $("#DivSelectRepeat").show(); }
               if ( this.value == 'Daily') { document.getElementById('LblTextNext').innerHTML = 'DAYs' ;}
               if ( this.value == 'Weekly') { document.getElementById('LblTextNext').innerHTML = 'WEEKs' ;}
               if ( this.value == 'Monthly') { document.getElementById('LblTextNext').innerHTML = 'MONTHs' ;}
               if ( this.value == 'Yearly') { document.getElementById('LblTextNext').innerHTML = 'YEARs' ;}
                 
             });
         });       
         
         
         function validtask()
         {
             var v1 = document.getElementById('sTRecRef').value;
             //alert ('ID '+v1);
             if (v1=='')
             {
                 document.getElementById('DivNewTgroup').style.display = 'block';
             }
         }
         
         
         function validate1()
         {
             //var sdt = new Date(StartDate);
             //var ddt = new Date(DueDate);
         
             //alert ('SDT='+sdt);
         
         
             if (document.getElementById('ForCompany').value=='' || document.getElementById('ForCompany').value=='ALL')
             {
                 document.getElementById("ForCompany").focus();   document.getElementById("ForCompany").style.borderColor = "red";
                 document.getElementById('LblErrorMessage').innerHTML = 'Please select Company !' ;
                 return false;
             }
             if (document.getElementById('ForRefUSR').value=='' || document.getElementById('ForRefUSR').value=='ALL')
             {
                 document.getElementById("ForRefUSR").focus();   document.getElementById("ForRefUSR").style.borderColor = "red";
                 document.getElementById('LblErrorMessage').innerHTML = 'Please select assign to user !' ;
                 return false;
             }
             
             if (document.getElementById('sTaskName').value=='')
             {
                 document.getElementById("sTaskName").focus();   document.getElementById("sTaskName").style.borderColor = "red";
                 document.getElementById('LblErrorMessage').innerHTML = 'Please enter task title !' ;
                 return false;
             }
         
             stdt = document.getElementById('StartDate').value;
             dudt = document.getElementById('DueDate').value;
         /*    if (stdt > dudt) {
                 alert("Start Date can not be greater than Due Date !");
                 StartDate.style.borderColor = "red";
                 DueDate.style.borderColor = "red";
            return false;
             }
           CHECK WHY NOT WORKING */ 
             
             //alert ('YES');
         
         var selected = [];
         for (var option of document.getElementById('ForRefUSR').options) {
          if (option.selected) {
             selected.push(option.value);
         }
         }
         
         var awdays =[];
         var checkboxes = document.querySelectorAll('#cbxDays:checked')
         
         for (var i = 0; i < checkboxes.length; i++) {
           awdays.push(checkboxes[i].value)
         }
         
         document.getElementById('ForRefUSR1').value = selected;
         document.getElementById('LblErrorMessage').innerHTML = '' ;
         // document.getElementById('AddNewBtnClick').value='YESADDNEW';
         // document.getElementById("TaskMgmt").submit();   
         
         ForCompany=document.getElementById('ForCompany').value;
         sTaskName=document.getElementById('sTaskName').value;
         sTRecRef=document.getElementById('sTRecRef').value;
         MainGroup=document.getElementById('MainGroup').value;
         SubGroup=document.getElementById('SubGroup').value;
         TaskDescription=document.getElementById('TaskDescription').value;
         ForRefUSR1=selected;
         chkPrivateTaskchk=document.getElementById('chkPrivateTask');
         if (chkPrivateTaskchk.checked == true) { chkPrivateTask ="1"; } else { chkPrivateTask ="0";  } 
         StartDate=document.getElementById('StartDate').value;
         DueDate=document.getElementById('DueDate').value;
         RepeatSchedule=document.getElementById('RepeatSchedule').value;
         NextAfter=document.getElementById('NextAfter').value;
         var ele = document.getElementsByName('radioNoOfTimes');
         for(i = 0; i < ele.length; i++) {
             if(ele[i].checked)
             {
             radioNoOfTimes=ele[i].value;
             }
         }
         //radioNoOfTimes=document.getElementById('radioNoOfTimes').value;     
         EndAfterOccur=document.getElementById('EndAfterOccur').value;
         EndByDate=document.getElementById('EndByDate').value;
         Priority=document.getElementById('priority').value;
         
         
         var dataString = "ForCompany=" + ForCompany + "&sTaskName=" + sTaskName + "&sTRecRef=" + sTRecRef + "&MainGroup=" + MainGroup + "&SubGroup=" + SubGroup + "&Priority=" + Priority + "&TaskDescription=" + TaskDescription + "&ForRefUSR1=" + ForRefUSR1 + "&chkPrivateTask=" + chkPrivateTask + "&StartDate=" + StartDate + "&DueDate=" + DueDate + "&RepeatSchedule=" + RepeatSchedule + "&awdays=" + awdays + "&NextAfter=" + NextAfter + "&radioNoOfTimes=" + radioNoOfTimes + "&EndAfterOccur=" + EndAfterOccur + "&EndByDate=" + EndByDate + "&cat=createtask" ;
         
         $.ajax({  
                type: "POST",  
                url: "ptaskload.php",  
                data: dataString,
                success: function(response)
                {
                    //alert(response);
                    
                    if (response.includes("Tasks is Scheduled")) {
                        alert ('Tasks is Scheduled !'); 
                        document.location='paddtask.php';
                    }
                    else {
                        alert ('Tasks is NOT Scheduled, please check criteria and try again !');
                    }
                    
                }
                
            });
         
         
         }
         
         function loadusers() {
             company = document.getElementById('ForCompany').value;
             var dataString = "company=" + company + "&cat=loadusers" ;
             $.ajax({  
                type: "POST",  
                url: "ptaskload.php",  
                data: dataString,
                success: function(response)
                {
                    $("#userselect").html(response);
                }
                
            });
         }
         
         function SetWeekdays() {
             var my_date  = document.getElementById('StartDate').value;
                      my_date = my_date.substr(3, 2)+"-"+my_date.substr(0, 2)+"-"+my_date.substr(6);
                     var d = new Date(my_date);
                     day = d.getDay();
                     
                      var ele=document.getElementsByName('cbxDays[]');  
                         for(var i=0; i<ele.length; i++){  
                         if (i==day-1) {
                             ele[i].checked=true;  
                             }
                             else {
                             ele[i].checked=false;      
                             }
                         }
                         if (day==0) {
                             ele[6].checked=true;
                         }
         }
      </script>
   </head>
   <style type="text/css">
      .card {
      grid-template-rows: 1fr auto max-content;
      width: 99%;
      height: 745px;
      aspect-ratio: 1 / 1.5;
      background: #fff;
      border-radius: 24px;
      overflow: hidden;
      margin-top: 18px;

      box-shadow: 0 1px 2px 0px rgb(0 0 0 / 20%), 0 2px 4px 0px rgb(0 0 0 / 20%), 0 4px 8px 0px rgb(0 0 0 / 20%), 0 8px 16px 0px rgb(0 0 0 / 7%), 0 16px 32px 0px rgb(0 0 0 / 13%), 0 32px 48px 0px rgb(0 0 0 / 20%);
      }
      .card-header {
      display: grid;
      position: relative;
      border-bottom: 2px solid #e2e2e2;
      text-align: left;
      color: #e74c3c;
      font-weight: bold;
      font-size: 18px;
      margin-left: 15px;
      }
      .card-header::before {
      content: "";
      position: absolute;
      display: flex;
      inset: 0;
      transition: transform 300ms ease;
      }
      .card-header:hover::before {
      transform: scale(1.2);
      transition: transform 266ms linear;
      }
      .title {
      text-align: center;
      width: 12ch;
      text-transform: uppercase;
      font-weight: 800;
      line-height: 1.2;
      font-size: 2.6rem;
      margin: auto;
      -webkit-text-stroke: 1.5px #0005;
      color: hsla(0, 100%, 100%, 0.8);
      text-shadow: 2px 2px 1px #0001, 2px 3px 2px #0002, 3px 4px 3px #0003,
      3px 5px 5px #0003, 4px 5px 7px #0004, 4px 6px 10px #0005;
      transform: rotate(-10deg);
      }
      .title:first-letter {
      color: hsla(0, 100%, 100%, 0.8);
      text-shadow: 3px 3px 0px teal;
      font-size: 1.5em;
      }
      .card-content {
      display: grid;
      grid-template-rows: repeat(3, 1fr);
      }
      .card-content,
      .card-footer {
      margin-inline: 1rem;
      }
      .card-footer {
      align-self: end;
      margin-block-end: 2rem;
      }
      .secondary-title {
      width: max-content;
      text-transform: capitalize;
      font-weight: 400;
      color: #444;
      font-size: 1.6rem;
      margin-block: 1rem 2rem;
      position: relative;
      }
      .secondary-title::before {
      content: "";
      position: absolute;
      display: inline-flex;
      width: calc(100% + 0.5em);
      top: 2.5rem;
      border-bottom: 3px solid teal;
      }
      .text {
      color: #0008;
      font-size: 0.9rem;
      line-height: 1.3;
      font-weight: 300;
      max-width: 28ch;
      }
      .quick_content {
      display: flex;
      justify-content: center;
      width: 576px;
      color: #f2f2f2;
      height: 900px;
      }
      .col-md-6{
      width: 50%;
      }
      .col-md-12{
      width: 100%;
      }
      .wrapper {
      padding: 25px 14px;
      }
      .wrapper .title h2 {
      text-align: center;
      font-size: 40px;
      margin-bottom: 22px;
      }
      .wrapper .p-one p {
      color: #95959d;
      padding: 0 10px;
      text-align: center;
      font-size: 14px;
      margin-bottom: 50px;
      }
      .wrapper .inp {
      position: relative;
      }
      .wrapper .inp {
      display: flex;
      flex-direction: column;
      }
      .wrapper .inp select {
      border: 0;
      border: 1px solid #e6e6e6;
      width: 100%;
      outline: none;
      height: 51px;
      padding: 0 20px;
      border-radius: 4px;
      background-image: url(data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20256%20448%22%20enable-background%3D%22new%200%200%20256%20448%22%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E.arrow%7Bfill%3A%23424242%3B%7D%3C%2Fstyle%3E%3Cpath%20class%3D%22arrow%22%20d%3D%22M255.9%20168c0-4.2-1.6-7.9-4.8-11.2-3.2-3.2-6.9-4.8-11.2-4.8H16c-4.2%200-7.9%201.6-11.2%204.8S0%20163.8%200%20168c0%204.4%201.6%208.2%204.8%2011.4l112%20112c3.1%203.1%206.8%204.6%2011.2%204.6%204.4%200%208.2-1.5%2011.4-4.6l112-112c3-3.2%204.5-7%204.5-11.4z%22%2F%3E%3C%2Fsvg%3E%0A);
      background-position: right 10px center;
      background-repeat: no-repeat;
      background-size: auto 50%;
      border-radius: 2px;
      padding: 10px 30px 10px 10px;
      outline: none;
      -moz-appearance: none;
      -webkit-appearance: none;
      appearance: none;
      }
      .wrapper .inp select:focus {
      border: 1px solid #e0e3ff;
      }
      .wrapper .inp select::placeholder {
      color: #a5a4ac;
      font-size: 12px;
      }
      .wrapper .inp label.email {
      position: absolute;
      left: 12px;
      top: -8px;
      color: #737373;
      font-size: 12px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
      .wrapper .inp::before {
      position: absolute;
      content: "";
      background-color: rgb(255, 255, 255);
      left: 10px;
      width: 54px;
      height: 21px;
      top: -10px;
      }
      .wrapper .inp i.email {
      position: absolute;
      right: 18px;
      top: 17.5px;
      font-size: 20px;
      color: #cfcfd3;
      }
      .wrapper .inp .email-margin {
      margin-bottom: 40px;
      }
      /* inp-email-end */
      /* inp-pass-start */
      .wrapper .inp label.pass {
      position: absolute;
      top: 80px;
      left: 20px;
      z-index: 2;
      color: #95959d;
      }
      .wrapper .inp::after {
      position: absolute;
      content: "";
      background-color: rgb(255, 255, 255);
      left: 12px;
      width: 87px;
      height: 0px;
      top: 79px;
      }
      .wrapper .inp i.lock {
      position: absolute;
      bottom: 15.3px;
      right: 20px;
      font-size: 20px;
      color: #cfcfd3;
      }
      /* inp-pass-end */
      /* btn-start */
      .wrapper .button {
      display: flex;
      justify-content: center;
      }
      .wrapper .button .btn {
      margin-top: 50px;
      border: 0;
      width: 100%;
      height: 60px;
      background-color: rgb(32, 40, 235);
      color: #fff;
      border-radius: 4px;
      font-size: 16px;
      margin-bottom: 26px;
      cursor: pointer;
      }
      .wrapper .button .btn:hover {
      box-shadow: 1px 1px 20px rgba(32, 40, 235, 0.2);
      }
      /* btn-end */
      /* line-start */
      .wrapper .line {
      width: 100%;
      text-align: center;
      border-bottom: 1px solid #f0f1ff;
      line-height: 0.1em;
      margin: 30px;
      margin-bottom: 40px;
      margin-left: 0%;
      }
      .wrapper .line span {
      background: #fff;
      padding: 0 10px;
      color: #afafb5;
      font-size: 14px;
      }
      .wrapper .icon-wrapper {
      display: flex;
      justify-content: space-between;
      /* align-items: center; */
      }
      .wrapper .icon-wrapper .google,
      .wrapper .icon-wrapper .facebook,
      .wrapper .icon-wrapper .apple {
      width: 100px;
      height: 50px;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 4px;
      font-size: 22px;
      border: 1px solid #d9dcff;
      margin-bottom: 30px;
      cursor: pointer;
      }
      .wrapper .icon-wrapper .google:hover {
      box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
      }
      .wrapper .icon-wrapper .facebook:hover {
      box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
      }
      .wrapper .icon-wrapper .apple:hover {
      box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;      }
      /* icon-wrapper-end */
      /* down-start */
      .wrapper .down {
      text-align: center;
      font-size: 14px;
      }
      .wrapper .down span {
      color: #b8b7be;
      }
      label.task_name {
      position: absolute;
      left: 12px;
      top: -10px;
      color: #737373;
      font-size: 12px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
      input#sTaskName {
      border: 0;
      border: 1px solid #e6e6e6;
      width: 100%;
      outline: none;
      height: 51px;
      padding: 0 20px;
      border-radius: 4px;
      color: #333333;
      font-size: 16px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
      input[type='date'] {
      border: 0;
      border: 1px solid #e6e6e6;
      width: 100%;
      outline: none;
      height: 51px;
      padding: 0 20px;
      border-radius: 4px;
      color: #333333;
      font-size: 16px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
      input[type='text'] {
      border: 0;
      border: 1px solid #e6e6e6;
      width: 100%;
      outline: none;
      height: 51px;
      padding: 0 20px;
      border-radius: 4px;
      color: #333333;
      font-size: 16px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
       input[type='radio'] {
          margin-top: 15px;
       }
      label.description {
      position: absolute;
      left: 12px;
      top: -10px;
      color: #737373;
      font-size: 12px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
      textarea {
      border: 0;
      resize: vertical;
      border: 1px solid #e6e6e6;
      width: 100%;
      outline: none;
      height: 200px;
      padding: 8px 20px;
      border-radius: 4px;
      color: #333333;
      font-size: 16px;
      font-family: 'Source Sans Pro';
      font-weight: normal;
      }
      button.fr.btn-save {
      margin-right: 15px;
      }
      .col-md-5{
      width: 48%;
      float: right;
      }
      .fl{
      float: left;
      }
      .mb-30{
      margin-bottom: 18px;
      }
      .form-group {
      display: inline-flex;
      margin-bottom: 15px;
      width: 100%;
      margin-right: 15px;
      }
      .form-group input {
      padding: 0;
      height: initial;
      width: initial;
      margin-bottom: 0;
      display: none;
      cursor: pointer;
      }
      .form-group label {
      position: relative;
      cursor: pointer;

      }
      .form-group input:checked + label:before {
      content: '';
      -webkit-appearance: none;
      background-color: #f7d991;
      border: 2px solid #f7d991;
      box-shadow: 0 1px 2px rgb(0 0 0 / 5%), inset 0px -15px 10px -12px rgb(0 0 0 / 5%);
      padding: 10px;
      display: inline-block;
      position: relative;
      vertical-align: middle;
      cursor: pointer;
      margin-right: 5px;
      }
      .form-group  label:before {
      content: '';
      -webkit-appearance: none;
      background-color: white;
      border: 2px solid #cecbc6;
      box-shadow: 0 1px 2px rgb(0 0 0 / 5%), inset 0px -15px 10px -12px rgb(0 0 0 / 5%);
      padding: 10px;
      display: inline-block;
      position: relative;
      vertical-align: middle;
      cursor: pointer;
      margin-right: 10px;
      }
      .form-group input:checked + label:after {
      content: '';
      display: block;
      position: absolute;
      top: 4px;
      left: 8px;
      width: 6px;
      height: 10px;
      padding: -1px;
      border: 1px solid #e74c3c;
      border-width: 0 3px 3px 0;
      transform: rotate(
      41deg);
      }
      .btn-save{
      color: white;
      background: #e74c3c;
      border: 1px solid #e74c3c;
      border-radius: 35%;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 1px;
      line-height: 15px;
      width: 183px;
      height: 40px;
      border-radius: 24px;
      transition: all 0.3s ease 0s;
      font-family: 'Source Sans Pro', sans-serif;
      }
        .col-md-3 {
            width: 20%;
        }

        .extrarow{
            display: flex;
        }
        #DivSelectDay{
            list-style: none;
            display: flex;
            padding-left: 0px;
        }
        .input-container {
       display: flex;
    width: 100%;
    margin-bottom: 15px;
    flex-direction: inherit !important;
    position: relative;
}
.icon {
    padding: 16px 5px;
    background: #e74c3c;
    color: white;
    min-width: 100px;
    text-align: center;
}
.input-field {
    width: 100%;
    padding: 10px;
    outline: none;

}
.col-md-7 {
    width: 42%;
}
input#StartDate{
    border-right: none;
}
input#DueDate{
    border-right: none;
}
button.btn.btn-outline-secondary.border-left-0 {
    position: absolute;
    height: 50px;
    border-radius: unset;
    border-left: none;
    background: white;
    border-color: #e6e6e6;
}
.gj-datepicker-bootstrap [role=right-icon] button .gj-icon, .gj-datepicker-bootstrap [role=right-icon] button .material-icons {
    position: absolute;
    font-size: 21px;
    top: 14px;
    left: 8px;
}
.gj-datepicker.gj-datepicker-bootstrap.gj-unselectable.input-group {
    margin-right: 40px;
}
   </style>
   <body>
      <div class="maindiv" id="wrapper" style="margin-left:16%;width:84%;margin-top:10px">
      <div id="floatleft" style="width:100%;float:left">
      <main class="card">
         <div class="card-header">
            <p>Task Details</p>
         </div>
         <input type=hidden name="AddNewBtnClick" id="AddNewBtnClick" value="" />
         <article class="card-content">
            <div class="wrapper">
               <div class="col-md-12">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="ForCompany"> Company</label>
                        <select name="ForCompany" id="ForCompany" onchange="loadusers()">
                           <option value="">-- Select a Company --</option>
                           <?php  
                              $maxcompanycode = sizeof($CompanyCode_arr);
                              $i=0; 
                              while($i<$maxcompanycode)
                              {   
                                  $valueof= $CompanyCode_arr[$i][0] ;
                                  ?>    
                           <option value="<?php echo $valueof ?>"> <?php echo $CompanyCode_arr[$i][2] ?> </option>
                           <?php  $i++; } ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-5 mb-30">
                    <input type=hidden name="ForRefUSR1" id="ForRefUSR1" value="<?php echo $ForRefUSR1; ?>" />
                     <div class="inp"  id="userselect">
                        <label class="email" for="ForRefUSR"> Assign To</label>
                        <select   name="ForRefUSR" id="ForRefUSR"  onChange ="checkedvalues()" >
                           <!-- onChange ="checkedvalues()" -->
                           <option value="">-- Select a Person --</option>
                        </select>
                        
                        <script>
                           document.multiselect('#ForRefUSR')
                           .setCheckBoxClick("checkboxAll", function(target, args) {
                               console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
                           })
                           .setCheckBoxClick("1", function(target, args) {
                               console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
                           });
                        </script>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="sTaskName">Task Title</label>
                        <input type="text" name="sTaskName" id="sTaskName" value="<?php echo $sTaskName; ?>">
                        <input type=hidden name="sTRecRef" id="sTRecRef" value="<?php echo $sTRecRef; ?>" />
                     </div>
                  </div>
                  <div class="col-md-5 mb-30">
                     <div class="inp">
                        <label class="email" for="MainGroup">Main Group</label>
                        <select  name="MainGroup" id="MainGroup" onchange="loadsubgrp()">
                           <option value="">-- Select a Main Group --</option>
                           <?php  
                              $maxtaskmaingrouptitle = sizeof($AllTaskMainGroups_arr);
                              $i=0; 
                              while($i<$maxtaskmaingrouptitle)
                              {   
                                  $valueof= $AllTaskMainGroups_arr[$i][0] ;
                               ?>    
                           <option value="<?php echo $valueof ?>"> <?php echo $AllTaskMainGroups_arr[$i][1] ?> </option>
                           <?php   $i++; } ?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="SubGroup">Sub Group</label>
                        <div id="subgroup">
                            <select name="SubGroup" id="SubGroup">
                           <option value="">-- Select a Sub Group --</option>
                        </select>
                        </div>
                        
                     </div>
                  </div>
                  <div class="col-md-5 mb-30">
                     <div class="inp">
                        <label class="email" for="priority"> Priority</label>
                        <select name="priority" id="priority">
                           <option value="P3" selected>P3 - Low</option>
                           <option value="P2">P2 - Medium</option>
                           <option value="P1">P1 - High</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="inp mb-30" style="display: table;width: 100%;">
                     <label class="description" for="TaskDescription" style="top: -8px;"> Description</label>
                     <textarea name="TaskDescription" id="TaskDescription" rows="15" placeholder="Please Provide Task Detail"></textarea>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <input type="checkbox" class="subbox" id="chkPrivateTask" name="chkPrivateTask"  value="">
                     <label for="chkPrivateTask">Private Task</label>
                  </div>
               </div>
               <div class="col-md-12 mb-30">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="StartDate">Start Date</label>
                        <input type="text"  name="StartDate" id="StartDate" onChange=SetWeekdays() value="" placeholder="YY-MM-DD" >
                        <script type="text/javascript">                           
                            $('#StartDate').datepicker({
                                uiLibrary: 'bootstrap4'
                            });    
                        </script>
                     </div>
                  </div>
                  <div class="col-md-5 mb-30">
                     <div class="inp">
                        <label class="email" for="DueDate">End Date</label>
                        <input type="text" name="DueDate" id="DueDate" value="" >
                        <script type="text/javascript">                           
                            $('#DueDate').datepicker({
                                uiLibrary: 'bootstrap4'
                            });    
                        </script>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="RepeatSchedule">Repeat</label>
                        <select id="RepeatSchedule" name="RepeatSchedule">
                           <?php  if ($RepeatSchedule == "") { ?> 
                           <option value="" selected > <?php } else{ ?> </option>
                           <option value="" > <?php } ?> --- No ---</option>
                           <?php  if ($RepeatSchedule == "Daily") { ?> 
                           <option value="Daily" selected > <?php } else{ ?></option> 
                           <option value="Daily" > <?php } ?> Daily</option>
                           <?php  if ($RepeatSchedule == "Weekly") { ?> 
                           <option value="Weekly" selected > <?php } else{ ?> </option>
                           <option value="Weekly" > <?php } ?> Weekly</option>
                           <?php  if ($RepeatSchedule == "Monthly") { ?> 
                           <option value="Monthly" selected > <?php } else{ ?> </option>
                           <option value="Monthly" > <?php } ?> Monthly</option>
                           <?php  if ($RepeatSchedule == "Yearly") { ?> 
                           <option value="Yearly" selected > <?php } else{ ?> </option>
                           <option value="Yearly" > <?php } ?> Yearly</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-12" style="display:flex;">
                <ul id="DivSelectDay" style="display:none">
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays1 name=cbxDays[] value=Mon <?php if ($cbxDays[0]=="Mon") {echo 'checked';} ?>>
                             <label for="cbxDays1">Mn</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays2 name=cbxDays[] value=Tue <?php if ($cbxDays[0]=="Tue") {echo 'checked';} ?>>
                             <label for="cbxDays2">Tu</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays3 name=cbxDays[] value=Wed <?php if ($cbxDays[0]=="Wed") {echo 'checked';} ?>>
                             <label for="cbxDays3">We</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays4 name=cbxDays[] value=Thu <?php if ($cbxDays[0]=="Thu") {echo 'checked';} ?>>
                             <label for="cbxDays4">Th</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays5 name=cbxDays[] value=Fri <?php if ($cbxDays[0]=="Fri") {echo 'checked';} ?>>
                             <label for="cbxDays5">Fr</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays6 name=cbxDays[] value=Sat <?php if ($cbxDays[0]=="Sat") {echo 'checked';} ?>>
                             <label for="cbxDays6">Sa</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                             <input type="checkbox" class="subbox" id=cbxDays7 name=cbxDays[] value=Sun <?php if ($cbxDays[0]=="Sun") {echo 'checked';} ?>>
                             <label for="cbxDays7">Su</label>
                        </div>
                    </li>
                </ul>
               </div>
               <div class="col-md-12 extrarow" id="DivSelectRepeat" style="display:none">
                  <div class="col-md-3">
                     <div class="inp input-container">
                        <label class="email" for="NextAfter">Next Task After:</label>
                        <input type="text" name="NextAfter" id="NextAfter" value="1">
                        <span class="icon" id="LblTextNext">Days</span>
                     </div>
                  </div>
                  <div class="col-md-3" style="margin-left: 15px;">
                     <div class="inp input-container">
                        <label class="email" for="EndAfterOccur">End After:</label>
                        <input type="radio" name="radioNoOfTimes" id="radioNoOfTimes" value="EndAfter" checked>
                        <input type="text" name="EndAfterOccur" id="EndAfterOccur" value="10">
                        <span class="icon">Occurrences</span>
                     </div>
                  </div>
                   <div class="col-md-3" style="margin-left: 15px;">
                      <div class="inp input-container">
                        <label class="email" for="EndByDate">End By:</label>
                        <input type="radio" name="radioNoOfTimes" id="radioNoOfTimes" value="EndBy">
                        <input type="text" name="EndByDate" id="EndByDate">
                     </div>
                  </div>
                   <div class="col-md-3" style="margin-left: 15px;">
                      <div style="display: contents;">
                        <input type="radio" name="radioNoOfTimes" id="radioNoOfTimes" value="NoEnd">
                        <label class="email" for="radioNoOfTimes">End after 10 years:</label>
                        
                     </div>
                  </div>

               </div>

               
               <div align="center"><font style="color:red;"><label id="LblErrorMessage"></label></font></div>
                  <div class="col-md-12" style="display: flow-root;" >

                     <button type="button"   class="btn-save" onclick="validate1()">Save New Task Detail</button>
                  </div>
         </article>
         <footer class="card-footer">
         </footer>
      </main>
      </div>
      </div>
   </body>
</html>