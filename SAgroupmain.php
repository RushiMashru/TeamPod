<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include("header.php");

if(isset($_COOKIE["name"]))           { $loginame=$_COOKIE["name"]; }
if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }
//echo '<br>UserID='.$id.'...UserName='.$loginame.'...SysAdmin='.$CanSystemAdmin.'...AccessLevel='.$AccessLevel ;
GLOBAL $AccessLevel;


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

                       
                        
        $AllCompanyCode_arr = array();        

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
    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
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
    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
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
    
 $query15= "SELECT CliRecRef FROM `tUser`where RefUSR='$id' ";
            $sql15 = mysqli_query($mysqli, $query15);
            $row15 = mysqli_fetch_array($sql15);
            $CliRecRef = $row15["CliRecRef"];        


    GLOBAL $AccessLevel;

    $page="maingroup";
    
    
    
    
    $uToAct=$_GET["ToAct"];
    $uRIDNO=$_GET["RIDNO"];
    
        //    echo "<script> alert ('$uToAct / $uRIDNO ');</script>";
    $SuccessMessage='';    
    
        $NewTitle=$_POST["NewTitle"];
        $selAccountStatus=$_POST["selAccountStatus"];
    
        $AddNewBtnClick=$_POST['AddNewBtnClick'];    //--   AddNewBtnClick  - to store a value from validation check if all valid is ok & submit button was pressed
    
        // var_dump($_POST);
    
    if ($AddNewBtnClick=="YES"  )
    {
        $AddNewBtnClick="";
        
        
        if ($uRIDNO!='')      //----- if Edit Record
        {   
            $query11="UPDATE `tTaskgCode` SET `gTitle`='$NewTitle',`Status`='$selAccountStatus'  
                      WHERE `gRecRef`='$uRIDNO'  " ;
            $sql11 = mysqli_query($mysqli, $query11);
    
            echo "<script> alert ('Record Updated');</script>";
            
        }
        else            //----- add new rocord
        {
            
           $query2="INSERT INTO `tTaskgCode`( `gTitle`,     `gUsedFor`,         `Status`, `CliRecRef`) 
                                    VALUES ( '$NewTitle', 'TASKMAINGROUP', '$selAccountStatus','$CliRecRef') " ;
            $sql2 = mysqli_query($mysqli, $query2);
            //$uUSRIDNO=$mysqli->insert_id;
    
            echo "<script> alert ('New Record Added');</script>";
        }
    
       
        
        echo "<script>document.location='SAgroupmain.php';</script>";
        
    }  //---- end if $AddNewBtnClick
    
    
        if ($uRIDNO!='')      //----- Show detail if Edit Record
        {
        
       
            $query31="SELECT * FROM `tTaskgCode` WHERE `gRecRef`='$uRIDNO'  " ;
            $sql31 = mysqli_query($mysqli, $query31);
            while($row31 = mysqli_fetch_array($sql31))
            {
                $gRecRef=$row31['gRecRef'];
                $gTitle=$row31['gTitle'];
                $gUsedFor=$row31['gUsedFor'];
                $selAccountStatus=$row31['Status'];
            }		    
            
        }
    


?>


<html>
<head>
<title>Team Pod</title>

<style>
/* Style the buttons */
.btn1 {
    border: none;
    outline: none;
    padding: 13px 30px;
    background-color: #ffe199;
    cursor: pointer;
    font-size: 14px;
    border-radius: 10px;
}

/* Style the active class, and buttons on mouse-over */
.active, .btn1:hover {
  border-radius: 10px !important;
  background-color: #e74c3c !important;
  color: white;
}

@media screen and (min-width: 1668px) {
  #customers {
       margin-left: 400px;
    }
}
</style>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  margin-left: 330px;
    width: 60%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}



#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #ffe199;
    color: #e74c3c;
}
input[type=text] {
  width: 15%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid #555;
  outline: none;
  border-radius: 20px;
  margin-left:5px;
}


select
{ width: 15%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 1px solid #555;
  outline: none;
  border-radius: 20px;
  margin-left:5px;
}


