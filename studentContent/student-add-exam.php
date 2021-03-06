<?php
    include_once "access-db.php";
    $student_id = $_GET['user_id'];
    $result = mysqli_query($conn,"SELECT * FROM progress WHERE student_id=$student_id;");
    $msg_error = "";
    $all_courses = array();
    
    $num_of_grades = 0;
    $courses_need_grades = "";
    $todays_date = new DateTime("now", new DateTimeZone('America/New_York') );
    $formatted_todays_date = $todays_date->format('Y-m-d');
    
    while($row = mysqli_fetch_array($result)){
        $course_name = $row["course"];
        array_push($all_courses, $course_name);

        $nextExam_string = $row['nextExam'];
        if(strlen($nextExam_string) > 2){
            $nextExam_date = strtotime($nextExam_string); 
            $nextExam = date('Y-m-d', $nextExam_date); 

            if($formatted_todays_date >= $nextExam){
                $courses_need_grades .= $course_name . ", ";
                $num_of_grades++;
            }
        }
    }
    if($num_of_grades > 0){
        $courses_need_grades = rtrim($courses_need_grades, ", ");
    }

    if(count($_POST) > 0){
        $grade_entered = $_POST["grade_for_course"];
        $choosen_class = $_POST["student_choosen_class"];

        if( floatval($grade_entered) < 150.0 && floatval($grade_entered) > 0.0){
            //echo "\"".floatval($grade_entered) . "\"\n";
            $prev_grades = "";
            $result = mysqli_query($conn,"SELECT * FROM progress WHERE student_id=$student_id;");
            while($row = mysqli_fetch_array($result)){
                $course_name = $row["course"];
            
                if(strcmp($course_name, $choosen_class)== 0){
                    $prev_grades = $row["grades"];
                }
            }
            if(strlen($prev_grades) < 2){
                $prev_grades = $grade_entered;
            }else{
                $prev_grades .= ",".$grade_entered;
            }
            
            mysqli_query($conn, "UPDATE progress SET grades=\"$prev_grades\", nextExam=\"\" WHERE student_id=$student_id AND course=\"$choosen_class\" ;");
            header('Location: ./student-progress.php?user_id='.$_GET['user_id'].'&cid='.$_POST["student_choosen_class"]);
        }else{
            $msg_error = "Enter a valid grade";
        }
    }
   
$progress= mysqli_query($conn,"SELECT * FROM progress WHERE student_id='" . $_GET['user_id'] . "'");

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
                 <li><a class="navlink" href="./student-appts.php?user_id=<?php echo $_GET['user_id']; ?>">my appointments</a> </li>
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
                    </div>
                <li><a class="navlink" href="./search.php?user_id=<?php echo $student_id; ?>">find a tutor</a> </li>
                <li><a class="navlink" href="./studentprof.php?user_id=<?php echo $student_id; ?>">profile</a> </li>
                <li><a class="navlink" href="../index.html">logout</a> </li>

            </ul>
        </div>

        <div class="logo">
            <h2 class="logo"> <a href="../index.html">UBtutoring</a> </h2>
        </div>

    </div>
    <hr class="hr-navbar">
    <br><br><br><br>
    <div class="modal">

    <?php
        if(strcmp($msg_error, "")!= 0){
            echo "<h2 class=\"modal-title\">Please enter a grade between 0 and 150.</h1><br>";
        }
        
        $num_classes = count($all_courses);
        if( $num_classes > 0){
    ?>
    
    <h1 class="modal-title welcome-page-title">Your Classes</h1><br>
    <br><br><br>
    <?php
    if($num_of_grades > 0){ ?>
            <p style="color:white" class="center"> <?php  echo "Enter grades for: ". $courses_need_grades; ?> </p> <?php } ?>

    <div id="tutor_signup_div">
    <div class="modal-input">        
        <form method="post">
        
        <label for="nextExam"> Choose a Course </label>
            <select class="input1" name="student_choosen_class">
                
                <?php
                    foreach($all_courses as $key => $value){
                ?>
                <option value=<?php  echo "\"$value\";"?>><?php  echo $value; ?></option>
                
                <?php
                    }
                ?>
            </select>
            <input class="sign_up_input" type="text" placeholder="enter your grade" onkeypress="validate(event)", name="grade_for_course"><br><br>
            <input id="log_in_button" type="submit" name="submit">

        </form>
        <br><br><br>
    </div>
    </div>

    <?php
        }else{
    ?>
    <h1 class="modal-title welcome-page-title">No courses available.</h1><br>
    <?php
        }
    ?>
    </div>
    <br><br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../index.js"></script>

<script>

</script>

</body>

</html>

