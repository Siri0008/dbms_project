<!DOCTYPE html>
<html>
	<head>
	<title>COVID VACCINE!!!</title>
		<link rel="stylesheet" type="text/css" href="Mystyle.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
		function myfunction(){
			var x=document.getElementByld("myTopnav");
			if(x.className==="topnav"){
				x.className+="responsive";
			}
			else{
				x.className="topnav";
			}
		}
		</script>
	</head>
	<body>
		<div class="content">
			<div class="topnav" id="myTopnav">
			
			<?php 
				if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { // check if session named 'id' is exist
         ?>
		 	<a href="welcome.php">Home</a>
			<a href="LoginH.php">Hospital Login</a>
			<a href="LoginU.php">User Login</a>
			<a href="register.php">User Registration</a>
              <?php } 
          else { ?>
		  <a href="Hospital.php">Home</a>
         <a href="LogoutHospital.php">Log Out</a>
		 <a href="CriticalPatients.php">CriticalPatients</a>
         <a href="Patients.php">Patients</a>
         <a href="DisplayDoctors.php">Doctors</a>
		 <a href="SlotsFilling.php">Slots</a>
		 
         <?php }?>
          
        <a href="javascript:void(0);" class="icon" onclick="myfunction()">
            <i class="fa fa-bars"></i>
        </a>
        </div>