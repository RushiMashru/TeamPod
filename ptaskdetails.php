<style type="text/css">
    .hide{
        display: none !important;
    }
     .show{
        display: block;
    }
    
.myDIV:hover + .hide {
  display: block !important;
  color: #e74c3c !important;
}

</style>
<?php               if ($Priority =="P1") {$taskcolor="#FA8654";}
                    if ($Priority =="P2") {$taskcolor="#FACA54";}
                    if ($Priority =="P3") {$taskcolor="#FAF054";}
                    $UserCodeName_arr = array(); 

                    $query11="SELECT t1.RefUSR, t1.FirstName, t1.LastName FROM `tUser` AS t1, `tUserAccessLevels` AS t2  
                            WHERE t1.RefUSR=t2.RefUSR AND t1.Status='ACT' AND t2.FCompany='$CoCode' 
                            GROUP BY t1.RefUSR ORDER BY t1.FirstName, t1.LastName "; 
                            //echo '<br>-----'.$query11;
                    $sql11 = mysqli_query($mysqli, $query11);
                    $i=0;
                    while($row11=mysqli_fetch_array($sql11))						//------------------- Store Practice ID & Full Name from database to AllPractice_arr ------
                    {
                        $UserCodeName_arr[$i][0]=$row11['RefUSR'];
                        $UserCodeName_arr[$i][1]=$row11['FirstName'].' '.$row11['LastName'];
                        // echo '<br><br> Yes '.$UserCodeName_arr[$i][0].'--'.$UserCodeName_arr[$i][1];
                        $i++;
                    }
                    
                    $query21 = "SELECT * FROM `tTaskNotes` t1 WHERE `TRecRef` ='$TRecRef' AND `Stage`='STARTTIME' AND cRecRef='$cRecRef' AND not EXISTS (
                        SELECT * FROM `tTaskNotes` t2 WHERE `TRecRef` ='$TRecRef' AND `Stage`='ENDTIME' AND cRecRef='$cRecRef' AND `NotesDT` > t1.`NotesDT`)";
                        //echo $query21;exit;
                    $sql21 = mysqli_query($mysqli, $query21);
                    $row21=mysqli_fetch_array($sql21);
                   // echo '<pre>';print_r($row21);exit;
                    $NRecRef=$row21['NRecRef'];
                    $startdisplay="inline";$clockdisplay="none"; $enddisplay="none";
                    $taskid='';$bgtaskcolor='';
                    if ($NRecRef!=""){ 
                        $bgtaskcolor='#f1f1f1';$startdisplay="none";$clockdisplay="inline";$enddisplay="inline";$taskid=$TRecRef; 
                        $query41 = "SELECT Distinct TaskNumber FROM `tTasks` t1 WHERE `TRecRef` ='$TRecRef'";
                        //echo $query21;exit;
                    $sql41 = mysqli_query($mysqli, $query41);
                    $row21=mysqli_fetch_array($sql41);
                   // echo '<pre>';print_r($row21);exit;
                    $taskid=$row21['TaskNumber'];
                    }
                    
                    $outall.= "<input type=hidden id=EditCalendarRef".$celnodv." name=EditCalendarRef".$celnodv." value=".$cRecRef." > ";
                    $outall.= "<input type=hidden id=EditScheduleRef".$celnodv." name=EditScheduleRef".$celnodv." value=".$sRecRef." > ";
                    $outall.= '<div class="maintab-box '.$tasktype.'" id=dv-'.$celnodv.' style="background-color:'.$bgtaskcolor.'">
               <div class="tabsub-box" id="tabsub'.$celnodv.'">';
               if($Priority=='P1'){
                  $outall.= '<img src="images/P1.svg" class="tab-img-1">';
               }
               if($Priority=='P2'){
                   $outall.= '<img src="images/P2.svg" class="tab-img-1">';
               }
               if($Priority=='P3'){
                   $outall.= '<img src="images/P3.svg" class="tab-img-1">';
               }
                $outall.=  "
                        <div class='tab-text-left'>
                        <a  href='#' onclick=popup('popUpDiv','tasknotes','$celnodv') >  <h1># $TaskNumber $CoShortCode</h1></a> 
                        <div class='tab-text-right' style='width:100%;padding-left: 10px;display:inherit'>
                     ";
                        if ($PrivateTask==1) { $outall.= "<img src='images/Lock.svg'> &nbsp "; }
                        if ($RepeatSchedule1!="") { $outall.= "<img src='images/iconcircle.svg'> &nbsp "; }
                        //echo $NStage;
                         $query29 = "SELECT * FROM `tTaskNotes` t1 WHERE `TRecRef` ='$TRecRef' AND `Stage`='FILEUPLOAD'";
                         $sql29 = mysqli_query($mysqli, $query29);
                         $row29=mysqli_fetch_array($sql29);
                        // echo '<pre>';print_r($row21);exit;
                         $NStage=$row29['Stage'];
                        if ($NStage=="FILEUPLOAD") { $outall.= "<img src='images/paperclip.svg'> &nbsp "; }
                        $outall.= '&nbsp <p id="title'.$celnodv.'">'.$TaskTitle.'</p>
                     </div>';
                     if ($nsubtasks == 1){
                     $outall.=  '<div class="tab-text-right">
                        <div class="icon" onclick="changeexpend('.$celnodv.')">
                           <img src="images/Copy of Collapsed.svg">
                        </div>
                     </div>';
                     } 
                
                    $outall.=  ' </div>
                  <div class="tab-text-1 tab-text-2">
                     <div class="tab-text-left">
                        <p id="maintask'.$celnodv.'">'.$TaskMainGroupTitle.' - '. $TaskSubGroupTitle.'</p>
                     </div>
                     <div class="tab-text-right">
                        <p>'.$showdate.'</p>
                     </div>
                  </div>
                  <div class="tab-text-2 tab-text-3 ">
                      <div class="tab-text-left">
                       <p class="myDIV">Description -  ';
                       if(strlen(strip_tags($TaskDescr)) < 50)  {
                       $outall.= $TaskDescr;
                       } else {
                       $outall.= substr(strip_tags($TaskDescr),0,50)."....".' </p>
                       <p class="hide"> '.$TaskDescr.'
                       </p>';
                       }
                     $outall.='</div>
                  </div>
                  <div class="tab-text-4">
                    <p id="fullname'.$celnodv.'" style="display:none" >'.$ForUserFullName.'</p>
                        '.$initials.'
                        <div id="tasktags'.$celnodv.'" >'.$ThisTaskTags.'</div>
                     
                     
                  </div>
                  
                  <div class="tab-text-1 tab-text-5">
                     <div class="tab-text-left"  style="cursor:pointer">
                        <h3 onclick=popup("popUpDiv","addsubtask",'.$cRecRef.')><img src="images/Plus.svg"> Sub task</h3>
                     </div>
                     <div class="tab-text-right">
                        <div class="tab">';
