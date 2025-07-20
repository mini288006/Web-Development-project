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
            background-color: #f7f9fc;
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
            background-color: #2c3e50;
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
            width: 100px;
            height: 100px;
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $selectedDay = $_POST['day'];
    echo "You selected: " . htmlspecialchars($selectedDay) . "<br>";

    $membershipStatus = $_POST['membership'];
    echo "Membership status: " . htmlspecialchars($membershipStatus) . "<br>";
}
?>
<div class="container">
    <!-- Left Section -->
    <div class="info-box">
        <h1>Analytics 101</h1>
        <p>This free workshop shows you how to track important metrics in your business.</p>
        <img src="https://via.placeholder.com/100" alt="Host Image" />
        <div class="host-name">Jane Smith</div>
        <div>CEO, Company</div>
    </div>

    <!-- Right Section -->
    <div class="form-box">
        <h1>Register now</h1>
        <label>Enter your information to register for the workshop</label>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="fname" placeholder="First name" required pattern="[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*" />
            <input type="text" name="lname" placeholder="Last name" required pattern="[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*" />
            <input type="email" name="email" placeholder="Your email" required />
            <label for="day">Select Day:</label>
            <select name="day" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <div class="radio-group">
            <label>Membership</label>
                <input type="radio" name="membership" value="yes" checked /> 
            </label>
            <label>Non-membership</label>
                <input type="radio" name="membership" value="no" />
            </label> 
        </div>
        <button type="submit">Register</button>
    </form>
    </div>
</div>
</body>
</html>