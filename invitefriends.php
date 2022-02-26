<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
error_reporting (E_ALL ^ E_NOTICE);
?>
<html>
<head>
   
<link rel="stylesheet" type="text/css" href="cssjs/newstyle.css"></link>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style type="text/css">
.selectt {
    color: #000;
    display: none;
    width: 83%;

    }
	 .btn {
    background-color: #4caaaf;
    font-size: 17px;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    width: 140px;
    height: 38px;
    margin-top: 23px;
   }
.form-control1{
    width: 70%;
    border-radius: 5px;
    height: 5vh;
    margin-top: 10px;
    margin-bottom: 21px;
}
  #popUpDiv{
    top: 10px !important;
    left: 50px !important;
    height:470px !important;
}
	</style>
<?php
if($_POST['cat'] == "invitepopup"){    
    
}

?>

</head>

<body style="background-color: #FFFFFF;">

<center>
		Invite 
		<h3> Select Colleague or Friend </h3>
		<div>
			<label>
				<input type="radio" name="colorRadio"
					value="C"> Colleague</label>
			<label>
				<input type="radio" name="colorRadio"
					value="Cplus"> Friend</label>
		</div>
		<div class="C selectt">
		
        <form action="" name="UserForm" method="post" onkeypress="return event.keyCode != 13;">

            <div class="row" >

                    <!-- New Registration --------------------------- START -->
                    <?php  {?> 
                    
                            </br>
                              <!--  <label class="lbl w120">  Email address </label>-->
                                  <input type="text" class="form-control1"   id="NewUserEmail" name="NewUserEmail" placeholder="Email address"/>
                           <br>
            		        	<input type="checkbox" id="click" name="click" onclick="UseLicense()" required>&nbsp;Use My License
                          <br>
                               
                            <button type="button" class="btn" name="btnInvite" value="Invite" onclick="inviteCheckEmail()">Send Invite</button>
                                                        
                   
                        <br></br>

                    <?php } ?>
       
                  <!-- col-2 --->               
            </div>  <!-- row --->
             
</form>
  	
		</div>
		<div class="Cplus selectt">
	
    
        <form action="" name="UserForm" method="post" onkeypress="return event.keyCode != 13;">

            <div class="row" >

                    <!-- New Registration --------------------------- START -->
                    <?php  {?> 
                    
                            </br>
                              <!--  <label class="lbl w120">  Email address </label>-->
                                  <input type="text" class="form-control1"   id="NewUserEmail" name="NewUserEmail" placeholder="Email address"/>
                         
                          <br>
                               
                            <button type="button" class="btn" name="btnInvite" value="Invite" onclick="inviteCheckEmail()">Send Invite</button>
                            
                                               
                        <br></br>

                    <?php } ?>
       
                  <!-- col-2 --->               
            </div>  <!-- row --->
      
         
</form>
    
    
    </div>

<!-- rado button js code start -->
		<script type="text/javascript">
			$(document).ready(function() {
				$('input[type="radio"]').click(function() {
					var inputValue = $(this).attr("value");
					var targetBox = $("." + inputValue);
					$(".selectt").not(targetBox).hide();
					$(targetBox).show();
				});
			});
		</script>
        
<!-- rado button js code end -->
	</center>




    
</body>

</html>