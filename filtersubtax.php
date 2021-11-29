<?php session_start();?>
<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);include "dbhands.php";

$AllTaskSubGroups_arr = array();
$ids = $_POST['ids'];
        $query11="SELECT `gRecRef`, `gOfMain`, `gTitle` FROM `tTaskgCode` WHERE `gUsedFor`='TASKSUBGROUP' AND `Status`='ACT' and `gOfMain` IN ($ids) ORDER BY `gTitle`"; 
        $sql11 = mysqli_query($mysqli, $query11);
        $i=0;
        while($row11=mysqli_fetch_array($sql11))
            {
            $AllTaskSubGroups_arr[$i][0]=$row11['gRecRef'];
            $AllTaskSubGroups_arr[$i][1]=$row11['gTitle'];
            $AllTaskSubGroups_arr[$i][2]=$row11['gOfMain'];
            $i++;
            }
        $maxtasksubgrouptitle = sizeof($AllTaskSubGroups_arr);
        $i=0;
        for ($s=0;$s<=sizeof($AllTaskSubGroups_arr);$s++)
           {
                $SubGroupsOfMain_arr[$i][0]=$AllTaskSubGroups_arr[$s][0];
                $SubGroupsOfMain_arr[$i][1]=$AllTaskSubGroups_arr[$s][1];
                $i++;
            }
        
        echo json_encode($SubGroupsOfMain_arr);
                    