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
        }
        $drid = 3;
    ?>
<head>
    <style>
        header{
            position: relative;
            bottom: 25  0px;
            left: 303px;

        }
    </style>
</head>
<body>
    <header><div>Come meet Coach Abriel</div></header>
</body>
</html>
<?php
    include("form.php");
?>