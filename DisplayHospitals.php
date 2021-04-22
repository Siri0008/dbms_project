<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginU.php");
    exit;
}

$id=$email_id=$name="";
$id = $_SESSION["id"];
$email_id = $_SESSION["emailid"];

require "Db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['submit'])){
    $hospid = $_POST['hospital'];
    if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error);
    } 
      $result = $mysqli->query("SELECT hos_id from reguser WHERE id='$id' AND emailid = '$email_id' ");
      $row = $result->fetch_assoc();
      if(is_null($row["hos_id"])){
        $_SESSION["hos_id"] = $hospid;
        $mysqli->query("UPDATE reguser SET hos_id='$hospid' WHERE id='$id' AND emailid='$email_id' AND hos_id IS NULL");
        echo "<script>alert('Registered succefully');document.location.href='userhome.php';</script>";
      }
      else{
        echo "<script>alert('Already registered cannot change now');document.location.href='welcome.php';</script>";
      }
    }
}

?>
<?php include('Inc/Header.php');?>
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
          <?php $sql = "SELECT * FROM reghosp";
          $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
             // output data of each row
                 while($row = $result->fetch_assoc()) { ?>
              
                        <div class="flip-card col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <div class="flip-card-inner">
                            <div class="flip-card-front">
                                    <h4><?php echo $row["name"] ?></h4> 
                                    <img src="hospital.jpg" alt="">
                                     <h5 style="font-size:16px;"><b>Mobile: <?php echo $row["mobile"] ?></b></h5>
                                     <b><p style="font-size:16px;">Email Id: <?php echo $row["emailid"] ?></p>
                                     
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
          
          <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <select name="hospital" type="number" placeholder="hospital" required>
              <?php $sql1 = "SELECT id,name FROM reghosp";
          $data = $mysqli->query($sql1);

        if ($data->num_rows > 0) {
             // output data of each row
                 while($row = $data->fetch_assoc()) {
                   echo "<option value = '".$row['id'] ."'>" .$row['name'] ."</option>";
                  }      
        }?>
            </select>
              <input type="submit" name="submit" value="submit"><br>
          </form>       

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