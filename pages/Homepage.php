<!DOCTYPE html>
<html>
<?php
    session_name("profile");
    session_start();
    if (!isset($_SESSION["submitted"])){
        $_SESSION["submitted"] = 0;
    }
    else{
        $_SESSION["submitted"]++;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (!isset($_SESSION["Usr_id"]))
        {
            header("Location: Profile/Assignmentloginpage.php");
            exit();
        }
        if ($_SESSION["submitted"] != $_POST["submitted"])
        {
            header("Location: Homepage.php");
            exit();
        }
    }
    include ("Styling/header.php");
?>

<?php
    if (!isset($_SESSION["submitted"])){
        $_SESSION["submitted"] = 0;
    }
    else{
        $_SESSION["submitted"]++;
    }
?>
    <div class="button-container">
    <a href="Water.php"><button class="water">
            <video autoplay muted loop>
                <source src="water.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <span>WATER</span>
        </button></a><br>
        <a href="Exercise.php"><button class="exercise">
            <video autoplay muted loop>
                <source src="run.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <span>EXERCISE</span>
        </button></a><br>
        <a href="BMI.php"><button class="bmi">
            <video autoplay muted loop>
                <source src="bmi.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <span>BMI/WEIGHT</span>
        </button></a><br>
    </div>
</body>
<?php
    include("MeetUpRequest.php");
    include("class.php");
    include ("Styling/footer.php");
?>


