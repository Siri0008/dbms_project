<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: Hospital.php");
    exit;
}
 
// Include config file
require_once "Db.php";
 
// Define variables and initialize with empty values
$id = $password = "";
$id_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter Id.";
    } else{
        $id = trim($_POST["id"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($id_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id,emailid,name,mobile,password,street,city,state,pincode FROM reghosp WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $emailid,$name,$mobile,$hashed_password,$street,$city,$state,$pincode);
                    if($stmt->fetch()){
                        if($password === $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;                            
                            $_SESSION["emailid"]=$emailid;
                            $_SESSION["name"]=$name;
                            $_SESSION["street"]=$street;
                            $_SESSION["city"]=$city;
                            $_SESSION["state"]=$state;
                            $_SESSION["pincode"]=$pincode;
							$_SESSION["password"]=$hashed_password;
                            // Redirect user to welcome page
                            header("location: Hospital.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Wrong password";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $id_err = "No account found with that hospital Id.";
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
<?php include('Inc/HeaderA.php');?>
<style>
        .topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
    <div class="container">
        <h1 style="text-align:center;">LOGIN As Hospital</h1>
        <p style="text-align:center; font-size:16px;">Contact admin to get your hospital registered</p>
 
       <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <div class="row">
            <div class="col-md-4 col-lg-4 "></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
           <div class="login" >
            <label for="id">Id:</label><?php echo (!empty($id_err)) ? $id_err : ''; ?><br>
            <input type="text" class = "form-control" id="id" name="id" placeholder="Your Id here" required><br><br>
           </div>
           <div class="login">
            <label for="password">Password:</label><?php echo (!empty($password_err)) ? $password_err : ''; ?><br>
            <input type="password" class = "form-control" id="password" name="password" placeholder="Your Password" required><br><br>
            
           </div>
        
           <div class="submit">
           <input type="submit" class="form-control" value="Login"><br>   
           </div>
           </div>
        </div>
       </form>
    </div>
    </div>
    <?php include('Inc/Footer.php');?>