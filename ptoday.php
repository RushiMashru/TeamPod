<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
   error_reporting (E_ALL ^ E_NOTICE);
   include("taskheader.php");
   
   /*
    * ................. FOR ptoday.php/PALLITEMS.php change following in same code ..............
       *  change ptoday.php to pallitem.php
       *  add following statement in ptoday for $query301
                    AND ( DATE(t3.cScheduleDate)<=CURDATE() )
    * .............................................................................
    */
   $DateStart='2019-01-01';
   $DateToday= date('Y-m-d');
   $DateTomorrow = date ("Y-m-d", strtotime("+1 day", strtotime($DateToday)));
   
   //echo '<br>DateToday'.$DateToday.'----DateTomorrow='.$DateTomorrow.'----';
   
               $target_path = "../TeamPod/SupportingDoc/";
   
   //echo 'print coockies= '; print_r($_COOKIE);
   if(isset($_COOKIE["name"]))           { $loginame=$_COOKIE["name"]; }
   if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
   if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }
   //echo '<br>UserID='.$id.'...UserName='.$loginame.'...SysAdmin='.$CanSystemAdmin.'...AccessLevel='.$AccessLevel ;
   GLOBAL $AccessLevel;
   
   //$ALarrSize=sizeof($AccessLevel);
   
   
   // $AccessLevelCO=$AccessLevel[0][0];   //--- company name
   // $AccessLevelAL=$AccessLevel[0][1];   //--- access level
   //    echo "<script> alert ('ID=$id / NAME=$loginame / AL=$AccessLevel / $AccessLevelCO = $AccessLevelAL <$arsi>');</script>";
   
   
   $ForCompany=$_POST['ForCompany'];
   $ForRefUSR=$_POST['ForRefUSR'];
   
   $ViewListForFD=$_POST['ViewListForFD'];
   
   
   
   //echo '<br>LINE 35--CO=('.$ForCompany.')----USR=('.$ForRefUSR.')';
   
   
   $ForCompany='ALL';
   $_SESSION['ForCompany']='ALL';
   $ForRefUSR=$id;
   $_SESSION['ForRefUSR']=$id;
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST' ) 
   {
        if(in_array('ALL',$_POST['Company'])){
            $_SESSION['ForCompany']= 'ALL';
        }else{
            $_SESSION['ForCompany']= implode(",",$_POST['Company']);
        }
       
       $_SESSION['ForRefUSR']= implode(",",$_POST['ForUSR']);
       $_SESSION['MainGroup']= implode(",",$_POST['Main']);
       $_SESSION['SubGroup']= implode(",",$_POST['Sub']);
       $_SESSION['ForTaskTag']= implode(",",$_POST['ForTaskTag']);
       $_SESSION['chkViewCompleted']= implode(",",$_POST['ViewCompleted']);
       
       echo "<p style='margin-top:100px'>ForCompany : ".$_SESSION['ForCompany']."</p></br>";
       echo "ForRefUSR : ".$_SESSION['ForRefUSR']."</br>";
       echo "MainGroup : ".$_SESSION['MainGroup']."</br>";
       echo "SubGroup : ".$_SESSION['SubGroup']."</br>";
       echo "chkViewCompleted : ".$_SESSION['chkViewCompleted']."</br>";
       exit;
       
   }

   
   //echo '<br>LINE 60--CO=('.$ForCompany.')----USR=('.$ForRefUSR.')----FCCriteria-'.$FCCriteria;
   
   $ForCompany=$_SESSION["ForCompany"];
   $ForRefUSR=$_SESSION["ForRefUSR"];
   $MainGroup=$_SESSION["MainGroup"];
   $SubGroup=$_SESSION["SubGroup"];
   //$ForTaskGroup=$_SESSION["ForTaskGroup"];
   $ForTaskTag=$_SESSION["ForTaskTag"];
   $chkViewCompleted=$_SESSION["chkViewCompleted"];
   
   
   //if ($ForRefUSR=='') {$ForRefUSR='ALL';}     //-------- if first time load the page then default show all users tasks
   
   
   //echo '<br>LINE 70--CO=('.$ForCompany.')----USR=('.$ForRefUSR.')----FCCriteria-'.$FCCriteria;
   
       $urlRecEdit=$_GET['ET'];
       //echo $urlRecEdit;
   
       $urlETLSC=$_GET['ETLSC'];   // Start Stop Clock/watch for RecRef Calander
       $urlETLSS=$_GET['ETLSS'];   // Start Stop Clock/watch for RecRef Schedule
       $urlSSC=$_GET['SSC'];     // Start Stop Clock/watch
   
   
       $DTTTRecRef=$_GET['DTTT'];
                           //----------- REMOVE TAG for this task
       if ($DTTTRecRef!='')
       {
           $query36="DELETE FROM `tTaskTags` WHERE `TRecRef`='$DTTTRecRef' AND RefUSR ='$id'" ;
           $sql36 = mysqli_query($mysqli, $query36);
           
           echo "<script>document.location='ptoday.php?ET=$urlRecEdit';</script>";
       }   //---- end if REMOVE TAG for this task
   
   
   
   
   if ($chkViewCompleted=='YES') {$IsChekedMark='checked';} else {$IsChekedMark='';}
   
   
   if ($ForCompany=='ALL' && $ForRefUSR!='')     { $FCCriteria.=" AND t2.FCompany IN (SELECT FCompany FROM `tUserAccessLevels` WHERE RefUSR='$id' AND `AccessLevel` LIKE '%ADMNDASH%' ) ";}
   else { 
                                           //-------------- if one company selected then check the user access level 
                           $LVLCriteria='';
                           for ($k=0;$k<$ALarrSize;$k++)
                           {
                               //echo '<br>CO='.$AccessLevel[1][$k];
                               if($AccessLevel[$k][0]==$ForCompany)            //-------- if company found then exit loop
                                   break;
                           }
                           //echo '<br>LEVEL='.$AccessLevel[$k][1];            //-------- get the access level = if its only a user then only selecte myself
                           if ($AccessLevel[$k][1]=='ALPROCES,') { $LVLCriteria=" AND t2.RefUSR='$id' ";}
       
           $FCCriteria = " AND t2.FCompany='$ForCompany' $LVLCriteria "; 
       
                           }   //--- end elseif $ForCompany
   
   //echo '<br>LINE 155--CO=('.$ForCompany.')----USR=('.$ForRefUSR.')----FCCriteria-'.$FCCriteria;
                           
                           
           $AllCompanyCode_arr = array();             //---------------- Get all File Codes from database table then when require only show specific codes in select statement
   
           $i=0;
               $AllCompanyCode_arr[$i][0]='ALL';
               $AllCompanyCode_arr[$i][2]='All Companies';
           $query11="SELECT t1.*,t2.CoRecRef,t2.CoCode,t2.CoName FROM `tUserAccessLevels` as t1, `tCompany` AS t2 
                     WHERE t1.FCompany=t2.CoRecRef AND t2.CoType='COMPANY' AND t2.Status='ACT' AND t1.RefUSR='$id'
                     GROUP BY t1.FCompany ORDER BY t2.CoName ";
           $sql11 = mysqli_query($mysqli, $query11);
           $i=1;
           while($row11=mysqli_fetch_array($sql11))                     //------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
               {
               $AllCompanyCode_arr[$i][0]=$row11['CoRecRef'];
               $AllCompanyCode_arr[$i][1]=$row11['CoCode'];
               $AllCompanyCode_arr[$i][2]=$row11['CoName'];
               $i++;
               }
    $maxcompanycode = sizeof($AllCompanyCode_arr);
   
           
       $UserCodeName_arr = array(); 
       $i=0;
               $UserCodeName_arr[$i][0]=$id;
               $UserCodeName_arr[$i][1]='my Tasks';
   /*    $i=1;
               $UserCodeName_arr[$i][0]='ALL';
               $UserCodeName_arr[$i][1]='All Users';
    */   
       $query11="SELECT t1.RefUSR, t1.FirstName, t1.LastName FROM `tUser` AS t1, `tUserAccessLevels` AS t2  
                 WHERE t1.RefUSR=t2.RefUSR AND t1.Status='ACT' $FCCriteria  
                 GROUP BY t1.RefUSR ORDER BY t1.FirstName, t1.LastName "; 
       //echo '<br>-----'.$query11;
       $sql11 = mysqli_query($mysqli, $query11);
       $i=1;
       while($row11=mysqli_fetch_array($sql11))                     //------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
           {
           $UserCodeName_arr[$i][0]=$row11['RefUSR'];
           $UserCodeName_arr[$i][1]=$row11['FirstName'].' '.$row11['LastName'];
           //echo ' Yes '.$UserCodeName_arr[$i][1];
           $i++;
           }
       
    $maxusercodename = sizeof($UserCodeName_arr);
       $UserNameOnly_arr = array(); 
       $i=0;
       $query11="SELECT t1.RefUSR, t1.FirstName,t1.LastName FROM `tUser` AS t1, `tUserAccessLevels` AS t2  
                 WHERE t1.RefUSR=t2.RefUSR AND t1.Status='ACT' $FCCriteria  
                 GROUP BY t1.RefUSR ORDER BY t1.FirstName "; 
       //echo '<br>-----'.$query11;
       $sql11 = mysqli_query($mysqli, $query11);
       while($row11=mysqli_fetch_array($sql11))                     //------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
           {
           $UserNameOnly_arr[$i][0]=$row11['RefUSR'];
           $UserNameOnly_arr[$i][1]=$row11['FirstName'].' '.$row11['LastName'];
           //echo ' Yes '.$UserCodeName_arr[$i][0];
           $i++;
           }
       
    $maxusernameonly = sizeof($UserNameOnly_arr);
   
                                            
   $AllTasksNameList = array();                                           
       $query1="SELECT `TRecRef`, `TaskGroup`, `TaskTitle` FROM `tTasks` WHERE Status='ACT' ORDER BY `TaskTitle`";
       $sql1 = mysqli_query($mysqli, $query1);
       while($row1=mysqli_fetch_array($sql1))                        
       {
           $AllTasksNameList[]=array(
               'value'=>$row1['TRecRef'],
               'label'=> ucfirst(strtolower($row1['TaskGroup']))." - ".ucfirst(strtolower($row1['TaskTitle']))
               );
       } 
   
       
       
   $AllTasksTagList = array();  
       $query1="SELECT DISTINCT `TagTitle` FROM `tTaskTags` WHERE RefUSR='$id' ORDER BY `TagTitle` ";
       $sql1 = mysqli_query($mysqli, $query1);
       while($row1=mysqli_fetch_array($sql1))                        
       {
           $AllTasksTagList[]=array(
               'value'=>$row1['TagTitle'],
               'label'=> ucfirst(strtolower($row1['TagTitle']))
               );
       } 
       
           
   ?>
