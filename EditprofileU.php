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
        $email_id = $_SESSION["emailid"];
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
                
                if($stmt->num_rows == 2){
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
        $name = $_SESSION["name"];     
    }
     else{
        $name = trim($_POST["name"]);
    }
    if(empty(trim($_POST["age"]))){
        $age = $_SESSION["age"];     
    }
     else{
        $age = trim($_POST["age"]);
    }
    if(empty(trim($_POST["mobilenumber1"]))){
        $mobilenumber1 = $_SESSION["mobilenumber1"];     
    }
     else{
        $mobilenumber1 = trim($_POST["mobilenumber1"]);
    }
    if(empty(trim($_POST["houseno"]))){
        $hno = $_SESSION["houseno"];     
    }
     else{
        $hno = trim($_POST["houseno"]);
    }
    if(empty(trim($_POST["street"]))){
        $street = $_SESSION["street"];     
    }
     else{
        $street = trim($_POST["street"]);
    }

    if(empty(trim($_POST["city"]))){
        $city = $_SESSION["city"];     
    }
     else{
        $city = trim($_POST["city"]);
    }
    if(empty(trim($_POST["state"]))){
        $state = $_SESSION["state"];     
    }
     else{
        $state = trim($_POST["state"]);
    }
    if(empty(trim($_POST["pincode"]))){
        $pin = $_SESSION["pincode"];     
    }
     else{
        $pin = trim($_POST["pincode"]);
        if($pin < 110001 || $pin > 855117){
            $pin_err = "Please enter correct pin code"; 
        }
    }
    $id=$_SESSION["id"];
     // Check input errors before inserting in database
     if(empty($mail_err) &&empty($pin_err)){
        
        // Prepare an insert statement

        $sql="UPDATE `reguser` SET name='$name', emailid='$email_id', age='$age', mobilenumber1='$mobilenumber1', houseno='$hno', street='$street', city='$city', state='$state', pincode='$pin'
                WHERE id ='$id'";
        if(!mysqli_query($mysqli,$sql))
        {
            echo "<script>alert('Server Busy! Please try again');</script>";
            
        }

        else
         {
                        $_SESSION["name"]=$name;
                        $_SESSION["emailid"] =$email_id;
                        $_SESSION["age"]=$age;
                        $_SESSION["houseno"]=$hno;
                        $_SESSION["street"]=$street;
                        $_SESSION["city"]=$city;
                        $_SESSION["state"]=$state;
                        $_SESSION["pincode"]=$pin;
                       echo "<script>alert('Succesfully Edited');document.location.href='profile.php';</script>";
        }
    }

    $mysqli->close();
}
?>
<?php include('Inc/Header.php');?>
<div class="content">
    <div class="container">
    <h1 style="text-align:center;">Edit Profile</h1>
    <h4 style="text-align:center;"> Fill only the cells to be updated</h4>
    <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row">
             <div class="col-md-5 col-lg-5 "></div>
            <div class="col-md-6 col-lg-6 col-sm-16 col-xs-16">
        <div class="signup">
            <label for="name">Name</label><br>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['name']?>" class="input-field"><br>
        
            <label for="emailid">Email-Id</label><?php echo (!empty($mail_err)) ? $mail_err : ''; ?><br>
            <input type="email" class="form-control" id="emailid" name="emailid"  value="<?php echo $_SESSION['emailid']?>" class="input-field" ><br>
       
            <label for="age">Age</label><br>
            <input type="int" class="form-control" id="age" name="age"  value="<?php echo $_SESSION['age']?>" class="input-field" ><br>

            <label for="mobilenumber1">Mobile Number</label><br>
            <input type="tel" class="form-control" id="mobilenumber1" name="mobilenumber1" value="<?php echo $_SESSION['mobilenumber1']?>" class="input-field" ><br>

            <label for="houseno">House Number</label><br>
            <input type="int" class="form-control" id="houseno" name="houseno" value="<?php echo $_SESSION['houseno']?>" class="input-field" ><br>

            <label for="street">Street/Area</label><br>
            <input type="text" class="form-control" id="street" name="street" value="<?php echo $_SESSION['street']?>"  class="input-field" ><br>

            <label for="city">City</label><br>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo $_SESSION['city']?>" class="input-field" ><br>

            <label for="state">State</label><br>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo $_SESSION['state']?>" class="input-field" ><br>

            <label for="pincode">Pincode</label><?php echo (!empty($pin_err)) ? $pin_err : ''; ?><br>
            <input type="int" class="form-control" id="pincode" name="pincode" value="<?php echo $_SESSION['pincode']?>" class="input-field" ><br>
        
        </div>
        <br>
        <div class="submit">
                        <input type="submit" name="submit" value="Update Profile"><br>
                    </div>
        </div>
        </div>
    </form>
    </div>
</div><br><br>
<?php include('Inc/FooterA.php');?>