<!DOCTYPE html>
<html>
<?php
    session_name("profile");
    session_start();
    if (!isset($_SESSION["Usr_id"]))
    {
        header("Location: Assignmentloginpage.php");
        exit();
    }
    if (!isset($_SESSION["submitted"])){
		$_SESSION["submitted"] = 0;
	}
	else{
		$_SESSION["submitted"]++;
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($_SESSION["submitted"] != $_POST["submitted"])
		{
			header("Location: records.php");
			exit();
		}
	}
    $dbconnect = include("databaseconnect.php");
?>
<head>
    <meta content="zh-cn" http-equiv="Content-Language" />
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huan Fitness Pal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Century;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
        }
        body {
            background-color: #4A628A;
            padding-bottom: 20%;
        }
        .container{
            text-align: center;
            height: auto;
        }
        footer {
            position:relative;
            width:100%;
            background-color: #43A047;
            padding: 20px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            top: 250px;
            height: 100px;
        }
        .footer_content{
            position: relative;
            text-align: center;
            top: 20px;
        }
        .footer_content li{
            display: inline-block;
            width: 200px;
            font-size: 20px;
        }
        /* Header */
        .Logo {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .logo {
            height: 100px;
            width: auto;
            border-radius: 30px;
        }

        .title {
            font-family: 'Playfair Display', cursive;
            font-size: 29px;
            letter-spacing: 0.3px;
            color: rgb(253, 255, 255);
            margin: 0;
        }

        header {
            background-color: #43A047;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .navbar {
            position: relative;
            right:0;
        }

        .navlink {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
            gap: 20px;
        }

        .navlink li {
            display: inline-block;
            padding: 0px;
        }

        .navlink li a {
            display: inline-block;
            text-decoration: none;
            color: rgb(255, 255, 255);
            font-family: "Montserrat", sans-serif;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            padding: 20px;
            width:60px;
        }

        .navlink li p {
            color: white;
            display: none;
            position: absolute;
        }

        .navlink li a:hover, button:hover {
            background-color: #75e6ff;
        }

        .navlink li:hover p {
            display: block;
        }

        /* Profile Icon Fix */
        .fa-user {
            margin-right: 8px;
        }
        table, th, td{
            border: solid #AFC8E6;
            border-radius: 10px;
            background-color: #E0E0E0;
            color: #3F51B5;
            text-align: center;
        }
        .table{
            display: flex;
            justify-content: center; 
            align-items: center;
        }
        .home_button{
            position: relative;
            margin-left: 80%;
            height: auto;
        }
        button{
            background-color: #A3B3D1;
            font-size: 14px;
            border-radius: 10px;
            width: 120px;
        }

        .cancel, .delete{
            width: 70px;
        }

        .edit, .save{
            width: 50px;
        }
        /* Search Bar Style */
        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type="date"] {
            padding: 10px;
            font-size: 16px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #43A047;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #2e7d32;
        }
        <?php include("../Styling/style.css") ?>
        header{
            margin: 40px;
        }
    </style>
