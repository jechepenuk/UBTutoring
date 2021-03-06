<?php
include_once "access-db.php";

$result = mysqli_query($conn,"SELECT * FROM students WHERE user_id='" . $_GET['student_id'] . "'");
$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
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
                <!-- <li><a href="javascript:loadPage('./login.html')">login</a> </li> -->
                <li><a class="navlink" href="./tutor-appts.php?user_id=<?php echo $_GET['user_id']; ?>">my appointments</a> </li>
                <li><a class="navlink" href="./tutorprof.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="../index.html">logout</a> </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="../index.html">UBtutoring</a> </h2>
        </div>

    </div>

    <hr class="hr-navbar">

    <h1 class="modal-title welcome-page-title"><?php echo $row["fname"]; ?> <?php echo $row["lname"]; ?></h1>
    <br>
    <br>
    <?php
    

    if ($row['user_image']){
     echo '<img class="profilePicture" src="data:image/jpeg;base64,'. $row['user_image'] .'"/>';
    }else{
        echo '<img class="profilePicture" src="user-default.jpg" alt="you">';
       }
    ?>    
    <br>
    <table class="info">
    <tr><td>Academic Level: </td><td><?php echo $row["title"]; ?></td></tr>
    <tr><td>Email: </td><td><?php echo $row["email"]; ?></td></tr>

    </table>    
        
    <br><br>
    <button class="selectButton" onclick="window.location.href = 'mailto:<?php echo $row['email'];?>?subject = Feedback&body = Message'">
     Contact Student
    </button>
    <br><br><br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../index.js"></script>
    <script>
        
    </script>

</body>

</html>
