<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginH.php");
    exit;
}
require "Db.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string
//echo $id;
$hospid = $_SESSION['id'];

$vac_err = $docid_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['submit'])) // when click on Update button
{
   // echo "ddd";
    if(empty(trim($_POST["vacid"]))){ //for empty
        $vac_err = "Please enter a vaccine id.";
    }   
    else{
        // Prepare a select statement
        $sql = "SELECT vacid FROM vacuser WHERE vacid = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_vac);
            
            // Set parameters
            $param_vac = trim($_POST["vacid"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $vac_err = "This vaccine id is already taken.";
                } else{
                    $sql = "SELECT id FROM vaccine WHERE hospid = '$hospid' AND id = ?";
        
                    if($stmt = $mysqli->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $param_vacc);
                        
                        // Set parameters
                        $param_vacc = trim($_POST["vacid"]);
                       // echo $param_vac;
                        
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            // store result
                            $stmt->store_result();
                            
                            if($stmt->num_rows == 0){
                                $vac_err = "This vaacine does not exists";
                            } else{
                                $vacid = trim($_POST["vacid"]);
                               
                            }
                           // echo $vacid;
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                   
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    // if(empty(trim($_POST["vacno"]))){
    //     $vacno_err = "Please select your vaccine number.";
    // }else{
        $sql = "SELECT id FROM vacuser WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_vac);
            
            // Set parameters
            $param_vac = $id;
            //echo $param_vac;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 0){
                    $vacno = 1;
                } else{
                    $vacno = 2;
                   
                }
                //echo $vacid;
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

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


	if(empty($vac_err) && empty($docid_err)){
        // echo $docid;
         //echo $vacid,$vacno;
    $sql = "INSERT INTO vacuser(id,vacno,vacid) VALUES('$id','$vacno','$vacid')";
	
        if(!mysqli_query($mysqli,$sql))
        {
            //echo "server busy";
           echo "<script>alert('Server Busy! Please try again');</script>";
            
        }
        else
        {
            //echo "done";
           //SESSION_destroy();
            $sql1 = $mysqli->query("UPDATE reguser SET doc_id = '$docid' WHERE id = '$id'");
           echo "<script>alert('Saved');document.location.href='Patients.php';</script>";

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
 <label for="vacid">Vaccine-Id</label><?php echo (!empty($vac_err)) ? $vac_err : ''; ?><br>
  <input type="int" class="form-control" id="vacid" name="vacid" placeholder="Vaccine id" required><br>
  </div>
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