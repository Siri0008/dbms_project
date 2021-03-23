<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginU.php");
    exit;
}?>
<?php include('Inc/Header.php');?>
<div class="container">
<div class="row">
        <div class="col-md-6 col-lg-6 col-sm-16 col-xs-16">
            
                
                <div>
                <img src="person.png" alt="" style="width:150px;height:150px;border-radius:50%">
                <h4 style="color:black"><i></i><?php echo htmlspecialchars($_SESSION["name"]) ?>, Age:<?php echo htmlspecialchars($_SESSION["age"]) ?></h4>
                <a href="tel:<?php $_SESSION["mobilenumber1"]?>"><h4 style="color:black"><i class="fa fa-phone"></i>+91 <b><?php echo htmlspecialchars($_SESSION["mobilenumber1"]); ?></b></h4></a>
                <a href="mailto:<?php $_SESSION["emailid"]?>"><h4 style="color:black"><i style="font-size:18px;"  class="material-icons">email</i><?php echo htmlspecialchars($_SESSION["emailid"])?></h4></a>
                <h4 style="color:black"><i class="fa fa-briefcase"></i><?php echo htmlspecialchars($_SESSION["occupation"])?></h4>
                <h4 style="color:black"><i class="fa fa-address-book"></i>H-no:<?php echo htmlspecialchars($_SESSION["houseno"]); ?>,<?php echo htmlspecialchars($_SESSION["street"]) ?>,<?php echo htmlspecialchars($_SESSION["city"])?>(<?php echo htmlspecialchars($_SESSION["pincode"])?>),<?php echo htmlspecialchars($_SESSION["state"])?></h4>
                <a href="EditprofileU.php"><h4 style="color:black"><i class="fa fa-edit"></i> Edit Profile</h4></a>
                </div>
            
        </div>
        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
        <h1 style="margin-top:100px;text-align:right;color:black">Your Profile</h1>
        </div>
</div>
        <?php
        require_once "Db.php";
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$name=$_SESSION["name"];
$myemail=$_SESSION["emailid"];
$mysqli->close();
?>
</div>
</div>
</div>
</div>
<style>
        @media screen and (min-width: 1100px) {.f{
            
                                     bottom:0;
                                     right:0;
                                     left:0;
                                 }
                                 .content{
                                     height:500px !important;
                                 }}
                                 </style> 
<?php include('Inc/Footer.php');?>