<html>
   <head>
      <title>Team Pod</title>
      <style>
         #odtasks{
         background-image:url('images/OverdueTasks.svg');
         background-position:5% 8px;
         background-repeat:no-repeat;
         }
         #tdtasks{
         background-image:url('images/TodayTasks.svg');
         background-position:5% 8px;
         background-repeat:no-repeat;
         }
         #tmtasks{
         background-image:url('images/TomorrowTasks.svg');
         background-position:5% 8px;
         background-repeat:no-repeat;
         }
         body {
         background-color: #fff;
         }
         /*.tab {
         overflow: hidden;
         border: 0px solid #ccc;
         background-color: #eee;
         }
         /* Style the buttons inside the tab 
         .tab button {
         background-color: inherit;
         float: left;
         border: none;
         outline: none;
         cursor: pointer;
         padding: 14px 16px;
         transition: 0.3s;
         font-size: 17px;
         }
         /* Change background color of buttons on hover 
         .tab button:hover {
         background-color: #ddd;
         border-radius:10px 10px 0px 0px;
         }
         /* Create an active/current tablink class 
         .tab button:active {
         background-color: #ccc;
         }*/
         .multiselect-wrapper{
            width: 100%;
         }
         #Nav_AddTask {  background: #eee;  background-size: 70px 38px;  border: 2px solid #5DADE2; width: 70px; height: 42px;}
         #Nav_AddTask:hover {  background: #999;  background-size: 70px 40px;}
          .list-wrapper {
    padding: 15px;
    overflow: hidden;
}

