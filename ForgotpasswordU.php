<?php
    if(isset($_POST["forgotpassword"])){
        session_start();
require_once "Db.php";      
$emailid=$_POST["emailid"];
if(empty($emailid)){
    $error_message= "Please fill to continue!!!";
}
else{
$condition = "";
if(!empty($_POST["emailid"])) {
    if(!empty($condition)) {
        $condition = $condition . " and ";
    }
    $condition = $condition ." emailid = '" . $_POST["emailid"] . "'";
}
if(!empty($condition)) {
    $condition = " where " . $condition;
}
$sql = "Select * from reguser " . $condition;
$result = mysqli_query($mysqli,$sql);
$user = mysqli_fetch_array($result);

if(!empty($user)) {
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
     // Check input errors before inserting in database
     if(empty($password_err) &&empty($confirm_password_err)){
        // Prepare an insert statement

        $sql="UPDATE `reguser` SET  password='$password' 
                WHERE emailid ='$emailid'";
        if(!mysqli_query($mysqli,$sql))
        {
            echo "<script>alert('Server Busy! Please try again');</script>";
            
        }

        else
         {
                       echo "<script>alert('password succefully changed');document.location.href='welcome.php';</script>";
        }
    }
    $mysqli->close();
} else {
    $error_message = 'No User Found';
}
}
session_destroy();
 }
 
?>
<?php include('Inc/Header.php');?>
    <div class="container">
        <form name="frmForgot" id="frmForgot" method="post" onSubmit="return validate_forgot();">
        <h1 style="text-align:center">Forgot Password?</h1>
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12"></div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <?php if(!empty($success_message)) { ?>
                <div class="success_message"><?php echo $success_message; ?></div>
                <?php } ?>
 
                <div id="validation-message">
                    <?php if(!empty($error_message)) { ?>
                <?php echo $error_message; ?>
                <?php } ?>
                </div>
                
                <div class="sell">
                    <div><label for="email">Email</label></div>
                    <div><input type="emailid" name="emailid" id="emailid"></div>

                    <label for="password">Password</label><?php echo (!empty($password_err)) ? $password_err : ''; ?><br>
            <input type="password" id="password" name="password"   required ><br>

            <label for="confirm_password">Confirm Password</label><?php echo (!empty($confirm_password_err)) ? $confirm_password_err : ''; ?><br>
            <input type="password" id="confirm_password" name="confirm_password"   required><br>
       
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12"></div>
                <div class="submit col-lg-4 col-md-4 col-sm-12">
                    <div><input type="submit" id="forgotpassword" name="forgotpassword" value="Submit"></div>
                </div>
            </div>  
        </form>
    </div>
 

<?php include('Inc/Footer.php');?>
