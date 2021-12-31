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


$ForCompany=$_POST['ForCompany'];
$selForRefUSR=$_POST['selForRefUSR'];
$ForTaskTag=$_POST['ForTaskTag'];

if ($selForRefUSR=='') {$selForRefUSR=$id;}

if ($ForCompany==''){
    $ForCompany='ALL';
}

$CalendarView=$_GET['CV'];        //--   check the selected month via NEXT or PREVIOUS button by receiving url
$StartOfWeek=$_GET['CM'];        //--   check the selected month via NEXT or PREVIOUS button by receiving url
if ($StartOfWeek=='')              //----------- if no url receive then check today's month
    {$day = date('w');
     $StartOfWeek=date('d-m-Y');
    }
    
$sqlStartOfWeek = date ("Y-m-d", strtotime($StartOfWeek));

$EndOfWeek=date('d-m-Y', strtotime('+6 days', strtotime($StartOfWeek)));
$sqlEndOfMonth = date ("Y-m-d", strtotime($EndOfWeek));
$NoOfDays=date("d", strtotime($EndOfWeek)); $NoOfDays+=1;                                                                        //--------------- calculate PREVIOUS & NEXT month
$pweek=date ("d-m-Y", strtotime("-1 week", strtotime($StartOfWeek)));
$nweek=date ("d-m-Y", strtotime("+1 week", strtotime($StartOfWeek)));    

//echo '<br>Current Week='.$CurrentWeek.'     day= '.$day.'     Start-W='.$StartOfWeek.'    End-W= '.$EndOfWeek;
//echo '<br>Previous-W= '.$pweek.' next-W= '.$nweek;

//--------------- show calender header
$south.="<table class='table-list' >
        <tr><td style='text-align:center;background-color:#ffe199;font-weight:bold;' colspan='9' >
        <a href=pcalendarw.php?CM=$pweek target=_self><pre style='display: inline-block;
        width: 10px;font-weight:bold;'>&lt;</pre></a>
        <span>$StartOfWeek &nbsp;&nbsp;&nbsp;&nbsp; $EndOfWeek</span>
        <a href=pcalendarw.php?CM=$nweek target=_self> <pre style='display: inline-block;
        width: 10px;font-weight:bold;'>&gt;</pre>
        </td></tr> ";  
             


        
//---------------End of header

$south.="<tr><td bgcolor='#FFFFFF' align=center><b>Name</b></td><td>Over Due</td>";
$showdate=$StartOfWeek;
while (strtotime($showdate) <= strtotime($EndOfWeek))     //------ loop to show 15 days in header
    { 
        $showdate = date ("d-M-y", strtotime($showdate));
        $dd = date ("d", strtotime($showdate));
        $dw = date( "l", strtotime($showdate));
        $CellColor='#FFFFFF';
        if ($dw=='Saturday' || $dw=='Sunday') {$CellColor='#DEDEDE';}
        if ($PCountry=='IE' && $dw=='Saturday') {$CellColor='#FFFFFF';}             
            
        $dw=Substr($dw,0,3)  ; 
        $south.="<td style='width:22;font-size:12px;text-align:center;background-color:$CellColor'><b>$dd</b><br>$dw</td>";
        $showdate = date ("d-M-y", strtotime("+1 day", strtotime($showdate)));
    } //---- end while loop to show 30days header
//$sout.="";
    
$checkTodayDateSTR=strtotime(date("Y-m-d"));
    
$sout.=$south;

