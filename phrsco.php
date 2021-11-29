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


//include "connect_to_mysql.php";
include "myfunctions.php";              //---------- my own Company Variables, Setttings & common functions
//include "i_functions.php"; 

$btnFilter=$_POST['btnFilter'];
$FromDate=$_POST['FromDate'];
$ToDate=$_POST['ToDate'];

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
        $ForCoRef=$_GET['DCOMP'];
        $uFDate=$_GET['uFD'];
        $uTDate=$_GET['uTD'];

        if ($uFDate!='' && $uTDate!='') {
            $FromDate = substr($uFDate,8,2)."-".substr($uFDate,5,2)."-".substr($uFDate,0,4);
            $ToDate = substr($uTDate,8,2)."-".substr($uTDate,5,2)."-".substr($uTDate,0,4);
            $sqlFromDate = $uFDate;
            $sqlToDate = $uTDate;
        }
    //echo "<br>2 uFDate=$uFDate ---uTDate=$uTDate ----- ForRefUSR=$ForRefUSR ---FromDate=$FromDate ---sqlFromDate=$sqlFromDate ---ToDate=$ToDate ---sqlToDate=$sqlToDate ";
    }

    


?>


<html>
<head>
<title>Tasks On Cloud</title>

      
	<meta charset="UTF-8">
        <link rel="shortcut icon" type="image/png" href="images/icontask.png"/>
        <link rel="stylesheet" type="text/css" href="cssjs/newstyle.css"></link>
 	
<!--  start Mask  Date Validation   -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="cssjs/jquery.inputmask.bundle.min.js"></script>
<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>
<!--  End Mask Date Validation    -->



<script>
     


</script>

</head>

<body>


<form action="" name="TaskMgmt" id="TaskMgmt" method="post" enctype="multipart/form-data" target="_self" >  
    
<!-- --------------------- START Column 1 ------------------ START -->

<div class="column_one" >
            <div class="divmenu" onclick="window.location.href='phrsuser.php'"  >
                <b>By User</b>
            </div>
            <div class="divmenu" onclick="window.location.href='phrsco.php'" style='background-color:#5DADE2;' >
                <b>By Company</b>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
    <label style="width:90px">From Date:</label>
    <input type="text" class="form-control" style="width:120px" name="FromDate" id="FromDate" data-inputmask="'alias': 'date'" value="<?php echo $FromDate; ?>"/>

    
    <label style="width:10px">&nbsp;</label>
    <label style="width:30px">To:</label>
    <input type="text" class="form-control" style="width:120px" name="ToDate" id="ToDate" data-inputmask="'alias': 'date'" value="<?php echo $ToDate; ?>"/>

     
        <label style="width:10px">&nbsp;</label>
            <input type=submit name="btnFilter"  value="Filter" class='btn btn-default' />
            
<div style="background-color: #ffffff">
    <?php 
    
        $tdbottomborderblue=" style='border-bottom:1pt solid blue;' " ;

        
    echo "<table cellpadding=4 cellspacing=0 width=100% border=0>";
    echo "<tr><td>Company</td><td>Task  -  User</td><td align=right>Hours</td></tr>";
    $query11="SELECT * FROM `tCompany` WHERE Status='ACT' ORDER BY CoName "; 
    $sql11 = mysqli_query($mysqli, $query11);
    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $uCoRecRef=$row11['CoRecRef'];
        $uCoName=$row11['CoName'];
         echo "<tr style='background-color:#5DADE2;'><td width=200px><a href=phrsco.php?DCOMP=$uCoRecRef&uFD=$sqlFromDate&uTD=$sqlToDate target=_self><b>$uCoName</b></a></td><td></td>";

         $userTotalHours='';
            $query12="SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( t4.TimeTaken ) ) ) AS UTIMETAKE 
                             FROM tTasks AS t1, tSchedule AS t2, tCalendar AS t3, tTaskNotes AS t4 
                             WHERE t1.TRecRef=t2.TRecRef AND t2.SRecRef=t3.SRecRef AND t3.cRecRef=t4.cRecRef 
                             AND t2.ForCoRecRef='$uCoRecRef' AND  (DATE(t4.NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' ) "; 
            $sql12 = mysqli_query($mysqli, $query12);
            //echo $query12;
            while($row12=mysqli_fetch_array($sql12))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                {
                    $userTotalHours=$row12['UTIMETAKE'];
 
                }         
            echo "<td width=200px align=right><b>$userTotalHours</b></td></tr>";
            
                if ($uCoRecRef==$ForCoRef) {
                   $query13="SELECT t1.TaskTitle, t2.ForCoRecRef, t4.NotesBy, t4.TimeTaken 
                             FROM tTasks AS t1, tSchedule AS t2, tCalendar AS t3, tTaskNotes AS t4 
                             WHERE t1.TRecRef=t2.TRecRef AND t2.SRecRef=t3.SRecRef AND t3.cRecRef=t4.cRecRef 
                             AND t2.ForCoRecRef='$uCoRecRef' AND  (DATE(t4.NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' )
                             ORDER BY t1.TaskTitle, t4.NotesBy  "; 
                   $sql13 = mysqli_query($mysqli, $query13);
                   //echo $query13;
                   while($row13=mysqli_fetch_array($sql13))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                       {
                           $TaskTitle=$row13['TaskTitle'];
                           $dTimeTaken=$row13['TimeTaken'];
                           $dNotesBy=$row13['NotesBy'];
                           $NameNotesBy=getUserFullName($dNotesBy);
                           echo "<tr><td width=200px align=left $tdbottomborderblue> $TaskTitle</td>
                                     <td width=50px align=left $tdbottomborderblue> $NameNotesBy</td>
                                     <td width=200px align=right $tdbottomborderblue> $dTimeTaken</td></tr>";
                       }         

                   }    //------ end if $ForRefUSR
             
        }   //------ end while $row11
        echo "</table>";
       
        
    ?>
    
</div>    
            <br/><br/><br/>
            
</div>

<!-- --------------------- END Column 1 --------------------- END -->

<!-- --------------------- START Column 2 ------------------ START -->
<div class="column_two" valign="top">
    
    
    
</div>
<!-- --------------------- END Column 2 --------------------- END -->

</form>
    
    


</body>
</html>    