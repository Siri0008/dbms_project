<?php
  session_start();
ob_start();
require "Db.php";
if (isset($_POST['submit'])){
    $feedback=$_POST['feedback'];
    $symptoms = $_POST['symptoms'];
    // $name=$_SESSION["name"];
    // $mail=$_SESSION["emailid"];
    // $user = get_current_user();
     $id = $_SESSION["id"];
     $sql = "SELECT id, fbno FROM feedback WHERE id = '$id'";
     $stmt = mysqli_query($mysqli,$sql);
     //echo $stmt->num_rows;
     if($stmt){
             $fbno = $stmt->num_rows + 1;
     }
         else{
             echo "Oops!Something went wrong. Try agaiin later";
         }
       //  $stmt->close();
    //echo $feedback;
    $sql = "INSERT INTO `feedback` (id, fbno, fb, symptoms) VALUES ('$id', '$fbno', '$feedback', '$symptoms')";
    if(!mysqli_query($mysqli,$sql))
       {
          echo "<script>alert('Server Busy>Please Try again');document.location.href=('feedback.php');</script>";
       }

       else
       {
         //  echo "script";
          echo "<script>alert('feedback added successfully');document.location.href=('userhome.php');</script>";    
       }

}
?>