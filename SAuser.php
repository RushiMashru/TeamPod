<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include("header.php");

//echo 'print coockies= '; print_r($_COOKIE);
if(isset($_COOKIE["name"]))           { $loginame=$_COOKIE["name"]; }
if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }
//echo '<br>UserID='.$id.'...UserName='.$loginame.'...SysAdmin='.$CanSystemAdmin.'...
GLOBAL $AccessLevel;

$page="user";

$uToAct=$_GET["ToAct"];
$uUSRIDNO=$_GET["USRIDNO"];

    //    echo "<script> alert ('$uToAct / $uUSRIDNO ');</script>";
$headermessage='Add New User';
$SuccessMessage='';    

    $FullName=$_POST["FullName"];
    $LName=$_POST["LName"];
    $UserEmail=$_POST["UserEmail"];
    $selLineMgr=$_POST["selLineMgr"];
    $Country=$_POST["Country"];
    $ContactNo=$_POST["ContactNo"];
    $Addr1=$_POST["Addr1"];
    $Addr2=$_POST["Addr2"];
    $City=$_POST["City"];
    $ZPCode=$_POST["ZPCode"];
    $StartDate=$_POST["StartDate"];
    $DueDate=$_POST["DueDate"];
    $selJobRole=$_POST["selJobRole"];
    $location=$_POST["location"];
    $selAccountStatus=$_POST["selAccountStatus"];
    if (isset($_POST["adminlevel"]))    {$adminlevel=$mysqli->real_escape_string($_POST['adminlevel']);}
    $ArraycbcAL=$_POST['cbxAL'];
       
    $AddNewBtnClick=$_POST['AddNewBtnClick'];    //--   AddNewBtnClick  - to store a value from validation check if all valid is ok & submit button was pressed
$query15= "SELECT CliRecRef,AccountType,Company FROM `tUser`where RefUSR='$id' ";
            $sql15 = mysqli_query($mysqli, $query15);
            $row15 = mysqli_fetch_array($sql15);
            $CliRecRef = $row15["CliRecRef"];
            $AccountType = $row15["AccountType"];
            $Company = $row15["Company"];