</head>
<body>
<header>
    <div class="Logo">
        <a href=""><img class="logo" src="weblogo.webp"></a>
        <h1 class="title">Huan Fitness Pal</h1>
    </div>

    <!-- Nav bar -->
    <div class="navbar">
        <nav>
            <ul class="navlink">
                <?php if(isset($_SESSION['Usr_id'])) { ?>
                    <li><a href="../Homepage.php"><i class="fa-solid fa-house"></i></a><p>Home</p></li>
                    
                    <li><a href="../history.php"><i class="fa-solid fa-phone"></i></a><p>Appointment</p></li>
                    <li><a href="profile.php"><i class="fa fa-user"></i></a><p>Profile</p></li>
                    <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a><p>Logout</p></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>
<main>
    <div class="container">
        <h1>Your Records</h1><br>
        <!-- Search Bar -->
        <div class="search-container">
            <?php
                if (isset($_POST["search_date"]))
                    $_GET["search_date"] = $_POST["search_date"];
                $search = "";
                if (isset($_GET["search"]) || isset($_GET["search_date"])){
                    if (isset($_GET["search_date"]))
                        $search = $_GET["search_date"];
                }
                if (isset($_GET["clear"])){
                    if(isset($_GET["search_date"])){
                        $_GET["search_date"] = "";
                        $search = "";
                    }
                }
            ?>
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="date" name="search_date" value = "<?php echo $search; ?>" />
                <button type="submit" name="search">Search</button>
                <button type="submit" name="clear">Clear</button>
            </form>
        </div>

        <?php
            $usrid = $_SESSION["Usr_id"];
            $search_date = isset($_GET['search_date']) ? $_GET['search_date'] : '';
            if(isset($_POST["delete"]) && isset($_POST["wateredit"]))
            {
                try{
                    $waterdate = $_POST["wateredit"];
                    $query = "DELETE FROM water WHERE Usr_id = $usrid AND Update_date = '$waterdate'";
                    $dltsuccess = $dbconnect->query($query);
                    }
                catch(Exception $e)
                {
                    echo $e;
                }
            }
            // Water intake query
            $water_query = "SELECT Water_intake, Update_date FROM water WHERE Usr_id = $usrid";
            if (!empty($search_date)) {
                $water_query .= " AND Update_date = '$search_date'";
            }
            $water_query .= " ORDER BY Update_date desc";
            $water_result = $dbconnect->query($water_query);
            $water_rows = $water_result->fetchAll();
        ?>
        <h2>Your Water Intake Records <a href="../Water.php"><button>Record More</button></a></h2>
        
        <div class="table">
            <table style="width: 50%;">
                <tr>
                    <th>Amount of water(Litres)</th>
                    <th>Date</th>
                    <th colspan=2>Controls</th>
                    
                </tr>
                <?php
                    foreach($water_rows as $row) {
                ?>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                    <tr>
                        <td>
                            <?php
                                if(isset($_POST["edit"]) && isset($_POST["wateredit"]) && $_POST["wateredit"] == $row["Update_date"]){
                            ?>
                            <input type="number" name="water" value="<?php echo $row["Water_intake"]; ?>">
                            <?php
                                }
                                else{
                                    if (isset($_POST["save"]) && isset($_POST["water"]) && $_POST["water"] != null 
                                        && $_POST["water"] > -1 && $_POST["wateredit"] == $row["Update_date"])
                                        echo $_POST["water"];
                                    else
                                        echo $row["Water_intake"];
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo $row["Update_date"];
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($_POST["edit"]) && isset($_POST["wateredit"]) && $_POST["wateredit"] == $row["Update_date"]){
                            ?>
                            <button class="save" name="save">Save</button>
                            <?php
                                }
                                else{
                            ?>
                            <button class="edit" name="edit">Edit</button>
                            <?php
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($_POST["edit"]) && isset($_POST["wateredit"]) && $_POST["wateredit"] == $row["Update_date"]){
                            ?>
                            <button class="cancel" name="cancel">Cancel</button>
                            <?php
                                }
                                else{
                            ?>
                            <button class="delete" name="delete" onclick = "return confirm('Are you sure you want to delete this record?')">Delete</button>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                        if(isset($_GET["search_date"]))
                        {
                    ?>
                    <input type="hidden" name="search_date" value= <?php echo $_GET["search_date"]; ?>>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="wateredit" value="<?php echo $row["Update_date"]; ?>">
                    <input  type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
                </form>
                <?php
                    }
                ?>
            </table>
            </div>
            <?php 
                if(isset($_POST["save"]) && isset($_POST["wateredit"]))
                {
                    try{
                        $waterdate = $_POST["wateredit"];
                        $waterin = (int)$_POST["water"];
                        $query = "UPDATE water SET Water_intake = $waterin WHERE Usr_id = $usrid AND Update_date = '$waterdate'";
                        if ($waterin != null && $waterin > -1){
                            if($dbconnect->query($query))
                                echo "<div style='color: lightgreen'>Your record at $waterdate has been successfully updated to $waterin</div><br>";
                            else
                                echo "<div style='color: red'>Failed to update your record at $waterdate, Please try again later</div><br>";
                        }
                        else{
                            echo "<div style='color: red'>Please insert your correct water intake</div><br>";
                        }
                    }catch(Exception $e)
                    {
                        echo $e;
                    }
                }
                if(isset($_POST["delete"]) && isset($_POST["wateredit"])){
                    if($dltsuccess)
                        echo "<div style='color: lightgreen'>Your record at $waterdate has been successfully deleted</div><br>";
                    else
                        echo "<div style='color: red'>Failed delete your record at $waterdate, Please try again later</div><br>";
                }
            ?>
        

        <!-- BMI Records -->
        <?php
            if(isset($_POST["save"]) && isset($_POST["bmiedit"]))
            {
                try{
                    $bmidate = $_POST["bmiedit"];
                    $bmiw = (int)$_POST["weight"];
                    $bmih = (int)$_POST["height"];
                    $updatedbmi = $bmiw / (($bmih / 100) * ($bmih / 100));
                    $query = "UPDATE physical SET Usr_Height = $bmih, Usr_Weight = $bmiw, BMI = $updatedbmi WHERE Usr_id = $usrid AND Update_date = '$bmidate'";
                    $updatesuccess = false;
                    if ($bmih != null && $bmih > 0 && $bmiw != null && $bmiw > 0){
                        if($dbconnect->query($query))
                            $updatesuccess = true;
                    }
                }catch(Exception $e)
                {
                    echo $e;
                }
            }
            if(isset($_POST["delete"]) && isset($_POST["bmiedit"]))
            {
                try{
                    $bmidate = $_POST["bmiedit"];
                    $query = "DELETE FROM physical WHERE Usr_id = $usrid AND Update_date = '$bmidate'";
                    $dltsuccess = $dbconnect->query($query);
                    }
                catch(Exception $e)
                {
                    echo $e;
                }
            }
            $bmi_query = "SELECT Usr_Height, Usr_Weight, BMI, Update_date FROM physical WHERE Usr_id = $usrid";
            if (!empty($search_date)) {
                $bmi_query .= " AND Update_date = '$search_date'";
            }
            $bmi_query .= " ORDER BY Update_date desc";
            $bmi_result = $dbconnect->query($bmi_query);
            $bmi_rows = $bmi_result->fetchAll();
        ?>
        <br><h2>Your BMI Records <a href="../BMI.php"><button>Record More</button></a></h2>
        <div class="table">
            <table style="width: 55%;">
                <tr>
                    <th>Height(cm)</th>
                    <th>Weight(kg)</th>
                    <th>BMI</th>
                    <th>Date</th>
                    <th colspan=2>Controls</th>
                </tr>
                <?php
                    foreach($bmi_rows as $row) {
                ?>
                <tr>
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <td>
                        <?php
                            if(isset($_POST["edit"]) && isset($_POST["bmiedit"]) && $_POST["bmiedit"] == $row["Update_date"]){
                        ?>
                        <input type="number" name="height" value="<?php echo $row["Usr_Height"]; ?>">
                        <?php
                            }
                            else{
                                if (isset($_POST["save"]) && isset($_POST["height"]) && $_POST["height"] != null 
                                    && $_POST["height"] > 0 && $_POST["bmiedit"] == $row["Update_date"])
                                    echo $_POST["height"];
                                else
                                    echo $row["Usr_Height"];
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if(isset($_POST["edit"]) && isset($_POST["bmiedit"]) && $_POST["bmiedit"] == $row["Update_date"]){
                        ?>
                        <input type="number" name="weight" value="<?php echo $row["Usr_Weight"]; ?>">
                        <?php
                            }
                            else{
                                if (isset($_POST["save"]) && isset($_POST["weight"]) && $_POST["weight"] != null 
                                    && $_POST["weight"] > 0 && $_POST["bmiedit"] == $row["Update_date"])
                                    echo $_POST["weight"];
                                else
                                    echo $row["Usr_Weight"];
                            }
                        ?>
                    </td>
                    <td><?php echo $row["BMI"];?></td>
                    <td><?php echo $row["Update_date"];?></td>
                    <td>
                        <?php
                            if(isset($_POST["edit"]) && isset($_POST["bmiedit"]) && $_POST["bmiedit"] == $row["Update_date"]){
                        ?>
                        <button class="save" name="save">Save</button>
                        <?php
                            }
                            else{
                        ?>
                        <button class="edit" name="edit">Edit</button>
                        <?php
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if(isset($_POST["edit"]) && isset($_POST["bmiedit"]) && $_POST["bmiedit"] == $row["Update_date"]){
                        ?>
                        <button class="cancel" name="cancel">Cancel</button>
                        <?php
                            }
                            else{
                        ?>
                        <button class="delete" name="delete" onclick = "return confirm('Are you sure you want to delete this record?')">Delete</button>
                        <?php
                            }
                        ?>
                    </td>
                    <?php
                        if(isset($_GET["search_date"]))
                        {
                    ?>
                    <input type="hidden" name="search_date" value= <?php echo $_GET["search_date"]; ?>>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="bmiedit" value="<?php echo $row["Update_date"]; ?>">
                    <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
                    </form>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        <?php
            if(isset($_POST["save"]) && isset($_POST["bmiedit"])){
                if ($bmih != null && $bmih > 0 && $bmiw != null && $bmiw > 0){
                    if($updatesuccess)
                        echo "<div style='color: lightgreen'>Your record at $bmidate has been successfully updated to <br>Height: $bmih<br>Weight: $bmiw</div><br>";
                    else
                        echo "<div style='color: red'>Failed to update your record at $bmidate, Please try again later</div><br>";
                }
                else{
                    echo "<div style='color: red'>Please insert your correct height/weight</div><br>";
                }
            }
            if(isset($_POST["delete"]) && isset($_POST["bmiedit"])){
                if($dltsuccess)
                    echo "<div style='color: lightgreen'>Your record at $bmidate has been successfully deleted</div><br>";
                else
                    echo "<div style='color: red'>Failed delete your record at $bmidate, Please try again later</div><br>";
            }
        ?>

        <!-- Exercise Records -->
        <?php
            if(isset($_POST["save"]) && isset($_POST["exedit"]))
            {
                try{
                    $exdate = $_POST["exedit"];
                    $extype = $_POST["extype"];
                    $exstart = $_POST["start"];
                    $exend = $_POST["end"];
                    $exduration = (strtotime($exend) - strtotime($exstart)) / 60;
                    
                    $query = "UPDATE work_outs SET Wo_type = :extype, time_start = :exstart, time_end = :exend, Wo_duration = :exduration WHERE Usr_id = $usrid AND Wo_date = '$exdate' AND time_start = :ostart AND time_end = :oend";
                    $updatesuccess = false;
                    if ($extype != null && trim($extype) != "" && $exduration > 0){
                        $extype = trim($extype);
                        $prep = $dbconnect->prepare($query);
                        $prep->bindParam(":extype", $extype);
                        $prep->bindParam(":exstart", $exstart);
                        $prep->bindParam(":exend", $exend);
                        $prep->bindParam(":exduration", $exduration);
                        $prep->bindParam(":ostart", $_POST["ostart"]);
                        $prep->bindParam(":oend", $_POST["oend"]);
                        if($prep->execute())
                            $updatesuccess = true;
                    }
                }catch(Exception $e)
                {
                    echo $e;
                }
            }
            if(isset($_POST["delete"]) && isset($_POST["exedit"]))
            {
                try{
                    $exdate = $_POST["exedit"];
                    $exstart = $_POST["ostart"];
                    $exend = $_POST["oend"];
                    $query = "DELETE FROM work_outs WHERE Usr_id = $usrid AND Wo_date = '$exdate' AND time_start = :ostart AND time_end = :oend";
                    $prep = $dbconnect->prepare($query);
                    $prep->bindParam(":ostart", $_POST["ostart"]);
                    $prep->bindParam(":oend", $_POST["oend"]);
                    if($prep->execute())
                        $dltsuccess = true;
                }
                catch(Exception $e)
                {
                    echo $e;
                }
            }
            $exercise_query = "SELECT Wo_date, time_start, time_end, Wo_type, Wo_duration FROM work_outs WHERE Usr_id = $usrid";
            if (!empty($search_date)) {
                $exercise_query .= " AND Wo_date = '$search_date'";
            }
            $exercise_query .= " ORDER BY Wo_date desc, time_start desc";
            $exercise_result = $dbconnect->query($exercise_query);
            $exercise_rows = $exercise_result->fetchAll();
        ?>
        <br><h2>Your Exercise Records <a href="../exercise.php"><button>Record More</button></a></h2>
        <div class="table">
            <table style="width: 60%;">
                <tr>
                    <th>Type(s) of exercise</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Duration<br>(Minutes)</th>
                    <th>Date</th>
                    <th colspan=2>Controls</th>
                </tr>
                <?php
                    foreach($exercise_rows as $row) {
                ?>
                <tr>
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                        <td>
                            <?php
                                if(isset($_POST["edit"]) && isset($_POST["exedit"]) && $_POST["exedit"] == $row["Wo_date"]&& $_POST["ostart"] == $row["time_start"] && $_POST["oend"] == $row["time_end"]){
                            ?>
                            <input type="text" name="extype" value="<?php echo $row["Wo_type"]; ?>">
                            <?php
                                }
                                else{
                                    if (isset($_POST["save"]) && isset($_POST["exedit"]) && $_POST["extype"] != null && trim($_POST["extype"]) != "" && isset($_POST["exedit"]) 
                                        && $_POST["ostart"] == $row["time_start"] && $_POST["oend"] == $row["time_end"] && $_POST["exedit"] == $row["Wo_date"])
                                        echo $_POST["extype"];
                                    else
                                        echo $row["Wo_type"];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($_POST["edit"]) && isset($_POST["exedit"]) && $_POST["exedit"] == $row["Wo_date"] && $_POST["ostart"] == $row["time_start"] && $_POST["oend"] == $row["time_end"]){
                            ?>
                            <input type="time" name="start" value="<?php echo $row["time_start"]; ?>">
                            <?php
                                }
                                else{
                                    if (isset($_POST["save"]) && isset($_POST["exedit"]) && $_POST["extype"] != null && trim($_POST["extype"]) != "" && isset($_POST["exedit"]) 
                                        && $_POST["ostart"] == $row["time_start"] && $_POST["oend"] == $row["time_end"] && $_POST["exedit"] == $row["Wo_date"])
                                        echo $_POST["start"];
                                    else
                                        echo $row["time_start"];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($_POST["edit"]) && isset($_POST["exedit"]) && $_POST["exedit"] == $row["Wo_date"]&& $_POST["ostart"] == $row["time_start"] && $_POST["oend"] == $row["time_end"]){
                            ?>
                            <input type="time" name="end" value="<?php echo $row["time_end"]; ?>">
                            <?php
                                }
                                else{
                                    if (isset($_POST["save"]) && isset($_POST["exedit"]) && $_POST["extype"] != null && trim($_POST["extype"]) != "" && isset($_POST["exedit"]) 
                                        && $_POST["ostart"] == $row["time_start"] && $_POST["oend"] == $row["time_end"] && $_POST["exedit"] == $row["Wo_date"])
                                        echo $_POST["end"];
                                    else
                                        echo $row["time_end"];
                                }
                            ?>
                        </td>
                        <td><?php echo $row["Wo_duration"];?></td>
                        <td><?php echo $row["Wo_date"];?></td>
                        <td>
                        <?php
                            if(isset($_POST["edit"]) && isset($_POST["exedit"]) && $_POST["ostart"] == $row["time_start"] 
                                && $_POST["oend"] == $row["time_end"] && $_POST["exedit"] == $row["Wo_date"]){
                        ?>
                        <button class="save" name="save">Save</button>
                        <?php
                            }
                            else{
                        ?>
                        <button class="edit" name="edit">Edit</button>
                        <?php
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if(isset($_POST["edit"]) && isset($_POST["exedit"]) && $_POST["ostart"] == $row["time_start"] 
                                && $_POST["oend"] == $row["time_end"] && $_POST["exedit"] == $row["Wo_date"]){
                        ?>
                        <button class="cancel" name="cancel">Cancel</button>
                        <?php
                            }
                            else{
                        ?>
                        <button class="delete" name="delete" onclick = "return confirm('Are you sure you want to delete this record?')">Delete</button>
                        <?php
                            }
                        ?>
                    </td>
                    <?php
                        if(isset($_GET["search_date"]))
                        {
                    ?>
                    <input type="hidden" name="search_date" value= <?php echo $_GET["search_date"]; ?>>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="exedit" value="<?php echo $row["Wo_date"]; ?>">
                    <input type="hidden" name="ostart" value="<?php echo $row["time_start"]; ?>">
                    <input type="hidden" name="oend" value="<?php echo $row["time_end"]; ?>">
                    <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
                    </form>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        <?php
            if(isset($_POST["save"]) && isset($_POST["exedit"])){
                if ($extype != null && $extype != "" && $exduration > 0){
                    if($updatesuccess)
                        echo "<div style='color: lightgreen'>Your record has been successfully updated to <br>Work Out Type: $extype<br>Start Time: $exstart<br>End Time: $exend</div><br>";
                    else
                        echo "<div style='color: red'>Failed to update your record, Please try again later</div><br>";
                }
                else if($exduration <= 0){
                    echo "<div style='color: red'>Your starting time should not be after your ending time</div><br>";
                }
                else
                    echo "<div style='color: red'>Please insert your exercise type(s)</div><br>";
            }
            if(isset($_POST["delete"]) && isset($_POST["exedit"])){
                if($dltsuccess)
                    echo "<div style='color: lightgreen'>Your record has been successfully deleted</div><br>";
                else
                    echo "<div style='color: red'>Failed delete your record , Please try again later</div><br>";
            }
        ?>
    </div>
    <br>
    <div class="home_button">
        <a href="../Homepage.php"><button>Back to Homepage</button></a>
    </div>
</main>
<footer>
    <div class="footer_content">
    <ul>
		<li><a href="../Sponsor.php"><i class="fa-solid fa-handshake"></i></a><p>Sponsor</p></li>
		<li><a href="../aboutUs.php"><i class="fa-solid fa-circle-info"></i></a><p>About Us</p></li>
        <a href="../address.php"><li>Address</li></a>
        <a href="../term.php"><li>Terms & Condition</li></a>
        <a href="../privacy.php"><li>Privacy Policy</li></a>
    </ul>
    </div>
</footer>
</body>
</html>