if ($CanSystemAdmin==1) {$CriteriaUSR='';}
else {$CriteriaUSR=" AND RefUSR='$id' "; }
if ($selForRefUSR!='ALL') {$CriteriaUSR=" AND RefUSR='$selForRefUSR' "; }
if ($ForTaskTag!='') {$FTTagCriteria.=" AND t3.cRecRef IN ( SELECT cRecRef FROM `tTaskTags` WHERE TagTitle='$ForTaskTag'  AND RefUSR ='$id') ";}

    $FUCriteria=""; 
    if ($ForCompany!='ALL') {$FUCriteria=" AND t2.ForCoRecRef=$ForCompany "; }


    $query101="SELECT RefUSR, FirstName, LastName FROM `tUser` WHERE 1 $CriteriaUSR ORDER BY FirstName, LastName ";
    $sql101 = mysqli_query($mysqli, $query101);
    while($row101=mysqli_fetch_array($sql101))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
        {
        $sRefUSR=$row101['RefUSR'];
        $sFullName=$row101['FirstName'].' '.$row101['LastName'];
        $sout.="<tr style='outline: 2px solid #ffe199;' ><td ><b>$sFullName</b></td>";

        $showdate=$StartOfWeek;

        $sout.="<td valign=top  style='line-height:1.2' width=11%>";
        
		$query132="SELECT t1.cRecRef, t1.cScheduleDate, t1.cDueDate, t1.Stage, t1.CompleteBy, t2.SRecRef, t1.ForRefUSR, t2.ForCoRecRef, t3.TRecRef, t3.TaskTitle , t3.Priority
				   FROM `tCalendar` AS t1, `tSchedule` AS t2, `tTasks` AS t3 
				   WHERE t1.SRecRef=t2.SRecRef AND t2.TRecRef=t3.TRecRef AND t1.ForRefUSR='$sRefUSR' $FUCriteria $FTTagCriteria 
				   AND t1.cDueDate<'$sqlStartOfWeek' AND t1.CompleteBy=0 and t1.Status='A'
				   ORDER BY cScheduleDate  ";
		//echo '<br>'.$query132;
		$sql132 = mysqli_query($mysqli, $query132);
		
			while($row132=mysqli_fetch_array($sql132))
				{
				$cTaskRef=$row132['cRecRef'];
				$tTaskRef=$row132['TRecRef'];
				$cScheduleDate=$row132['cScheduleDate'];
				$cDueDate=$row132['cDueDate'];
				$TaskTitle=$row132['TaskTitle'];
				$CompleteBy=$row132['CompleteBy'];
				$Priority=$row132['Priority'];
				$cForCoRecRef=$row132['ForCoRecRef'];
                $cCoCode=getCompanyShortCode($cForCoRecRef);
				$statuscolor="style='color:red' ";
				$sout.="<div style='border: 1px #aaa solid;padding:2px;border-radius:5px'><span $statuscolor><b> Task#$tTaskRef - $Priority</b></span><br clear='all'/> <a onclick=popup('popUpDiv','calendar','$tTaskRef') style='line-height:1.2;'> <span $statuscolor ><b>$cCoCode</b><br clear='all' />$TaskTitle<span> </a><br  clear='all' />$cDueDate<br  clear='all' /></div><br  clear='all' />";

				}   //-------- end while $row132 calender tasks list
        $sout.="</td>";


            $tTaskRefPrvDay ="";
            while (strtotime($showdate) <= strtotime($EndOfWeek))     //------ loop to show 30 days in header
                { 
                    $TaskForDate = date ("Y-m-d", strtotime($showdate));
                    //echo '<br>ForDate='.$TaskForDate;
                    $TodayCellColor='#ffffff';
                    $checkTaskDateSTR=strtotime($TaskForDate);
                    if ($checkTodayDateSTR==$checkTaskDateSTR) { $TodayCellColor='#ffe199';}
                    $tTaskRefPrvDay = substr($tTaskRefPrvDay,2);
                    if ($tTaskRefPrvDay!="") {$taskcriteriaprvday = " AND t2.TRecRef NOT IN ($tTaskRefPrvDay)";}
                    $sout.="<td valign=top style='background-color:$TodayCellColor;line-height:1.2;width:11%'>";

                        $query102="SELECT t1.cRecRef, t1.cScheduleDate, t1.cDueDate, t1.Stage, t1.CompleteBy, t2.SRecRef, t1.ForRefUSR, t2.TRecRef, t2.ForCoRecRef, t3.TRecRef, t3.TaskTitle , t3.Priority
                                   FROM `tCalendar` AS t1, `tSchedule` AS t2, `tTasks` AS t3 
                                   WHERE t1.SRecRef=t2.SRecRef AND t2.TRecRef=t3.TRecRef AND t1.ForRefUSR='$sRefUSR' $FUCriteria $FTTagCriteria
                                   AND ( t1.cScheduleDate <= '$TaskForDate' AND t1.cDueDate >= '$TaskForDate' ) and t1.Status='A'
                                   ORDER BY cScheduleDate  ";
                       // echo '<br>'.$query102;
                        $sql102 = mysqli_query($mysqli, $query102);
                        
                            while($row102=mysqli_fetch_array($sql102))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                                {
                                $tTaskRef=$row102['TRecRef'];
                                $cTaskRef=$row102['cRecRef'];
                                $cScheduleDate=$row102['cScheduleDate'];
                                $cDueDate=$row102['cDueDate'];
                                $TaskTitle=$row102['TaskTitle'];
                                $CompleteBy=$row102['CompleteBy'];
			                	$cForCoRecRef=$row102['ForCoRecRef'];
                                $cCoCode=getCompanyShortCode($cForCoRecRef);
                                $Priority=$row102['Priority'];
                                $statuscolor="style='color:black' ";
                                if ($CompleteBy==0 && $cDueDate<$current_date) {$statuscolor="style='color:red' ";}
                                if ($CompleteBy!=0) {$statuscolor="style='color:green' ";}
                                if (($cScheduleDate !==$cDueDate) && $TaskForDate == date('Y-m-d') ) { $print = 'Y'; } else { $print = 'N'; }
                                if ($TaskForDate == $cDueDate && $TaskForDate < date('Y-m-d')) { $print = 'Y'; } 
                                if ($TaskForDate == $cScheduleDate && $TaskForDate > date('Y-m-d')) { $print = 'Y'; } 
                                if ($cScheduleDate == $cDueDate) { $print = 'Y'; }
                                if ($print == 'Y') {
                                $sout.="<div style='border: 1px #999 solid;padding:2px;border-radius:5px'><span style='color:#666;'><b> Task#$tTaskRef - $Priority</b></span><br clear='all'/>";
                                $sout.="<a onclick=popup('popUpDiv','calendar','$tTaskRef') style='line-height:1.2' '> <span $statuscolor ><b>$cCoCode</b><br clear='all'/>$TaskTitle<span> </a><br  clear='all' />";
                                if ($cScheduleDate !==$cDueDate) {$sout.="SD=$cScheduleDate <br>DD=$cDueDate";}
                                $sout.="</div><br  clear='all' />";
                                }
                                //<br>S-$cScheduleDate<br>D-$cDueDate<hr/><br>";
                                //$sout.="SD=$cScheduleDate <br>DD=$cDueDate <br><a href=pallitems.php?ET=$cTaskRef target=_self> <span $statuscolor >$TaskTitle<span> </a><hr/><br>";
                                $tTaskRefPrvDay = $tTaskRefPrvDay .",'".$tTaskRef."'";
                                }   //-------- end while $row102 calender tasks list

                    $sout.="</td>";

                    $showdate = date ("d-M-y", strtotime("+1 day", strtotime($showdate)));

                } //---- end while loop to show 30days header

    

        $sout.="</tr>";
        
        }   //-------- end while $row101 user list
