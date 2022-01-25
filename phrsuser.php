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


$btnFilter=$_POST['btnFilter'];
$FromDate=$_POST['FromDate'];
$ToDate=$_POST['ToDate'];


$selForRefUSR=$_POST['selForRefUSR'];

$selForRefUSR1=$_POST['selForRefUSR1'];



if ($FromDate=='' && $ToDate=='')
    {
    $day = date('w');
    $FromDate=date('d-m-Y', strtotime('-'.$day.' days'));       //---------- start of previous week
    $ToDate=date('d-m-Y');
    //$FromDate=date('d-m-Y', strtotime('-1 week', strtotime($selenddate)));    //-------- previous 1 week  
    }
    
    if ($btnFilter!=''){
    $sqlFromDate = substr($FromDate,6,4)."-".substr($FromDate,3,2)."-".substr($FromDate,0,2);
    $sqlToDate = substr($ToDate,6,4)."-".substr($ToDate,3,2)."-".substr($ToDate,0,2);

    //echo "<br>1 ForRefUSR=$ForRefUSR ---FromDate=$FromDate ---sqlFromDate=$sqlFromDate ---ToDate=$ToDate ---sqlToDate=$sqlToDate ";
        }
    else {    
        $ForRefUSR=$_GET['DUSER'];
        $uFDate=$_GET['uFD'];
        $uTDate=$_GET['uTD'];
        $uTDETAIL=$_GET['uTDETAIL'];
        $selForRefUSR=$ForRefUSR;
        $selForRefUSR1=$ForRefUSR;
        
        if ($uFDate!='' && $uTDate!='') {
            $FromDate = substr($uFDate,8,2)."-".substr($uFDate,5,2)."-".substr($uFDate,0,4);
            $ToDate = substr($uTDate,8,2)."-".substr($uTDate,5,2)."-".substr($uTDate,0,4);
            $sqlFromDate = $uFDate;
            $sqlToDate = $uTDate;
        }
    //echo "<br>2 uFDate=$uFDate ---uTDate=$uTDate ----- ForRefUSR=$ForRefUSR ---FromDate=$FromDate ---sqlFromDate=$sqlFromDate ---ToDate=$ToDate ---sqlToDate=$sqlToDate ";
    }

    
    $query101="SELECT RefUSR, FirstName, LastName, Company, CompanyID FROM `tUser` ORDER BY FirstName, LastName,Company, CompanyID";
    $sql101 = mysqli_query($mysqli, $query101);
    $i=0;
    $UserCodeName_arr[$i][0]="";
    $UserCodeName_arr[$i][1]="--- ALL ---";
    $UserCodeName1_arr[$i][0]="";
    $UserCodeName1_arr[$i][1]="--- ALL ---";
    $i=1;
    while($row101=mysqli_fetch_array($sql101))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $UserCodeName_arr[$i][0]=$row101['RefUSR'];
        $UserCodeName_arr[$i][1]=$row101['FirstName'].' '.$row101['LastName'];
        $UserCodeName1_arr[$i][0]=$row101['RefUSR'];
        $UserCodeName1_arr[$i][1]=$row101['Company'];
        //echo ' Yes '.$UserCodeName_arr[$i][0];
        $i++;
        }
    
	$maxusercodename = sizeof($UserCodeName_arr);

    $maxusercodename1 = sizeof($UserCodeName1_arr);
   

?>


<html>
<head>
<title>Tasks On Cloud</title>
      
	<meta charset="UTF-8">
        <link rel="shortcut icon" type="image/png" href="images/icontask.png"/>
        <link rel="stylesheet" type="text/css" href="newstyle.css"></link>
        <link rel="stylesheet" type="text/css" href="css/phrsuser.css"></link>
        <!-- pagination links -->
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
 	
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
 <link type="text/css" href="multiselect.css?v=23454" rel="stylesheet" />
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
     
</head>

<body>

<div class="row" style="margin-top:75px;">
    
