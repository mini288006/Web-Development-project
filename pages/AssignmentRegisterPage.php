<!DOCTYPE html>
<html>
<head>
<style>
        .form-box .radio-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .radio-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #333;
        }

        .radio-group input[type="radio"] {
            margin-right: 10px;
            vertical-align: middle;
        }       
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

        .form-box h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-box label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #333;
        }

        .form-box input,
        .form-box select,
        .form-box button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .gender, .gender label, .gender input[type=radio]{
                    text-align: center;
                    width: auto;
                    display: inline-block;
        }


        .form-box button {
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .form-box button:hover {
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
<?php
session_name("profile");
session_start();
if (isset($_SESSION["Usr_id"])){
    header("Location: profile.php");
    exit();
}
if (!isset($_SESSION["submitted"])){
    $_SESSION["submitted"] = 0;
}
else{
    $_SESSION["submitted"]++;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION["submitted"] != $_POST["submitted"])
    {
        header("Location: AssignmentRegisterPage.php");
        exit();
    }
    $fname = $_REQUEST["fname"];
    if (!preg_match("/^[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*$/", $fname)) {
        echo "* The name $fname is invalid. Please enter a valid name.<br>";
    }

    $lname = $_REQUEST["lname"];
    if (!preg_match("/^[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*$/", $lname)) {
        echo "* The name $lname is invalid. Please enter a valid name.<br>";
    }

    $email = $_REQUEST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "* The email $email is invalid. Please enter a valid email.<br>";
    }

    $usrname = $_REQUEST["usrname"];
    if (!preg_match("/^[^\s]{0,20}$/", $usrname)) {
        echo "* The username $usrname is must not have spaces. Please enter a valid username.<br>";
    }

    if ($_REQUEST["phone"] != ""){
        $phone = $_REQUEST["phone"];
        if (!preg_match("/^\+60(\d{1,2}-\d{7,8}|\d{3}-\d{7,8})$/", $phone)) {
            echo "* The phone number $phone does not match the required format (+60 format).<br>";
        }
    }

    // Validate password
    $password = $_REQUEST["password"];
    if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}/", $password)) {
        echo "* The password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character (@#$%^&+=).<br>";
    }

    $gender = $_REQUEST["gender"];

    if (empty($errors)) {
        if (!isset($phone))
			$phone = null;
        try{
            $password = password_hash($_REQUEST['password'], PASSWORD_BCRYPT);
            include("saveinfo.php");
            saveinfo($fname, $lname, $usrname, $phone, $email, $gender, $password);
            $dbconnect = include("databaseconnect.php");
            $passfound = "SELECT * FROM users WHERE Usr_username = '$usrname'";
            $passfound = $dbconnect->query($passfound);
            $passfound = $passfound->fetch(PDO::FETCH_ASSOC);
            $_SESSION["Usr_id"] = $passfound["Usr_id"];
            $_SESSION["Usr_username"] = $passfound["Usr_username"];
            $_SESSION["email"] = $passfound["email"];
            $_SESSION["contact"] = $passfound["contact"];
            $_SESSION["Fname"] = $passfound["Fname"];
            $_SESSION["Lname"] = $passfound["Lname"];
            $_SESSION["amountowe"] = $passfound["amountowe"];
            header("Location: ../Homepage.php");
            exit();
        } catch (Exception $e){
            if (strpos($e, "key 'Usr_username'"))
                echo "Current username already in use, please try another username";
            else if (strpos($e, "key 'email'"))
                echo "Current email already in use, please try another email";
            else
                echo "Register failed, Please try again later";
        }
    } else {
        // Display errors
        echo "<h2>Errors in Submission</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}

?>
<div class="container">
    <!-- Left Section -->
    <div class="info-box">
        <h1>Huan Fitness Pal</h1>
        <p>"Your Ultimate Guide to Fitness: Workouts, Nutrition, and Wellness Tips for a Healthier You!"</p>
        <a href = "../Homepage.php"><img src="../weblogo.webp" alt="Logo" /></a>
    </div>

    <!-- Right Section -->
    <div class="form-box">
        <h1>Register now</h1>
        <label>Enter your information to register for the workshop</label><br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="lname">First name:</label>
            <input type="text" name="fname" placeholder="First name" required pattern="[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*" />
            <label for="lname">Last name:</label>
            <input type="text" name="lname" placeholder="Last name" required pattern="[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*" />
            <label for="usrname">Username:</label>
            <input type="text" name="usrname" placeholder="Username" required pattern="[^\s]{,20}" />
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Your email" required />
            <div class="gender">
                <label for="gender">Gender:</label>
                <label for="genderm">Male</label>
                <input type="radio" id = "genderm" name="gender" value = "M" required style=""/>&nbsp&nbsp
                <label for="genderf">Female</label>
                <input type="radio" id = "genderf" name="gender" value = "F" required />&nbsp&nbsp
                <label for="gendero">Other</label>
                <input type="radio" id = "gendero" name="gender" value ="O" required />
			</div>
            <label for="phone">Phone Number(Optional):</label>
            <input type="tel" name="phone" id="phone" placeholder="Phone number (+60 format)" pattern="^\+60(\d{1,2}-\d{7,8}|\d{3}-\d{7,8})$" />
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required minlength="8" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" />
            <p style="font-size: 12px; color: gray; margin-top: -15px;">
             Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character (@#$%^&+=).
            </p>
            <button type="submit">Register</button>
            <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
        </form>
        <a href="Assignmentloginpage.php"><small>Already have an account? Login instead!</small></a>
    </div>
</div>
</body>
</html>