$sout.="</table>";



if ($CanSystemAdmin==1) {
    $query101="SELECT RefUSR, FirstName, LastName FROM `tUser` ORDER BY FirstName, LastName ";
    $i=0;
    $UserCodeName_arr[$i][0]="";
    $UserCodeName_arr[$i][1]="--- ALL ---";
    $i=1;
}
else
{
    $query101="SELECT RefUSR, FirstName, LastName FROM `tUser` WHERE RefUSR='$id' ORDER BY FirstName, LastName ";
    $i=0;
}
    $sql101 = mysqli_query($mysqli, $query101);
    $i=0;
    $UserCodeName_arr[$i][0]="ALL";
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
   
        
        $AllCompanyCode_arr = array();             //---------------- Get all File Codes from database table then when require only show specific codes in select statement

        $i=0;
            $AllCompanyCode_arr[$i][0]='ALL';
            $AllCompanyCode_arr[$i][2]='All Companies';
        $query11="SELECT t1.*,t2.CoRecRef,t2.CoCode,t2.CoName FROM `tUserAccessLevels` as t1, `tCompany` AS t2 
                  WHERE t1.FCompany=t2.CoRecRef AND t2.CoType='COMPANY' AND t2.Status='ACT' AND t1.RefUSR='$id'
                  GROUP BY t1.FCompany ORDER BY t2.CoName ";
        $sql11 = mysqli_query($mysqli, $query11);
        $i=1;
        while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
            {
            $AllCompanyCode_arr[$i][0]=$row11['CoRecRef'];
            $AllCompanyCode_arr[$i][1]=$row11['CoCode'];
            $AllCompanyCode_arr[$i][2]=$row11['CoName'];
            $i++;
            }
	$maxcompanycode = sizeof($AllCompanyCode_arr);
        
      