if ($AddNewBtnClick=="YES"  )
{
    $AddNewBtnClick="";
    if ($uUSRIDNO!='')      //----- if Edit Record
    {
      $query11="UPDATE `tUser` SET `FirstName`='$FullName',`LastName`='$LName',`EmailID`='$UserEmail',`JobRole`='$selJobRole',`AccessLevel`='$cbxALarrayweb',`Status`='$selAccountStatus',
      `myManager`='$selLineMgr',`Country`='$Country',`ContactNo`='$ContactNo',`Addr1`='$Addr1',`Addr2`='$Addr2',`City`='$City',`ZPCode`='$ZPCode', `URegStartDate`='$StartDate', `URegEndDate`='$DueDate',`MainSite`='$location',`CanSystemAdmin`='$adminlevel', `UpdateBy`='$id'  WHERE `RefUSR`='$uUSRIDNO'  " ;
        $sql11 = mysqli_query($mysqli, $query11);
        echo "<script> alert ('User Updated');</script>";
      }
    else            //----- add new rocord
    {
    $query301="SELECT * FROM `tUser` WHERE `EmailID`='$UserEmail'";

                $sql301 = mysqli_query($mysqli, $query301);    
                $existCount301 = mysqli_num_rows($sql301);
                if ($existCount301>0){
                 echo "<script> alert ('User already exists');</script>";
                 echo "<script>window.location.href=\"SAuser.php\"</script>";
                exit();
                }
                
                else{
                    
       $query2="INSERT INTO `tUser` ( `FirstName`,`LastName`, `UserID`,  `EmailID`, `JobRole`, `AccessLevel`, `Status`, `UpdateBy`,`CliRecRef`,`AccountType`,`Company`,`ContactNo` ,`Addr1`,`Addr2`,`City`,`ZPCode`,`URegStartDate`,`URegEndDate`,`MainSite`,`myManager`,`CanSystemAdmin`) 
        VALUES ( '$FullName','$LName', '$UserEmail',  '$UserEmail', '$selJobRole', '$cbxALarrayweb', '$selAccountStatus', '$id','$CliRecRef','$AccountType','$Company','$ContactNo','$Addr1','$Addr2','$City','$ZPCode','$StartDate','$DueDate','$location','$selLineMgr','$adminlevel') " ;
        $sql2 = mysqli_query($mysqli, $query2);
        $uUSRIDNO=$mysqli->insert_id;
        echo "<script> alert ('New User Added');</script>";
        $currdatetime = date('Y-m-d H:i:s');
        $string= random_strings(10);
        $query_pass = "INSERT INTO `tPasswordReset`(`id`, `RefUSR`, `resetstring`, `UpdateDate`) VALUES ('','$uUSRIDNO','$string','$currdatetime')";
        $sql_pass = mysqli_query($mysqli, $query_pass);
    
    
        $actual_link = "https://$_SERVER[HTTP_HOST]/TeamPod/resetpasswordpage.php?usid=$uUSRIDNO&rstr=$string&ToAct=SET";
        
        $to="$UserEmail";
        //$to="jitulalwani89@gmail.com";
	    $subject1= "Welcome to the organization, set your password to proceed further";
	    $fromName = "HR Team";
	    $from = "support@teampod.co.uk"; 
	    $message1 = "Hi " . $FirstName.",\r\n \r\nWelcome to the organization. Please find below link to set your initial account password- \r\n \r\nURL: ". $actual_link;
	    $message1.="\r\n \r\nThanks & Regards, \r\n HR Team";
        $headers1 = "From: $fromName"." <".$from.">";
        
	    mail($to,$subject1,$message1,$headers1);
	    //mail("jitulalwani89@gmail.com",$subject1,$message1,$headers1);
	    echo "<script> alert ('Please ask user to check inbox/spam email folder to set the password. ');</script>";
    }
    }
    echo "<script>document.location='SAuser.php';</script>";
    }  //---- end if $AddNewBtnClick


function random_strings($length_of_string) 
{ 
  
    // String of all alphanumeric character 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
    // Shufle the $str_result and returns substring 
    // of specified length 
    return substr(str_shuffle($str_result),0, $length_of_string); 
} 

