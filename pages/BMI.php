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
            <h2>BMI Calculator</h2>
            <label>Please choose which date you did you workout/exercise:</label><br>
            <input type="date" name="date" ><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["date"]) && !empty($_POST["date"]))
                    {
                        $date = $_POST["date"];
                    }
                    else{
                        echo "<label style='color: red'>Please insert your record date</label><br><br>";
                        $continue = false;
                    }
                }
            ?>
            <label>Please enter your current weight:</label><br>
            <input type="number" name="weight" class="form" placeholder="Weight in KG"><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["weight"]) && !empty($_POST["weight"]))
                    {
                        $weight = $_POST["weight"];
                    }
                    else{
                        echo "<label style='color: red'>Please insert your current weight</label><br><br>";
                        $continue = false;
                    }
                }
            ?>
            <label>Please enter your current height</label><br>
            <input type="number" name="height" class="form" placeholder="Height in CM"><br><br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $continue)
                {
                    if (isset($_POST["height"]) && !empty($_POST["height"]))
                        $height = $_POST["height"];
                    else{
                        echo "<label style='color: red'>Please insert your current height</label><br><br>";
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
                    $BMI = $weight / (($height / 100) * ($height / 100) );
                    echo "<label>Your current BMI: ";
                    echo $BMI;
                    echo "</label><br>";
                    $dbconnect = include("Profile/databaseconnect.php");
                    $query = "INSERT INTO physical (Usr_id, Update_date, Usr_weight, Usr_height, BMI) VALUES (:usrid, :update_date, :usrweight, :usrheight, :BMI)";
                    $prep = $dbconnect->prepare($query);
                    $prep->bindParam(":usrid", $_SESSION["Usr_id"]);
                    $prep->bindParam(":update_date", $date);
                    $prep->bindParam(":usrweight", $weight);
                    $prep->bindParam(":usrheight", $height);
                    $prep->bindParam(":BMI", $BMI);
                    try{
                        if($prep->execute())
                            echo "<Label>Your physical condition has been saved</label>";
                    }catch(Exception $e){
                        if (strpos($e, "Duplicate entry"))
                            echo "<Label style = 'color: brown'>You have already saved your physical condition on that day<br>
                                To ensure consistancy please only update your physical condition once per day</label>";
                        else

                            echo $e;
                    }
                    $usrid = $_SESSION["Usr_id"];
                    $lphysical = $dbconnect->query("SELECT Usr_weight, Usr_height FROM physical 
                                                WHERE Usr_id = 1 
                                                AND Update_date = 
                                                (SELECT DISTINCT MAX(Update_date) FROM physical)");
                    $lphysical = $lphysical->fetch(PDO::FETCH_ASSOC);
                    $lweight = $lphysical["Usr_weight"];
                    $lheight = $lphysical["Usr_height"];
                    $query = "UPDATE users SET Usr_height = ($lheight), Usr_weight = ($lweight)";
                    $dbconnect->query($query);
                }
            ?>
            <h3>Here is the formula if you wish to calculate yourself and not save to your profile</h3>
            <h2 style = "color: green">(Weight kg) /<br>((Height m) * Height (m))</h2>
            <h3>Here is a reference chart</h3>
            <img src="BMI.gif" width="500px">
        </div>
</body>
</html>