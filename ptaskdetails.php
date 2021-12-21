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
                    $sql21 = mysqli_query($mysqli, $query21);
                    $row21=mysqli_fetch_array($sql21);
                    $NRecRef=$row21['NRecRef'];
                    $startdisplay="inline";$clockdisplay="none"; $enddisplay="none";
                    $taskid='';
                    if ($NRecRef!=""){ $startdisplay="none";$clockdisplay="inline";$enddisplay="inline";$taskid=$TRecRef; }
                    
                    $outall.= "<input type=hidden id=EditCalendarRef".$celnodv." name=EditCalendarRef".$celnodv." value=".$cRecRef." > ";
                    $outall.= "<input type=hidden id=EditScheduleRef".$celnodv." name=EditScheduleRef".$celnodv." value=".$sRecRef." > ";
                    $outall.= '<div class="maintab-box" id=dv-'.$celnodv.'>
               <div class="tabsub-box">
                  <img src="images/Copy of Completed Bookmark.svg" class="tab-img-1">
                  <div class="tab-text-1">
                     <div class="tab-text-left">
                        <h1># Company</h1>
                        <p><img src="images/lock.svg">Task
                        <p>
                     </div>
                     <div class="tab-text-right">
                        <div class="icon">
                           <img src="images/Copy of Collapsed.svg">
                        </div>
                     </div>
                  </div>
                  <div class="tab-text-1 tab-text-2">
                     <div class="tab-text-left">
                        <p>Main Group - Sub Group</p>
                     </div>
                     <div class="tab-text-right">
                        <p>'.$showdate.'</p>
                     </div>
                  </div>
                  <div class="tab-text-2 tab-text-3 ">
                     <div class="tab-text-left">
                        <p>'.$TaskDescr.'
                        </p>
                     </div>
                  </div>
                  <div class="tab-text-4">
                     <div class="img-box">
                        '.$CoShortCode.'
                     </div>
                     
                  </div>
                  <div class="tab-text-1 tab-text-5">
                     <div class="tab-text-left">
                        <h3><img src="images/Plus.svg" onclick=popup("popUpDiv","addsubtask","$cRecRef")> Sub task</h3>
                     </div>
                     <div class="tab-text-right">
                        <div class="tab">

                           <button class="tablinks" type="button" id=clockstarticon".$celnodv." onclick="openCity(event, \''."tab-1".$celnodv.'\')"><img src="images/Copy of Clock.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-2".$celnodv.'\')"><img src="images/Hourglass Start.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-3".$celnodv.'\')"><img src="images/Users.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-4".$celnodv.'\')"><img src="images/Tags.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-5".$celnodv.'\')"><img src="images/Copy of Cloud_Upload.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-6".$celnodv.'\')"><img src="images/Notes.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-7".$celnodv.'\')"><img src="images/Copy of Calendar_Default.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-8".$celnodv.'\')"><img src="images/Copy of By User.svg"></button>
                           <button class="tablinks" type="button" onclick="openCity(event, \''."tab-9".$celnodv.'\')"><img src="images/Task_Completed.svg"></button>
                        </div>
                     </div>
                  </div>
                  <div class="Collapsed tabcontent">
                      <hr>
                      <div class="tab-text-4">
                              <div class="img-box">
                                 <img src="images/tab-11.png">
                              </div>
                              <div class="name-box">
                                 P2: Sub Task
                              </div>
                           </div>
                     <p> Description. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sem
                              mauris consectetur. Lorem ipsum dolor sit amet, consectetur adipiscing
                              elit. Sem mauris consectetur
                           </p>
                           <div class="img-btn-sec">
                             <img src="images/Copy of Clock.svg">
                          <img src="images/Hourglass Start.svg">
                               <img src="images/Copy of Cloud_Upload.svg">
                          <img src="images/Notes.svg">
                          <img src="images/Copy of Calendar_Default.svg">
                          <img src="images/Copy of By User.svg">
                          <img src="images/Task_Completed.svg">
                           </div>  
                            <hr>   
                            <div class="tab-text-4">
                              <div class="img-box">
                                 <img src="images/tab-11.png">
                              </div>
                              <div class="name-box">
                                 P2: Sub Task
                              </div>
                           </div>
                     <p> Description. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sem
                              mauris consectetur. Lorem ipsum dolor sit amet, consectetur adipiscing
                              elit. Sem mauris consectetur
                           </p>
                           <div class="img-btn-sec">
                             <img src="images/Copy of Clock.svg">
                          <img src="images/Hourglass Start.svg">
                               <img src="images/Copy of Cloud_Upload.svg">
                          <img src="images/Notes.svg">
                          <img src="images/Copy of Calendar_Default.svg">
                          <img src="images/Copy of By User.svg">
                          <img src="images/Task_Completed.svg">
                           </div>   
                  </div>
                  <div class="tab-text-6">
                     <div id="tab-1'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" name="name" placeholder="Start Notes*"></textarea>
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                           
                        </div>
                     </div>
                     <div id="tab-2'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" name="name" placeholder="End Notes*"></textarea>
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                           
                        </div>
                     </div>
                     <div id="tab-3'.$celnodv.'" class="tabcontent">
                          <div class="text-box">
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select>
                                    <option>Main Group</option>
                                    <option>Main Group</option>
                                    <option>Main Group</option>
                                </select>
                            </div>
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select>
                                    <option>Sub Group</option>
                                    <option>Sub Group</option>
                                    <option>Sub Group</option>
                                </select>
                            </div>
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                         
                           
                        </div>
                     </div>
                     <div id="tab-4'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                            <div class="input-box">
                               <input type="text" name="text" placeholder="Tag">
                            </div>
                            
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="tab-5'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                           <textarea type="text" name="name" placeholder="Supporting Document Notes"></textarea>

                           <div class="upload-box">
                               <h3>Flie Upload</h3>
                               <div class="image-upload-wrap">
                                <input class="file-upload-input" type="file" onchange="readURL(this);" accept="image/*" />
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
                              <button>save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="tab-6'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                             <div class="input-box">
                               <input type="text" name="text" placeholder="Time Taken">
                               <img src="images/clock.png">
                            </div>
                           <textarea type="text" name="name" placeholder="Complete Notes"></textarea>
                          
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                          
                        </div>
                     </div>
                     <div id="tab-7'.$celnodv.'" class="tabcontent">
                         <div class="text-box">
                           <div style="height:40px"></div>
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                          
                           
                        </div>
                     </div>
                     <div id="tab-8'.$celnodv.'" class="tabcontent">
                        <div class="text-box">
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select>
                                    <option>Reassign Option</option>
                                    <option>Reassign Option</option>
                                    <option>Reassign Option</option>
                                </select>
                            </div>
                            <div class="select-box">
                                <img src="images/drop-down-arrow.svg" class="img-down">
                                <select>
                                    <option>Reassign</option>
                                    <option>Reassign</option>
                                    <option>Reassign</option>
                                </select>
                            </div>
                           <div class="btn-sec">
                              <button>save</button>
                           </div>
                          
                        </div>
                     </div>
                     <div id="tab-9'.$celnodv.'" class="tabcontent">
                         <div class="text-box">
                             <div class="input-box">
                               <input type="text" name="text" placeholder="Time Taken">
                               <img src="images/clock.png">
                            </div>
                           <textarea type="text" name="name" placeholder="Complete Notes"></textarea>
                          
                           <div class="btn-sec">
                              <button>save</button>
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