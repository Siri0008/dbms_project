<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginH.php");
    exit;
}
require "Db.php"; // Using database connection file here

// $id = $_GET['id']; // get id through query string

$slots_err  ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['submit'])) // when click on Update button
{
    
    if(empty(trim($_POST["slots"]))){
        $slots_err = "Please select # of slots";
    }else{
        $slots = trim($_POST["slots"]);
        $sql=$mysqli->query("select class1,class2,class3 from weights");
        while($row = $sql->fetch_assoc()){
        $class1=(int)($row["class1"]*$slots/100);
        $class2=(int)($row["class2"]*$slots/100);
        $class3=(int)($row["class3"]*$slots/100);

      }
    }

    $today = date("Y-m-d");
    $next_date = date('Y-m-d',strtotime($today . '+7 day'));

    $hospid = $_SESSION["id"];

	if(empty($slots_err)){
        // echo $docid;
        // echo $vacid,$vacno;
    $sql = "INSERT INTO hosp_slots(hos_id,num_slots,empty_1,empty_2,empty_3,date) VALUES('$hospid','$slots','$class1','$class2','$class3','$next_date')";
	
        if(!mysqli_query($mysqli,$sql))
        {
            // echo "server busy";
            echo "<script>alert('Already filled! Cannot fill again');</script>";
            
        }
        else
        {
            //echo "done";
           //SESSION_destroy();
           echo "<script>alert('Saved');document.location.href='hospital.php';</script>";

        }	
        $mysqli->close();
    }
}
}
?>

<?php include('Inc/HeaderA.php');?>
<div class="container">
<h3  style="text-align:center;">Update Data</h3>
<h4 style="text-align:center;">Fill number of slots for <?php 
$t = date("Y-m-d");
$n = date('Y-m-d',strtotime($t . '+7 day'));
echo $n
?></h4>
       <form method="POST">
           <div class="row" >
            <div class="col-md-4 col-lg-4 "></div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
 <label for="slots" > Number of Slots</label><?php echo (!empty($slots_err)) ? $slots_err : ''; ?><br>
  <input type="int" class="form-control" id="slots" name="slots" placeholder="Number of slots" required><br>
  <div class="row">
                    <div class="col-md-4 col-lg-4"></div>
                    <div class="submit col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <input  type="submit" name = "submit" value="Submit">
                    </div>
        </div>
  </div>
  </div>
</form>
</div>
<?php include('Inc/Footer.php');?>