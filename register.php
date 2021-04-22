<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Include Database 
require_once "Db.php";
//initialize the session
session_start();
$name=$email_id=$password=$confirm_password=$occupation=$hno=$street=$city=$state=$pin=$age=$mobilenumber11=$mobilenumber2="";
$name_err=$mail_err=$password_err=$confirm_password_err=$occupation_err=$hno_err=$street_err=$city_err=$state_err=$pin_err=$age_err=$mobilenumber1_err=$mobilenumber2_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["emailid"]))){
        $mail_err = "Please enter a email id.";
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM reguser WHERE emailid = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_mail);
            
            // Set parameters
            $param_mail = trim($_POST["emailid"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $mail_err = "This Email is already taken.";
                } else{
                    $email_id = trim($_POST["emailid"]);
                   
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";     
    }
     else{
        $name = trim($_POST["name"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty(trim($_POST["age"]))){
        $age_err = "Please enter your age.";     
    }
     else{
        $age = trim($_POST["age"]);
    }
    if(empty(trim($_POST["occupation"]))){
        $occupation_err = "Please select your occupation.";
    }else{
        $occupation = trim($_POST["occupation"]);
        if($occupation != "Student" && $occupation != "Govt Sector" && $occupation != "Pvt Sector" && $occupation != "Health Sector" && $occupation != "Other"){
            $occupation_err = "Please select your occupation from the list";
        }
    }

    if(empty(trim($_POST["mobilenumber1"]))){
        $mobilenumber1_err = "Please enter your mobile number.";     
    }
     else{
        $mobilenumber1 = trim($_POST["mobilenumber1"]);
        if(strlen($mobilenumber1) != 10){
            $mobilenumber1_err = "Please enter corrrect mobile number";
        }
    }

   
    $mobilenumber2 = trim($_POST["mobilenumber2"]);
    if(strlen($mobilenumber2) != 10 && strlen($mobilenumber2) != 0){
        $mobilenumber2_err = "Please enter corrrect mobile number";
    }

    if(empty(trim($_POST["houseno"]))){
        $hno_err = "Please enter your House No.";     
    }
     else{
        $hno = trim($_POST["houseno"]);
    }
    if(empty(trim($_POST["street"]))){
        $street_err = "Please enter your street name.";     
    }
     else{
        $street = trim($_POST["street"]);
    }

    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter your city";     
    }
     else{
        $city = trim($_POST["city"]);
    }
    if(empty(trim($_POST["state"]))){
        $state_err = "Please enter your State";     
    }
     else{
        $state = trim($_POST["state"]);
    }
    if(empty(trim($_POST["pincode"]))){
        $pin_err = "Please enter your Pincode";     
    }
     else{
        $pin = trim($_POST["pincode"]);
        if($pin < 110001 || $pin > 855117){
            $pin_err = "Please enter correct pin code"; 
        }
    }
     // Check input errors before inserting in database
     if(empty($name_err) && empty($mail_err)&&empty($age_err)&& empty($password_err) && empty($confirm_password_err) && empty($occupation_err) && empty($hno_err) && empty($street_err) && empty($state_err) && empty($city_err) && empty($pin_err) && empty($mobilenumber1_err) && empty($mobilenumber2_err)){
        
        // Prepare an insert statement

        $sql="INSERT INTO reguser(name, emailid, age, occupation, mobilenumber1, mobilenumber2, houseno, street, city, state, pincode, password) VALUES('$name', '$email_id', '$age', '$occupation', '$mobilenumber1', '$mobilenumber2', '$hno', '$street', '$city', '$state', '$pin', '$password')";
        if(!mysqli_query($mysqli,$sql))
        {
            echo "<script>alert('Server Busy! Please try again');</script>";
            
        }

        else
        {
            SESSION_destroy();
           echo "<script>alert('Succesfully registered');document.location.href=('LoginU.php');</script>";

        }
        
            // // Set parameters
            $_SESSION["name"]=$name;
            $_SESSION["emailid"]=$email_id;
            $_SESSION["age"]=$age;
            $_SESSION["occupation"]=$occupation;
            $_SESSION["houseno"]=$hno;
            $_SESSION["street"]=$street;
            $_SESSION["city"]=$city;
            $_SESSION["state"]=$state;
            $_SESSION["pincode"]=$pin;
            $_SESSION["password"]=$password;
    }

    $mysqli->close();
}
?>


<?php include('Inc/Header.php');?>
<div class="content">
    <div class="container">
    <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12"></div>
           <div class="col-lg-4 col-md-4 col-cm-12">
           <h3 style="text-align:center;">User Registration</h3>
        <div class="signup">
            <label for="name">Name</label><?php echo (!empty($name_err)) ? $name_err : ''; ?><br>
            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required><br>
        
            <label for="emailid">Email-Id</label><?php echo (!empty($mail_err)) ? $mail_err : ''; ?><br>
            <input type="email" class = "form-control" id="emailid" name="emailid" placeholder="Your Email-Id" required><br>
       
            <label for="age">Age</label><?php echo (!empty($age_err)) ? $age_err : ''; ?><br>
            <input type="int" class = "form-control" id="age" name="age" placeholder="Your Age" required><br>

            <label for="mobilenumber1">Mobile Number</label><?php echo (!empty($mobilenumber1_err)) ? $mobilenumber1_err : ''; ?><br>
            <input type="tel" class = "form-control" id="mobilenumber1" name="mobilenumber1" placeholder="Your Mobile number" required><br>

            <label for="mobilenumber2">Alternate Mobile Number</label><br>
            <input type="tel" class = "form-control" id="mobilenumber2" name="mobilenumber2" placeholder="Your Mobile number"><br>

            

            <label for="occupation">Occupation</label><?php echo (!empty($occupation_err)) ? $occupation_err : ''; ?><br>
            <select class = "form-control" id="occupation" name="occupation" placeholder="Your Occuption" required >
                <option value="Student">Student</option>
                <option value="Govt Sector">Govt Sector</option>
                <option value="Pvt Sector">Pvt Sector</option>
                <option value="Health Sector">Health Sector</option>
                <option value="Other">Other</option>
            </select><br>
            <label for="houseno">House Number</label><?php echo (!empty($hno_err)) ? $hno_err : ''; ?><br>
            <input type="int" class = "form-control" id="houseno" name="houseno" placeholder="Your House Number" required><br>

            <label for="street">Street/Area</label><?php echo (!empty($street_err)) ? $street_err : ''; ?><br>
            <input type="text" class = "form-control" id="street" name="street" placeholder="Your Area" required><br>

            <label for="city">City</label><?php echo (!empty($city_err)) ? $city_err : ''; ?><br>
            <input type="text" class = "form-control" id="city" name="city" placeholder="Your City" required><br>

            <label for="state">State</label><?php echo (!empty($state_err)) ? $state_err : ''; ?><br>
            <input type="text" class =  "form-control" id="state" name="state" placeholder="Your State" required><br>

            <label for="pincode">Pincode</label><?php echo (!empty($pin_err)) ? $pin_err : ''; ?><br>
            <input type="int" class = "form-control" id="pincode" name="pincode" placeholder="Your Pincode" required><br>
        
            <label for="password">Password</label><?php echo (!empty($password_err)) ? $password_err : ''; ?><br>
            <input type="password" class = "form-control" id="password" name="password" placeholder="Create password" required><br>

            <label for="confirm_password">Confirm Password</label><?php echo (!empty($confirm_password_err)) ? $confirm_password_err : ''; ?><br>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Your Password" required><br>
        </div>
        <div class="row">
                    <div class="col-md-4 col-lg-4"></div>
                    <div class="submit col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <input class = "form-control" type="submit" value="Submit"><br>
                    </div>
        </div>
        </div>
    </form>
    </div>
</div>
<?php include('Inc/FooterA.php');?>