<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include("taskheader.php");

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
    $Newpswrd=$_POST["Newpswrd"];
    $selJobRole=$_POST["selJobRole"];
    $selAccountStatus=$_POST["selAccountStatus"];
    $ArraycbcAL=$_POST['cbxAL'];
    
    
    $AddNewBtnClick=$_POST['AddNewBtnClick'];    //--   AddNewBtnClick  - to store a value from validation check if all valid is ok & submit button was pressed

    // var_dump($_POST);

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
        $query11="UPDATE `tUser` SET `FirstName`='$FullName',`LastName`='$LName',`usrPass`='$Newpswrd',`EmailID`='$UserEmail',`JobRole`='$selJobRole',`AccessLevel`='$cbxALarrayweb',`Status`='$selAccountStatus', `UpdateBy`='$id'  
                  WHERE `RefUSR`='$uUSRIDNO'  " ;
                 // print_r($query11);
                  //exit();
        $sql11 = mysqli_query($mysqli, $query11);
     /*   if($uUSRIDNO==$id) {
        unset($_COOKIE['loginame']); 
        setcookie("loginame", $FullName, time()+ (86400 * 30),'/');
        }
    */
        echo "<script> alert ('User Updated');</script>";
        
    }
    else            //----- add new rocord
    {
       $query2="INSERT INTO `tUser` ( `FirstName`,`LastName`, `UserID`, `usrPass`, `EmailID`, `JobRole`, `AccessLevel`, `Status`, `UpdateBy`,`CliRecRef`,`AccountType`,`Company`  ) 
                    VALUES ( '$FullName','$LName', '$UserEmail', '$Newpswrd', '$UserEmail', '$selJobRole', '$cbxALarrayweb', '$selAccountStatus', '$id','$CliRecRef','$AccountType','$Company') " ;
        $sql2 = mysqli_query($mysqli, $query2);
        $uUSRIDNO=$mysqli->insert_id;
        
//print_r($sql8);
//exit();
        $uUSRIDNO=$mysqli->insert_id;

        echo "<script> alert ('New User Added');</script>";
    }

            //----------- DELETE Old Access Level & then Update New Levels
    $query3 = "DELETE FROM `tUserAccessLevels` WHERE  `RefUSR`='$uUSRIDNO'  ";
    $sql3 = mysqli_query($mysqli, $query3);

            //------------ Insert New Access Level for Company Account & User Modules
    $query4 = "SELECT * FROM `tCompany` WHERE `CoType`='COMPANY' AND `Status`='ACT' ORDER BY `CoName` ";
    $sql4 = mysqli_query($mysqli, $query4);
    $TACount4=mysqli_num_rows($sql4);
    if ($TACount4>0)
    {
       while($row4 = mysqli_fetch_array($sql4)){
           $chkCode = $row4["CoRecRef"];
           $AssignedAL=$ArraycbcAL[$chkCode][0].','.$ArraycbcAL[$chkCode][1];
           //echo $AssignedAL;echo '<br>';
           if (strlen($AssignedAL)>4){
            $query2="INSERT INTO `tUserAccessLevels`( `RefUSR`, `FCompany`, `AccessLevel`) 
                                            VALUES ( '$uUSRIDNO', '$chkCode', '$AssignedAL') " ;
           $sql2 = mysqli_query($mysqli, $query2);
           }  //------- end if strlen
       }    //--- end while $row4
    }    //-------- end if $TACount4
    
    
    echo "<script>document.location='Umanagement.php';</script>";
    
}  //---- end if $AddNewBtnClick


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
            $usrPass=$row31['usrPass'];
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

<script>
$(document).ready(function(){
    $(":input").inputmask();
});
</script>
<!--  End Mask Date Validation    -->


