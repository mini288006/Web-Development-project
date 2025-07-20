<!DOCTYPE html>
<html lang="en">
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
            <h2>Water Intake Records</h2>
            <label>Please choose a date:</label><br>
            <input type="date" name="date" class="form" ><br>
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
            <label>Please enter how much water intake that day:</label><br>
            <input type="number" name="water" class="form" placeholder="In Litre"><br><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["water"]) && !empty($_POST["water"]))
                        $water = $_POST["water"];
                    else{
                        echo "<label style='color: red'>Please insert your water intake for the day</label><br><br>";
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
                    $dbconnect = include("Profile/databaseconnect.php");
                    $query = "INSERT INTO water VALUES (:usrid, :update_date, :water)";
                    $prep = $dbconnect->prepare($query);
                    $prep->bindParam(":usrid", $_SESSION["Usr_id"]);
                    $prep->bindParam(":update_date", $date);
                    $prep->bindParam(":water", $water);
                    try{
                        if($prep->execute())
                            echo "<Label>Your water intake has been saved</label>";
                    }catch(Exception $e){
                        if (strpos($e, "Duplicate entry"))
                            echo "<Label style = 'color: brown'>You have already saved your water intake on that day<br>
                                To ensure consistancy please only update your water intake once per day</label>";
                    }
                }
            ?>
            <h3>Why is drinking water important</h3>    
            <h4>
                It plays a key role in many of our body's functions, <br>
                including bringing nutrients to cells, getting rid of wastes, <br>
                protecting joints and organs, and maintaining body <br>
                temperature.
            </h4>
            <h3>Why we record our customer's water intake</h3>
            <h4>
                Recording of intake helps to ensure that the patient has a <br>
                proper intake of fluid and recording of output helps to <br>
                determine whether there is an adequate output of urine & <br>
                normal defecation.
            </h4>
        </div>
</body>
</html>