.list-item {
    border: 1px solid #EEE;
    background: #FFF;
    margin-bottom: 10px;
    padding: 10px;
    box-shadow: 0px 0px 10px 0px #EEE;
}

.list-item h4 {
    color: #FF7182;
    font-size: 18px;
    margin: 0 0 5px;    
}

.list-item p {
    margin: 0;
}

.simple-pagination ul {
    margin: 0 0 20px;
    padding: 0;
    list-style: none;
    text-align: center;
}

.simple-pagination li {
    display: inline-block;
    margin-right: 5px;
}

.simple-pagination li a,
.simple-pagination li span {
    color: #666;
    padding: 2px 10px;
    text-decoration: none;
    border: 1px solid #e74c3c;
    background-color: #FFF;
}

.simple-pagination .current {
        color: #e74c3c;
    background-color: #f4e5c1;
    border-color: #e74c3c;
}

.simple-pagination .prev.current,
.simple-pagination .next.current {
    background: #f4e5c1;
}
.simple-pagination ul li.active{
        border: 2px solid #e74c3c !important;
}
      </style>
<link rel="shortcut icon" type="image/png" href="images/icontask.png"/>
      <link rel="stylesheet" type="text/css" href="newstyle.css?v=vcb54">
      </link>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <!--Requirement jQuery-->
    
      <link type="text/css" href="multiselect.css?v=4534" rel="stylesheet" />
      <!---->
      <script>
         $(function() {
           $( ".datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
         }); 
          
      </script>
      <!-- --------------- START Auto Complete Text from Array -->
     
      <script language=javascript>
         var h=0;
         var m=0;
         var s=0;
         function to_start(){
         
         switch(document.getElementById('btn').value)
         {
         case  'Stop Timer':
         window.clearInterval(tm); // stop the timer 
         document.getElementById('btn').value='Start Timer';
         break;
         case  'Start Timer':
         tm=window.setInterval('disp()',1000);
         document.getElementById('btn').value='Stop Timer';
         break;
         }
         }
         
         
         function disp(){
         // Format the output by adding 0 if it is single digit //
         if(s<10){var s1='0' + s;}
         else{var s1=s;}
         if(m<10){var m1='0' + m;}
         else{var m1=m;}
         if(h<10){var h1='0' + h;}
         else{var h1=h;}
         // Display the output //
         str= h1 + ':' + m1 +':' + s1 ;
         document.getElementById('upTimeTaken').value=str;
         // Calculate the stop watch // 
         if(s<59){ 
         s=s+1;
         }else{
         s=0;
         m=m+1;
         if(m==60){
         m=0;
         h=h+1;
         } // end if  m ==60
         }// end if else s < 59
         // end of calculation for next display
         
         }
      </script>
      <script>
         var complextask = <?php echo json_encode($AllTasksNameList); ?>;
         datatask=complextask;
         $(function() {
                 $("#NewTaskName").autocomplete({
                         source: datatask,
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
                                 $("#sTRecRefNew").val(ui.item.value);
                                 //$("#sTRecRef-value").val(ui.item.value);
                         }
                 });
         });
         
         
      </script>
      <script>
         function ShowList(tday)
         {
             document.getElementById("ViewListForFD").value=tday;
             //document.getElementById("TaskMgmt").submit(); 
             $("#odtasks").removeClass('active-tab');
             $("#tdtasks").removeClass('active-tab');
             $("#tmtasks").removeClass('active-tab');
             $("#OD").css('display','none');
             $("#TD").css('display','none');
             $("#TM").css('display','none');
             if(tday=='OD'){
                    $("#odtasks").addClass('active-tab');
                    $("#OD").css('display','block');
             }
             if(tday=='TD'){
                    $("#tdtasks").addClass('active-tab');
                    $("#TD").css('display','block');
             }
             if(tday=='TM'){
                    $("#tmtasks").addClass('active-tab');
                    $("#TM").css('display','block');
             }
         }
         
         
      </script>
   </head>
   <body>
     
         <div style="position:fixed;top:50%;left:30%;font-size:20px;padding:15px;border: solid 1px #300000;border-radius:5px;background-color: #000;color:#fff;display:none;z-index:10000;text-align:center" class ="successmsg"></div>
         <input type=hidden name=AddNewBtnClick id=AddNewBtnClick value="" />
         <input type=hidden name=ViewListForFD id=ViewListForFD value="<?php echo $ViewListForFD;?>" />
         <?php    if ($urlRecEdit=='') { 
              include "taskfilter.php";
            ?>
         <div class="maindiv" id="wrapper" style="margin-left:16%;width:84%;">
            <div id="floatleft" style="width:100%;float:left;z-index: -1;">
               <div style="background-color: #fff">
                  <?php       $FTMGCriteria=''; $FTSGCriteria=''; $FTGCriteria='';
                     $FCCriteria=" AND t2.ForCoRecRef IN (SELECT FCompany FROM `tUserAccessLevels` WHERE RefUSR='$id' AND ( `AccessLevel` LIKE '%ALPROCES%' ) ) ";
                     if ($chkViewCompleted=='YES') {$FCMPCriteria=" AND t3.CompleteBy!='' "; } else  {$FCMPCriteria=" AND t3.CompleteBy='' "; }
                     if ($ForCompany=='ALL' && $ForRefUSR=='ALL') {$FUCriteria=""; }
                     if ($ForCompany=='ALL' && $ForRefUSR!='ALL') { $FUCriteria=" AND t3.ForRefUSR='$ForRefUSR' "; }
                     //    if ($ForCompany=='ALL' && $ForRefUSR!='ALL') {$FCCriteria=" AND t2.ForCoRecRef IN (SELECT FCompany FROM `tUserAccessLevels` WHERE RefUSR='$id' ) ";}
                     if ($ForCompany!='ALL' && $ForRefUSR=='ALL') {$FUCriteria=" AND t2.ForCoRecRef=$ForCompany "; }
                     if ($ForCompany!='ALL' && $ForRefUSR!='ALL') {$FUCriteria=" AND t2.ForCoRecRef=$ForCompany AND t3.ForRefUSR='$ForRefUSR'  ";}
                     if ($MainGroup!='') {$FTMGCriteria.=" AND t1.TaskMainGroup='$MainGroup' ";}
                     if ($SubGroup!='') {$FTSGCriteria.=" AND t1.TaskSubGroup='$SubGroup' ";}
                     //if ($ForTaskGroup!='') {$FTGCriteria.=" AND t1.TaskGroup='$ForTaskGroup' ";}
                     // if ($ForTaskTag!='') {$FTTagCriteria.=" AND t1.TRecRef IN ( SELECT TaRecRef FROM `tTaskTags` WHERE TagTitle='$ForTaskTag' )  ";}
                     if ($ForTaskTag!='') {$FTTagCriteria.=" AND t3.cRecRef IN ( SELECT cRecRef FROM `tTaskTags` WHERE TagTitle='$ForTaskTag'  AND RefUSR ='$id') ";}
                     //echo '<br>LINE 325--CO=('.$ForCompany.')----USR=('.$ForRefUSR.')<br>//---FCCriteria=('.$FCCriteria.')<br>//---FUCriteria=('.$FUCriteria.')';
                     
                     $OverDueCount=0; $TodaysCount=0; $TomorrowCount=0; $celnodv=0;$TRecRefold='';
                     
                     
                     
                                             //----------------------- START Over Due, Today & Tomorrow Task List --------------------------- START
                     $query301="SELECT t1.*,t2.*,t3.* FROM `tTasks` AS t1, `tSchedule` AS t2, `tCalendar` AS t3 
                                 WHERE t1.TRecRef=t2.TRecRef AND t2.SRecRef=t3.SRecRef $FCCriteria $FUCriteria $FTMGCriteria $FTSGCriteria $FCMPCriteria $FTTagCriteria 
                                 AND ( DATE(t3.cScheduleDate) BETWEEN '$DateStart' AND '$DateTomorrow' ) AND t3.Status='A'
                                 ORDER BY t1.TRecRef LIMIT 200";

                              //   $query301 = "SELECT t1.*,t2.*,t3.* FROM `tTasks` AS t1, `tSchedule` AS t2, `tCalendar` AS t3 WHERE t1.TRecRef=t2.TRecRef AND t2.SRecRef=t3.SRecRef ORDER BY t3.cScheduleDate,t1.TRecRef LIMIT 200";
                     
                     $sql301 = mysqli_query($mysqli, $query301);    
                     $existCount301 = mysqli_num_rows($sql301);
                    // echo '<br>QUERY---'.$existCount301.'-----'.$query301;exit;
                     if ($existCount301>0){
                         while($row301=mysqli_fetch_array($sql301))
                             {
                                 $TRecRef=$row301['TRecRef'];
                                 $csqlScheduleDate=$row301['cScheduleDate'];
                                 $csqlDueDate=$row301['cDueDate'];
                                 $TaskNumber=$row301['TaskNumber'];
                                 $nsubtasks = 0;

                                 if (($TRecRef !== $TRecRefold) or ($TRecRef == $TRecRefold && $csqlScheduleDateold !== $csqlScheduleDate && $csqlDueDate !==$csqlDueDateold)) 
                                {
                                   // echo "1";exit;
                                 $taskowner = $row301['CreatedBy'];
                                 $cRecRef=$row301['cRecRef'];
                                 $sRecRef=$row301['SRecRef'];
                                 $cScheduleDateUK = date ("d/m/Y", strtotime($csqlScheduleDate));
                                 $cScheduleDate = date('d', strtotime($csqlScheduleDate));
                                 $cSchDay = date('D', strtotime($csqlScheduleDate));
                                 $cDueDateUK = date ("d/m/Y", strtotime($csqlDueDate));
                                 $cDueDate = date('d M-Y', strtotime($csqlDueDate));
                                 $cDueDay = date('D', strtotime($csqlDueDate));
                                 $cStage=$row301['Stage'];
                                 $TaskTitle=$row301['TaskTitle'];
                                 $CoCode=$row301['ForCoRecRef'];
                                 $CoShortCode=getCompanyShortCode($CoCode);
                                 $TaskGroup=$row301['TaskGroup'];
                                 $PrivateTask=$row301['PrivateTask'];
                                 $AssignedBy=$row301['AssignedBy'];
                                 $CompleteBy=$row301['CompleteBy'];
                                 $RepeatSchedule1=$row301['RepeatSchedule'];
                                 $AlertColor=$row301['AlertColor'];
                                 $eMainGroup=$row301['TaskMainGroup'];
                                 $eSubGroup=$row301['TaskSubGroup'];
                                 $TaskMainGroup=$row301['TaskMainGroup'];
                                 $TaskMainGroupTitle=getTaskMainGroupTitle($TaskMainGroup);
                                 $TaskSubGroup=$row301['TaskSubGroup'];
                                 $TaskSubGroupTitle=getTaskSubGroupTitle($TaskSubGroup);
                                 $TaskDescr=$row301['TaskDescription'];
                                 $Priority=$row301['Priority'];
                                 $ForRefUSRC=$row301['ForRefUSR'];
                                 $showdate='';
                                 $showday='';
                                 $ForUserFullName='';
                                 $initials='';
                                 $fullname='';
                                 $awdays = $row301['DaysInWeek'];
                                 //if($ForRefUSR!='ALL') {;
                                 $assigneduser=array();
                                 $x=0;
                                  $query11="SELECT * FROM `tSubTasks` a WHERE STRecRef in (Select STRecRef from tSubTaskCal b where cRecRef in 
                                (select cRecRef from tCalendar where SRecRef in (select SRecRef from tSchedule c where TRecRef = '$TRecRef') 
                                and (`cScheduleDate`,`cDueDate`) in (select `cScheduleDate`,`cDueDate` from tCalendar where cRecRef='$cRecRef') ) AND b.cRecRef in (select cRecRef from tCalendar where cRecRef=b.cRecRef and Status='A')) ORDER BY a.STRecRef ";
                
                                $sql11 = mysqli_query($mysqli, $query11);    
                                $existCount11 = mysqli_num_rows($sql11);
                                if ($existCount11>0){
                                    $nsubtasks = 1;
                                }
                                 $query3011 = "SELECT distinct ForRefUSR from tCalendar where TRecRef='$TRecRef' AND Status='A' and (`cScheduleDate`,`cDueDate`) in (select `cScheduleDate`,`cDueDate` from tCalendar where cRecRef='$cRecRef') ";
                                 $sql3011 = mysqli_query($mysqli, $query3011);
                                 
                                 while($row3011=mysqli_fetch_array($sql3011))
                                 {
                                 $ForRefUSR=$row3011['ForRefUSR'];
                                 $query31="SELECT `RefUSR`, `FirstName`, `LastName`  FROM `tUser` WHERE `RefUSR`='$ForRefUSR' ";
                                 $sql31 = mysqli_query($mysqli, $query31);
                                 while($row31 = mysqli_fetch_array($sql31)){
                                     $UserRef   =$row31["RefUSR"];
                                     $FirstName  =$row31["FirstName"];
                                     $LastName  =$row31["LastName"];
                                     $FullName=$FirstName.' '.$LastName;
                                     $FullName1=$FirstName.$LastName;
                                     $FullName=ucwords(strtolower($FullName)); //----- convert to UpperLower Case
                                 }
                                 $ForUserFullName.=', ' .$FullName;
                                 if($ForRefUSRC==$ForRefUSR) {$color="#ccc";} else { $color="#fff";};
                                 
                                  $initials.="<div class='img-box' style='background: #ffe199;color: black;'><span style='background:#ffe199;color:#e74c3c;border-radius:50%;padding: 7px;border:1px solid #e74c3c' ><a href='#' title='$FullName' style='color:white !improtant'>".substr($FirstName,0,1).substr($LastName,0,1)."</a></span></div>";
                                 $assigneduser[$x]=$ForRefUSR;
                                 $x++;
                                 }
                                 $ForUserFullName = substr($ForUserFullName,2);
                                 /*}
                                 else {
                                 $ForRefUSR=$row301['ForRefUSR'];
                                 $query31="SELECT `RefUSR`, `FirstName`, `LastName`  FROM `tUser` WHERE `RefUSR`='$ForRefUSR' ";
                                 $sql31 = mysqli_query($mysqli, $query31);
                                 while($row31 = mysqli_fetch_array($sql31)){
                                     $UserRef   =$row31["RefUSR"];
                                     $FirstName  =$row31["FirstName"];
                                     $LastName  =$row31["LastName"];
                                     $FullName=$FirstName.' '.$LastName;
                                     $FullName1=$FirstName.$LastName;
                                     $FullName=ucwords(strtolower($FullName)); //----- convert to UpperLower Case
                                 }
                                 $initials.="<span style='background:#fff;color:#000;border-radius:50%;padding:5px;border:1px solid #000' ><a href='#' title='$FullName'>".substr($FirstName,0,1).substr($LastName,0,1)."</a></span>&nbsp;&nbsp;";
                                 }*/
                                 
                                 if ($csqlScheduleDate==$csqlDueDate)
                                 {   $showdate=$cDueDate;
                                     $showday=$cDueDay;
                                 } else {
                                     $showdate=$cScheduleDate.' to '.$cDueDate;
                                     $showday=$cSchDay.'-'.$cDueDay;
                                 }
                                 if($csqlDueDate<$current_date) {$statuscolor='style="background-color:red;"'; $statusBARcolor='red';}
                                 else {$statuscolor='style="background-color:#5DADE2;"'; $statusBARcolor='#5DADE2';}
                                 if ($CompleteBy!=0) {$statuscolor='style="background-color:green;"'; $statusBARcolor='green';}
                                 if ($cStage=='WorkInProgress') {$statuscolor='style="background-color:#ffcc00;"'; $statusBARcolor='#ffcc00';}
                                 $newassigncolor='black';
                                // if ($AlertColor=='DB') {$newassigncolor='style="color:blue;"';}
                                // if ($AlertColor=='LB') {$newassigncolor='style="color:deepskyblue;"';}
                                 
                                     $ThisTaskTags='';
                                     $query21="SELECT * FROM `tTaskTags` WHERE `TaRecRef`='$TRecRef' AND `RefUSR` ='$id' AND cRecRef='$cRecRef' ORDER BY `TagTitle` ";
                                     //echo 'Q21='.$query21;
                                     $sql21 = mysqli_query($mysqli, $query21);
                                     while($row21=mysqli_fetch_array($sql21))                        
                                     {
                                         $ThisTRecRef=$row21['TRecRef'];
                                         $ThisTaskRecRef=$row21['TaRecRef'];
                                         $ThisTagTitle=$row21['TagTitle'];
                                         //$ThisTagTitle= ucfirst(strtolower($ThisTagTitle));
                                         //$ThisTaskTags.=" -<i>$ThisTagTitle</i>&nbsp;&nbsp; ";
                                         $ThisTaskTags.="<a href='#' onClick='removetag($celnodv,$ThisTRecRef)'><img src='images/imgRemove.png' alt='X' height='15' width='15' border=0/></a>
                     $ThisTagTitle&nbsp;<br/> ";
                                     } 
                                 
                                 //  ($ForRefUSR==$AssignedBy && $AssignedBy!=$id)   //---- This is private task
                                 
                                 if ($PrivateTask==1 && $AssignedBy!=$id) { 
                                   //---- This is private task 

                                 }
                                 else {
                                     /*  id="dv-<?php echo $celnodv;?>" onmouseover="mouseOverDV(<?php echo $celnodv;?>)" onmouseout="mouseOutDV(<?php echo $celnodv;?>)"> */

                 
               //echo $outall;exit;
               
               
                $outall = "<input type=hidden id=EditTaskRef".$celnodv."     name=EditTaskRef".$celnodv." value=".$TRecRef." > ";
                  include "ptaskdetails.php";
                $celnodv++;                  
                    $outall.= "
               </div>
               ";
              // echo '<br>csqlScheduleDate'.$csqlScheduleDate.'='.strtotime($csqlScheduleDate).'------DateToday='.$DateToday.'='.strtotime($DateToday).'------'.$csqlDueDate;
              // exit;
               //if (strtotime($csqlScheduleDate)<strtotime($DateToday))  {$outover.=$outall; $OverDueCount++;}
               //if (strtotime($csqlScheduleDate)==strtotime($DateToday)) {$outoday.=$outall; $TodaysCount++;}
               $tasktype="";
                if (strtotime($csqlScheduleDate)<strtotime($DateToday) && strtotime($csqlDueDate)<strtotime($DateToday))  {$outover.=$outall; $OverDueCount++;$tasktype='t1';}
                    if (strtotime($csqlScheduleDate)==strtotime($DateToday) || ( strtotime($csqlScheduleDate)<strtotime($DateToday) && strtotime($csqlDueDate)>=strtotime($DateToday)  ) ) {$outoday.=$outall; $TodaysCount++;$tasktype='t2';}
                    if (strtotime($csqlScheduleDate)==strtotime($DateTomorrow)) {$outomorrow.=$outall; $TomorrowCount++; $tasktype='t3';}
                    
                    }   //------ end if private task
                    
               
               $TRecRefold = $TRecRef;
               $csqlScheduleDateold=$row301['cScheduleDate'];
               $csqlDueDateold=$row301['cDueDate'];
               }
               }   //---- end while
               //----------------------- END Over Due, Today & Tomorrow Task List --------------------------- END
               }   //------- end if
               ?>
               <input type="hidden" name="CountCells" id="CountCells" value="<?php echo $celnodv;?>"/>
               <div class="tab">
                  <button class="tablinks " type="button" id="odtasks" onclick="ShowList('OD')"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbspOver due tasks (<?php echo $OverDueCount; ?>)&nbsp</button>
                  <button class="tablinks active-tab" type="button" id="tdtasks" onclick="ShowList('TD')"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbspToday's tasks (<?php echo $TodaysCount; ?>) &nbsp &nbsp</button>
                  <button class="tablinks" id="tmtasks" type="button" onclick="ShowList('TM')"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbspTomorrow's tasks (<?php echo $TomorrowCount; ?>)</button>
               </div>
               <div id="OD" class="tabcontent1" style="display: none;margin-top:10px;">
                
                         
                             <div id="pagination-container2"></div>
                                <div class="main-tab OD">
                                      <?php echo $outover; ?>
                                </div>
                       
                    </div>
               <div id="TD" class="tabcontent1" style="margin-top:10px;" >
                  <div id="pagination-container1"></div>
                  <div class="main-tab TD">
           
           <?php if ($ViewListForFD=='TD' || $ViewListForFD=='') { echo $outoday; } ?> 
           
         </div>
         
               </div>
               <div id="TM" class="tabcontent1 TM" style="display: none;margin-top:10px;">
                 
                  
                             <div id="pagination-container3"></div>
                                <div class="TM main-tab">
                                      <?php echo $outomorrow; ?>
                                </div>
                        
               </div>
               <!--  <table cellpadding=4 cellspacing=0 width=100% border=0><tr style="cursor: pointer;" onclick="ShowList('OD')" >
                  <td width="100%"><div class=BLUbkgBLUborder style='width:100%'><h4>OVER DUE TASKS &nbsp;&nbsp;&nbsp;&nbsp;</h4></div></td>
                  <td align=center><div class=BLUbkgBLUborder style='width:90px;'><h4><?php //echo $OverDueCount; ?></h4></div></td>
                  </tr></table>
                      <?php //if ($ViewListForFD=='OD') { echo $outover; } ?>
                  <table cellpadding=4 cellspacing=0 width=100% border=0><tr style="cursor: pointer;"  onclick="ShowList('TD')" >
                  <td width="100%"><div class=BLUbkgBLUborder style='width:100%'><h4>TODAY's TASKS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4></div></td>
                  <td align=center><div class=BLUbkgBLUborder style='width:90px;'><h4><?php //echo $TodaysCount; ?></h4></div></td>
                  </tr></table>
                      <?php //if ($ViewListForFD=='TD' || $ViewListForFD=='') { echo $outoday; } ?>
                  <table cellpadding=4 cellspacing=0 width=100% border=0><tr style="cursor: pointer;"  onclick="ShowList('TM')">
                  <td width="100%"><div class=BLUbkgBLUborder style='width:100%'><h4>TOMORROW's TASKS</h4></div></td>
                  <td align=center><div class=BLUbkgBLUborder style='width:90px;'><h4><?php //echo $TomorrowCount; ?></h4></div></td>
                  </tr></table>
                      <?php //if ($ViewListForFD=='TM') { echo $outomorrow; } ?> -->
               <?php
                  }   //---- end if $urlRecEdit
                  ?>
            </div>
         </div>
         <!-- wrapper & center -->
         
      </form>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js'></script>

      <script type="text/javascript">
          
          function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function changeexpend(id){
    
    $("#expendeddiv"+id).slideToggle();
       // $(this).toggleClass('active-icon');
}

