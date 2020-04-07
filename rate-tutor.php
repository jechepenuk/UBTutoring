<?php
include_once "access-db.php";

$message=""; 

if(count($_POST)>0){
	
	$rating = $_POST['rating'];
	
	$avg = $_POST['rank'];
		
	$numberOfRatings = $_POST['numRatings'];
	$oldNumRatings = $_POST['numRatings'];
	$numberOfRatings = $numberOfRatings + 1; 
	
	
	$base = $oldNumRatings/$numberOfRatings;

	$avg = $avg * $base;

	$avgModifier = $rating/$numberOfRatings; 

	$avg = $avg + $avgModifier;

	$avg = round($avg, 2);
	
	if(empty($rating)){
		$message="Please enter a value (1-5)";
	}else if($rating != 1 && $rating != 2 && $rating != 3 && $rating != 4 && $rating != 5){
		 $message="Please enter a number from 1-5";
    	}else{
		 mysqli_query($conn,"UPDATE tutors SET rank='" . $avg . "', numRatings='" . $numberOfRatings . "' WHERE user_id='" . $_POST['user_id'] . "'");
		 $message = "Rating submitted successfully";
		 header('Location: ./student-appt-history.php?user_id=' . $_GET['user_id']);

    	 }
        
    }

$result = mysqli_query($conn,"SELECT * FROM tutors WHERE user_id='" . $_GET['tutor_id'] . "'");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>UB Tutoring</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>UB Tutoring Service</title>
</head>
<body>
<div class="header">
        <div class="menu_welcomePage">
            <ul>
                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.php')">login</a> </li> -->
		<li><a class="navlink" href="./student-appts.php?user_id=<?php echo $_GET['user_id']; ?>">my appointments</a> </li>
                <li><a class="navlink" href="./search.php?user_id=<?php echo $_GET['user_id']; ?>">find a tutor</a> </li>
                <li><a class="navlink" href="./studentprof.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li>
                    <a href="./index.html">logout</a> </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="./index.html">UBtutoring</a> </h2>
        </div>
    </div>
    <hr class="hr-navbar">


<?php
$row = mysqli_fetch_array($result);
?>


<form class = "info1" method="post" action="">

<div><?php if(isset($message)) { echo $message; } ?>
</div>
<div style="padding-bottom:5px;">
</div>


<input type= "hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
<input type="hidden" name="fname" class="input1" value="<?php echo $row['fname']; ?>">
<input type="hidden" name="lname" class="input1" value="<?php echo $row['lname']; ?>">
<input type="hidden" name="numRatings" id='numRatings' class="input1" value="<?php echo $row['numRatings']; ?>">
<input type="hidden" name="rank" id='rank' class="input1" value="<?php echo $row['rank']; ?>">

<h1 class="wecome-page-title">Rating for Tutor: <?php echo $row["fname"]; ?> <?php echo $row["lname"]; ?> </h1>
<br><br>
<input type='text' name="rating" id='rating' placeholder="Enter a value from 1 - 5">
<br>

<br>
<br>

<input type="submit" id="submit" value="Submit" class="selectButton">
</form>

</body>
</html>
