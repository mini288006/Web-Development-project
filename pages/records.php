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
        .container{
            text-align: center;
            height: auto;
        }
        footer {
            position:relative;
	        width:100%;
            background-color: #43A047;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            top: 250px;
            height: 100px;
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
        .navlink {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        .navlink li {
            display: inline-block;
            padding: 0 20px;
        }

        .navlink li a {
            text-decoration: none;
            color: rgb(255, 255, 255);
            font-family: "Montserrat", sans-serif;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            padding: 20px;
            margin-right: 10px;
        }

        .navlink li a:hover {
            background-color: #75e6ff;
        }

        /* Profile Icon Fix */
        .fa-user {
            margin-right: 8px;
        }
        table, th, td{
            border: solid #AFC8E6;
            border-radius: 10px;
            background-color: #E0E0E0;
            color: #3F51B5;
            text-align: center;
        }
        .table{
            display: flex;
            justify-content: center; 
            align-items: center;
        }
        .home_button{
            position: relative;
            left: 1002px;
            height: auto;
        }
        button{
            background-color: #A3B3D1;
            font-size: 14px;
            border-radius: 10px;
            width: 120px;
        }
    </style>
</head>

<header>
    <div class="Logo">
        <img class="logo" src="weblogo.webp">
        <h1 class="title">Huan Fitness Pal</h1>
    </div>

    <!-- Nav bar -->
    <div class="navbar">
        <nav>
            <ul class="navlink">
                <li><a href=""><i class="fa-solid fa-house"></i></i></i></a></li>
                <li><a href=""><i class="fa-solid fa-handshake"></i></i></a></li>
                <li><a href=""><i class="fa-solid fa-circle-info"></i></a></li>
                <li><a href=""><i class="fa-solid fa-phone"></i></i></a></li>
                <li><a href=""><i class="fa fa-user"></i></a></li>
            </ul>
        </nav>
    </div>
</header>

<body>
    <div class="container">
            <h1>Your Records</h1><br>
            <h2>Your Water Intake Records</h2>
            <div class="table">
            <table style="width: 30%;">
                <tr>
                    <th>Amount of water in litre</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td>hi</td>
                    <td>hi</td>
                </tr>
            </table>
            </div>
            <h2>Your BMI</h2>
            <div class="table">
            <table style="width: 50%;">
                <tr>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>BMI</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td>hi</td>
                    <td>hi</td>
                    <td>hi</td>
                    <td>hi</td>
                </tr>
            </table>
            </div>
            <h2>Exercise Records</h2>
            <div class="table">
            <table style="width: 50%;">
                <tr>
                    <th>Type's of exercise</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td>hi</td>
                    <td>hi</td>
                    <td>hi</td>
                    <td>hi</td>
                </tr>
            </table>
            </div>
    </div>
    <br>
    <div class="home_button">
        <a href="Homepage.php"><button>Back to Homepage</button></a>
    </div>
</body>
<footer>
        <div class="footer_content">
            <ul>
                <a href=""><li>Address</li></a>
                <a href=""><li>Terms & Condition</li></a>
                <a href=""><li>Privacy Policy</li></a>
            </ul>
        </div>
</footer>
</html>