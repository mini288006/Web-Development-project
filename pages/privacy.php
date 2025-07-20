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

        footer {
            background-color: #957DFA;
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

        /* Profile Icon Fix */
        .fa-user {
            margin-right: 8px;
        }
        .container{
            padding: 40px;
            background-color: #43A047; /* Match header color */
            border-radius: 30px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            max-width: 800px;
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
        <p style="color:white;  font-family: 'Playfair Display', cursive;">At Huan Fitness Pal, your privacy is our priority. We are committed to safeguarding your personal information
             and ensuring your data remains secure. When you use our platform, we may collect limited personal details, such as your 
             name, email address, and fitness preferences, to enhance your experience and deliver tailored services. We do not share,
              sell, or distribute your information to third parties without your explicit consent. All data is stored securely,
               and we utilize the latest encryption technologies to protect against unauthorized access. By using our website,
             you agree to our privacy practices outlined in this policy. If you have any questions, feel free to contact us at HuanPal@gmail.com.
             You have full control over your personal information and can update or delete your account details at any time through your profile settings.
              We may use cookies and tracking technologies to improve website functionality, analyze usage trends, and provide a personalized experience,
               but you can manage your preferences in your browser settings. Our Privacy Policy is periodically reviewed and updated to comply with legal standards and best practices,
                and any changes will be communicated clearly on this page. Your trust matters to us, and we are dedicated to providing a secure and transparent environment for your fitness journey.
             </p>
        </div>
        
</body>

<?php
    include ("Styling/footer.php");
?>

</html>