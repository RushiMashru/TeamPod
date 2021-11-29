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
        
        if ($uFDate!='' && $uTDate!='') {
            $FromDate = substr($uFDate,8,2)."-".substr($uFDate,5,2)."-".substr($uFDate,0,4);
            $ToDate = substr($uTDate,8,2)."-".substr($uTDate,5,2)."-".substr($uTDate,0,4);
            $sqlFromDate = $uFDate;
            $sqlToDate = $uTDate;
        }
    //echo "<br>2 uFDate=$uFDate ---uTDate=$uTDate ----- ForRefUSR=$ForRefUSR ---FromDate=$FromDate ---sqlFromDate=$sqlFromDate ---ToDate=$ToDate ---sqlToDate=$sqlToDate ";
    }

    
    $query101="SELECT RefUSR, FirstName, LastName FROM `tUser` ORDER BY FirstName, LastName ";
    $sql101 = mysqli_query($mysqli, $query101);
    $i=0;
    $UserCodeName_arr[$i][0]="";
    $UserCodeName_arr[$i][1]="--- ALL ---";
    $i=1;
    while($row101=mysqli_fetch_array($sql101))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $UserCodeName_arr[$i][0]=$row101['RefUSR'];
        $UserCodeName_arr[$i][1]=$row101['FirstName'].' '.$row101['LastName'];
        //echo ' Yes '.$UserCodeName_arr[$i][0];
        $i++;
        }
    
	$maxusercodename = sizeof($UserCodeName_arr);
   

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

<div class="column_one" style="width:84%;margin-left:16%;margin-top:56px">
    <div style="float:left;">
            <div class="divmenu" onclick="window.location.href='phrsuser.php'" style='background-color:#5DADE2;'  >
                <b>By User</b>
            </div>
            <div class="divmenu" onclick="window.location.href='phrsco.php'" >
                <b>By Company</b>
            </div>
    </div>
    <br clear="all"/>
    <div style="float:left;margin:5px 0 0 0px;width:100%">
           <div class="labelcust1">For User:</div> 
           <select class="total_fields forminput" style="width:67%;float:left" name="selForRefUSR" id="selForRefUSR"  >
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
    <br clear="all"/>
    <br clear="all"/>
    <div class="labelcust1">From Date:</div>
    <input type="text" class="total_fields forminput" style="width:120px;float:left" name="FromDate" id="FromDate" data-inputmask="'alias': 'date'" value="<?php echo $FromDate; ?>"/>

    <br clear="all"/>
    <br clear="all"/>
    <div class="labelcust1">To:</div>
    <input type="text" class="total_fields forminput" style="width:120px;float:left" name="ToDate" id="ToDate" data-inputmask="'alias': 'date'" value="<?php echo $ToDate; ?>"/>
     
    <input type=submit name="btnFilter"  style="margin-left:20px;height:32px;width:100px;float:left" value="Filter" class='btn btn-default' />
    </div>      
        <br clear="all"/>
    <br clear="all"/>
<div style="background-color: #ffffff">
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

        
    echo "<table id='users'  cellpadding=4 cellspacing=0 border=0>";
    echo "<tr><th>Full Name</th><th>Task  -  Company</th><th align=right>Hours</th></tr>";
    $query11="SELECT RefUSR, FirstName, LastName FROM `tUser` WHERE Status='ACT' $CriteriaUSR ORDER BY FirstName, LastName "; 
    //echo $query11;
    $sql11 = mysqli_query($mysqli, $query11);
    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $uRefUSR=$row11['RefUSR'];
        $uFullName=$row11['FirstName'].' '.$row11['LastName'];
         echo "<tr><td><a href=phrsuser.php?DUSER=$uRefUSR&uFD=$sqlFromDate&uTD=$sqlToDate target=_self><b>$uFullName</b></a></td><td></td>";

            $query12="SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `TimeTaken` ) ) ) AS UTIMETAKE FROM `tTaskNotes` 
                      WHERE NotesBy='$uRefUSR' AND  (DATE(NotesDT) BETWEEN '$sqlFromDate' AND '$sqlToDate' ) "; 
            $sql12 = mysqli_query($mysqli, $query12);
            //echo $query12;
            while($row12=mysqli_fetch_array($sql12))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                {
                    $userTotalHours=$row12['UTIMETAKE'];
                }         
            echo "<td width=10% align=right><b>$userTotalHours</b></td></tr>";
            
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
                           
                           echo "<tr><td width=200px align=left $tdbottomborderblue > 
                               <a href=phrsuser.php?DUSER=$uRefUSR&uFD=$sqlFromDate&uTD=$sqlToDate&uTDETAIL=$TaskRecRef target=_self><b>$TaskTitle</b></a> ";
                            
                           if ($uTDETAIL!='') {
                               echo "<br/>&nbsp;&nbsp; <i>$TaskNotes;</i></td>";
                            }
                                   echo "<td width=50px align=right $tdbottomborderblue> $CoShortCode</td>
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