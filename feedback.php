<?php
// Initialize the session
// Check if the user is logged in, if not then redirect him to login page
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: LoginU.php");
    exit;
}
?>


<?php include('Inc/Header.php'); ?>
<div class=container>
    <form method="post" action="feedback_action.php" enctype='multipart/form-data'>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12"></div>
        <div class="col-lg-4 col-md-4 col-cm-12">
            <h3 style="text-align:centre">Feedback</h3>
            <div class="form-group">
            <label for="feedback">Health Feedback</label>
            <select class="form-control" id="feedback" name = "feedback" required>
            <option>No sign of any illness</option>
            <option>Normal to light fever and aches</option>
            <option>High Fever, tiredness but symptoms subsided after 2-3 days</option>
            <option>Critical symptoms even after 3 days</option>
            </select>
            </div>
            <div class = "form-group">
                <label for="symptoms">Symptoms</label>
                <input type = "text" class = "form-control" id="symptoms" name ="symptoms"rows="3">
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5"></div>
            <div class="submit col-lg-2">
            <input type="submit" value="submit" name="submit"><br>
            </div>
         </div>
    </div>
    <br>
    </form>
</div>
    <?php include('Inc/Footer.php'); ?>