<script>
function validcheck1()
{
   var letters = /^[a-zA-Z]+(\s{1}[a-zA-Z]+)*$/;  
   var numbers = /^[0-9]*$/;
   var paswd=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; 


        var x=document.forms["UserForm"]["UserEmail"].value;
        var atpos=x.indexOf("@");
        var dotpos=x.lastIndexOf(".");

         // alert("LEN > 2");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
          {
          document.UserForm.UserEmail.focus() ;
          UserEmail.style.borderColor = "red";
          UserEmail.style.color = "red";
          return false;
          }

        if(!document.forms["UserForm"]["Newpswrd"].value.match(paswd))
        {
        document.UserForm.Newpswrd.focus() ;
        Newpswrd.style.borderColor = "red";
        Newpswrd.style.color = "red";
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
input[type=password] {
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
  <a class="btn1 " href="SAcompanyacc.php">Company Account</a>
  <a class="btn1 active" href="Umanagement.php">User Management</a>
 
</div>

<div class="row" style="margin-top:30px;">
<form action="" name="UserForm" method="post">
            <input type=hidden name=AddNewBtnClick value="">

  <input type="text" id="FullName" name="FullName" placeholder="First Name" value="<?php echo $FullName; ?>"   >

  <input type="text" id="LName" name="LName" placeholder="Last Name" value="<?php echo $LName; ?>"   >
  
  <input type="text" id="UserEmail" name="UserEmail" placeholder="* Email address" autocorrect=off autocapitalize=words value="<?php echo $UserEmail; ?>" >
  <br>
  <select name="selJobRole"  required>
  <option value="" <?php if($selJobRole=='') { ?> selected="selected" <?php } ?> >--- Select Job Role---</option>
                        <option value="Line Manager" <?php if($selJobRole=='Line Manager') { ?> selected="selected" <?php } ?> >Line Manager</option>
                        <option value="Audit Manager" <?php if($selJobRole=='Audit Manager') { ?> selected="selected" <?php } ?> >Audit Manager</option>
                        <option value="Auditor" <?php if($selJobRole=='Auditor') { ?> selected="selected" <?php } ?> >Auditor</option>
                        <option value="Accounts Manager" <?php if($selJobRole=='Accounts Manager') { ?> selected="selected" <?php } ?> >Accounts Manager</option>
                        <option value="Accountant" <?php if($selJobRole=='Accountant') { ?> selected="selected" <?php } ?> >Accountant</option>
                        <option value="Administrator" <?php if($selJobRole=='Administrator') { ?> selected="selected" <?php } ?> >Administrator</option>
                        <option value="Admin Asst" <?php if($selJobRole=='Admin Asst') { ?> selected="selected" <?php } ?> >Admin Asst</option>
  </select>
  
  <input type="password" id="Newpswrd" name="Newpswrd" placeholder="* Password" value="<?php echo $usrPass; ?>"  >
  
  <select name="selAccountStatus" id="selAccountStatus" required>
  <option value="" <?php if($selAccountStatus=='') { ?> selected="selected" <?php } ?> >---  Account Status---</option>
  <option value="ACT" <?php if($selAccountStatus=='ACT') { ?> selected="selected" <?php } ?> >Active</option>
                        <option value="INA" <?php if($selAccountStatus=='INA') { ?> selected="selected" <?php } ?> >In-Active</option>
                     
  </select>
  
  <br>
  <div style=" text-align: center; margin-left: 565px;margin-right: 565px;font-size: 11px;
    line-height: 20px;">
  [Enter 8 to 15 characters which contains lowercase letter, uppercase letter, numeric digit, special character]
</div>
</div>

  <div style="margin-top:20px;">
<table id="customers">
  <tr>
    <th>Code</th>
    <th>Company</th>
    <th>User</th>
    <th>Supervisor</th>
    
  </tr>

  <?php 

                     $query6 = "SELECT * FROM `tCompany` WHERE `CoType`='COMPANY' AND `Status`='ACT' AND CliRecRef	='$CliRecRef' ORDER BY `CoName` ";
                     $sql6 = mysqli_query($mysqli, $query6);
                     $TACount=mysqli_num_rows($sql6);
                     if ($TACount>0)
                     {
                        while($row6 = mysqli_fetch_array($sql6)){
                            $CoRecRef = $row6["CoRecRef"];
                            $CoName = $row6["CoName"];
                            $Code = $row6["CoCode"];
                            
                            $AccessLevel='';
                            $query7 = "SELECT * FROM `tUserAccessLevels` WHERE `RefUSR`='$uUSRIDNO' AND `FCompany`='$CoRecRef' LIMIT 1 ";
                            $sql7 = mysqli_query($mysqli, $query7);
                               while($row7 = mysqli_fetch_array($sql7)){
                                   $AccessLevel = $row7["AccessLevel"];
                                   //echo $AccessLevel;
                               }
                                //if (strpos($AccessLevel,'ALPROCES') !== false) {$cbxRequire[ALPROCES]='checked';} else { $cbxRequire[ALPROCES]=''; }
                                //if (strpos($AccessLevel,'ADMNDASH') !== false) {$cbxRequire[ADMNDASH]='checked';} else { $cbxRequire[ADMNDASH]=''; }
                                if (strpos($AccessLevel,'ALPROCES') !== false) {$cbxRequire='checked';} else { $cbxRequire=''; }
                                if (strpos($AccessLevel,'ADMNDASH') !== false) {$cbxRequire1='checked';} else { $cbxRequire1=''; }
                            
                            ?> 
  <tr>
    <td><?php echo $Code?></td>
    <td><?php echo $CoName?></td>
    <td><input type=checkbox name=cbxAL[<?php echo $CoRecRef?>][] value="ALPROCES" <?php echo $cbxRequire  ?> ></td>
    <td><input type=checkbox name=cbxAL[<?php echo $CoRecRef?>][] value="ADMNDASH" <?php echo $cbxRequire1 ?> ></td>
   
  </tr>
 
  <?php

}   //------------ end while $row5
}   //-------------- end if $TACount
else
{
?>
<p>&nbsp;</p> NO COMPANY ADDED !
<?php
}
?>

</table><br>
<button class="button"  name="btnSave" value="SaveUser" onclick="validcheck1()">Save User</button>
</div>

<div style="margin-top:20px;">
<div class=hbox> <h2 style="color: #6f6467;font-weight: bold;">User List</h2> </div>
                        
                        <?php 
           
                                $query6 = " 
                                SELECT * FROM `tUser` WHERE UpdateBy	='$id' and CliRecRef = '$CliRecRef'
                                  ORDER BY `FirstName`;
                                ";
                                $sql6 = mysqli_query($mysqli, $query6);
                                $TACount=mysqli_num_rows($sql6);
                                    //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
                                if ($TACount>0)
                                {
                                    ?>
<table id="customers">
  <tr>
    <th>Name</th>
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
    <td> <a target="_self" title="  Edit User  " href="Umanagement.php?USRIDNO=<?php echo $RefUSR?>&ToAct=EDIT" >
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