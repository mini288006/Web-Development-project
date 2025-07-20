<!DOCTYPE html>
<html>

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

        /* Profile Icon Fix */
        .fa-user {
            margin-right: 8px;
        }
        .container{
            padding:40px;
        }
        footer {
            background-color: #43A047;
            padding: 20px;
            text-align: center;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
            flex-shrink: 0; /* Prevent footer from shrinking */
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
    </style>
</head>
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
<head>
    <style>
        header{
            margin: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
        <address style="color:white">
                1234 Wellness Avenue<br>
                FitZone District<br>
                Springfield, 435660<br>
                Malaysia<br>
                <br>
                Opening Hours:<br>
                Monday - Friday: 6:00 AM - 10:00 PM<br>
                Saturday - Sunday: 7:00 AM - 8:00 PM<br><br>

                </address>
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?..." width="100%" height="800"></iframe>
            </div>
        </div>
</body>

<?php
    include ("Styling/footer.php");
?>

</html>