$AllUserList_arr = array();             //---------------- Get all File Codes from database table then when require only show specific codes in select statement
$query11="SELECT RefUSR,FirstName,LastName FROM `tUser` WHERE `RefUSR`!='$eRefUSR' AND `Status`='ACT' AND `CliRecRef`='$CliRecRef' ORDER BY `FirstName`, `LastName` ";
//echo '<br><br>SQL11= '.$query11;
$sql11 = mysqli_query($mysqli, $query11);
$i=0;
while($row1=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
    {
    $AllUserList_arr[$i][0]=$row1['RefUSR'];
    $AllUserList_arr[$i][1]=$row1['FirstName'].' '.$row1['LastName'];
    $i++;
    }
$maxcodelinemgr = sizeof($AllUserList_arr);

$AllLocationCode_arr = array();             //---------------- Get all File Codes from database table then when require only show specific codes in select statement
$query11="SELECT *  FROM `tLocation` WHERE `Status`='ACT' and CliRecRef = '$CliRecRef' ORDER BY `Location` ";
$sql11 = mysqli_query($mysqli, $query11);
$i=0;
while($row1=mysqli_fetch_array($sql11))						//------------------- Store Code & Location from database to AllPractice_arr ------
    {
    $AllLocationCode_arr[$i][0]=$row1['Code'];
    $AllLocationCode_arr[$i][1]=$row1['Location'];
    $i++;
    }
$maxcodelocation = sizeof($AllLocationCode_arr);

   $AllJRoleCode_arr = array();             //---------------- Get all File Codes from database table then when require only show specific codes in select statement
       $query11="SELECT * FROM `tJobRole` WHERE `Status`='ACT' and CliRecRef = '$CliRecRef' ORDER BY `JobRoleTitle` ";
       $sql11 = mysqli_query($mysqli, $query11);
       $i=0;
       while($row1=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
           {
           $AllJRoleCode_arr[$i][0]=$row1['JRRefRef'];
           $AllJRoleCode_arr[$i][1]=$row1['JobRoleTitle'];
           $i++;
           }
$maxcoderole = sizeof($AllJRoleCode_arr);   
if ($uUSRIDNO!='')      //----- Show detail if Edit Record
{
    $headermessage='Update User Information';
    $query31="SELECT * FROM `tUser` WHERE `RefUSR`='$uUSRIDNO'  " ;
    $sql31 = mysqli_query($mysqli, $query31);
    while($row31 = mysqli_fetch_array($sql31))
    {
        $FName=$row31['FirstName'];
        $LName=$row31['LastName'];
        $FullName = $FName;
        $ContactNo=$row31['ContactNo'];
        $StartDate=$row31['URegStartDate'];
        $DueDate=$row31['URegEndDate'];
        $location=$row31['MainSite'];
        $selLineMgr=$row31['myManager'];
        $Addr1=$row31['Addr1'];
        $Addr2=$row31['Addr2'];
        $City=$row31['City'];
        $ZPCode=$row31['ZPCode'];
        $adminlevel=$row31['CanSystemAdmin'];
        $UserEmail=$row31['EmailID'];
        $selJobRole=$row31['JobRole'];
        $cbxALarray=$row31['AccessLevel'];
        $selAccountStatus=$row31['Status'];
    // echo "<script> alert ('$FullName / $uUSRIDNO');</script>";
    }		    
    
}

?>
<html>
<head>
<title>Team Pod</title>
<!--  start Mask  Date Validation   -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="jquery.inputmask.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
 

<!--   Styles Start   -->
<style>
/* Style the buttons */
.btn1 { border: none;outline: none;padding: 13px 30px;background-color: #ffe199;cursor: pointer;font-size: 14px; border-radius: 10px;}
.active, .btn1:hover { border-radius: 10px !important; background-color: #e74c3c !important; color: white;}
.signup-form { width:650px;margin:30px auto;}
.form-body { padding:10px 40px;color:#666;}
.form-group{ margin-bottom:20px;}
.form-body .label-title { color: #645121; font-size: 16x; margin-bottom: 7px; float: left;}
.form-body .form-input { font-size: 15px; box-sizing: border-box; width: 100%; height: 34px; padding-left: 10px; padding-right: 10px; color: #564f4f; text-align: left; border: 1px solid #d6d6d6; border-radius: 4px; background: white; outline: none;}
.horizontal-group .left{ float:left; width:49%; }
.horizontal-group .right{ float:right; width:49%; }
::-webkit-input-placeholder  { color:#d9d9d9;}
.button {   background-color: #4caaaf;border: none; color: white; padding: 10px 35px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; border-radius: 24px; margin-left: 5px; }
.btn { display: inline-block; padding: 10px 20px; background-color: #4caaaf; font-size: 17px; border: none; border-radius: 5px; color: #fff; cursor: pointer;  margin-top: 30px;  width: 140px; margin-bottom: 25px; margin-left: -125px; }
.btn:hover { background-color: #169c7b; color:white; }
#ui-datepicker-div{ top:285px !important; }
.row { margin-left: 275px; margin-right: 70px; margin-top: 40px;font-size:13px; }
.column { float: left;width: 50%;padding: 5px;}
.row::after { content: ""; clear: both; display: table;}
table { border-collapse: collapse; border-spacing: 0; width: 100%; border: 1px solid #ddd;}
th, td { text-align: left;padding: 16px;}
tr:nth-child(even) {background-color: #f2f2f2;}
table .header{ padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #ffe199; color: #e74c3c; }
.form-control1 { margin-left: -174px; width: 150%; border-radius: 5px; height: 5vh; margin-top: -17px;}
input[type=checkbox]
{ margin-left: -120px;}
@media screen and (min-width: 1300) {
  .row {
    margin-left: 290px ;
    margin-right: 50px;
}
}

</style>

<!--   Styles end   -->

<!--   validations start   -->
<script>

function validcheck1()
{
   var letters = /^[a-zA-Z]+(\s{1}[a-zA-Z]+)*$/;  
   var numbers = /^[0-9]*$/;
   var paswd=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; 
        var x=document.forms["UserForm"]["UserEmail"].value;
          var atpos=x.indexOf("@");
        var dotpos=x.lastIndexOf(".");
        if(document.forms["UserForm"]["FullName"].value=="")
        {
        document.UserForm.FullName.focus() ;
        FullName.style.borderColor = "red";
        FullName.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["LName"].value=="")
        {
        document.UserForm.LName.focus() ;
        LName.style.borderColor = "red";
        LName.style.color = "red";
          return false;
        }
         // alert("LEN > 2");
       else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
          {
          document.UserForm.UserEmail.focus() ;
          UserEmail.style.borderColor = "red";
          UserEmail.style.color = "red";
          return false;
          }
           else if(document.forms["UserForm"]["ContactNo"].value=="")
        {
        document.UserForm.ContactNo.focus() ;
        ContactNo.style.borderColor = "red";
        ContactNo.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["selJobRole"].value=="")
        {
        document.UserForm.selJobRole.focus() ;
        selJobRole.style.borderColor = "red";
        selJobRole.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["selLineMgr"].value=="")
        {
        document.UserForm.selLineMgr.focus() ;
        selLineMgr.style.borderColor = "red";
        selLineMgr.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["location"].value=="")
        {
        document.UserForm.location.focus() ;
        location.style.borderColor = "red";
        location.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["selAccountStatus"].value=="")
        {
        document.UserForm.selAccountStatus.focus() ;
        selAccountStatus.style.borderColor = "red";
        selAccountStatus.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["Addr1"].value=="")
        {
        document.UserForm.Addr1.focus() ;
        Addr1.style.borderColor = "red";
        Addr1.style.color = "red";
          return false;
        }
        /*else if(document.forms["UserForm"]["Addr2"].value=="")
        {
        document.UserForm.Addr2.focus() ;
        Addr2.style.borderColor = "red";
        Addr2.style.color = "red";
          return false;
        } */
        else if(document.forms["UserForm"]["City"].value=="")
        {
        document.UserForm.City.focus() ;
        City.style.borderColor = "red";
        City.style.color = "red";
          return false;
        }
        else if(document.forms["UserForm"]["ZPCode"].value=="")
        {
        document.UserForm.ZPCode.focus() ;
        ZPCode.style.borderColor = "red";
        ZPCode.style.color = "red";
          return false;
        }

	/*   after all field valids then submit the form */
 document.forms["UserForm"]["AddNewBtnClick"].value="YES";				//----- store parameter to check if the Submit New Button was clicked
 document.forms['UserForm'].submit();

}
</script>
<!--   validations end   -->
</head>
<body>
<div id="myDIV" style="margin-top:100px;">
  <a class="btn1 active " href="SAuser.php">Add user</a>
  <a class="btn1 " href="SAjobrole.php">Job Role</a>
  <a class="btn1 " href="SAlocation.php"> Location</a>
 </div>
<div class="row">
  <div class="column">
    <table>
    <form action="" class="signup-form" name="UserForm" method="post">
<input type=hidden name=AddNewBtnClick value="">
<!-- form body -->
<div class="form-body">
  <div class="horizontal-group">
    <div class="form-group left">
      <label for="firstname" class="label-title">First name <font color="#FF0000">*</font></label>
      <input type="text" id="FullName" name="FullName" class="form-input" placeholder="First Name" value="<?php echo $FullName; ?>"   >
          </div>
    <div class="form-group right">
      <label for="lastname" class="label-title">Last name <font color="#FF0000">*</font></label>
      <input type="text" id="LName" name="LName" class="form-input" placeholder="Last Name" value="<?php echo $LName; ?>"    >
    </div>
    <div class="form-group left">
      <label for="firstname" class="label-title">Email <font color="#FF0000">*</font> </label>
      <input type="text" id="UserEmail" name="UserEmail" class="form-input" placeholder="* Email address" autocorrect=off autocapitalize=words value="<?php echo $UserEmail; ?>" >
    </div>
    <div class="form-group right">
      <label for="ContactNo" class="label-title">Contact No : <font color="#FF0000">*</font></label>
      <input type="text" id="ContactNo" name="ContactNo" class="form-input" placeholder="Enter your number" value="<?php echo $ContactNo; ?>"   >
    </div>
      <div class="form-group left">
       <label class="label-title" for="StartDate">Start Date <font color="#FF0000">*</font> </label>
       <input type="text"  name="StartDate" id="StartDate" value="<?php echo $StartDate; ?>" placeholder="DD-MM-YYYY" class="form-input" autocomplete="off">
    </div>
    <div class="form-group right">
    <label class="label-title" for="DueDate">End Date</label>
     <input type="text" name="DueDate" id="DueDate" value="<?php echo $DueDate; ?>" placeholder="DD-MM-YYYY"  class="form-input" autocomplete="off">
    </div>
     <div class="form-group left">
      <label for="lastname" class="label-title">Job Role <font color="#FF0000">*</font></label>
      <select name="selJobRole" id="selJobRole" class="form-input">
           <option value="" <?php if($selJobRole=='') { ?> selected="selected" <?php } ?>>-- Select --</option>
          <?php  $i=0;
          while($i<$maxcoderole)
          { 
            $valueof= $AllJRoleCode_arr[$i][0] ;
            if ($selJobRole == $valueof) {  ?>
              <option value="<?php echo $valueof; ?>" selected> <?php echo $AllJRoleCode_arr[$i][1] ?></option>
            <?php } else{ ?>    
              <option value="<?php echo $valueof ?>"> <?php echo $AllJRoleCode_arr[$i][1] ?> </option>
          <?php  }   $i++; } ?>
     </select>
      </div>
    <div class="form-group right">
      <label for="location" class="label-title">Site/ Location <font color="#FF0000">*</font></label>
      <select class="form-input" id="location" name="location">
        <option value="" <?php if($location=='') { ?> selected="selected" <?php } ?>>-- Select --</option>
							<?php  $i=0;
							while($i<$maxcodelocation)
							{ 
								$valueof= $AllLocationCode_arr[$i][0] ;
								if ($location == $valueof) {  ?>
									<option value="<?php echo $valueof; ?>" selected> <?php echo $AllLocationCode_arr[$i][1] ?></option>
								<?php } else{ ?>    
									<option value="<?php echo $valueof ?>"> <?php echo $AllLocationCode_arr[$i][1] ?> </option>
							<?php  }   $i++; } ?>
 
      </select>  
    </div>
 
    <div class="form-group left">
    <label for="linemanager" class="label-title">Line Manager <font color="#FF0000">*</font></label>
      <select name="selLineMgr" id="selLineMgr" class="form-input"  required >
						<option value="" <?php if($selLineMgr=='') { ?> selected="selected" <?php } ?>>-- Select --</option>
							<?php  $i=0;
							while($i<$maxcodelinemgr)
							{ 
								$valueof= $AllUserList_arr[$i][0] ;
								if ($selLineMgr == $valueof) {  ?>
									<option value="<?php echo $valueof; ?>" selected> <?php echo $AllUserList_arr[$i][1] ?></option>
								<?php } else{ ?>    
									<option value="<?php echo $valueof ?>"> <?php echo $AllUserList_arr[$i][1] ?> </option>
							<?php  }   $i++; } ?>
					  </select>            
      
    </div>
    
    <div class="form-group right">
    <label for="Addr1" class="label-title">Address Line 1 <font color="#FF0000">*</font> </label>
      <input type="text" id="Addr1" name="Addr1" class="form-input" placeholder="Enter your address1" value="<?php echo $Addr1; ?>" required="required"/>

    </div>
    <div class="form-group left">
    <label for="Addr2" class="label-title">Address Line 2</label>
      <input type="text" id="Addr2" name="Addr2" class="form-input" value="<?php echo $Addr2;?>" placeholder="Enter your address2" />
    </div>

    <div class="form-group right">
    <label for="City" class="label-title">City <font color="#FF0000">*</font> </label>
      <input type="text" id="City" name="City" class="form-input" value="<?php echo $City;?>" placeholder="Enter your city" />
    </div>
    <div class="form-group left">
    <label for="ZPCode" class="label-title">Zip/Post Code <font color="#FF0000">*</font></label>
      <input type="text" id="ZPCode" name="ZPCode" class="form-input" value="<?php echo $ZPCode; ?>" placeholder="Enter your Zip/Post Code" required="required" />
    </div>
    <div class="form-group right">
      <label for="lastname" class="label-title">Account Status <font color="#FF0000">*</font></label>

      <select name="selAccountStatus" id="selAccountStatus" class="form-input">
  <option value="" <?php if($selAccountStatus=='') { ?> selected="selected" <?php } ?> >---  Account Status---</option>
  <option value="ACT" <?php if($selAccountStatus=='ACT') { ?> selected="selected" <?php } ?> >Active</option>
                        <option value="INA" <?php if($selAccountStatus=='INA') { ?> selected="selected" <?php } ?> >In-Active</option>
                     
  </select>
    </div>
  <br>    
  <div class="form-group">
      <label for="lastname" class="label-title" style="margin-left:30px">Administrator &nbsp &nbsp</label>
      <input type=checkbox name=adminlevel value=1 <?php if ($adminlevel==1) {echo 'checked';} ?>  <?php echo $canChangeSA;?>  style="float:left" />
    </div>
  
    </div>
  </div>
  <button type="button"  class="btn"  name="btnSave" value="SaveUser" onclick="validcheck1()">Save User</button>
  </form>
</table>
  </div>
  <div class="column">
    <h2 style="color: #6f6467;"> Users List </h2>
  <?php 
           $query6 = " 
           SELECT * FROM `tUser` WHERE CliRecRef = '$CliRecRef' AND (myManager = '$id' OR myManager IN (SELECT RefUSR FROM `tUser` WHERE myManager = '$id'))
             ORDER BY `FirstName`;
           ";
           $sql6 = mysqli_query($mysqli, $query6);
           $TACount=mysqli_num_rows($sql6);
               //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
           if ($TACount>0)
           {
               ?>
    <table>
      <tr class="header">
      <th>Full Name</th>
        <th>Email</th>
        <th>Status</th>
        <th></th>
      </tr>
      <?php
                     while($row6 = mysqli_fetch_array($sql6)){
                         // RefMake, CarMake, Status
                             $RefUSR = $row6["RefUSR"];
                             $FName = $row6["FirstName"];
                             $LName = $row6['LastName'];
                             $FullName = $FName.' '.$LName;
                             $EmailID = $row6["EmailID"];
                             $Status = $row6["Status"];
                             ?> 
      <tr>
      <td><?php echo $FullName?></td>
    <td><?php echo $EmailID?></td>
    <td><?php echo $Status?></td>
    <td> <a target="_self" title="  Edit User  " href="SAuser.php?USRIDNO=<?php echo $RefUSR?>&ToAct=EDIT" >
                                       <img src="images/iconedit.png" alt="EDIT" height="20" width="20" border=0></a></td>
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
NO USER ADDED !
<?php
}

?>

<p>&nbsp;</p>
  
    </table>
  </div>
</div>
    <!--- Date script start-->
    <script>
$(document).ready(function(){
    var StartDate;
    var DueDate;
    //$(":input").inputmask();
    $("#StartDate").datepicker({
                     dateFormat: 'dd-mm-yy'
                    });
    //$('#StartDate').datepicker('setDate', 'today');
    $("#DueDate").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    //$('#DueDate').datepicker('setDate', 'today');

    $('#StartDate').change(function(){
        startDate=$(this).datepicker('getDate');

        $('#DueDate').datepicker('option','minDate',startDate);
    });

    $('#DueDate').change(function(){
        endDate=$(this).datepicker('getDate');

        $('#StartDate').datepicker('option','maxDate',endDate);
    });
});
</script>
<!--- Date script end-->
<!-- tab buttons js start -->
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
<!-- tab buttons js end -->
</body>
</html>    