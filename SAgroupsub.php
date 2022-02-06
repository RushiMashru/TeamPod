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

$page="subgroup";


$uToAct=$_GET["ToAct"];
$uRIDNO=$_GET["RIDNO"];

    //    echo "<script> alert ('$uToAct / $uRIDNO ');</script>";
$SuccessMessage='';    

    $NewTitle=$_POST["NewTitle"];
        $NewTitle = preg_replace("/[^a-zA-Z0-9\s]/", " ", $NewTitle);         //----- replace special characters
    $eMainGroup=$_POST["eMainGroup"];
    $selAccountStatus=$_POST["selAccountStatus"];

    $AddNewBtnClick=$_POST['AddNewBtnClick'];    //--   AddNewBtnClick  - to store a value from validation check if all valid is ok & submit button was pressed

    // var_dump($_POST);

 $query15= "SELECT CliRecRef FROM `tUser`where RefUSR='$id' ";
            $sql15 = mysqli_query($mysqli, $query15);
            $row15 = mysqli_fetch_array($sql15);
            $CliRecRef = $row15["CliRecRef"];

if ($AddNewBtnClick=="YES"  )
{
    $AddNewBtnClick="";
    
    
    if ($uRIDNO!='')      //----- if Edit Record
    {
        $query11="UPDATE `tTaskgCode` SET `gTitle`='$NewTitle',`gOfMain`='$eMainGroup',`Status`='$selAccountStatus'  
                  WHERE `gRecRef`='$uRIDNO'  " ;
        $sql11 = mysqli_query($mysqli, $query11);

        echo "<script> alert ('Record Updated');</script>";
        
    }
    else            //----- add new rocord
    {
        
        $query31="SELECT * FROM `tTaskgCode` WHERE `gOfMain`='$eMainGroup' and  `gTitle` ='$NewTitle' and `CliRecRef`='$CliRecRef' " ;
        $sql31 = mysqli_query($mysqli, $query31);
        $existCount31 = mysqli_num_rows($sql31);	
        if ($existCount31 > 0) {
            echo "<script> alert ('Subgroup already exists!');</script>";
        } else {
        $query2="INSERT INTO `tTaskgCode`( `gTitle`,    `gUsedFor`,     `gOfMain`,        `Status`,`CliRecRef`) 
                                VALUES ( '$NewTitle', 'TASKSUBGROUP', '$eMainGroup', '$selAccountStatus','$CliRecRef') " ;
        $sql2 = mysqli_query($mysqli, $query2);
        //$uUSRIDNO=$mysqli->insert_id;

        echo "<script> alert ('New Record Added');</script>";
        }
    }

   
    
    echo "<script>document.location='SAgroupsub.php';</script>";
    
}  //---- end if $AddNewBtnClick


    if ($uRIDNO!='')      //----- Show detail if Edit Record
    {
    
   
        $query31="SELECT * FROM `tTaskgCode` WHERE `gRecRef`='$uRIDNO'  " ;
        $sql31 = mysqli_query($mysqli, $query31);
        while($row31 = mysqli_fetch_array($sql31))
        {
            $gRecRef=$row31['gRecRef'];
            $gTitle=$row31['gTitle'];
            $eMainGroup=$row31['gOfMain'];
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

        if(document.forms["UserForm"]["eMainGroup"].value=="")
        {
        alert('Please Select Main Group');
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
  <a class="btn1 " href="SAgroupmain.php">Main Groups</a>
  <a class="btn1 active " href="SAgroupsub.php">Sub Groups</a>
  <a class="btn1" href="SAcompanyacc.php">Company Account</a>
  <a class="btn1" href="Umanagement.php">User Management</a>
 
</div>

<div class="row" style="margin-top:40px;">
<form action="" name="UserForm" method="post">
            <input type=hidden name=AddNewBtnClick value="">

  <input type="text" id="NewTitle" name="NewTitle" placeholder="Task Sub Group Title" value="<?php echo $gTitle; ?>">

  <select name="eMainGroup" id="eMainGroup">
  <option value="">... Select Main Group ...</option>
                            <?php  
                            $maxtaskmaingrouptitle = sizeof($AllTaskMainGroups_arr);
                            $i=0; 
                            while($i<$maxtaskmaingrouptitle)
                            {   
                                $valueof= $AllTaskMainGroups_arr[$i][0] ;
                                if ($eMainGroup == $valueof) {  ?>
                                    <option value="<?php echo $valueof; ?>" selected> <?php echo $AllTaskMainGroups_arr[$i][1] ?></option>
                                <?php } else{ ?>    
                                    <option value="<?php echo $valueof ?>"> <?php echo $AllTaskMainGroups_arr[$i][1] ?> </option>
                            <?php  }  $i++; } ?>
 
  </select>
  
  <select name="selAccountStatus" id="selAccountStatus">
  <option value="ACT" <?php if($selAccountStatus=='ACT') { ?> selected="selected" <?php } ?> >Active</option>
                        <option value="INA" <?php if($selAccountStatus=='INA') { ?> selected="selected" <?php } ?> >In-Active</option>
 
  </select>
  
  <button class="button" name="btnSave" value="SaveGroup" onclick="validcheck1()">Save Group</button>

</div>

  <div >
  <div class=hbox > <h3 style="color:#6f6467;">Sub Group List</h3> </div>

  <?php 

$query6 = "SELECT * FROM `tTaskgCode` WHERE gUsedFor='TASKSUBGROUP' AND CliRecRef = '$CliRecRef' ORDER BY `gTitle` ";
$sql6 = mysqli_query($mysqli, $query6);
$TACount=mysqli_num_rows($sql6);
    //    printf("Result = %d , %d rows.\n",$id ,$TSCount);
if ($TACount>0)
{
    ?> 
<table id="customers">
<tr>
  <!-- <th>Code</th> -->
  <th>Sub Group Title</th>
  <th>Main Group</th>
  <th>Status</th>
  <th>Edit</th>
</tr>

<?php
                     while($row6 = mysqli_fetch_array($sql6)){
                         // RefMake, CarMake, Status
                         $gOfMainTitle='';
                             $gRecRef = $row6["gRecRef"];
                             $gTitle = $row6["gTitle"];
                             $gOfMain = $row6["gOfMain"];
                             $gOfMainTitle=getTaskMainGroupTitle($gOfMain);
                             $Status = $row6["Status"];
                             
                             
                             ?> 
  <tr>
    <!-- <td><?php //echo $gRecRef?></td> -->
    <td><?php echo $gTitle?></td>
    <td><?php echo $gOfMainTitle?></td>
    <td><?php echo $Status?></td>
    <td style="text-align: center";><a target="_self" title="  Edit Group  " href="SAgroupsub.php?RIDNO=<?php echo $gRecRef?>&ToAct=EDIT" >
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