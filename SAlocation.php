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

    $uRIDNO=$_GET["RIDNO"];
    
        //    echo "<script> alert ('$uToAct / $uRIDNO ');</script>";
    $SuccessMessage='';    
    
        $NewTitle=$_POST["NewTitle"];
        $Code=$_POST["Code"];
        $selAccountStatus=$_POST["selAccountStatus"];
    
        $AddNewBtnClick=$_POST['AddNewBtnClick'];    //--   AddNewBtnClick  - to store a value from validation check if all valid is ok & submit button was pressed
    
        // var_dump($_POST);
    
    if ($AddNewBtnClick=="YES"  )
    {
        $AddNewBtnClick="";
        
        
        if ($uRIDNO!='')      //----- if Edit Record
        {   
            $query11="UPDATE `tLocation` SET `Location`='$NewTitle',`Code`='$Code',`Status`='$selAccountStatus'  
                      WHERE `lRecRef`='$uRIDNO' and `CliRecRef`= '$CliRecRef' " ;
            $sql11 = mysqli_query($mysqli, $query11);
    
            echo "<script> alert ('Record Updated');</script>";
            
        }
        else            //----- add new rocord
        {
             $query301="SELECT * FROM `tLocation` WHERE `Location`='$NewTitle' and `CliRecRef`='$CliRecRef'";

                $sql301 = mysqli_query($mysqli, $query301);    
                $existCount301 = mysqli_num_rows($sql301);
                if ($existCount301>0){
                 echo "<script> alert ('Location already exists');</script>";
                 echo "<script>window.location.href=\"SAlocation.php\"</script>";
                exit();
                }
                
                else{
            
           $query2="INSERT INTO `tLocation`( `Location`,     `Code`, `Status`, `CliRecRef`,`UpdateBy`) 
                                    VALUES ( '$NewTitle', '$Code', '$selAccountStatus','$CliRecRef', '$id') " ;
            $sql2 = mysqli_query($mysqli, $query2);
            //$uUSRIDNO=$mysqli->insert_id;
    
            echo "<script> alert ('New Site/Location Added');</script>";
        }
    
        }
        
        echo "<script>document.location='SAlocation.php';</script>";
        
    }  //---- end if $AddNewBtnClick
    
    
        if ($uRIDNO!='')      //----- Show detail if Edit Record
        {
        
       
            $query31="SELECT * FROM `tLocation` WHERE `lRecRef`='$uRIDNO'  " ;
            $sql31 = mysqli_query($mysqli, $query31);
            while($row31 = mysqli_fetch_array($sql31))
            {
                $gRecRef=$row31['gRecRef'];
                $Location=$row31['Location'];
                $Code=$row31['Code'];
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
  margin-left: 325px;
    width: 55%;
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
  <a class="btn1 " href="SAjobrole.php">Job Role</a>
  <a class="btn1 active" href="SAlocation.php"> Location</a>
 
</div>

<div class="row" style="margin-top:30px;">


<form action="" name="UserForm" method="post">
            <input type=hidden name=AddNewBtnClick value="">

 <input type="text" id="Code" name="Code" placeholder="Code"  value="<?php echo $Code; ?>" required>

  <input type="text" id="NewTitle" name="NewTitle" placeholder="Location"  value="<?php echo $Location; ?>" required>

    
  <select name="selAccountStatus" id="selAccountStatus" required>
  <option value="ACT" <?php if($selAccountStatus=='ACT') { ?> selected="selected" <?php } ?> >Active</option>
                        <option value="INA" <?php if($selAccountStatus=='INA') { ?> selected="selected" <?php } ?> >In-Active</option>
  </select>
  <br>
  <button class="button"  name="btnSave" value="SaveGroup" onclick="validcheck1()" style="margin-top:15px;">Save Location</button>

</div>
<div class=hbox> <h3 style="color: #6f6467;">Location List</h3> </div>
  <div style="margin-top:5px;">
  <?php 

$query6 = "SELECT * FROM `tLocation` WHERE CliRecRef = '$CliRecRef' ORDER BY `Location` ";
$sql6 = mysqli_query($mysqli, $query6);
$TACount=mysqli_num_rows($sql6);
    //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
if ($TACount>0)
{
    ?> 
<table id="customers">


  <tr>
    <!-- <th>Code</th> -->
    <th>Code</th>
    <th> Location</th>
    <th>Status</th>
    <th>Edit</th>
  </tr>
  <?php
                     while($row6 = mysqli_fetch_array($sql6)){
                         // RefMake, CarMake, Status
                             $lRecRef = $row6["lRecRef"];
                             $Location = $row6["Location"];
                             $Code = $row6["Code"];
                             $Status = $row6["Status"];
                             ?> 
  <tr>
    <!-- <td><?php //echo $gRecRef?></td> -->
    <td><?php echo $Code?></td>
    <td><?php echo $Location?></td>
       <td><?php echo $Status?></td>
    <td style="text-align: center";>
    <a target="_self" title="  Edit Group  " href="SAlocation.php?RIDNO=<?php echo $lRecRef?>&ToAct=EDIT" >
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
NO SITE/LOCATION ADDED !
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