if ($cStage!="Completed") {
                           $outall.='<button class="tablinks" type="button" id=clockstarticon1'.$celnodv.' style=display:'.$clockdisplay.' ><img src="images/Copy of Clock.svg" title="Clock Started"></button>
                           <button class="tablinks" type="button" id=clockstarticon2'.$celnodv.' style=display:'.$startdisplay.' onclick="openCity(event, \''."tab-2".$celnodv.'\',\'divstarttime\')"><img src="images/Hourglass Start.svg" title="Start Time"></button>
                           <button class="tablinks" type="button" id=clockstarticon10'.$celnodv.' style=display:'.$enddisplay.' onclick="openCity(event, \''."tab-10".$celnodv.'\',\'divendtime\')"><img src="images/Hourglass End.svg" title="End Time"></button>
                           <button class="tablinks" type="button" id=clockstarticon3'.$celnodv.' onclick="openCity(event, \''."tab-3".$celnodv.'\',\'diveditgroup\')"><img src="images/Users.svg" title="Re-Group"></button>
                           <button class="tablinks" type="button" id=clockstarticon4'.$celnodv.' onclick="openCity(event, \''."tab-4".$celnodv.'\',\'divedittags\')"><img src="images/Tags.svg" title="Add Tag"></button>
                           <button class="tablinks" type="button" id=clockstarticon5'.$celnodv.' onclick="openCity(event, \''."tab-5".$celnodv.'\',\'divaddattach\')"><img src="images/Copy of Cloud_Upload.svg" title="Add Attachment"></button>
                           <button class="tablinks" type="button" id=clockstarticon6'.$celnodv.' onclick="openCity(event, \''."tab-6".$celnodv.'\',\'divnewnote\')"><img src="images/Notes.svg" title="Add Comments"></button>
                           <button class="tablinks" type="button" id=clockstarticon7'.$celnodv.' onclick="openCity(event, \''."tab-7".$celnodv.'\',\'divnewdate\')"><img src="images/Copy of Calendar_Default.svg" title="Re-schedule Date"></button>
                           <button class="tablinks" type="button" id=clockstarticon8'.$celnodv.' onclick="openCity(event, \''."tab-8".$celnodv.'\',\'divnewuser\')"><img src="images/Copy of By User.svg" title="Reassign"></button>
                           <button class="tablinks" type="button" id=clockstarticon9'.$celnodv.' onclick="openCity(event, \''."tab-9".$celnodv.'\',\'divcomplete\')"><img src="images/Task_Completed.svg" title="Mark Complete"></button>';
}
                        $outall.='</div>
                     </div>
                  </div>
                  <br>
                  <div class="Collapsed tabcontent" id="expendeddiv'.$celnodv.'">';
        
         $query11="SELECT * FROM `tSubTasks` a WHERE STRecRef in (Select STRecRef from tSubTaskCal b where cRecRef in 
        (select cRecRef from tCalendar where SRecRef in (select SRecRef from tSchedule c where TRecRef = '$TRecRef') 
        and (`cScheduleDate`,`cDueDate`) in (select `cScheduleDate`,`cDueDate` from tCalendar where cRecRef='$cRecRef') ) AND b.cRecRef in (select cRecRef from tCalendar where cRecRef=b.cRecRef and Status='A')) ORDER BY a.STRecRef ";
        //echo $query11;exit;
        //$query11="SELECT * FROM `tSubTasks` a WHERE  TRecRef = '$TRecRef' ORDER BY a.STRecRef ";
        $sql11 = mysqli_query($mysqli, $query11);    
        $existCount11 = mysqli_num_rows($sql11);
                      
        if ($existCount11>0){
        $SubUserCodeName_arr=array();
        $y=0;
        $query3011 = "SELECT ForRefUSR from tCalendar where TRecRef='$TRecRef' and (cScheduleDate,cDueDate)=(select cScheduleDate,cDueDate from tCalendar where cRecRef='$cRecRef') and Status='A'";
        $sql3011 = mysqli_query($mysqli, $query3011);
        //$outall.=$query3011;
        while($row3011=mysqli_fetch_array($sql3011))
        {
            $ForRefUSR=$row3011['ForRefUSR'];
            $query31="SELECT `RefUSR`, `FirstName`, `LastName`  FROM `tUser` WHERE `RefUSR`='$ForRefUSR' ";
            $sql31 = mysqli_query($mysqli, $query31);
            while($row31 = mysqli_fetch_array($sql31)){
            $UserRef   =$row31["RefUSR"];
            $FirstName  =$row31["FirstName"];
            $LastName  =$row31["LastName"];
            $FullName=$FirstName.' '.$LastName;
            $FullName1=$FirstName.$LastName;
            $FullName=ucwords(strtolower($FullName)); //----- convert to UpperLower Case
            }
        $SubUserCodeName_arr[$y][0]=$UserRef;
        $SubUserCodeName_arr[$y][1]=$FullName;
      //  $outall.=$SubUserCodeName_arr[$y][0];
        //$outall.=$SubUserCodeName_arr[$y][1];
        $y++;
        
        }            
         $sizeofsubuserarr =   sizeof($SubUserCodeName_arr);
             
            $scelnodv=0;
            $outall.="<input type='hidden' id='subgroupcount-".$celnodv."' value='$existCount11'/>";
            $outall.="";
            while($row11=mysqli_fetch_array($sql11))
            {
                $TRecRefsub=$row11['TRecRef'];
                $STRecRefsub=$row11['STRecRef'];
                //$cRecRefsub=$row11['cRecRef'];
                $TaskTitlesub=$row11['TaskTitle'];
                $Descrsub=$row11['Descr'];
                $Prioritysub=$row11['Priority'];
                $Stagesub=$row11['Stage'];
                $TimeTakensub=$row11['TimeTaken'];
                $CompleteBysub=$row11['CompleteBy'];
                $CompleteDTsub=$row11['CompleteDT'];
                $subtaskowner=$row11['CreatedBy'];
                $CreatedDateTimesub=$row301['CreatedDateTime'];
                if ($Prioritysub =="P1") {$subtaskcolor="#FA8654";}
                if ($Prioritysub =="P2") {$subtaskcolor="#FACA54";}
                if ($Prioritysub =="P3") {$subtaskcolor="#FAF054";}
                $sbordercolor = "#ffd980";
                if ($Stagesub =="Completed") {$sbordercolor="green";}
                $subassigneduser=array();
                $x=0;
                $subinitials='';
                $usertask='N';
                $squery3011 = "SELECT ForRefUSR from tSubTaskCal a where STRecRef='$STRecRefsub' and Status='A' and cRecRef in (select cRecRef from tCalendar where Status='A' and cRecRef=a.cRecRef)";
                $ssql3011 = mysqli_query($mysqli, $squery3011);
                while($row30111=mysqli_fetch_array($ssql3011))
                {
                    $sForRefUSR=$row30111['ForRefUSR'];
                    $squery31="SELECT `RefUSR`, `FirstName`, `LastName`  FROM `tUser` WHERE `RefUSR`='$sForRefUSR' ";
                    $ssql31 = mysqli_query($mysqli, $squery31);
                    while($row311 = mysqli_fetch_array($ssql31)){
                        $sFirstName  =$row311["FirstName"];
                        $sLastName  =$row311["LastName"];
                        $sFullName=$sFirstName.' '.$sLastName;
                        $sFullName=ucwords(strtolower($sFullName)); //----- convert to UpperLower Case
                    }
                    if($ForRefUSRC==$sForRefUSR) {$color1="#ccc";$usertask='Y';} else { $color1="#fff";};
                    $subinitials.="<span style='background:$color1;color:#000;border-radius:50%;padding:5px;border:1px solid #000' ><a href='#' title='$sFullName'>".substr($sFirstName,0,1).substr($sLastName,0,1)."</a></span>&nbsp;&nbsp;";
                    $subassigneduser[$x]=$sForRefUSR;
                    $x++;
                }
                
                $query212 = "SELECT * FROM `tTaskNotes` t1 WHERE `STRecRef` ='$STRecRefsub' AND `Stage`='SUBSTARTTIME' AND cRecRef='$cRecRef' AND not EXISTS (
                        SELECT * FROM `tTaskNotes` t2 WHERE `STRecRef` ='$STRecRefsub' AND `Stage`='SUBENDTIME' AND cRecRef='$cRecRef' AND `NotesDT` > t1.`NotesDT`)";
                    $sql212 = mysqli_query($mysqli, $query212);
                    $row212=mysqli_fetch_array($sql212);
                    $sNRecRef=$row212['NRecRef'];
                    $substartdisplay="inline";$subclockdisplay="none"; $subenddisplay="none";
                    $subtaskid='';
                    if ($sNRecRef!=""){ $substartdisplay="none";$subclockdisplay="inline";$subenddisplay="inline";$subtaskid=$STRecRefsub; }
                
                
                $outall.="<input type='hidden' id='EditSubTaskRef-".$celnodv."-".$scelnodv."' value='$STRecRefsub'/>";
                $outall.="<input type='hidden' id='subgroupstatus-".$celnodv."-".$scelnodv."' value='$Stagesub'/>";
               
               $outall.='<div style="border: 2px solid;border-color:'.$sbordercolor.';padding: 5px;border-radius: 5px;border-left-width: 10px;margin-bottom:5px">';
                
                 $outall.=' <div class="tab-text-4" id=sdv-'.$celnodv.'-'.$scelnodv.'>
                              <div class="img-box" style="background: #ffe199;    color: black;" >
                                 '.substr($sFirstName,0,1).substr($sLastName,0,1).'</div>
                              <div class="name-box" >';

                                if($Prioritysub=='P1'){
                  $outall.= '<img src="images/P1.svg" class="tab-img-1">';
               }
               if($Prioritysub=='P2'){
                   $outall.= '<img src="images/P2.svg" class="tab-img-1">';
               }
               if($Prioritysub=='P3'){
                   $outall.= '<img src="images/P3.svg" class="tab-img-1">';
               }$outall.='<a onclick=popup("popUpDiv","subtasknotes",'.$celnodv.','.$scelnodv.')>'.$TaskTitlesub.'</a>
                              </div>
                           </div>
                     <p> Description - '.$Descrsub.'
                           </p>
                           <div class="tab-text-1 tab-text-5">
                            <div class="tab-text-left">
                        <h3></h3>
                     </div>
                           <div class="tab-text-right">
                        <div class="tab">';
                        if ($usertask=='Y' && $Stagesub !="Completed") {
                           $outall.='<button class="tablinks" type="button" id=clockstart'.$celnodv.$scelnodv.' style=display:'.$subclockdisplay.'><img src="images/Copy of Clock.svg""  title="Clock Started" /></span>
                           <button class="tablinks" type="button" id=starttimeicon'.$celnodv.$scelnodv.' style=display:'.$substartdisplay.' onclick="openCity1(event, \''."sub-tab-1".$celnodv.$scelnodv.'\','.$celnodv.','.$scelnodv.',\'divsubstarttime\')"><img src="images/Hourglass Start.svg" title="Start Time"></button>
                           <button class="tablinks" type="button" id=endtimeicon'.$celnodv.$scelnodv.'  style=display:'.$subenddisplay.' onclick="openCity1(event, \''."sub-tab-2".$celnodv.$scelnodv.'\','.$celnodv.','.$scelnodv.',\'divsubendtime\')"><img src="images/Hourglass End.svg" title="End Time"></button>                          
                           <button class="tablinks" type="button" id=subaddattach'.$celnodv.$scelnodv.'  onclick="openCity1(event, \''."sub-tab-3".$celnodv.$scelnodv.'\','.$celnodv.','.$scelnodv.',\'divsubaddattach\')"><img src="images/Copy of Cloud_Upload.svg"></button>
                           <button class="tablinks" type="button" id=clockstarticon6'.$celnodv.$scelnodv.' onclick="openCity1(event, \''."sub-tab-4".$celnodv.$scelnodv.'\','.$celnodv.','.$scelnodv.',\'divsubnewnote\')"><img src="images/Notes.svg"></button>
                           <button class="tablinks" type="button" id=clockstarticon8'.$celnodv.$scelnodv.' onclick="openCity1(event, \''."sub-tab-6".$celnodv.$scelnodv.'\','.$celnodv.','.$scelnodv.',\'divsubnewuser\')"><img src="images/Copy of By User.svg"></button>
                           <button class="tablinks" type="button" id=clockstarticon9'.$celnodv.$scelnodv.' onclick="openCity1(event, \''."sub-tab-7".$celnodv.$scelnodv.'\','.$celnodv.','.$scelnodv.',\'divsubcomplete\')"><img src="images/Task_Completed.svg"></button>';
                           }
                        $outall.='</div>
                        </div>
                        </div>
                     </div>
                      <div class="tab-text-6">
                     <div id="sub-tab-1'.$celnodv.$scelnodv.'" class="tabcontent">
                           <input type="hidden" class=subnoteid id=notid'.$celnodv.'-'.$scelnodv.'    value='.$sNRecRef.'>
                           <input type="hidden" class=subntaskid id=ntaskid'.$celnodv.'-'.$scelnodv.' value='.$subtaskid.'>
                     </div>
                     <div id="sub-tab-2'.$celnodv.$scelnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" id=EndNote'.$celnodv.'-'.$scelnodv.' name=EndNote'.$celnodv.'-'.$scelnodv.' placeholder="End Notes*"></textarea>

                           <div class="btn-sec">
                              <button type="button"  onClick="addsubendnote('.$celnodv.','.$scelnodv.')" name=btnSaveEndNote'.$celnodv.'>save</button>
                              <button type="button" onClick="Completesubtaskend('.$celnodv.','.$scelnodv.')" name=btnSaveEndNote'.$celnodv.'>save & complete</button>
                           </div>
                           
                        </div>
                     </div>
                     <div id="sub-tab-3'.$celnodv.$scelnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" name="sDocNote'.$celnodv.'-'.$scelnodv.'" id="sDocNote'.$celnodv.'-'.$scelnodv.'"  placeholder="Supporting Document Notes"></textarea>

                           <div class="upload-box">
                               <h3>Flie Upload</h3>
                               <div class="image-upload-wrap">
                                <input class="file-upload-input" id="AttachDoc'.$celnodv.'-'.$scelnodv.'" name="AttachDoc'.$celnodv.'-'.$scelnodv.'" type="file" onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                  <h3><img src="images/upload.svg">Browse to upload</h3>
                                </div>
                              </div>
                              <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                  <button type="button" onclick="removeUpload()" class="remove-image">X</button>
                                </div>
                              </div>
                                                           <p>Supported formats: .pdf,.doc,.jpg,.jpeg,.png,.docx,.xlsx</p>
                            <p>You can only upload files with file size under 5 MB.</p>
                           </div>
                           <div class="btn-sec">
                              <button type="button" onclick=addsubfile('.$celnodv.','.$scelnodv.') name=btnUploadFile'.$celnodv.'-'.$scelnodv.' >save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="sub-tab-4'.$celnodv.$scelnodv.'" class="tabcontent">
                        <div class="text-box">
                             <div class="input-box">
                               <input type="text" name="noteupTimeTaken'.$celnodv.'-'.$scelnodv.'" id="noteupTimeTaken'.$celnodv.'-'.$scelnodv.'" placeholder="HH:MM">
                               <img src="images/clock.png">
                            </div>
                           <textarea type="text"  id="NewNote'.$celnodv.'-'.$scelnodv.'" name="NewNote'.$celnodv.'-'.$scelnodv.'" placeholder="Complete Notes"></textarea>
                          
                           <div class="btn-sec">
                              <button type="button" onclick=newsubnote('.$celnodv.','.$scelnodv.') name="btnSaveNewNote'.$celnodv.'-'.$scelnodv.'">save</button>
                           </div>
                          
                        </div>
                     </div>
                     <div id="sub-tab-5'.$celnodv.$scelnodv.'" class="tabcontent">
                         <div class="text-box">
                           <div style="height:40px"></div>
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="sub-tab-6'.$celnodv.$scelnodv.'" class="tabcontent">
                        <div class="text-box">
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select  name="reassignopt'.$celnodv.'" id=reassignopt'.$celnodv.'>
                                    <option value="current" '.$selected.'> Current Schedule</option>';
                                     if ($RepeatSchedule1!='') { 
                                    $outall.= "<option value='allfuture'>All Future Schedule</option>";
                                }
                                $outall.='</select>
                            </div>
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">';
                                $sizeofuserarr=sizeof($UserCodeName_arr);
                                if ($id == $subtaskowner) {
                                   $outall.= "<select name='selNewUser".$celnodv."'  id='ForRefUSR".$celnodv."-".$scelnodv."' class='total_fields' multiple>";
                                              $i=0;$maxsubassigneduser=sizeof($subassigneduser);
                                             
                                             while($i<$sizeofsubuserarr)
                                             {   
                                                 $x=0;$selected='';
                                                while($x<$maxsubassigneduser) {
                                                    if ($SubUserCodeName_arr[$i][0] == $subassigneduser[$x]) {
                                                        $selected ='selected';
                                                    }
                                                    $x++;
                                                }
                                                $outall.= "<option value=".$SubUserCodeName_arr[$i][0]." $selected> ".$SubUserCodeName_arr[$i][1]."</option>";
                                               $i++; 
                                             }

                             $outall.='</select>
                             <script>
                                    document.multiselect("#ForRefUSR'.$celnodv.'-'.$scelnodv.'")
                                 .setCheckBoxClick("checkboxAll", function(target, args) {
                                    
                                 })
                                 .setCheckBoxClick("1", function(target, args) {
                                 });
                                 
                                 </script>
                             </div>
                           <div class="btn-sec">
                              <button type="button" onclick="reassignsub('.$celnodv.','.$scelnodv.')"   id="btnSaveNewUser'.$celnodv.'" name="btnSaveNewUser'.$celnodv.'">save</button>
                           </div>';
                           } else {
                                       $outall.= "<select name='selNewUser".$celnodv."-".$scelnodv."' style='width:300px;float:left' id='ForRefUSR".$celnodv."-".$scelnodv."' class='total_fields'>";
                                            $i=0;$maxsubassigneduser=sizeof($subassigneduser);
                                             while($i<$sizeofsubuserarr)
                                             {   
                                                 $x=0;$match="";
                                                while($x<$maxsubassigneduser) {
                                                    if ($SubUserCodeName_arr[$i][0] == $subassigneduser[$x]) {
                                                     $match="true";  
                                                    }
                                                    $x++;
                                                }
                                                if ($match!="true"){
                                                    $outall.= "<option value=".$SubUserCodeName_arr[$i][0]." > ".$SubUserCodeName_arr[$i][1]."</option>";
                                                }
                                               $i++; 
                                             }
                                    $outall.= '</select> </div>';
                                    $outall.='<div class="btn-sec"><button type="button" onclick=reassignsubuser('.$celnodv.','.$scelnodv.')>save</button></div>';
                                    }
                          
                        $outall.= '</div>
                     </div>
                     <div id="sub-tab-7'.$celnodv.$scelnodv.'" class="tabcontent">
                         <div class="text-box">
                             <div class="input-box">
                               <input type="text" placeholder="HH:MM" name="upTimeTaken'.$celnodv.'-'.$scelnodv.'" id="upTimeTaken'.$celnodv.'-'.$scelnodv.'">
                               <img src="images/clock.png">
                            </div>
                           <textarea type="text" id="NewCompNote'.$celnodv.'-'.$scelnodv.'" name="NewCompNote'.$celnodv.'-'.$scelnodv.'"  placeholder="Complete Notes"></textarea>
                          
                           <div class="btn-sec">
                              <button type=button  onclick="completesubtask('.$celnodv.','.$scelnodv.')" name="btnSaveNewNote'.$celnodv.'-'.$scelnodv.'">save</button>
                           </div>
                          
                        </div>
                     </div>
                  </div> 
                           ';
                $scelnodv++;
            }
        } else {
            $outall.="<input type='hidden' id='subgroupcount-".$celnodv."' value='0'/>";
        }
    
                  $outall.='</div>
                  <div class="tab-text-6">
                     <div id="tab-2'.$celnodv.'" class="tabcontent">
                        <input type="hidden" class="noteid" id="notid'.$celnodv.'" value="'.$NRecRef.'">
                        <input type="hidden" class="ntaskid" id="ntaskid'.$celnodv.'" value="'.$taskid.'">
                      
                     </div>
                     <div id="tab-10'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" id=EndNote'.$celnodv.' name=EndNote'.$celnodv.' placeholder="End Notes*"></textarea>

                           <div class="btn-sec">
                              <button type="button" onClick="addendnote('.$celnodv.')" name=btnSaveEndNote'.$celnodv.'>save</button>
                              <button type="button" onClick="Completetaskend('.$celnodv.')" name=btnSaveEndNote'.$celnodv.'>save & complete</button>
                           </div>
                           
                        </div>
                     </div>
                     <div id="tab-3'.$celnodv.'" class="tabcontent">
                     <input type=hidden id="MainGroup'.$celnodv.'" value='.$eMainGroup.' >
                          <div class="text-box">
                            <div class="select-box" >
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select name="eMainGroup'.$celnodv.'" id="eMainGroup'.$celnodv.'"  onchange="loadsubgrp1('.$celnodv.')"><option value="">Main Group</option>';

                                    $maxtaskmaingrouptitle = sizeof($AllTaskMainGroups_arr);
                                        $i=0; 
                                        while($i<$maxtaskmaingrouptitle)
                                        {   
                                            $valueof= $AllTaskMainGroups_arr[$i][0] ;
                                            if ($eMainGroup == $valueof) {  
                                                $outall.= "<option value='$valueof' selected>".$AllTaskMainGroups_arr[$i][1]."</option>";
                                             } else{     
                                              $outall.= "<option value='$valueof'>".$AllTaskMainGroups_arr[$i][1]."</option>";
                                         }  $i++; } 
                                $outall.='</select>
                            </div>
                            <div class="select-box">
                            <input type=hidden id="SubGroup'.$celnodv.'" value='.$eSubGroup.'>
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select name="eSubGroup'.$celnodv.'" id="eSubGroup'.$celnodv.'"><option value="">Sub Group</option>';
                                    if ($eMainGroup!="0") {
                                        $SubGroupsOfMain_arr=getSubGroupOfMain($eMainGroup);
                                        if ($SubGroupsOfMain_arr!="") {
                                        $maxtasksubgrouptitle = sizeof($SubGroupsOfMain_arr);
                                        } else {
                                        $maxtasksubgrouptitle=0;
                                        }
                                        $i=0; 
                                        while($i<$maxtasksubgrouptitle)
                                        {   
                                            $valueof= $SubGroupsOfMain_arr[$i][0] ;
                                            if ($eSubGroup == $valueof) {  
                                            $outall.= "<option value='$valueof' selected>".$SubGroupsOfMain_arr[$i][1]." </option>";
                                            } else{     
                                            $outall.= "<option value='$valueof'>".$SubGroupsOfMain_arr[$i][1]."</option>";
                                        }  $i++; } 
                                        }else {
                                            $outall.= "<option value=''>--Select Maingroup--</option>";
                                        }
                                $outall.='</select>
                            </div>
                           <div class="btn-sec">
                              <button type="button" onClick="regroup('.$celnodv.')" name=btnSaveGroup".$celnodv.">save</button>
                           </div>
                         
                           
                        </div>
                     </div>
                     <div id="tab-4'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                            <div class="input-box">
                               <input type="text"name="sTaskTag'.$celnodv.'" id="sTaskTag'.$celnodv.'" value="'.$sTaskTag.'" placeholder="Tag">
                            </div>
                            
                           <div class="btn-sec">
                              <button type="button" onClick="addtag('.$celnodv.')" name=btnAddTag'.$celnodv.'>save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="tab-5'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" name="sDocNote'.$celnodv.'" id="sDocNote'.$celnodv.'"  placeholder="Supporting Document Notes"></textarea>

                           <div class="upload-box">
                               <h3>Flie Upload</h3>
                               <div class="image-upload-wrap">
                                <input class="file-upload-input" id="AttachDoc'.$celnodv.'" name="AttachDoc'.$celnodv.'" type="file" onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                  <h3><img src="images/upload.svg">Browse to upload</h3>
                                </div>
                              </div>
                              <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                  <button type="button" onclick="removeUpload()" class="remove-image">X</button>
                                </div>
                              </div>
                                                           <p>Supported formats: .pdf,.doc,.jpg,.jpeg,.png,.docx,.xlsx</p>
                            <p>You can only upload files with file size under 5 MB.</p>
                           </div>
                           <div class="btn-sec">
                              <button type="button" onclick="addfile('.$celnodv.')" name=btnUploadFile'.$celnodv.'>save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="tab-6'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                             <div class="input-box">
                               <input type="text" name="noteupTimeTaken'.$celnodv.'" id="noteupTimeTaken'.$celnodv.'" placeholder="HH:MM">
                               <img src="images/clock.png">
                            </div>
                           <textarea type="text"  id="NewNote'.$celnodv.'" name="NewNote'.$celnodv.'" placeholder="Complete Notes"></textarea>
                          
                           <div class="btn-sec">
                              <button type="button" onclick="newnote('.$celnodv.')" name="btnSaveNewNote'.$celnodv.'">save</button>
                           </div>
                          
                        </div>
                     </div>
                     <div id="tab-7'.$celnodv.'" class="tabcontent">
                         <div class="text-box">
                           <div style="height:40px">
                            <button type="button" onclick="showschedule('.$celnodv.',\'divreschdulecurr\')" name="btnReSchCurrD1" id="btnReSchCurrD1" style="margin-left: 22px;">Re-Schedule Current Date</button>
                            <button type="button" onclick="showschedule('.$celnodv.',\'removecurrent\')" name="btnReSchCurrD1" id="btnReSchCurrD1">Remove Current Date</button>
                           </div>';
                                           if ($RepeatSchedule1!='') { 
                        $outall.= " <button type=button name='btnReSchFullS1' id='btnReSchFullS1'  onclick=showschedule('".$celnodv."','divreschdulefuture') >Re-Schedule All Future Series</button>
                                    <button type=button name='btnRemovFullS1' id='btnRemovFullS1'  onclick=showschedule('".$celnodv."','removefuture')    >Remove All Future Series</button><br/>";
                                 }
                               $outall.= "<div id=divreschdulecurr-".$celnodv." style='display: none;margin-top:20px;'>Start Date: <input type=text style='width:100px' id=NewStartDate".$celnodv." name=NewStartDate".$celnodv." class='datepicker total_fields' value=".$cScheduleDateUK.">
                                            <br><br> Due Date: &nbsp; <input type=text style='width:100px' id=NewDueDate".$celnodv." name=NewDueDate".$celnodv." class='datepicker total_fields' value=".$cDueDateUK.">
                                    <input type=button onclick=reschedulecurrent(".$celnodv.") name=btnSaveReSchedule".$celnodv." value='Save' title='Save' style='padding: 7px 30px;border: 1px solid #e74c3c;color: #e74c3c;background-color: transparent;font-size: 14px;margin-left: 35px;border-radius: 50px;'>
                                    <input type=hidden style='width:100px' id=OldStartDate".$celnodv." name=OldStartDate".$celnodv." class='datepicker total_fields' value=".$csqlScheduleDate.">
                                    <input type=hidden style='width:100px' id=OldDueDate".$celnodv." name=OldDueDate".$celnodv." class='datepicker total_fields' value=".$csqlDueDate.">
                                    </div>
                                    <div id=divreschdulefuture-".$celnodv." style='display: none;margin-top:20px;'>
    <span style='float:left;width:100px;margin-top:7px;text-align:left'>Start Date:</span>
    <input type='text' class='total_fields' style='width:120px;float:left' id=StartDate".$celnodv." name=StartDate".$celnodv." value=''>
    
    <script type='text/javascript'>
            $(function(){
            $('*[name=StartDate".$celnodv."]').datepicker({
                     dateFormat: 'dd-mm-yy'
                    });
            
    $('*[name=StartDate".$celnodv."]').datepicker('setDate', 'today');
            });
    </script>
    
    <span style='float:left;width:100px;margin-top:7px;margin-left:10px;text-align:left'>Due Date:</span>
    <input type='text' class='total_fields' style='width:120px;float:left' id=DueDate".$celnodv." name=DueDate".$celnodv." value=''>
   
      <script type='text/javascript'>
            $(function(){
            $('*[name=DueDate".$celnodv."]').datepicker({
                     dateFormat: 'dd-mm-yy'
                    });
            
    $('*[name=DueDate".$celnodv."]').datepicker('setDate', 'today');
            });
    </script>
   
    <span style='float:left;width:100px;margin-top:15px;text-align:left'>Repeat:</span>
    <select class='total_fields' name='RepeatSchedule' id='RepeatSchedule' style='width:120px;margin-top:7px;float:left' >";
    $displaydays="none";
        if ($RepeatSchedule1 == 'Daily') {  $outall.= "<option value='Daily' selected >" ; } else{  $outall.= "<option value='Daily' >"; }  $outall.= "Daily</option>";
        if ($RepeatSchedule1 == 'Weekly') { $displaydays="block"; $outall.= "<option value='Weekly' selected >" ; } else{  $outall.= "<option value='Weekly' >"; }  $outall.= "Weekly</option>";
        if ($RepeatSchedule1 == 'Monthly') { $outall.= "<option value='Monthly' selected >";  } else{ $outall.= "<option value='Monthly' >"; }  $outall.= "Monthly</option>";
        if ($RepeatSchedule1 == 'Yearly') { $outall.= "<option value='Yearly' selected >" ; } else{  $outall.= "<option value='Yearly' >"; } $outall.= "Yearly</option>";
    $outall.= "</select>
    <br clear='all'/>
    <br clear='all'/>
    
     <div id='DivSelectDay' style='display:$displaydays;float:left'>
    &nbsp;
        Mo <input type=checkbox id=cbxDays name=cbxDays[] value='Mon'"; if (strpos($awdays,"Mon") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";
        $outall.= "Tu <input type=checkbox id=cbxDays name=cbxDays[] value='Tue'"; if (strpos($awdays,"Tue") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";
        $outall.= "We <input type=checkbox id=cbxDays name=cbxDays[] value='Wed'"; if (strpos($awdays,"Wed") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";
        $outall.= "Th <input type=checkbox id=cbxDays name=cbxDays[] value='Thu'"; if (strpos($awdays,"Thu") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";
        $outall.= "Fr <input type=checkbox id=cbxDays name=cbxDays[] value='Fri'"; if (strpos($awdays,"Fri") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";
        $outall.= "Sa <input type=checkbox id=cbxDays name=cbxDays[] value='Sat'"; if (strpos($awdays,"Sat") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";
        $outall.= "Su <input type=checkbox id=cbxDays name=cbxDays[] value='Sun'"; if (strpos($awdays,"Sun") !== false) { $outall.= " checked";} $outall.= " > &nbsp;&nbsp;";

    $outall.= "</div><br clear='all'/><br clear='all'/>
   <div id='DivSelectRepeat' style='display:block;'>
    <span style='float:left;width:130px;margin-top:7px;text-align:left'>Next Task After:</span>
    <input type='text' class='total_fields' style='width:50px;float:left' name='NextAfter' id='NextAfter' value='1'/>&nbsp;&nbsp;<label id='LblTextNext'></label><br clear='all'/><br clear='all'/>

    <span style='float:left;width:130px;margin-top:7px;text-align:left'><input type='radio' name='radioNoOfTimes' id='radioNoOfTimes' value='EndAfter' checked>&nbsp;&nbsp;End After </input></span><input type='text' class='total_fields' style='width:50px;float:left' name='EndAfterOccur' id='EndAfterOccur' value='10'/> <span style='float:left;margin-top:7px;text-align:right'>&nbsp;&nbsp;&nbsp;Occurrences</span><br clear='all'/>   <br clear='all'/>
    <span style='float:left;width:130px;margin-top:7px;text-align:left'><input type='radio' name='radioNoOfTimes' id='radioNoOfTimes' value='EndBy'>&nbsp;&nbsp;End By </input></span><input type='text' class='total_fields' style='width:120px;float:left' name='EndByDate' id='EndByDate' value=''/>  <br clear='all'/>   <br clear='all'/>
    <span style='float:left;width:170px;margin-top:7px;text-align:left'><input type='radio' name='radioNoOfTimes' id='radioNoOfTimes' value='NoEnd'>&nbsp;&nbsp;End after 10 years </input></span>

   <script type='text/javascript'>
            $(function(){
            $('*[name=EndByDate]').datepicker({
                     dateFormat: 'dd-mm-yy'
                    });
            
    $('*[name=EndByDate]').datepicker('setDate', 'today');
            });
    </script>
    
    </div>
 
    
    </div>";
                           $outall.= '
                        </div>
                     </div>
                     <div id="tab-8'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select  name="reassignopt'.$celnodv.'" id=reassignopt'.$celnodv.'>
                                    <option value="current" '.$selected.'> Current Schedule</option>';
                                     if ($RepeatSchedule1!='') { 
                                    $outall.= "<option value='allfuture'>All Future Schedule</option>";
                                }
                                $outall.='</select>
                            </div>
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">';
                                $sizeofuserarr=sizeof($UserCodeName_arr);
                                if ($id == $taskowner) {
                                   $outall.= "<select name=selNewUser".$celnodv."  id=ForRefUSR".$celnodv." class='total_fields' multiple>";
                                             $i=0;$maxassigneduser=sizeof($assigneduser);
                                             
                                             while($i<$sizeofuserarr)
                                             {   
                                                 $x=0;$selected='';
                                                while($x<$maxassigneduser) {
                                                    if ($UserCodeName_arr[$i][0] == $assigneduser[$x]) {
                                                        $selected ='selected';
                                                    }
                                                    $x++;
                                                }
                                                $outall.= "<option value=".$UserCodeName_arr[$i][0]." $selected> ".$UserCodeName_arr[$i][1]."</option>";
                                               $i++; }

                             $outall.='</select>
                             <input type=hidden name="taskowner'.$celnodv.'" value="YES" /> <input type=hidden name="selectedusers'.$celnodv.'" id="selectedusers'.$celnodv.'" value="'.$selectedusers.'" /> <script>
                                    document.multiselect("#ForRefUSR'.$celnodv.'")
                                 .setCheckBoxClick("checkboxAll", function(target, args) {
                                    
                                 })
                                 .setCheckBoxClick("1", function(target, args) {
                                 });
                                 
                                 </script>
                             </div>
                           <div class="btn-sec">
                              <button type="button" onclick="reassign('.$celnodv.')" id="btnSaveNewUser'.$celnodv.'" name="btnSaveNewUser'.$celnodv.'">save</button>
                           </div>';
                           } else {
                                       $outall.= "<select name=selNewUser".$celnodv." id=ForRefUSR".$celnodv." class='total_fields'>";
                                             $i=0;$maxassigneduser=sizeof($assigneduser);
                                             while($i<$sizeofuserarr)
                                             {   
                                                 $x=0;$match="";
                                                while($x<$maxassigneduser) {
                                                    if ($UserCodeName_arr[$i][0] == $assigneduser[$x]) {
                                                     $match="true";  
                                                    }
                                                    $x++;
                                                }
                                                if ($match!="true"){
                                                    $outall.= "<option value=".$UserCodeName_arr[$i][0]." > ".$UserCodeName_arr[$i][1]."</option>";
                                                }
                                               $i++; 
                                             }
                                    $outall.= '</select> </div><input type=hidden name="taskowner'.$celnodv.'" value="NO" />';
                                    $outall.='<div class="btn-sec"><button type="button" onclick="reassign('.$celnodv.')" id="btnSaveNewUser'.$celnodv.'" name="btnSaveNewUser'.$celnodv.'">save</button></div>';
                                    }
                         
                        $outall.= '</div>
                     </div>
                     <div id="tab-9'.$celnodv.'" class="tabcontent">
                         <div class="text-box">
                             <div class="input-box">
                               <input type="text" name="text" placeholder="HH:MM" name="upTimeTaken'.$celnodv.'" id="upTimeTaken'.$celnodv.'">
                               <img src="images/clock.png">
                            </div>
                           <textarea type="text" id="NewCompNote'.$celnodv.'" name="NewCompNote'.$celnodv.'" placeholder="Complete Notes"></textarea>
                          
                           <div class="btn-sec">
                              <button type=button onclick="completetask('.$celnodv.')">save</button>
                           </div>
                          
                        </div>
                     </div>
                  </div>

               </div>
            ';
  
        /*} else {
            $outall.="<input type='hidden' id='subgroupcount-".$celnodv."' value='0'/>";
        }*/
    
?>