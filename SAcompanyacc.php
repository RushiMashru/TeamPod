<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include("taskheader.php");

//echo 'print coockies= '; print_r($_COOKIE);
if(isset($_COOKIE["name"]))           { $loginame=$_COOKIE["name"]; }
if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }
GLOBAL $AccessLevel;

$page="company";


$uToAct=$_GET["ToAct"];
$uREFIDNO=$_GET["REFIDNO"];

    //    echo "<script> alert ('$uToAct / $uREFIDNO ');</script>";
    
$SuccessMessage='';    

$query15= "SELECT CliRecRef FROM `tUser`where RefUSR='$id' ";
            $sql15 = mysqli_query($mysqli, $query15);
            $row15 = mysqli_fetch_array($sql15);
            $CliRecRef = $row15["CliRecRef"];

    $NewCode=$_POST["NewCode"];
    $NewCode=strtoupper($NewCode);
    $NewTitle=$_POST["NewTitle"];

    $AddNewBtnClick=$_POST['AddNewBtnClick'];    //--   AddNewBtnClick  - to store a value from validation check if all valid is ok & submit button was pressed

if ($AddNewBtnClick=="YES" && $NewCode!='' && $NewTitle!='' )
{
    $AddNewBtnClick="";
                            //---- check duplicate Code
    $query4 = "SELECT * FROM `tCompany` WHERE `CoCode`='$NewCode' AND `CoType`='COMPANY' AND `CliRecRef` = '$CliRecRef' ORDER BY `CoName` ";
    $sql4 = mysqli_query($mysqli, $query4);
    $TECount=mysqli_num_rows($sql4);
          //  printf("Result = %s , %d rows.\n",$NewCode ,$TECount);
    if ($TECount>0)
    {
        $SuccessMessage=' Code is Already in the List ! ';
    }    
     else
    {
        $query2="INSERT INTO `tCompany`( `CoCode`, `CoName`, `CoType`, `Status`,`CliRecRef`) 
                                VALUES ( '$NewCode', '$NewTitle', 'COMPANY', 'ACT','$CliRecRef') " ;
        $sql2 = mysqli_query($mysqli, $query2);
        $SuccessMessage=' Successfully Added ! ';
        $NewMake='';
     }  //---- end if $TECount
}



            //--------------------- START Activate and Inactivate List Item ----------------- START

                if ($uToAct=='INACTIVE' && $uREFIDNO!='')
                    {
                        $query11="UPDATE `tCompany` SET `Status`='INA' WHERE `CoRecRef`='$uREFIDNO'  " ;
                        $sql11 = mysqli_query($mysqli, $query11);

                        $SuccessMessage=' Successfully Inactivated  ! ';		
                    }
                    
                if ($uToAct=='ACTIVATE' && $uREFIDNO!='')
                    {
                        $query11="UPDATE `tCompany` SET `Status`='ACT' WHERE `CoRecRef`='$uREFIDNO'  " ;
                        $sql11 = mysqli_query($mysqli, $query11);

                        $SuccessMessage=' Successfully Activated  ! ';		
                    }
            //--------------------- END Activate and Inactivate List Item ----------------- END

// echo '<br><br>INSERT SQL='.$query2.'  <br>UPDATE SQL11='.$query11;

?>


<html>

<head>
<title>Team Pod</title>

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
        if(document.forms["UserForm"]["NewCode"].value=="")
        {
        document.UserForm.NewCode.focus() ;
        NewCode.style.borderColor = "red";
        NewCode.style.color = "red";
          return false;
        }

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
  margin-left: 234px;
    width: 70%;
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
</head>

<body>

<div id="myDIV" style="margin-top:100px;">
  <a class="btn1 " href="SAgroupmain.php">Main Groups</a>
  <a class="btn1 " href="SAgroupsub.php">Sub Groups</a>
  <a class="btn1 active" href="SAcompanyacc.php">Company Account</a>
  <a class="btn1" href="Umanagement.php">User Management</a>
 
</div>

<div class="row" style="margin-top:40px;">
<form action="" name="UserForm" method="post">
            <input type=hidden name=AddNewBtnClick value="">


  <input type="text" id="NewCode" name="NewCode" maxlength=5 placeholder="* Unique FIVE alphabet Code" autocorrect=off autocapitalize=words/>
  
  <input type="text" id="NewTitle" name="NewTitle" placeholder="* New Title" autocorrect=off />
  
  <button class="button" name="btnRegisterMe" value="RegisterMe" onclick="validcheck1()">Add New Company Account</button>

</div>

  <div >
  <div class=hbox> <h3 style="color: #6f6467;">Company Account</h3> </div>
  <?php 

$query6 = "SELECT * FROM `tCompany` where CliRecRef = '$CliRecRef' ORDER BY `CoName` ";
$sql6 = mysqli_query($mysqli, $query6);
$TACount=mysqli_num_rows($sql6);
    //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
if ($TACount>0)
{
    ?>
<table id="customers">
<tr>
  <th>Code</th>
  <th>Company Account</th>
  <th>Status</th>
  <th>Action</th>
</tr>
              <?php
      while($row6 = mysqli_fetch_array($sql6)){
          // RefMake, CarMake, Status
              $RecRef = $row6["CoRecRef"];
              $Code = $row6["CoCode"];
              $Title = $row6["CoName"];
              $Status = $row6["Status"];
              ?> 
  <tr>
    <td><?php echo $Code?></td>
    <td><?php echo $Title?></td>
    <td><?php echo $Status?></td>
    <td style="text-align: center;">      <?php if ($Status=='ACT') {?>
                                         <a target="_self" href="SAcompanyacc.php?REFIDNO=<?php echo $RecRef?>&ToAct=INACTIVE" >
                                            <img src="images/imgRemove.png" alt="X" height="20" width="20" border=0></a>
                                         <?php }?>
                                         <?php if ($Status=='INA') {?>
                                         <a target="_self" href="SAcompanyacc.php?REFIDNO=<?php echo $RecRef?>&ToAct=ACTIVATE" >
                                            <img src="images/imgcheck.png" alt="Y" height="20" width="20" border=0></a>
                                         <?php }?></td>
 
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
                        NO COMPANY ADDED !
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