?>


<html>
<head>
<title>Tasks On Cloud</title>

<base target="main">
    
<!-- <meta http-equiv="refresh" content="50"></meta>     -->

<link rel="shortcut icon" type="image/png" href="images/icontask.png"/>
<link rel="stylesheet" type="text/css" href="cssjs/newstyle.css"></link>
<link rel="stylesheet" type="text/css" href="css/pcalendarw.css"></link>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!--  start Mask  Date Validation   -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="sysdm/jquery.inputmask.bundle.min.js"></script>

<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>
<!--  End Mask Date Validation    -->


 
</head>

<body>

        
    <form action="" name="TaskMgmt" id="TaskMgmt" method="post" enctype="multipart/form-data" target="_self" >    
    
        <!-- Main TAB menu Header START -->

        <div class="calendar-header">
        <div class="search-container">
    <form action="/action_page.php">
      <input type="text" placeholder="Search.." name="search" style=" border-radius: 18px;">
      <i class="fa fa-search" style="font-size: 14px; margin-left: -23px;"></i>
    </form>
  </div>
          <span>  <div class="button"  onclick="window.location.href='pcalendarw.php'" >Weekly</div>
           <div class="button" onclick="window.location.href='pcalendarm.php'">Monthly</div>
            <img src="images/Filters.svg"  onclick="openfilter()" style="height: 25px;" >
         
            <div class=sidenav1 id=sidenav1>
           <label style="width:100px;float:left;font-size: 18px;"> Filter by:</label> <i class="fa fa-close" onclick="window.location.href='pcalendarw.php'"></i> <a onclick="closefilter()"><img style="border:none;background:#eee;float:right;margin-right:10px" alt="" src="../focinc/images/close.jpg" /></a><br/><br/>
            <select class="total_fields forminput" name="ForCompany" style="width:200px;" >
                        <?php  $i=0; 
                        while($i<$maxcompanycode)
                        {   
                            $valueof= $AllCompanyCode_arr[$i][0] ;
                            
                            if ($ForCompany == $valueof) {  ?>
                                <option value="<?php echo $valueof; ?>" selected> <?php echo $AllCompanyCode_arr[$i][2] ?></option>
                            <?php } else{ ?>    
                                <option value="<?php echo $valueof ?>"> <?php echo $AllCompanyCode_arr[$i][2] ?> </option>
                        <?php  }  $i++; } ?>
                </select>
           <br clear='all'/><br clear='all'/>
            <select class="total_fields forminput" name="selForRefUSR" id="selForRefUSR" style="width:200px" >
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
            <br clear='all'/><br clear='all'/>
            <select class="total_fields forminput" name="ForTaskTag" style="width:200px">
                    <option value="">Task Tags</option>
                        <?php  $i=0; 
                        while($i<$maxtasktags)
                        {   
                            $valueof= $AllTasksTagList_arr[$i][0] ;
                            
                            if ($ForTaskTag == $valueof) {  ?>
                                <option value="<?php echo $valueof; ?>" selected> <?php echo $AllTasksTagList_arr[$i][0] ?></option>
                            <?php } else{ ?>    
                                <option value="<?php echo $valueof ?>"> <?php echo $AllTasksTagList_arr[$i][0] ?> </option>
                        <?php  }  $i++; } ?>
                </select>           
           <br clear='all'/><br clear='all'/>
           <div class="floatleft">
            <input type=submit name="btnFilter"  value="Filter" style="margin-left:20px;height:32px;width:100px" class='btn btn-default' />
            </div>
        </div>
        </div>
        </span>
        </div>

    
        <!-- Main TAB menu Header END -->
<br>
        
<?php echo $sout ?>


    </form>

<br/><br/> <br/><br/> 

</body>
</html>    