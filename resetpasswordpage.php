<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include "dbhands.php";
include "newheader.php";

$ResetStr = $_GET['rstr'];
$id = $_GET['usid'];

$SuccessMessage='';    

    $Pswd=$_POST["NewPswd"];
    $AddNewBtnClick=$_POST['AddNewBtnClick'];

$query10= "SELECT RefUSR, resetstring FROM `tPasswordReset` where RefUSR='$id' ";
$sql10 = mysqli_query($mysqli, $query10);
$row10 = mysqli_fetch_array($sql10);
$resetstring = $row10["resetstring"];

if($ResetStr!=$resetstring)
{
   echo "<script> alert('Please use latest link, this link is invalid');</script>";
   echo "<script>document.location='index.php';</script>";
   return false;
}

if ($AddNewBtnClick=="YES"  )
{
    $AddNewBtnClick="";
    
    if ($id!='')      //----- if Edit Record
    {
        $query11="UPDATE `tUser` SET `usrPass`='$Pswd' WHERE `RefUSR`='$id'  " ;
        $sql11 = mysqli_query($mysqli, $query11);
    
        echo "<script> alert ('User Password is Updated, Please try to login now!');</script>";
        
    }
    echo "<script>document.location='index.php';</script>";
}    
?>


<html>
<head>
   
<link rel="shortcut icon" type="image/png" href="images/icontask.png"/>
<link rel="stylesheet" type="text/css" href="cssjs/newstyle.css"></link>

<!--  start Mask  Date Validation   -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="jquery.inputmask.bundle.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
      .btn {
       background-color: #4caaaf;
    font-size: 17px;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
     width: 140px;
   }
</style>
<script>

function ShowHidePswrd() {
           var x = document.getElementById("NewPswd");
           if (x.type === "password") {
             x.type = "text";
           } else {
             x.type = "password";
           }
           
         }
         
function ShowHidePswrd1() {
           var y = document.getElementById("NewPswd1");
           if (y.type === "password") {
             y.type = "text";
           } else {
             y.type = "password";
           }
         }
function validcheck1()
{
   var letters = /^[a-zA-Z]+(\s{1}[a-zA-Z]+)*$/;  
   var numbers = /^[0-9]*$/;
   var paswd=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; 


        var x=document.forms["UserForm"]["NewPswd"].value;
        var y=document.forms["UserForm"]["NewPswd1"].value;
        
        
        if(x==y)
        {
            if(!x.match(paswd))
         		{
         		  alert('Password not accepted');
         		  return false;
         		}
            
        }
        else
        {
          alert('Passwords do not match');
          return false;  
        }


	/*   after all field valids then submit the form */
 document.forms["UserForm"]["AddNewBtnClick"].value="YES";				//----- store parameter to check if the Submit New Button was clicked
 document.forms['UserForm'].submit();


}

</script>

</head>

<div align="center" style='margin:55px 0 0 0;'>

    <form action="" name="UserForm" method="post">
      <!-- <h3 style="margin-bottom: 40px;color:#cf6735"> Change Password</h3> -->
        <input type=hidden name=AddNewBtnClick value="">
                     <div style="display:inline;width:120px;float:center;margin-top:10px;margin-right:10px;"><b style="color:#bda217">New Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b></div>

                    <input type="password" class="form-control total_fields" style="display:inline;width:250px" id="NewPswd" name="NewPswd" placeholder="*New Password" value="" >

                    <span toggle="#NewPswd" class="fa fa-fw fa-eye-slash field-icon pwd-toggle" style="margin-left:-35px;"></span></br><p>&nbsp;</p>

                    <div style="display:inline;width:120px;float:center;margin-top:10px;margin-right:10px;"><b style="color:#bda217">Confirm Password :</b></div>

                    <input type="password" class="form-control total_fields" style="display:inline;width:250px" id="NewPswd1" name="NewPswd1" placeholder="*Confirm Password" value="" >  

                    <span toggle="#NewPswd1" class="fa fa-fw fa-eye-slash field-icon pwd-toggle" style="margin-left:-35px;"></span>

                   </br>
                    <p style="font-size: 13px;margin-top: 15px;"><i>[Enter 8 to 15 characters which contains lowercase letter, uppercase letter, numeric digit, special character]</i></p>
<br/>
                    <button type="button" class="btn" name="btnSave" value="SaveUser" onclick="validcheck1()">Save</button>

                     <p>&nbsp;</p>
                     
                     <?php if ($SuccessMessage!='') echo $SuccessMessage; ?>
                     <p>&nbsp;</p>
                </div>

<!-- password eye js code start  -->
                
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script>
  $(".pwd-toggle").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
input.attr("type", "text");
} else {
input.attr("type", "password");
}
});

</script>
<!-- password eye js code end  -->
    