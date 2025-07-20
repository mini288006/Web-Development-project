<!DOCTYPE html>
<html>
<head>
<style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #E0F7FA;
        }

        /* Main container for the two columns */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0 auto;
        }

        /* Left side (info section) styling */
        .info-box {
            background-color: #43A047;
            color: white;
            padding: 50px;
            flex: 1;
            text-align: center;
            min-width: 300px;
        }

        .info-box h1 {
            margin-bottom: 20px;
            font-size: 28px;
        }

        .info-box p {
            margin-bottom: 20px;
        }

        .info-box img {
            width: auto;
            height: 100px;
            object-fit: cover; 
            border-radius: 50%; 
            margin-bottom: 10px;
        }

        .info-box .host-name {
            font-size: 18px;
            font-weight: bold;
        }

        /* Right side (form section) styling */
        .form-box {
            background-color: white;
            padding: 50px;
            flex: 1;
            min-width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-box h3 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-box label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #333;
        }

        .form-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-box input[type="submit"] {
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .form-box input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .form-box a {
            color: #3498db;
            font-size: 14px;
            text-decoration: none;
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .form-box a:hover {
            text-decoration: underline;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .info-box,
            .form-box {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Left Section -->
    <div class="info-box">
        <h1>Huan Fitness Pal</h1>
        <p>"Your Ultimate Guide to Fitness: Workouts, Nutrition, and Wellness Tips for a Healthier You!"</p>
        <a href = "../Homepage.php"><img src="../weblogo.webp" alt="Logo" /></a>
    </div>

    <!-- Right Section -->
    <div class="form-box">
        <h3>Log in</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <label for="email">Email/Username</label>
            <input type="text" name="Email" placeholder="abc@gmail.com / username" required>
            <?php
                session_name("profile");
                session_start();
                if (isset($_SESSION["Usr_id"])){
                    header("Location: profile.php");
                    exit();
                }
                session_write_close();
                session_name("login");
                session_start();
                if (!isset($_SESSION["submitted"])){
                    $_SESSION["submitted"] = 0;
                }
                else{
                    $_SESSION["submitted"]++;
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    if ($_SESSION["submitted"] != $_POST["submitted"])
                    {
                        header("Location: Assignmentloginpage.php");
                        exit();
                    }
                    $dbconnect = include("databaseconnect.php");
                    if ($dbconnect){
                        if (isset($_POST["Email"])){
                            $login = $_POST["Email"];
                            $loginquery = "SELECT Usr_id FROM users
                                WHERE Usr_username = '$login'
                                UNION
                                SELECT Usr_id FROM users
                                WHERE email = '$login';";
                            $loginresult = $dbconnect->query($loginquery);
                            $idfound = $loginresult->fetch(PDO::FETCH_ASSOC);
                            if ($idfound == null){
                                echo "username or email not found";
                            }
                        }
                        else
                            echo "no login provided";
                    }
                }
            ?>
            <label for="password">Password</label>
            <input type="password" name="Password" placeholder="Enter your account password" required>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    if ($dbconnect){
                        if ($idfound != null){
                            $idfound = $idfound["Usr_id"];
                            if (isset($_POST["Password"])){
                                $passquery = "SELECT * FROM users
                                    WHERE Usr_id = '$idfound';";
                                $passresult = $dbconnect->query($passquery);
                                $passfound = $passresult->fetch(PDO::FETCH_ASSOC);
                                if ($_POST["Password"] != $passfound["pass"])
                                    echo "password incorrect";
                                else
                                {
                                    session_unset();
                                    session_write_close();
                                    session_name("profile");
                                    session_start();
                                    $_SESSION["Usr_id"] = $passfound["Usr_id"];
                                    $_SESSION["Usr_username"] = $passfound["Usr_username"];
                                    $_SESSION["email"] = $passfound["email"];
                                    $_SESSION["contact"] = $passfound["contact"];
                                    $_SESSION["Fname"] = $passfound["Fname"];
                                    $_SESSION["Lname"] = $passfound["Lname"];
                                    $_SESSION["amountowe"] = $passfound["amountowe"];
                                    header("Location: profile.php");
                                    exit();
                                }
                            }
                        }
                    }
                    else{
                        echo "Connection has failed, please try again later";
                    }
                }
            ?>
            <input type="submit" name="Login" value="Login">
            <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
        </form>
        
        <a href="webAssignment_Verification.html"><small>Forgot Password?</small></a>
        <a href="AssignmentRegisterPage.php"><small>No Account? Sign Up Now!</small></a>
    </div>
</div>
</body>
</html>