function removeUpload() {
  //$('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
  $('.file-upload-image').attr('src', "");
}
$('.image-upload-wrap').bind('dragover', function () {
    
    $('.image-upload-wrap').addClass('image-dropping');
  });
  $('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
/*  $(".icon").click(function(){
  $(".Collapsed.tabcontent").slideToggle();
  $(this).toggleClass('active-icon');
});*/
  function openCity(evt, tdid, divid) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tdid).style.display = "block";
  evt.currentTarget.className += " active";
  
  if (divid == "divstarttime") {
        var tdid=tdid.replace("tab-2","");
        var fordiv='clockstarticon1'+tdid;

        document.getElementById(fordiv).style.display = "inline";
        var fordiv='dv-'+tdid;
        document.getElementById(fordiv).style.backgroundColor = "#f1f1f1";
        var fordiv='clockstarticon2'+tdid;
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
    		    document.getElementById("clockstarticon10"+tdid).style.display = "inline";
                $(".successmsg").html('Task Started Successfully!').fadeIn(500);
    			$(".successmsg").html('Task Started Successfully!').fadeOut(2000);
    		    
    		}
    		
    	});
    	
    
    }
}

function openCity1(evt, tdid,mid,subid,divid) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tdid).style.display = "block";
  evt.currentTarget.className += " active";
  $("#expendeddiv"+mid).slideToggle();
 // $("#sdv-"+mid+'-'+subid).css('display','block');
 
 if (divid == "divsubstarttime") {
        var tdid=tdid.replace("sub-tab-1","");
        var fordiv='clockstart'+tdid;
        document.getElementById(fordiv).style.display = "inline";
        var fordiv='starttimeicon'+tdid;
        document.getElementById(fordiv).style.display = "none";
        
        forstid = "EditSubTaskRef-"+mid+"-"+subid;
        subtaskid = document.getElementById(forstid).value; 
        fortid = "EditTaskRef"+mid;
        taskid = document.getElementById(fortid).value; 
        forcid = "EditCalendarRef"+mid;
        cid = document.getElementById(forcid).value;
        var dataString = "ForTaskid=" + taskid + "&ForSTaskid=" + subtaskid + "&ForCalid=" + cid + "&cat=substarttime" ;
    
        $.ajax({  
    		type: "POST",  
    		url: "ptaskload.php",  
    		data: dataString,
    		success: function(response)
    		{   
    		    fornoteid = "notid"+mid+'-'+subid;
    		    noteid = response.substring(response.indexOf("_") + 1);
    		    document.getElementById(fornoteid).value=noteid;
    		    fortaskid = "ntaskid"+mid+'-'+subid;
    		    document.getElementById(fortaskid).value=subtaskid;
    		    document.getElementById("endtimeicon"+tdid).style.display = "inline";
                $(".successmsg").html('SubTask Started Successfully!').fadeIn(500);
    			$(".successmsg").html('SubTask Started Successfully!').fadeOut(2000);
    		    
    		}
    		
    	});
    	
 }
}
      </script>
      <script type="text/javascript">
  var items = $(".t1");
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
</script>
 <script type="text/javascript">
  var items1 = $(".t2");
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
</script> <script type="text/javascript">
  var items2 = $(".t3");
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
</script>






   </body>
</html>