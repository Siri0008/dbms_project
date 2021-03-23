<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "Db.php";
 
// Define variables and initialize with empty values
$emailid = $password = "";
$emailid_err = $password_err = "";
$dif = 0;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["emailid"]))){
        $emailid_err = "Please enter Registered Emailid.";
    } else{
        $emailid = trim($_POST["emailid"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($emailid_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id,emailid,password,name,age,occupation,mobilenumber1,mobilenumber2,houseno,street,city,state,pincode,hos_id,doc_id,regdate FROM reguser WHERE emailid = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_emailid);
            
            // Set parameters
            $param_emailid = $emailid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $emailid,$hashed_password,$name,$age,$occupation,$mobilenumber1,$mobilenumber2,$houseno,$street,$city,$state,$pincode,$hos_id,$doc_id, $regdate);
                    if($stmt->fetch()){
                        if($password=== $hashed_password){
                            // Password is correct, so start a new session
                           // session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;                            
                            $_SESSION["emailid"]=$emailid;
                            $_SESSION["name"]=$name;
                            $_SESSION["age"]=$age;
                            $_SESSION["occupation"]=$occupation;
                            $_SESSION["mobilenumber1"]=$mobilenumber1;
                            $_SESSION["mobilenumber2"]=$mobilenumber2;
                            $_SESSION["houseno"]=$houseno;
                            $_SESSION["street"]=$street;
                            $_SESSION["city"]=$city;
                            $_SESSION["state"]=$state;
                            $_SESSION["pincode"]=$pincode;
                            $_SESSION["hos_id"]=$hos_id;
                            $_SESSION["doc_id"]=$doc_id;
							$_SESSION["password"]=$hashed_password;
                            $_SESSION["regdate"] = $regdate;

                            $sql = "SELECT vacno, vacid, vacdate FROM vacuser WHERE id = $id AND vacno = (select max(vacno) from vacuser)";
                            $result = mysqli_query($mysqli, $sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                //   echo "vacno: " . $row["vacno"]. " - vacid: " . $row["vacid"]. " vacdate" . $row["vacdate"]. "<br>";
                                //   echo "Today is " . date("Y-m-d") . "<br>";
                                  $today = date("Y-m-d");
                                 // echo "Vac Date is " . substr($row["vacdate"], 0, 10) . "<br>";
                                  $vacdate =  substr($row["vacdate"], 0, 10);
                                  $diff = date_diff(date_create($today), date_create($vacdate));
                                 // echo $diff->format("%a");
                                  $dif = $diff->format("%a");
                                }
                              }

                            // Redirect user to welcome page
                            $sql = "SELECT id, fbno FROM feedback WHERE id = '$id'";
                            $stm = mysqli_query($mysqli,$sql);
                            //echo $stm->num_rows;
                            if($dif >= 5 && $stm->num_rows == 0){
                                //echo "ENTERED HERE";
                                header("location: feedback.php");
                              }
                              else if($dif >= 10 && $stm->num_rows <= 1){
                                header("location: feedback.php");
                              }
                            else header("location: userhome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Wrong password";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $emailid_err = "No account found with that mail Id.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
 
            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
<?php include('Inc/Header.php');?>
<style>
        .topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
    <div class="container">
        <h1 style="text-align:center;">LOGIN As User</h1>
        <p style="text-align:center; font-size:16px;">Do not have account.Register <b><a href="register.php">here.</a></b></p>
 
       <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <div class="row" style="text-align:right;">
            <div class="col-md-4 col-lg-4 "></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
           <div class="login" >
            <label for="emailid">Email Id:</label><?php echo (!empty($emailid_err)) ? $emailid_err : ''; ?><br>
            <input type="text" id="emailid" name="emailid" placeholder="Your Registered Mail id here" required><br><br>
           </div>
           <div class="login">
            <label for="password">PASSWORD:</label><?php echo (!empty($password_err)) ? $password_err : ''; ?><br>
            <input type="password" id="password" name="password" placeholder="Your Password" required><br><br>
            
           </div>
        
           <div class="submit">
           <input type="submit" value="Login"><br>      
           </div>
		   <a class="foot1" href="ForgotpasswordU.php"><p>Forgot Password?</p></a>
           </div>
        </div>
       </form>
    </div>
    </div>
    <?php include('Inc/Footer.php');?>