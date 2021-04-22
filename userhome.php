<?php
session_start();
 // Include config file
 require_once "Db.php";
if($_SESSION["slotdate"] == NULL){
  $class = "";
  $empty = "";
  $user_id = $_SESSION["id"];
  $hos_id = $_SESSION["hos_id"];
  $regdate = $_SESSION["regdate"];
  if(strcmp($_SESSION["occupation"], "Health Sector") == 0 || $_SESSION["age"] >= 60){
    //echo "USERHOE";
    $class = "class1";
    $regdate = substr($regdate, 0, 10);
   // echo $hos_id;
    //echo $regdate;
    $sql = "SELECT hos_id, num_slots, empty_1, empty_2, empty_3, date 
            FROM hosp_slots 
            WHERE hos_id = '$hos_id' AND empty_1 > 0 AND STRCMP('$regdate', date) < 0 
            ORDER BY date LIMIT 1";
    $result = mysqli_query($mysqli, $sql);
    if($result->num_rows > 0){
    //  echo "entering";
      while($row = $result->fetch_assoc()) {
        $date = $row["date"];
        $empty_1 = $row["empty_1"];
        //echo $empty_1;
        $empty_2 = $row["empty_2"];
       // echo $row["empty_3"];
        $empty_3 = $row["empty_3"];

        $num_slots = $row["num_slots"];
       // echo $hos_id;
      //  echo $date;
        $mysqli->query("UPDATE hosp_slots SET empty_1 = '$empty_1' -1  WHERE hos_id = '$hos_id' && date = '$date'");
        $empty_1 = $empty_1 -1;
        $empty = "updated";
        }
      
    }

  }
  else if(strcmp($_SESSION["occupation"], "Govt Sector") == 0 || $_SESSION["age"] >= 45){
    $class = "class2";
    $regdate = substr($regdate, 0, 10);
   //echo $hos_id;
    //echo $regdate;
    $sql = "SELECT hos_id, num_slots, empty_1, empty_2, empty_3, date 
            FROM hosp_slots 
            WHERE hos_id = '$hos_id' AND empty_2 > 0 AND STRCMP('$regdate', date) < 0 
            ORDER BY date LIMIT 1";
    $result = mysqli_query($mysqli, $sql);
    if($result->num_rows > 0){
    //  echo "entering";
      while($row = $result->fetch_assoc()) {
        $date = $row["date"];
        $empty_1 = $row["empty_1"];
        //echo $empty_1;
        $empty_2 = $row["empty_2"];
       // echo $row["empty_3"];
        $empty_3 = $row["empty_3"];

        $num_slots = $row["num_slots"];
       // echo $hos_id;
      //  echo $date;
        $mysqli->query("UPDATE hosp_slots SET empty_2 = '$empty_2' -1  WHERE hos_id = '$hos_id' && date = '$date'");
        $empty_2 = $empty_2 -1;
        $empty = "updated";
  }
}
  }
  else{
     $class = "class3";
     $regdate = substr($regdate, 0, 10);
    // echo $hos_id;
     //echo $regdate;
     $sql = "SELECT hos_id, num_slots, empty_1, empty_2, empty_3, date 
             FROM hosp_slots 
             WHERE hos_id = '$hos_id' AND empty_3 > 0 AND STRCMP('$regdate', date) < 0 
             ORDER BY date LIMIT 1";
     $result = mysqli_query($mysqli, $sql);
     if($result->num_rows > 0){
     //  echo "entering";
       while($row = $result->fetch_assoc()) {
         $date = $row["date"];
         $empty_1 = $row["empty_1"];
         //echo $empty_1;
         $empty_2 = $row["empty_2"];
        // echo $row["empty_3"];
         $empty_3 = $row["empty_3"];
 
         $num_slots = $row["num_slots"];
        // echo $hos_id;
       //  echo $date;
         $mysqli->query("UPDATE hosp_slots SET empty_3 = '$empty_3' -1  WHERE hos_id = '$hos_id' && date = '$date'");
         $empty_3 = $empty_3 -1;
         $empty = "updated";
  }
}
  }
  if($empty != ""){
  $slotno = (int)(($num_slots - ($empty_1 + $empty_2 + $empty_3))/20 +1);
  $mysqli->query("UPDATE reguser SET slotdate = '$date', slotno = '$slotno' WHERE id = '$user_id'");
  $_SESSION["slotdate"] = $date;
  $_SESSION["slotno"] = $slotno;
  }
}
?>

<?php include('Inc/Header.php');?>
	<div class="page-header">
		<h1 style="text-align:center">Hi,<br>Welcome !!!</h1>
	</div>
	<p>
		<h2 style="text-align:center">You are succesfully registered. Your slot 
    <?php if(!empty($_SESSION["slotdate"])){echo "is on " . $_SESSION["slotdate"] ;} else echo "will be informed soon"; ?><?php if(!empty($_SESSION["slotno"])){if($_SESSION["slotno"] == 1) echo ", Slot Time: 9:00 a.m."; else if($_SESSION["slotno"] == 2) echo ", Slot Time: 11:00 a.m."; else if($_SESSION["slotno"] == 3) echo ", Slot Time: 2:00 p.m."; else if($_SESSION["slotno"] == 4) echo ", Slot Time: 4:00 p.m."; else echo ", Slot Time: 6:00 p.m."; }?></h2>
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
<?php include('Inc/Footer.php');?>