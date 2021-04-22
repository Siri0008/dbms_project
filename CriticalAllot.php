<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginH.php");
    exit;
}
require "Db.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string
// echo $id;
$hospid = $_SESSION['id'];
// echo $hospid;

$docid_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['submit'])) // when click on Update button
{

    if(empty(trim($_POST["docid"]))){
        $docid_err = "Please enter doctor id";
    }else{
        $sql = "SELECT id FROM doctor WHERE hos_id = '$hospid' AND id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_doc);
            
            // Set parameters
            $param_doc = trim($_POST["docid"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 0){
                    $docid_err = "Enter correct doctor id";
                } else{
                    $docid = trim($_POST["docid"]);
                    // echo $docid;
                   
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }


	if(empty($docid_err)){
        // echo $docid;
        // echo $vacid,$vacno;
    $sql = "INSERT INTO comp_doc(userid,docid) VALUES('$id','$docid')";
	
        if(!mysqli_query($mysqli,$sql))
        {
            //echo "server busy";
            echo "<script>alert('Server Busy! Please try again');</script>";
            
        }
        else
        {
            //echo "done";
           //SESSION_destroy();
           echo "<script>alert('Saved');document.location.href='CriticalPatients.php';</script>";

        }	
        $mysqli->close();
    }
}
}
?>

<?php include('Inc/HeaderA.php');?>

<div class="container">
<h3 style="text-align:center;">Update Data</h3>

<form method="POST">
<div class="row" style="text-align:right;">
            <div class="col-md-4 col-lg-4 "></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
<div class="login" >
  <label for="docid">Doctor-Id</label><?php echo (!empty($docid_err)) ? $docid_err : ''; ?><br>
  <input type="int" class="form-control" id="docid" name="docid" placeholder="Doctor id" required><br></div>
  <div class="submit">
  <input type="submit" name="submit" value="Submit">
  </div>
  </div>
  </div>
  </form>
  </div>
<?php include('Inc/Footer.php');?>