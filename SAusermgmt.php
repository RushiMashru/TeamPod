<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
include("taskheader.php");

if(isset($_COOKIE["id"]))             { $id=$_COOKIE["id"]; }
if(isset($_COOKIE["CanSystemAdmin"])) { $CanSystemAdmin=$_COOKIE["CanSystemAdmin"]; }

$disabled = "disabled";
$readonly = "readonly";

if ($CanSystemAdmin == 1)
{$disabled = ''; $readonly=''; }
$SuccessMessage='';    

    $FName=$_POST["FName"];
    $LName=$_POST["LName"];
    $Contact=$_POST["Contact"];
    $Contact=$_POST["Contact"];
    $AddNewBtnClick=$_POST['AddNewBtnClick'];
    $AccountType=$_POST["AccountType"];
    $Company=$_POST["Company"];

    $query10= "SELECT FirstName,LastName,EmailID,ContactNo FROM `tUser`where RefUSR='$id' ";
    $sql10 = mysqli_query($mysqli, $query10);
    $row10 = mysqli_fetch_array($sql10);
    $EmailID = $row10["EmailID"];
    $FirstName = $row10["FirstName"];
    $LastName = $row10["LastName"];
    $ContactNo = $row10["ContactNo"];

if ($AddNewBtnClick=="YES"  )
{
    $AddNewBtnClick="";
    
    if ($id!='')      //----- if Edit Record
    {
        $query11="UPDATE `tUser` SET `FirstName`='$FName',`LastName`='$LName',`ContactNo`='$Contact',`AccountType`='$AccountType', `Company`='$Company', `UpdateBy`='$id' 
      
                  WHERE `RefUSR`='$id'  " ;
                  // print_r($query11);
                   // exit(); 
        $sql11 = mysqli_query($mysqli, $query11);


        $query15= "SELECT AccountType,CliRecRef FROM `tUser`where RefUSR='$id' ";
        $sql15 = mysqli_query($mysqli, $query15);
        $row15 = mysqli_fetch_array($sql15);
        $AccountType = $row15["AccountType"];
        $CliRecRef = $row15["CliRecRef"];

   
        if($AccountType=="Personal"){

            $query30=" UPDATE `tUser` SET `Company`='' ,`UpdateBy`='$id'  WHERE `RefUSR`='$id' ";
            $sql30 = mysqli_query($mysqli, $query30);

         //   print_r($query30);
           // exit();

            $query17= "SELECT MAX(CliCode) as CNum FROM `tClient` where CliType='Personal' ";
            $sql17 = mysqli_query($mysqli, $query17);
            $row17 = mysqli_fetch_array($sql17);
            $CNum = $row17["CNum"];

            $CNum = (int) substr($CNum,1,strlen($CNum));

            if( $CNum > 0){
                $CNum = $CNum + 1;
                $CliCode='P'.$CNum;

            }
            else{
                $CliCode = 'P1';
            }

            if($CliRecRef=='0'){

                $query16="INSERT INTO `tClient`(`CliCode`,`CliName`,  `CliType`,`Status` ) 
            VALUES ( '$CliCode', '$FName', 'Personal','ACT') " ;
            $sql8 = mysqli_query($mysqli, $query16);

            $query19= "SELECT CliRecRef FROM `tClient` where CliCode='$CliCode' ";
            $sql19 = mysqli_query($mysqli, $query19);
            $row19 = mysqli_fetch_array($sql19);
            $CliRecRef = $row19["CliRecRef"];

            $query20="UPDATE `tUser` SET `CliRecRef`='$CliRecRef'  where RefUSR ='$id'";
            $sql20 = mysqli_query($mysqli, $query20);
   // print_r( $query11);
     //exit();

            }

            else{
                $query55= "SELECT CliType FROM `tClient`where CliRecRef='$CliRecRef' ";
                $sql55 = mysqli_query($mysqli, $query55);
                $row55 = mysqli_fetch_array($sql55);
                $CliType = $row55["CliType"];

                if($AccountType != $CliType ){
                   
                      $query24=" UPDATE `tClient` SET `CliCode`='$CliCode', `CliName`='$FName', `CliType`='Personal'  where  CliRecRef='$CliRecRef'";
                      $sql24 = mysqli_query($mysqli, $query24);
  
                  }
            }

        }
           
        else{


          //  $query19="UPDATE `tclient` SET `FirstName`='$FName',`LastName`='$LName',`ContactNo`='$Contact',`AccountType`='$AccountType',  `UpdateBy`='$id'"; 


        }



      
        if($AccountType=="Company"){
            $query21= "SELECT MAX(CliCode) as CNum FROM `tClient` where CliType='Client' ";
            $sql21 = mysqli_query($mysqli, $query21);
            $row21 = mysqli_fetch_array($sql21);
            $CNum = $row21["CNum"];

            $CNum = (int) substr($CNum,1,strlen($CNum));

            if( $CNum > 0){
                $CNum = $CNum + 1;
                $CliCode='C'.$CNum;

            }
            else{
                $CliCode = 'C1';
            }

            if($CliRecRef=='0'){

            $query22="INSERT INTO `tClient`(`CliCode`,`CliName`,  `CliType`,`Status` ) 
            VALUES ( '$CliCode', '$Company', 'Client','ACT') " ;
            $sql26 = mysqli_query($mysqli, $query22);


            $query23= "SELECT CliRecRef FROM `tClient` where CliCode='$CliCode' ";
            $sql23 = mysqli_query($mysqli, $query23);
            $row23 = mysqli_fetch_array($sql23);
            $CliRecRef = $row23["CliRecRef"];

            $query24="UPDATE `tUser` SET `CliRecRef`='$CliRecRef'  where RefUSR ='$id'";
            $sql24 = mysqli_query($mysqli, $query24);
   //print_r( $query21);
    //exit();

            }
            else{
                $query55= "SELECT CliType FROM `tClient`where CliRecRef='$CliRecRef' ";
                $sql55 = mysqli_query($mysqli, $query55);
                $row55 = mysqli_fetch_array($sql55);
                $CliType = $row55["CliType"];

                if($AccountType != $CliType ){
                
                    $query24=" UPDATE `tClient` SET `CliCode`='$CliCode', `CliName`='$Company', `CliType`='Client'  where  CliRecRef='$CliRecRef'";
                    $sql24 = mysqli_query($mysqli, $query24);

                }
            }
        }
           
        else{


          //  $query19="UPDATE `tclient` SET `FirstName`='$FName',`LastName`='$LName',`ContactNo`='$Contact',`AccountType`='$AccountType',  `UpdateBy`='$id'"; 


        }
    
        echo "<script> alert ('User Profile Updated');</script>";
        
    }
    echo "<script>document.location='ptoday.php';</script>";
}

