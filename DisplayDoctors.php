<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginH.php");
    exit;
}

require "Db.php";

// echo $_SESSION["id"];

?>
<?php include('Inc/HeaderA.php');?>
        <div class="container" style="text-align:center;">
        <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="font-size:20px;">
        </div>
        </div>
<div class="row1">
<?php
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 
?>
          <?php 
          $hos_id = $_SESSION["id"];
          $sql = "SELECT * FROM doctor where hos_id = '$hos_id' ";
          $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
             // output data of each row
                 while($row = $result->fetch_assoc()) { ?>
              
                        <div class="flip-card col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <div class="flip-card-inner">
                            <div class="flip-card-front">
                                    
                                    <img src="doctor.jpg" alt="">
                                    <h4><?php echo $row["name"] ?></h4>
                                     <h5 style="font-size:16px;"><b>Qualifications: <?php echo $row["qualifications"] ?></b></h5>
                                     <b><p style="font-size:16px;">Id: <?php echo $row["id"] ?></p>
                                     
                             </div>
							         <div class="flip-card-back">
                                     <!-- <h2 style="text-decoration:underline;">street</h2> -->
                                      <h4><?php echo $row["street"] ?></h4>
                                      <!-- <h2 style="text-decoration:underline;">State</h2> -->
                                      <h4><?php echo $row["state"] ?></h4> 
                                      <p ><?php echo $row["pincode"] ?></p></b>   
                             </div>
                            </div>
                     </div>
              <?php   } ?>      

      <?php } 
      else { ?>
        <h1>not available!!</h1>
        <style>
        @media screen and (min-width: 700px) {.f{
                                    position:fixed;
                                     bottom:0;
                                     right:0;
                                     left:0;
                                 }
                                 .content{
                                     height:1000px !important;
                                 }}
                                 </style> 
     <?php } ?>
<?php
$mysqli->close();
?>
</div>
</div>
<?php include('Inc/Footer.php');?>