<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include("header.php");

if(isset($_COOKIE["name"]))           { $loginame=$_COOKIE["name"]; }
if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }
//echo '<br>UserID='.$id.'...UserName='.$loginame.'...SysAdmin='.$CanSystemAdmin.'...AccessLevel='.$AccessLevel ;

$query15= "SELECT CliRecRef FROM `tUser`where RefUSR='$id' ";
            $sql15 = mysqli_query($mysqli, $query15);
            $row15 = mysqli_fetch_array($sql15);
            $CliRecRef = $row15["CliRecRef"];

GLOBAL $AccessLevel;
    $DTTTRecRef=$_GET['DTTT'];
                        //----------- REMOVE TAG for this task
    if ($DTTTRecRef!='')
    {
        $query36="DELETE FROM `tTaskTags` WHERE `TRecRef`='$DTTTRecRef' AND RefUSR ='$id'" ;
        $sql36 = mysqli_query($mysqli, $query36);
        
        echo "<script>document.location='ptoday.php?ET=$urlRecEdit';</script>";
    }   //---- end if REMOVE TAG for this task

    $uToAct=$_GET["ToAct"];

    $uREFIDNO=$_GET["REFIDNO"];
    
        //    echo "<script> alert ('$uToAct / $uREFIDNO ');</script>";
    
    $headermessage='Add New Job Role';
        
    $SuccessMessage='';    
    
        if (isset($_POST["NewCode"]))           {$NewCode=$mysqli->real_escape_string($_POST["NewCode"]);}
        if (isset($_POST["NewTitle"]))          {$NewTitle=$mysqli->real_escape_string($_POST["NewTitle"]);}
        if (isset($_POST["selAccountStatus"]))  {$selAccountStatus=$mysqli->real_escape_string($_POST["selAccountStatus"]);}
        if (isset($_POST["AddNewBtnClick"]))    {$AddNewBtnClick=$mysqli->real_escape_string($_POST['AddNewBtnClick']);}
    
    if ($AddNewBtnClick=="YES" && $NewTitle!='' )
    {
        $AddNewBtnClick="";
    
            if ($NewCode!='')      //----- if Edit Record
            {
                $query11="UPDATE `tJobRole` SET `JobRoleTitle`='$NewTitle',`Status`='$selAccountStatus',`UpdateBy`='$id',`UpdateDate`='$current_date' WHERE `JRRefRef`='$NewCode'  " ;
                $sql11 = mysqli_query($mysqli, $query11);
                //$SuccessMessage=' Job Role Updated ! ';
                echo "<script> alert ('Record Updated');</script>";
                echo "<script>window.location.href=\"SAjobrole.php\"</script>";
                exit();
            }
            else            //----- add new rocord
            {
                
                $query301="SELECT * FROM `tJobRole` WHERE `JobRoleTitle`='$NewTitle' and `CliRecRef`='$CliRecRef'";

                $sql301 = mysqli_query($mysqli, $query301);    
                $existCount301 = mysqli_num_rows($sql301);
                if ($existCount301>0){
                 echo "<script> alert ('Job Role already exists');</script>";
                 echo "<script>window.location.href=\"SAjobrole.php\"</script>";
                exit();
                }
                
                else{
                $query2="INSERT INTO `tJobRole`(`JobRoleTitle`, `Status`, `UpdateBy`, `UpdateDate`,`CliRecRef`) 
                                        VALUES ( '$NewTitle',    'ACT',      '$id', '$current_date','$CliRecRef') " ;
                $sql2 = mysqli_query($mysqli, $query2);
                echo "<script> alert ('New Job Role Added');</script>";
                echo "<script>window.location.href=\"SAjobrole.php\"</script>";
                exit();
                }
            }
    }
                            
        if ($uREFIDNO!='')      //----- Show detail if Edit Record
        {
        
            $headermessage='Update Job Role Information';
        
            $query31="SELECT * FROM `tJobRole` WHERE `JRRefRef`='$uREFIDNO'  " ;
            $sql31 = mysqli_query($mysqli, $query31);
            //if($sql31==true) {echo '<br/>YES='.$query31;} else {echo '<br/>NO='.$query31;}
            while($row31 = mysqli_fetch_array($sql31))
            {
                $JRRefRef = $row31["JRRefRef"];
                $NewTitle = $row31["JobRoleTitle"];
                $Status = $row31["Status"];
            // echo "<script> alert ('$RecRef / $Title');</script>";
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
  margin-left: 300px;
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
  <a class="btn1  " href="SAuser.php">Add user</a>
  <a class="btn1 active" href="SAjobrole.php">Job Role</a>
  <a class="btn1 " href="SAlocation.php"> Location</a>

 </div>
 <a href="ptoday.php" title="Configuration" style="display:none">
 <img src="images/back.png" title=" Back to User Management" style="width: 30px;float:right;">

</a>
<div class="row" style="margin-top:30px;">


<form action="" name="UserForm" method="post">
            <input type=hidden name=AddNewBtnClick value="">

            <input type="text" id="NewCode" name="NewCode" maxlength=5 placeholder="Auto" readonly value="<?php echo $JRRefRef; ?>" style="display:none;">

            <input type="text" id="NewTitle" name="NewTitle"  placeholder="* Job Role Title" autocorrect=off value="<?php echo $NewTitle; ?>" />

            <select name="selAccountStatus" >
                        <option value="ACT" <?php if($Status=='ACT') { ?> selected="selected" <?php } ?> >Active</option>
                        <option value="INA" <?php if($Status=='INA') { ?> selected="selected" <?php } ?> >In-Active</option>
                      </select>

                      <button type="button"  class="button"  name="btnRegisterMe" value="RegisterMe" onclick="validcheck1()">Save Job Role</button>

                
  
</div>
<div class=hbox> <h3 style="color: #6f6467;">Job Roles</h3> </div>
  <div style="margin-top:5px;">
  <?php 

$query6 = "SELECT * FROM `tJobRole` WHERE  CliRecRef = '$CliRecRef' ORDER BY `Status`, `JobRoleTitle` ";
$sql6 = mysqli_query($mysqli, $query6);
$TACount=mysqli_num_rows($sql6);
    //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
if ($TACount>0)
{
    ?> 

 
<table id="customers">

  <tr>
    <th>Job Title</th>
      <th>Status</th>
    <th>Edit</th>
  </tr>
  <?php
                     while($row6 = mysqli_fetch_array($sql6)){
                             $JRRefRef = $row6["JRRefRef"];
                             $JobRoleTitle = $row6["JobRoleTitle"];
                             $Status = $row6["Status"];
                             ?> 

  <tr>
    <td><?php echo $JobRoleTitle?></td>
      <td><?php echo $Status?></td>
    <td style="text-align: center">
    <a target="_self" title="  Edit Site  " href="SAjobrole.php?REFIDNO=<?php echo $JRRefRef?>&ToAct=EDIT" >
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
NO JOB ROLE ADDED !
      
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