$query10= "SELECT FirstName,LastName,EmailID,ContactNo,AccountType,Company FROM `tUser`where RefUSR='$id' ";
$sql10 = mysqli_query($mysqli, $query10);
$row10 = mysqli_fetch_array($sql10);
$EmailID = $row10["EmailID"];
$FirstName = $row10["FirstName"];
$LastName = $row10["LastName"];
$ContactNo = $row10["ContactNo"];
$AccountType = $row10["AccountType"];
$Company = $row10["Company"];

if($AccountType == 'Company'){$disp="display:block";}else{$disp="display:none";}

?>


<html>
<head>
   
<link rel="shortcut icon" type="image/png" href="images/icontask.png"/>
<link rel="stylesheet" type="text/css" href="cssjs/newstyle.css"></link>

<!--  start Mask  Date Validation   -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="jquery.inputmask.bundle.min.js"></script>

<style>
  .total_fields {
    width: 350px;
    margin-top: 10px;
    margin-bottom: 10px;
    height: 40px;
  }
  .btn-login{
    width: 150px;
    background: #e74c3c;
    color: #fff;
    height: 40px;
    margin-left: 92px;
  }
  
  @media screen and (min-width: 1668px) {
  #customers {
       margin-left: 400px;
    }
}
    </style>


<script>
function validcheck1()
{
   var letters = /^[a-zA-Z]+(\s{1}[a-zA-Z]+)*$/;  
   var numbers = /^[0-9]*$/;
   var paswd=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; 


        var x=document.forms["UserForm"]["FName"].value;
        var y=document.forms["UserForm"]["LName"].value;
        var z=document.forms["UserForm"]["Contact"].value;
    //  var a=document.forms["UserForm"]["company_name_text"].value;
        
        if(x=='')
        {
            alert('Please Enter First Name');
            return false;
        }
        if(y=='')
        {
            alert('Please Enter Last Name');
            return false;
        }
        if(z=='')
        {
            alert('Please Enter Contact Number');
            return false;
        }
    /* if(a=='')
        {
            alert('Please Enter Company Name');
            return false;
        } */
	/*   after all field valids then submit the form */
 document.forms["UserForm"]["AddNewBtnClick"].value="YES";				//----- store parameter to check if the Submit New Button was clicked
 document.forms['UserForm'].submit();


}