<div class="tab">
  <button class="tablinks active" id="defaultOpen" onclick="openCity(event, 'By User')"><img src="images/ByUser.svg" height="30" style="vertical-align:middle;margin: -4px 1px 0px 0px;/* width: 28px; */">By User</button>
  <button class="tablinks" onclick="openCity(event, 'By Company')">
  <img src="images/ByCompany.svg" height="30" style="vertical-align:middle;margin: -4px 1px 0px 0px;">
By Company</button>

</div>


                        <!--- by user tab one start -->


<div id="By User" class="tabcontent active">
<div class="maindiv" id="wrapper" >
      <div id="floatleft" >
      <main class="card" style="margin-top:-91px;">
      <form action="" name="TaskMgmt" id="TaskMgmt" method="post" enctype="multipart/form-data" target="_self" >  

         <input type=hidden name="AddNewBtnClick" id="AddNewBtnClick" value="" />
         <article class="card-content">
            <div class="wrapper">
               <div class="col-md-12">
                  <div class="col-md-12 fl mb-30">
                     <div class="inp">
                        <label class="email" for="ForCompany"> For User</label>
                        
                        <select name="selForRefUSR" id="selForRefUSR" onchange="loadusers()">
                           <option value=""></option>
                           <?php  $i=0; 
                while($i<$maxusercodename)
                {   
                    $valueof= $UserCodeName_arr[$i][0] ;

                    if ($selForRefUSR == $valueof) {  ?>
                        <option value="<?php echo $valueof; ?>" selected> <?php echo $UserCodeName_arr[$i][1] ?></option>
                    <?php } else{ ?>    
                        <option value="<?php echo $valueof ?>"> <?php echo $UserCodeName_arr[$i][1] ?> </option>
                <?php  }  $i++; } ?>
                        </select>
                  

                     </div>
                  </div>
               
               </div>
                    


               <div class="col-md-12 mb-30">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="FromDate">Start Date</label>
                        <input type="text"  name="FromDate" id="FromDate" value="" placeholder="DD/MM/YYYY" autocomplete="off">
                     
                     </div>
                  </div>
                  <div class="col-md-5 mb-30">
                     <div class="inp">
                        <label class="email" for="DueDate">ToDate</label>
                        <input type="text" name="ToDate" id="ToDate" value="" placeholder="DD/MM/YYYY" autocomplete="off">
                       
                     </div>
                  </div>
               </div>

           
               
               <div align="center"><font style="color:red;"><label id="LblErrorMessage"></label></font></div>
                  <div class="col-md-12" style="display: flow-root;" >

                     <input type="submit" value="Show filtered results"  name="btnFilter" class="btn-save" ></button>
                  </div>

              
    </div>      
    <div class="row">
    <?php 
        
        $tdbottomborderblue=" style='border-bottom:1pt solid blue;' " ;
        $CriteriaUSR='';
        $CriteriaTask='';
                    //--------- add all time for each task Group By
        $CriteriaTaskSUM=" SEC_TO_TIME( SUM( TIME_TO_SEC( t4.TimeTaken ) ) ) AS TASTTIMETAKE ";
        $CriteriaGroup= " GROUP BY t1.TRecRef ";
        
    if ($selForRefUSR!='') {$CriteriaUSR=" AND RefUSR='$selForRefUSR' "; }
    if ($uTDETAIL!='') {
        $CriteriaTask=" AND t1.TRecRef='$uTDETAIL' ";
        $CriteriaTaskSUM=' t4.TimeTaken AS TASTTIMETAKE';
        $CriteriaGroup='';
    }
    

    echo "<table id='tableData' class='content-table' style='overflow-x:auto;'>";
    
    echo "<thead><tr>
    <th>Full Name</th>
    <th>Task  -  Company</th>
    <th >Hours</th>
    </tr></thead>";
   
  echo "<tbody>";
    $query11="SELECT RefUSR, FirstName, LastName FROM `tUser` WHERE Status='ACT' $CriteriaUSR ORDER BY FirstName, LastName "; 
    //echo $query11;
    $sql11 = mysqli_query($mysqli, $query11);
    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $uRefUSR=$row11['RefUSR'];
        $uFullName=$row11['FirstName'].' '.$row11['LastName'];


      
        $query12="SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `TimeTaken` ) ) ) AS UTIMETAKE FROM `tTaskNotes` 
        WHERE NotesBy='$uRefUSR' AND  (DATE(NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' ) "; 
        $sql12 = mysqli_query($mysqli, $query12);
        //echo $query12;
        while($row12=mysqli_fetch_array($sql12))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
            $userTotalHours=$row12['UTIMETAKE'];
        }         

        echo "<tr>
        <td>
        <a href=phrsuser.php?DUSER=$uRefUSR&uFD=$sqlFromDate&uTD=$sqlToDate target=_self>$uFullName</a>
        </td>
        ";

        if ($ForRefUSR==$uRefUSR) {
            $query12="SELECT t1.TRecRef, t1.TaskTitle, t2.ForCoRecRef, $CriteriaTaskSUM, t4.Notes 
                      FROM tTasks AS t1, tSchedule AS t2, tCalendar AS t3, tTaskNotes AS t4 
                      WHERE t1.TRecRef=t2.TRecRef AND t2.SRecRef=t3.SRecRef AND t3.cRecRef=t4.cRecRef $CriteriaTask
                      AND t4.NotesBy='$uRefUSR' AND  (DATE(t4.NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' )
                      $CriteriaGroup ORDER BY t2.ForCoRecRef, t1.TaskTitle  "; 
            $sql12 = mysqli_query($mysqli, $query12);
            //echo $query12;
            while($row12=mysqli_fetch_array($sql12))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                {
                    $TaskRecRef=$row12['TRecRef'];
                    $TaskTitle=$row12['TaskTitle'];
                    $TaskNotes=$row12['Notes'];
                    $dTimeTaken=$row12['TASTTIMETAKE'];
                    $dForCoRecRef=$row12['ForCoRecRef'];
                    $CoShortCode=getCompanyShortCode($dForCoRecRef);



                    echo "<tr>
                    <td  $tdbottomborderblue > 
                        <a href=phrsuser.php?DUSER=$uRefUSR&uFD=$sqlFromDate&uTD=$sqlToDate&uTDETAIL=$TaskRecRef target=_self>$TaskTitle</a> ";
                     
                    if ($uTDETAIL!='') {
                        echo "<br/>&nbsp;&nbsp; <i>$TaskNotes;</i></td>";
                     }
                            echo "<td  $tdbottomborderblue> $CoShortCode</td>
                              <td $tdbottomborderblue> $dTimeTaken
                              </td>
                              
                              </tr>";

    
   
                            }         

                          }    //------ end if $ForRefUSR
                    
               }   //------ end while $row11

         
        echo "<td ></td>";


         echo "<td >$userTotalHours</td>
           
           </tr>";

           
               echo "</tbody>";  
              
               echo "</table>";  
                            
               
           ?>
                     </div>


         </article>
            </form>
      </main>
      </div>
      </div>
</div>

<!--- by user tab  End -->

<!--- by Company Tab start -->

<div id="By Company" class="tabcontent">
<div class="maindiv" id="wrapper" >
      <div id="floatleft" >
      <main class="card" style="margin-top:-91px;">
      <form action="" name="TaskMgmt" id="TaskMgmt" method="post" enctype="multipart/form-data" target="_self" >  

         <input type=hidden name="AddNewBtnClick" id="AddNewBtnClick" value="" />
         <article class="card-content">
            <div class="wrapper">
               <div class="col-md-12">
                  <div class="col-md-12 fl mb-30">
                     <div class="inp">
                        <label class="email" for="ForCompany"> For Company</label>
                        
                        <select name="selForRefUSR1" id="selForRefUSR1" onchange="loadusers()">
                           <option value=""></option>
                           <?php  $i=0; 
                while($i<$maxusercodename1)
                {   
                    $valueof= $UserCodeName1_arr[$i][0] ;

                    if ($selForRefUSR1 == $valueof) {  ?>
                        <option value="<?php echo $valueof; ?>" selected> <?php echo $UserCodeName1_arr[$i][1] ?></option>
                    <?php } else{ ?>    
                        <option value="<?php echo $valueof ?>"> <?php echo $UserCodeName1_arr[$i][1] ?> </option>
                <?php  }  $i++; } ?>
                        </select>
                  

                     </div>
                  </div>
               
               </div>
                    


               <div class="col-md-12 mb-30">
                  <div class="col-md-6 fl mb-30">
                     <div class="inp">
                        <label class="email" for="FromDate">Start Date</label>
                        <input type="text"  name="FromDate" id="FromDate1" value="" placeholder="DD/MM/YYYY" autocomplete="off">
                       
                     </div>
                  </div>
                  <div class="col-md-5 mb-30">
                     <div class="inp">
                        <label class="email" for="DueDate">ToDate</label>
                        <input type="text" name="ToDate" id="ToDate1" value="" placeholder="DD/MM/YYYY" autocomplete="off">
                       
                     </div>
                  </div>
               </div>


           
               
               <div align="center"><font style="color:red;"><label id="LblErrorMessage"></label></font></div>
                  <div class="col-md-12" style="display: flow-root;" >

                     <input type="submit" value="Show filtered results"  name="btnFilter" class="btn-save" ></button>
                  </div>

              
    </div>      
    <div class="row">
    <?php 
        
        $tdbottomborderblue=" style='border-bottom:1pt solid blue;' " ;
        $CriteriaUSR='';
        $CriteriaTask='';
                    //--------- add all time for each task Group By
        $CriteriaTaskSUM=" SEC_TO_TIME( SUM( TIME_TO_SEC( t4.TimeTaken ) ) ) AS TASTTIMETAKE ";
        $CriteriaGroup= " GROUP BY t1.TRecRef ";
        
    if ($selForRefUSR1!='') {$CriteriaUSR=" AND RefUSR='$selForRefUSR1' "; }
    
    if ($uTDETAIL!='') {
        $CriteriaTask=" AND t1.TRecRef='$uTDETAIL' ";
        $CriteriaTaskSUM=' t4.TimeTaken AS TASTTIMETAKE';
        $CriteriaGroup='';
    }
    

    echo "<table id='tableData1' class='content-table' style='overflow-x:auto;'>";
    
    echo "<thead><tr>
    <th>Company </th>
    <th>User</th>
    <th> Task</th>
    <th >Hours</th>
    </tr></thead>";
   
  echo "<tbody>";
    $query11="SELECT RefUSR, Company, CompanyID FROM `tUser` WHERE Status='ACT' $CriteriaUSR ORDER BY Company, CompanyID "; 
    //echo $query11;
    $sql11 = mysqli_query($mysqli, $query11);
    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $uRefUSR=$row11['RefUSR'];
        $uFullName=$row11['Company'];
  
        $query12="SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `TimeTaken` ) ) ) AS UTIMETAKE FROM `tTaskNotes` 
        WHERE NotesBy='$uRefUSR' AND  (DATE(NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' ) "; 
$sql12 = mysqli_query($mysqli, $query12);
//echo $query12;
while($row12=mysqli_fetch_array($sql12))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
  {
      $userTotalHours=$row12['UTIMETAKE'];
  }         


        echo "<tr>
        <td>
        <a href=phrsuser.php?DUSER=$uRefUSR&uFD=$sqlFromDate&uTD=$sqlToDate target=_self>$uFullName</a>
        </td>
        ";

         
         echo "<td ></td>";
         echo "<td ></td>";

           echo "<td >$userTotalHours</td>
           
           </tr>";

           if ($ForRefUSR==$uRefUSR) {
            $query12="SELECT t1.TRecRef, t1.TaskTitle, t2.ForCoRecRef, $CriteriaTaskSUM, t4.Notes 
                      FROM tTasks AS t1, tSchedule AS t2, tCalendar AS t3, tTaskNotes AS t4 
                      WHERE t1.TRecRef=t2.TRecRef AND t2.SRecRef=t3.SRecRef AND t3.cRecRef=t4.cRecRef $CriteriaTask
                      AND t4.NotesBy='$uRefUSR' AND  (DATE(t4.NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' )
                      $CriteriaGroup ORDER BY t2.ForCoRecRef, t1.TaskTitle  "; 
            $sql12 = mysqli_query($mysqli, $query12);
            //echo $query12;
            while($row12=mysqli_fetch_array($sql12))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                {
                    $TaskRecRef=$row12['TRecRef'];
                    $TaskTitle=$row12['TaskTitle'];
                    $TaskNotes=$row12['Notes'];
                    $dTimeTaken=$row12['TASTTIMETAKE'];
                    $dForCoRecRef=$row12['ForCoRecRef'];
                    $CoShortCode=getCompanyShortCode($dForCoRecRef);



                    echo "<tr>
                    <td  $tdbottomborderblue > 
                        <a href=phrsuser.php?DUSER=$uRefUSR&uFD=$sqlFromDate&uTD=$sqlToDate&uTDETAIL=$TaskRecRef target=_self>$TaskTitle</a> ";
                     
                    if ($uTDETAIL!='') {
                        echo "<br/>&nbsp;&nbsp; <i>$TaskNotes;</i></td>";
                     }
                            echo "<td  $tdbottomborderblue> $CoShortCode</td>
                              <td $tdbottomborderblue> $dTimeTaken
                              </td>
                              
                              </tr>";

    
   
                            }         

                          }    //------ end if $ForRefUSR
                    
               }   //------ end while $row11

               echo "</tbody>";  
              
               echo "</table>";  
                            
               
           ?>
                     </div>


         </article>
            </form>
      </main>
      </div>
      </div>
  
</div>
<!--- by Company Tab End -->
</div>

<!-- pagination js start -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/paging.js"></script> 


<script type="text/javascript">
            $(document).ready(function() {
                $('#tableData').paging({limit:15});
            });
        </script>
        <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<script type="text/javascript">
            $(document).ready(function() {
                $('#tableData1').paging({limit:15});
            });
        </script>
        <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'https://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- pagination js end -->

<! -- tab start -->

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
</script>
    

<! -- tab end -->

<!--- user script start-->
<script>
$(document).ready(function(){
    var FromDate;
    var ToDate;
    //$(":input").inputmask();
    $("#FromDate").datepicker({
                     dateFormat: 'dd/mm/yy'
                    });
    $("#ToDate").datepicker({
        dateFormat: 'dd/mm/yy'
    });

    $('#FromDate').change(function(){
        startDate=$(this).datepicker('getDate');

        $('#ToDate').datepicker('option','minDate',startDate);
    });

    $('#ToDate').change(function(){
        endDate=$(this).datepicker('getDate');

        $('#FromDate').datepicker('option','maxDate',endDate);
    });
});
</script>
<!--- user script end-->

<!--- company script start-->

<script>
$(document).ready(function(){
    var FromDate;
    var ToDate;
    //$(":input").inputmask();
    $("#FromDate1").datepicker({
                     dateFormat: 'dd/mm/yy'
                    });
    $("#ToDate1").datepicker({
        dateFormat: 'dd/mm/yy'
    });

    $('#FromDate1').change(function(){
        startDate=$(this).datepicker('getDate');

        $('#ToDate1').datepicker('option','minDate',startDate);
    });

    $('#ToDate1').change(function(){
        endDate=$(this).datepicker('getDate');

        $('#FromDate1').datepicker('option','maxDate',endDate);
    });
});
</script>
<!--- company script start-->
</body>
</html>    