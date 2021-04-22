<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    text-align:left;
    border: 1px solid black;
}
table {
  border-collapse: collapse;
  width: 100%;
}
th, td {
  padding: 15px;
}
</style>
</head>
<body>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginH.php");
    exit;
}
?>
<?php include('Inc/HeaderA.php');?>
    <div class="container" style="text-align:center;">
    <h3>Patients list</h3>
<?php
    require_once "Db.php";
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    $hosid = $_SESSION["id"];
    $sql = "select id,name,emailid,mobilenumber1 from reguser WHERE hos_id = '$hosid' AND id NOT IN (select r.id from reguser r,vacuser v WHERE r.id = v.id GROUP BY v.id HAVING COUNT(v.id) = 2 ORDER BY COUNT(v.id) DESC) ";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    
    echo "<table><tr><th>ID</th><th>Name</th><th>Mail-Id</th><th>Mobile Number</th><th>Vaccine Dose</th><th>Allot</th></tr>";
    while($row = $result->fetch_assoc()) {
        $user_id = $row["id"];
        $vacno = 1;
        $res = "select vacno FROM vacuser WHERE id = '$user_id'";
        if(($mysqli->query($res))->num_rows > 0){
            $vacno = 2;
        }
        ?>
    
    <tr><td><?php echo $row["id"] ?> </td>
        <td><?php echo $row["name"] ?> </td>
        <td><?php echo $row["emailid"]  ?></td>
        <td><?php echo $row["mobilenumber1"] ?> </td>
        <td><?php echo $vacno ?> </td>
        <td><a href="Allot.php?id=<?php echo $row['id']; $_SESSION['userid'] = $row['id']?>">Allot</a></td> 
    </tr>
<?php } ?>
    </table>
    <?php }
else {
    echo "0 Users!";?>
    <style>
    @media screen and (min-width: 1100px) {.f{
                                position:fixed;
                                 bottom:0;
                                 right:0;
                                 left:0;
                             }
                             .content{
                                 height:1000px !important;
                             }}
                             </style> 
<?php }
$mysqli->close();
    ?>
    </div>
    <style>
    @media screen and (min-width: 1100px) {.f{
                                position:fixed;
                                 bottom:0;
                                 right:0;
                                 left:0;
                             }
                             .content{
                                 height:1000px !important;
                             }}
                             </style> 
<?php include('Inc/Footer.php');?> 