</script>

</head>
<body>
<div align="left" style='margin:100px 0 0 15%;width:87%'>
<div class="row" style="margin-left:300px;">
    <form action="" name="UserForm" method="post">
        <input type=hidden name=AddNewBtnClick value="">
      
              <div ><b>First Name :</b></div>
              <input type="text" class="form-control total_fields"  id="FName" name="FName" placeholder="First Name" value="<?php echo $FirstName; ?>" required></br>
                    <div ><b>Last Name :</b></div>
                    <input type="text" class="form-control total_fields" id="LName" name="LName" placeholder="Last Name" value="<?php echo $LastName; ?>" required></br>
                    <div ><b>Email :</b></div>
                    <input type="text" class="form-control total_fields"  id="Email" name="Email" placeholder="Email" value="<?php echo $EmailID;?>" readonly></br>
                    <div ><b>Contact No. :</b></div>
                    <input type="text" class="form-control total_fields"  id="Contact" name="Contact" placeholder="Contact" value="<?php echo $ContactNo; ?>" required></br>
               
                  <div ><b>Account Type. :</b></div>
            <select name="AccountType" id="AccountType" onChange="AccountType_check(this);" class="form-control total_fields" required <?php echo $disabled?> >
            <option value="Personal" <?php if($AccountType=='Personal') { ?> selected="selected" <?php } ?> >Personal</option>
            <option value="Company" <?php if($AccountType=='Company') { ?> selected="selected" <?php } ?> > Company</option>
                       

                           
            </select>
       <br>
       <div  id="Company" style= <?php echo $disp;?> >
            <input type="text" id="Company" name="Company" class="form-control total_fields" placeholder="Company Name"  value="<?php echo $Company;?>"  required <?php echo $readonly?> >
</div>
<br>

                    <button type="button" class="btn btn-default btn-login" name="btnSave" value="SaveUser" onclick="validcheck1()">Update</button>
                    </div>
                     <p>&nbsp;</p>
                     
                     <?php if ($SuccessMessage!='') echo $SuccessMessage; ?>
                     <p>&nbsp;</p>
</form>
                </div>
                    
                <script> 
                function AccountType_check() {
                     var dropdown = document.getElementById("AccountType"); 
                     var current_value = dropdown.options[dropdown.selectedIndex].value; 
                     if (current_value == "Company") { 
                         document.getElementById("Company").style.display = "block";
                         } 
                         if (current_value == "Personal") { 
                         document.getElementById("Company").style.display = "none";
                         }  } 
                </script>

                        </body>
                        </html>


