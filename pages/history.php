<!DOCTYPE html>
<html>
<?php
session_name("profile");
session_start();
if (!isset($_SESSION["Usr_id"])) {
    header("Location: Profile/Assignmentloginpage.php");
    exit();
}
if (!isset($_SESSION["submitted"])) {
    $_SESSION["submitted"] = 0;
} else {
    $_SESSION["submitted"]++;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION["submitted"] != $_POST["submitted"]) {
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
}
include("Styling/header.php");
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
        .container {
            text-align: center;
            height: auto;
        }
        .search-container {
            text-align: center;
            margin: 20px 0;
        }
        .search-container input[type="date"] {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-container button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #43A047;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #2e7d32;
        }
        footer {
            position: relative;
            width: 100%;
            background-color: #43A047;
            padding: 20px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            top: 250px;
            height: 100px;
        }
        .footer_content {
            position: relative;
            text-align: center;
            top: 20px;
        }
        .footer_content li {
            display: inline-block;
            width: 200px;
            font-size: 20px;
        }
        table, th, td {
            border: solid #AFC8E6;
            border-radius: 10px;
            background-color: #E0E0E0;
            color: #3F51B5;
            text-align: center;
        }
        .table {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        button {
            background-color: #A3B3D1;
            font-size: 14px;
            border-radius: 10px;
            width: 120px;
        }
        header{
            margin: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your History</h1><br>
        <!-- search bar -->
        <!-- <div class="search-container">
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="date" name="search_date" placeholder="Search by Date" />
                <button type="submit">Search</button>
            </form>
        </div> -->
        <div class="search-container">
            <?php
                $search = "";
                if (isset($_GET["search"]) || isset($_GET["search_date"])){
                    if (isset($_GET["search_date"]))
                        $search = $_GET["search_date"];
                }
                if (isset($_GET["clear"])){
                    if(isset($_GET["search_date"])){
                        $_GET["search_date"] = "";
                        $search = "";
                    }
                }
            ?>
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="date" name="search_date" value = "<?php echo $search; ?>" />
                <button type="submit" name="search">Search</button>
                <button type="submit" name="clear">Clear</button>
            </form>
        </div>
        <h2>Your Previous/Booked Appointment</h2>
        <div class="table">
            <table style="width: 70%;">
                <tr>
                    <th>Doctor</th>
                    <th>Reason of Visit</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Cancel<br>Appointment</th>
                </tr>
                <?php
                $dbconnect = include("Profile/databaseconnect.php");
                $usrid = $_SESSION["Usr_id"];
                $search_date = isset($_GET['search_date']) ? trim($_GET['search_date']) : '';

                // Query for appointments
                $query = "SELECT M.Usr_id, M.Dr_id, D.Fname, D.Lname, M.Meet_description, M.Meet_Date, M.Meet_Time, M.meet_status
                          FROM doctors D INNER JOIN meet_ups M ON D.Dr_id = M.Dr_id
                          WHERE M.Usr_id = :usrid";

                if (!empty($search_date)) {
                    $query .= " AND M.Meet_Date = :search_date";
                }
                $query .= " ORDER BY M.Meet_Date DESC, M.Meet_Time DESC";

                $prep = $dbconnect->prepare($query);
                $prep->bindParam(':usrid', $usrid);
                if (!empty($search_date)) {
                    $prep->bindParam(':search_date', $search_date);
                }
                $prep->execute();
                $rows = $prep->fetchAll();

                foreach ($rows as $index => $row) {
                    $drname = $row["Fname"] . " " . $row["Lname"];
                    $reason = !empty($row["Meet_description"]) ? $row["Meet_description"] : "NONE";
                    $cancel = "";
                    $curphp = $_SERVER["PHP_SELF"];
                    if ($row["meet_status"] == "pending" || $row["meet_status"] == "approved") {
                        $cancel = "<form id='appointment$index' action=$curphp method='post'>
                            <button name='ap' value='$index' onclick='return confirm(\"Are you sure you want to cancel this appointment?\")'>Cancel</button>
                            <input type='hidden' name='submitted' value='" . ($_SESSION["submitted"] + 1) . "'></form>";
                    }
                ?>
                <tr>
                    <td><?php echo $drname; ?></td>
                    <td><?php echo $reason; ?></td>
                    <td><?php echo $row["Meet_Date"]; ?></td>
                    <td><?php echo $row["Meet_Time"]; ?></td>
                    <td><?php echo $row["meet_status"]; ?></td>
                    <td><?php echo $cancel; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <h2>Your Previous/Booked Classes/Sessions</h2>
            <div class="table">
            <table style="width: 50%;">
                <tr>
                    <th>Class/Session</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                </tr>
                <?php
                    $dbconnect = include("Profile/databaseconnect.php");
                    $usrid = $_SESSION["Usr_id"];
                    $query = "SELECT C.Cls_name, C.Cls_price, T.Cls_date, T.Cls_time
                            FROM takes T INNER JOIN classes C ON C.Cls_id = T.Cls_id
                            WHERE Usr_id = 1 ORDER BY T.Cls_date desc, T.Cls_time desc";
                    $result = $dbconnect->query($query);
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    while ($row)
                    {
                ?>
                <tr>
                    <td><?php echo $row["Cls_name"];?></td>
                    <td><?php echo $row["Cls_date"];?></td>
                    <td><?php echo $row["Cls_time"];?></td>
                    <td><?php echo $row["Cls_price"];?></td>
                </tr>
                <?php
                        $row = $result->fetch(PDO::FETCH_ASSOC);
                    }
                    $query = "UPDATE "
                ?>
            </table>
        </div>
        <h3>Your Amount Due</h3>
        <?php
            $query = "SELECT amountowe FROM users WHERE Usr_id = $usrid";
            $result = $dbconnect->query($query);
            $amount = $result->fetch(PDO::FETCH_ASSOC)["amountowe"];
        ?>
        <div class="table">
            <table style="width: 30%;">
                <tr>
                    <th>Amount</th>
                    <th>RM <?php echo $amount;?></th>
                </tr>
            </table>
        </div>
</div>
    </div>
</body>
<footer>
    <div class="footer_content">
        <ul>
			<li><a href="Sponsor.php"><i class="fa-solid fa-handshake"></i></a><p>Sponsor</p></li>
			<li><a href="aboutUs.php"><i class="fa-solid fa-circle-info"></i></a><p>About Us</p></li>
            <a href="address.php"><li>Address</li></a>
            <a href="term.php"><li>Terms & Condition</li></a>
            <a href="privacy.php"><li>Privacy Policy</li></a>
        </ul>
    </div>
</footer>
</html>