input[type=text]:focus {
  background-color: lightblue;
}
select:focus{
  background-color: lightblue;
}
.button{
    background-color: #4caaaf;
    border: none;
    color: white;
    padding: 10px 35px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 24px;
    margin-left:5px;
}
</style>


<!--  start Mask  Date Validation   -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="jquery.inputmask.bundle.min.js"></script>


<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>
<!--  End Mask Date Validation    -->


<script>
function validcheck1()
{
    
        if(document.forms["UserForm"]["NewTitle"].value=="")
        {
        document.UserForm.NewTitle.focus() ;
        NewTitle.style.borderColor = "red";
        NewTitle.style.color = "red";
          return false;
        }


	/*   after all field valids then submit the form */
 document.forms["UserForm"]["AddNewBtnClick"].value="YES";				//----- store parameter to check if the Submit New Button was clicked
 document.forms['UserForm'].submit();


}

</script>

</head>

<body>

<div id="myDIV" style="margin-top:100px;">
  <a class="btn1 active" href="SAgroupmain.php">Main Groups</a>
  <a class="btn1 " href="SAgroupsub.php">Sub Groups</a>
  <a class="btn1" href="SAcompanyacc.php">Company Account</a>
  <a class="btn1" href="SAtaskmanagement.php">Task Management Access</a>
</div>

<div class="row" style="margin-top:30px;">


<form action="" name="UserForm" method="post">
            <input type=hidden name=AddNewBtnClick value="">

  <input type="text" id="NewTitle" name="NewTitle" placeholder="Task Main Group Title"  value="<?php echo $gTitle; ?>" required>
  
  <select name="selAccountStatus" id="selAccountStatus" required>
  <option value="ACT" <?php if($selAccountStatus=='ACT') { ?> selected="selected" <?php } ?> >Active</option>
                        <option value="INA" <?php if($selAccountStatus=='INA') { ?> selected="selected" <?php } ?> >In-Active</option>
  </select>
  
  <button class="button"  name="btnSave" value="SaveGroup" onclick="validcheck1()">Save Group</button>

</div>
<div class=hbox> <h3 style="color: #6f6467;">Main Group List</h3> </div>
  <div style="margin-top:5px;">
  <?php 

$query6 = "SELECT * FROM `tTaskgCode` WHERE gUsedFor='TASKMAINGROUP' AND CliRecRef = '$CliRecRef' ORDER BY `gTitle` ";
$sql6 = mysqli_query($mysqli, $query6);
$TACount=mysqli_num_rows($sql6);
    //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
if ($TACount>0)
{
    ?> 
<table id="customers">


  <tr>
    <!-- <th>Code</th> -->
    <th>Group Title</th>
    <th>Used For</th>
    <th>Status</th>
    <th>Edit</th>
  </tr>
  <?php
                     while($row6 = mysqli_fetch_array($sql6)){
                         // RefMake, CarMake, Status
                             $gRecRef = $row6["gRecRef"];
                             $gTitle = $row6["gTitle"];
                             $gUsedFor = $row6["gUsedFor"];
                             $Status = $row6["Status"];
                             ?> 
  <tr>
    <!-- <td><?php //echo $gRecRef?></td> -->
    <td><?php echo $gTitle?></td>
    <td><?php echo $gUsedFor?></td>
    <td><?php echo $Status?></td>
    <td style="text-align: center";>
    <a target="_self" title="  Edit Group  " href="SAgroupmain.php?RIDNO=<?php echo $gRecRef?>&ToAct=EDIT" >
                                       <img src="images/iconedit.png" alt="EDIT" height="20" width="20" border=0></a>  
    </td>
  </tr>
    
  <?php

}   //------------ end while $row5

?> 
    
        </table> <?php
}   //-------------- end if $TACount
else
{
?>
<p>&nbsp;</p>
NO GROUP ADDED !
<?php
}

?>

<p>&nbsp;</p>
  

</table>
</form>
</div>






<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("myDIV");
var btns = header.getElementsByClassName("btn1");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}
</script>

</body>
</html>    