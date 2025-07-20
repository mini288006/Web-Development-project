<!DOCTYPE html>
<?php
    session_name("profile");
    session_start();
    if (!isset($_SESSION["submitted"])){
        $_SESSION["submitted"] = 0;
    }
    else{
        $_SESSION["submitted"]++;
    }
    if (!isset($_SESSION["Usr_id"]))
    {
        header("Location: Profile/Assignmentloginpage.php");
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if ($_SESSION["submitted"] != $_POST["submitted"])
        {
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit();
        }
        $continue = true;
    }
?>
<html lang="en">
<head>
    <style>
        body{
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        right: 150px;
        background-color: #4A628A;
    }
    .container{
        position: relative;
        text-align: left;
        padding: 20px;
        width: 500px;
        border-radius: 20px;
        box-shadow: 4px 4px 8px rgba(1, 1, 1, 1);
        background-color: #B0C1D8;
        left: 150px;
    }
    .container h2{
        margin: 0px;
        text-align: center;
    }
    .form{
        border: inset;
    }
    header{
        text-align: left;
        font-size: 30px;
    }
    form{
        text-align: left;
        font-size: 20px;
    }
    .submit{
        width: 15%;
        height: 23px;
        background-color: #A3B3D1;
        font-size: 15px;
        border-radius: 10px;
    }
    .request{
        border: inset;
        width: 400px;
        height: 50px;
    }
    .button{
        position: relative;
        width: 35%;
        height: 23px;
        bottom: 25px;
        left: 85px;
        background-color: #A3B3D1;
        font-size: 15px;
        border-radius: 10px;
    }
    .submit:hover{
        background-color: #8493B0;
    }
    .button:hover{
        background-color: #8493B0;
    }
    </style>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="container">
            <h2>Workout record</h2>
            <label>Please enter what workout/exercise you did:</label><br>
            <input type="text" name="exercise" class="form" placeholder="Workout/Exercise"><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["exercise"]) && !empty($_POST["exercise"]))
                        $exercise = $_POST["exercise"];
                    else{
                        echo "<label style='color: red'>Please insert your exercise type(Example: Push up/Sit up)</label><br><br>";
                        $continue = false;
                    }
                }
            ?>
            <label>Please choose which date you did you workout/exercise:</label><br>
            <input type="date" name="date" ><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["date"]) && !empty($_POST["date"]))
                        $date = $_POST["date"];
                    else{
                        echo "<label style='color: red'>Please select your record date</label><br><br>";
                        $continue = false;
                    }
                }
            ?>
            <label>Please enter what time you started:</label><br>
            <input type="time" name="Stime" class="form"><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["Stime"]) && !empty($_POST["Stime"]))
                        $Stime = $_POST["Stime"];
                    else{
                        echo "<label style='color: red'>Please select your starting time</label><br><br>";
                        $continue = false;
                    }
                }
            ?>
            <label>Please enter what time you ended:</label><br>
            <input type="time" name="Etime" class="form"><br><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["Etime"]) && !empty($_POST["Etime"]))
                        $Etime = $_POST["Etime"];
                    else{
                        echo "<label style='color: red'>Please select your ending time</label><br><br>";
                        $continue = false;
                    }
                }
            ?>
            <input class="submit" type="submit" name="submit" value="Submit">     
            <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
            </form>

            <form action="Homepage.php" method="get">
                    <button type="submit" class="button">Back to homepage</button>
                    <button type="submit" class="button" formaction="Profile/profile.php">Back to profile</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    $starttime = strtotime($Stime);
                    $endtime = strtotime($Etime);
                    $duration = $endtime - $starttime;
                    $minutes = $duration / 60;
                    if ($minutes < 0){
                        echo "<Label>Starting should not be after Ending time<br>If you have exercised overnight
                            <br>Please record your exercises seperately for each day<br><br>Example: Record From 10pm to 11:59pm for day 1 and 00am to 2am for day 2</label><br><br>";
                        $continue = false;
                    }
                    else if ($minutes == 0){
                        echo "<Label>Please do not record an exercise that lasted 0 minutes</label><br><br>";
                        $continue = false;
                    }
                    else{
                        echo "<Label>You have exercised for $minutes minutes</label><br><br>";
                    }
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    $dbconnect = include("Profile/databaseconnect.php");
                    $query = "INSERT INTO work_outs VALUES (:usrid, :update_date, :Stime, :Etime, :Wo_type, :duration)";
                    $prep = $dbconnect->prepare($query);
                    $prep->bindParam(":usrid", $_SESSION["Usr_id"]);
                    $prep->bindParam(":update_date", $date);
                    $prep->bindParam(":Stime", $Stime);
                    $prep->bindParam(":Etime", $Etime);
                    $prep->bindParam(":Wo_type", $exercise);
                    $prep->bindParam(":duration", $minutes);
                    try{
                        if($prep->execute())
                            echo "<Label>Your exercise session has been saved</label>";
                    }catch(Exception $e){
                        if (strpos($e, "Duplicate entry"))
                            echo "<Label style = 'color: brown'>You have already saved an exercise for this time period<br><br>
                                Please save your other sessions at another time slot or insert multiple exercise types at once when saving</label>";
                    }
                }
            ?>
            <h3>Why is exercise important</h3>
            <h4>
                Regular physical activity can improve your muscle <br>
                strength and boost your endurance. Exercise sends oxygen <br>
                and nutrients to your tissues and helps your <br>
                cardiovascular system work more efficiently. And when <br>
                your heart and lung health improve, you have more <br>
                energy to tackle daily chores.
            </h4>
            <h3>Why it is important to record what exercise you did</h3>
            <h4>
            Keeping track of your workouts allows you to assess the <br>
            progress you've made. By analysing your tracked data, <br>
            you can identify patterns, strengths, and areas that may <br>
            need a bit of improvement.
            </h4>
        </div>
</body>
</html>