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
<head>
    <meta content="zh-cn" http-equiv="Content-Language" />
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huan Fitness Pal</title>
    <style>
body {
    font-family: Century, sans-serif;
    background-color: #4A628A;
    margin: 0;
    padding: 0;
    color: #fff; /* Adjusted for contrast against dark background */
    box-sizing: border-box;
}

h1, h2 {
    color: #014b5b;
    font-family: 'Playfair Display', cursive;
    margin-bottom: 20px;
    font-size: 24px; /* Uniform font size for headers */
    letter-spacing: 0.5px;
}

p, ul {
    margin: 10px 0;
    font-size: 16px;
    line-height: 1.8;
}
* {
            margin: 0;
            padding: 0;
            font-family: Century;
            box-sizing: border-box;
            list-style: none;
            text-decoration: none;
        }

        footer{
            display: block;
            padding-bottom:100px;
        }
.footer_content{
	top:0px;
}
        /* Profile Icon Fix */
        .fa-user {
            margin-right: 8px;
        }
.container {
    padding: 40px;
    background-color: #43A047; /* Match header color */
    border-radius: 30px;
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
    margin: 20px auto;
    max-width: 800px;
}
    header{
        margin: 40px;
        text-align: center;
    }
    </style>
</head>


    <?php
        if (!isset($_SESSION["submitted"])){
            $_SESSION["submitted"] = 0;
        }
        else{
            $_SESSION["submitted"]++;
        }
    ?>
<body>
<div class="container">
<body>
    <h1>Terms and Conditions</h1>
    <p><strong>Last Updated:</strong> 26 November 2024</p>
    <p>Welcome to Huan Fitness Pal. By accessing or using our website, you agree to comply with and be bound by the following Terms and Conditions. Please read them carefully before using our services.</p>
    <h2>1. Acceptance of Terms</h2>
    <p>By accessing or using Huan Fitness Pal and its services, you agree to be legally bound by these Terms and Conditions and our Privacy Policy. If you do not agree, you must discontinue use of our website and services.</p>
    <h2>2. Eligibility</h2>
    <p>You must be at least 18 years old to use our services. By using the site, you confirm that you meet this age requirement.</p>
    <h2>3. User Accounts</h2>
    <ul>
        <li><strong>Account Creation:</strong> To access certain features, you may need to create an account. You are responsible for maintaining the confidentiality of your login credentials.</li>
        <li><strong>Account Responsibility:</strong> You agree to provide accurate and up-to-date information and to promptly update your details if they change.</li>
        <li><strong>Account Termination:</strong> We reserve the right to suspend or terminate your account for violations of these Terms.</li>
    </ul>
    <h2>4. Use of Services</h2>
    <p>You may use our services for personal, non-commercial purposes only. You agree not to:</p>
    <ul>
        <li>Use our platform for any unlawful or fraudulent purposes.</li>
        <li>Attempt to interfere with or disrupt the website’s functionality.</li>
        <li>Reproduce, duplicate, or exploit any portion of the site without our written permission.</li>
    </ul>
    <h2>5. Health Disclaimer</h2>
    <p>The content and information on our website are for general informational purposes and are not intended as medical advice. Always consult with a qualified healthcare professional before beginning any fitness program. We are not responsible for injuries or health issues resulting from your use of our services.</p>
    <h2>6. Payment and Subscriptions</h2>
    <p>Certain services may require payment or subscription. Prices are subject to change without prior notice.</p>
    <h2>7. Intellectual Property</h2>
    <p>All content on the website, including text, graphics, logos, and software, is the property of Huan Fitness Pal or its licensors and is protected by intellectual property laws. You may not use, reproduce, or distribute any content without our written consent.</p>
    <h2>8. Third-Party Links</h2>
    <p>Our website may contain links to third-party websites. We are not responsible for the content, policies, or practices of these websites. Accessing third-party links is at your own risk.</p>
    <h2>9. Limitation of Liability</h2>
    <p>To the fullest extent permitted by law, Huan Fitness Pal and its affiliates shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from:</p>
    <ul>
        <li>Your use or inability to use the website.</li>
        <li>Any unauthorized access to or alteration of your data.</li>
    </ul>
    <h2>10. Indemnification</h2>
    <p>You agree to indemnify and hold harmless Huan Fitness Pal and its affiliates from any claims, losses, damages, liabilities, and expenses arising from:</p>
    <ul>
        <li>Your violation of these Terms.</li>
        <li>Your use of the website or services.</li>
    </ul>
</body>
</div>
</body>

<?php
    include ("Styling/footer.php");
?>

</html>