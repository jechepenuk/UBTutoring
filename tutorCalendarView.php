

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <title>UB Tutoring Service</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- <script type="text/javascript" src="js/modernizr.custom.86080.js"></script> -->
</head>


<body>

    <div class="header">

        <div class="menu_welcomePage">
            <ul>

                <!-- the line of code commented below is important when we upload the work on a server. for now, i'm using an alternative below -->
                <!-- <li><a href="javascript:loadPage('./login.php')">login</a> </li> -->
                <li><a class="navlink" href="./tutor-appts.php?user_id=<?php echo $_GET['user_id']; ?>">appointments</a> </li>
                <li><a class="navlink" href="./tutorprof.php?user_id=<?php echo $_GET['user_id']; ?>">profile</a> </li>
                <li><a class="navlink" href="./index.html">logout</a> </li>

            </ul>
        </div>
           
        <div class="logo">
            <h2 class="logo"> <a href="./index.html">UBtutoring</a> </h2>
        </div>
        
    </div>
    <hr class="hr-navbar">


    <h1 class = "welcome-page-title">Your Availability</h1>

    <table id="calendar_tutor" rules="all">
        <thead>
            <tr>
                <th>
                    <span id="calendar_monday">Monday</span>
                </th>
                <th>
                    <span id="calendar_tuesday">Tuesday</span>
                </th>
                <th>
                    <span id="calendar_wednesday">Wednesday</span>
                </th>
                <th>
                    <span id="calendar_thursday">Thursday</span>
                </th>
                <th>
                    <span id="calendar_friday">Friday</span>
                </th>
                <th>
                    <span id="calendar_saturday">Saturday</span>
                </th>
                <th>
                    <span id="calendar_sunday">Sunday</span>
                </th>
            </tr>
        </thead>

        <tbody id=calender_tutor_body>
            <br>
            <br>
            <tr>
                <td id="calendar_monday_data"></td>
                <td id="calendar_tuesday_data"></td>
                <td id="calendar_wednesday_data"></td>
                <td id="calendar_thursday_data"></td>
                <td id="calendar_friday_data"></td>
                <td id="calendar_saturday_data"></td>
                <td id="calendar_sunday_data"></td>
            </tr>
            <?php
                include_once "access-db.php";
                $result = mysqli_query($conn,"SELECT * FROM calendar WHERE user_id=22");
                $count  = mysqli_num_rows($result);
                if($count==0) {
                    echo"failed";
                } else {
                    $items = mysqli_fetch_array($result);
                    //echo $items;
                    for($i = 1; $i < 14; $i++){
                        echo "<tr>";
                        for($j= 0; $j < 7; $j++){
                            $k = ($j * 13) + $i ;
                            $color = "green";
                            if($items[$k] == 1){
                                $color = "red";
                            }
                            echo "<td bgcolor=\"$color\"><input type=submit style=\"width:100%; height:100%; background: transparent; border: none;\" value=\"\"></td>";
                        }
                        echo "</tr>";
                    }
                    
                }
            ?>
        </tbody>
    </table>

    
    <form style="width: 100%; text-align: center; ">
        <button id="popup_open" class="add-or-edit-button" type="submit"> Add or Edit </button>
    </form>
    
    

    <script src="index.js"></script>
  
</body>

</html>
