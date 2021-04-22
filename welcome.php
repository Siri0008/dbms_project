<?php
session_start();
require_once "Db.php";
$sql = "SELECT * FROM weights";
$result = mysqli_query($mysqli, $sql);
if ($result->num_rows > 0) {
  // output data of each row
  //echo "WEIGHTS";
  while($row = $result->fetch_assoc()) {
  //   echo "vacno: " . $row["vacno"]. " - vacid: " . $row["vacid"]. " vacdate" . $row["vacdate"]. "<br>";
  //   echo "Today is " . date("Y-m-d") . "<br>";
    $today = date("Y-m-d");
   // echo "Vac Date is " . substr($row["vacdate"], 0, 10) . "<br>";
    $update =  $row["lastupdated"];
    $diff = date_diff(date_create($today), date_create($update));
    //echo $diff->format("%a");
    $dif = $diff->format("%a");
    $class1 = $row["class1"];
    $class2 = $row["class2"];
    $class3 = $row["class3"];
    if($dif >= 1){
      //  echo "here";
        $sql = "SELECT sum(num_slots) as slots, sum(empty_1) as empty_1, sum(empty_2) as empty_2, sum(empty_3) as empty_3 
                FROM hosp_slots 
                WHERE STRCMP('$update', date) = 1
               ORDER BY date DESC LIMIT 3";
        $res = mysqli_query($mysqli, $sql);
        if($res->num_rows > 0){
         // echo "going hree";
          while($row = $res->fetch_assoc()){
          //  echo "Not goig";
            $slots = $row["slots"] ;
            $empty_1 = $row["empty_1"];
            $empty_2 = $row["empty_2"];
            $empty_3 = $row["empty_3"];
            if(($empty_1*$class2)/$class1 > $empty_2 ){
              $mysqli->query("UPDATE weights SET class1 = '$class1' -1  WHERE class1 ='$class1'");
              $class1 = $class1 -1 ;
              $mysqli->query("UPDATE weights SET class2 = '$class2' +1  WHERE class2 ='$class2'");
              $class2 = $class2 -1;
            }
            if(($empty_1*$class2)/$class1 < $empty_2 ){
              $mysqli->query("UPDATE weights SET class1 = '$class1' +1  WHERE class1 ='$class1'");
              $class1 = $class1 + 1;
              $mysqli->query("UPDATE weights SET class2 = '$class2' -1  WHERE class2 ='$class2'");
              $class2 = $class2 -1;
            }
            if(($empty_2*$class3)/$class2 > $empty_3 ){
              $mysqli->query("UPDATE weights SET class2 = '$class2' -1  WHERE class2 ='$class2'");
              $class2 = $class2 - 1;
              $mysqli->query("UPDATE weights SET class3 = '$class3' +1  WHERE class2 ='$class3'");
              $class3 = $class3 + 1;
            }
            if(($empty_2*$class3)/$class2 > $empty_3 ){
              $mysqli->query("UPDATE weights SET class2 = '$class2' +1  WHERE class2 ='$class2'");
              $class2 = $class2 + 1;
              $mysqli->query("UPDATE weights SET class3 = '$class3' -1  WHERE class2 ='$class3'");
              $class3 = $class3 - 1;
            }
            $mysqli->query("UPDATE weights SET lastupdated = '$today'  WHERE lastupdated ='$update'");

          }
        }
          else {
            echo $res->num_rows;
          }

          $_SESSION["class1"] = $class1;
          $_SESSION["class2"] = $class2;
          $_SESSION["class3"] = $class3;
    }

  }
}

?>
<?php include('Inc/Header.php');?>
	<div class="page-header">
		<h1 style="text-align:center">Hi,<br>Welcome !!!</h1>
	</div>
	<p>
		<h2 style="text-align:center">GET VACCINATED SAFELY AND SECURELY!!!</h2>
		<div class="welcome" style="margin-left:0%;margin-right:25%">
        <div class="row" style="height:500px;width:133%">
  <div class="column">
    <img src="4.jpg" alt="Snow" style="height=400px;width:110%">
  </div>
  <div class="column">
    <img src="2.jpg" alt="Forest" style="height=400px;width:110%">
  </div>
  <div class="column">
    <img src="3.jpg" alt="Mountains" style="height=400px;width:110%">
  </div>
</div>
        <marquee behavior="scroll" bgcolor="yellow" direction="left" style="height:50px;width:134%;">
        <i> <font color="blue">    
        PLEASE SIGNUP AND LOGIN TO USE THE FACILITIES! GET VACCINATED STAY SAFE! WE ASSURE YOUR SAFETY! </font></i></marquee>
        
		</div>
	</p>
	</div>
<?php include('Inc/FooterA.php');?>

