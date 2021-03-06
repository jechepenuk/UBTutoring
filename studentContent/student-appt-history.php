<?php
include_once "access-db.php";
$result = mysqli_query($conn,"SELECT * FROM students WHERE user_id='" . $_GET['user_id'] . "'");
$row = mysqli_fetch_array($result);

$result2 = mysqli_query($conn,"SELECT * FROM appointments WHERE student_id='" . $_GET['user_id'] . "' and status != 'upcoming'");

$progress= mysqli_query($conn,"SELECT * FROM progress WHERE student_id='" . $_GET['user_id'] . "'");

if (isset($_POST['submit'])){
    $apptid=$_POST['id'];
    $sql = "DELETE FROM appointments WHERE appt_id=?";
    $stmt= $conn->prepare($sql);
    $stmt->bind_param("i", $apptid);
    $stmt->execute();
    $stmt->close();
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>UB Tutoring</title>
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&family=Noto+Serif:wght@700&family=Roboto+Slab:wght@900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow&family=Fredericka+the+Great&family=Noto+Serif&family=Roboto&display=swap" rel="stylesheet">
    <title>UB Tutoring Service</title>
</head>

<body class="main-container">

    <div class="header">

        <div class="menu_welcomePage">
            <ul>

                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.php')">login</a> </li> -->
                <li><a class="navlink" href="./student-appts.php?user_id=<?php echo $_GET['user_id']; ?>">my appointments</a> </li>
                <li><a class="navlink" href="./search.php?user_id=<?php echo $row['user_id']; ?>">find a tutor</a> </li>
                <div class="dropdown">
                        <li><a class="dropbtn">my progress</a>
                            <div class="dropdown-content">
                                <?php 
                                while ($progressInfo = mysqli_fetch_array($progress)){ 
                                    $linkname=$progressInfo['course'];
                                    $link="./student-progress.php?user_id=" . $_GET['user_id'] . "&cid=" . $linkname ; 
                                    echo "<a href=".$link.">".$linkname."</a>";}
                                ?>
                            </div>
                        </li>
                    </div>                <li><a class="navlink" href="./studentprof.php?user_id=<?php echo $row['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="../index.html">logout</a> </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="../index.html">UBtutoring</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">

    <h1 class=" modal-title welcome-page-title">Your Past Appointments</h1>
    <br>
    <?php 
    if (mysqli_num_rows($result2)<1){
        echo "<br><br><br><br><h2 class='center'>No past appointments.</h2>";
    }else{
    ?>
    <table class="infoAppt">
    <tr>
    <th width="20%">Date</th>
    <th width="20%">Tutor</th>
    <th width="20%">Class</th>
    <th width="10%">Status</th>
    <th width="10%"></th>
    </tr>

    <?php
    while($appt = mysqli_fetch_array($result2)){
    //find tutor name
    $tid=$appt['tutor_id'];
    $tutorRes= mysqli_query($conn,"SELECT * FROM tutors WHERE user_id=$tid");
    $tutarray = mysqli_fetch_array($tutorRes);
    ?>

 
    <tr>
        <td><?php echo $appt["day"]." "; if($appt["time"]>12){echo $appt["time"]-12 . ":00 PM";}else{echo $appt["time"] . ":00 AM";} ?></td>
        <td><a style="text-decoration: none" class="navlink" href="./tutorprof-student.php?user_id=<?php echo $_GET['user_id']; ?>&tutor_id=<?php echo $tid;?>"><?php echo $tutarray["fname"]; ?> <?php echo $tutarray["lname"]; ?></td>
        <td><?php echo $tutarray["courses"]; ?></td>
        <td><?php echo $appt["status"]; ?></td>
        <td><div class="cont">
            <button class="dropbtn2">options</button>
            <div class="dropdown-content2">
                <a><form method="post"><input type="hidden" name="id" value=<?php echo $appt['appt_id'];?>><input class="complete" type="submit" name="submit" value="delete"></form></a>
                <?php if ($appt['status']=="completed"){
                $link="./rate-tutor.php?user_id=" . $_GET['user_id'] . "&tutor_id=" . $tutarray['user_id'] ; 
                echo '<a href='.$link.'>rate tutor</a>";';
                ?>          
            </div></div></td>
    <?php
    }
    ?>

    </tr>  
    <?php
        }
    }
    ?>
    </table>
    <br><br><br><br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../index.js"></script>

    </body>

</html>
