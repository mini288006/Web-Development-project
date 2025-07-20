<!DOCTYPE html>
<html>
    
<head>
<style>
    body{
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        right: 150px;
        background-color: #4A628A;
    }
    .container{
        text-align: left;
        padding: 20px;
        width: 500px;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: #B0C1D8;
    }
    .container h2{
        margin: 0px;
        text-align: center;
    }
    .form{
        border: inset;
    }
    header{
        text-align: left;
        font-size: 30px;
    }
    form{
        text-align: left;
        font-size: 20px;
    }
    .submit{
        width: 15%;
        height: 23px;
        background-color: #A3B3D1;
        font-size: 15px;
        border-radius: 10px;
    }
    .request{
        border: inset;
        width: 400px;
        height: 50px;
    }
    .button{
        position: relative;
        width: 35%;
        height: 23px;
        bottom: 25px;
        left: 85px;
        background-color: #A3B3D1;
        font-size: 15px;
        border-radius: 10px;
    }
    .submit:hover{
        background-color: #8493B0;
    }
    .button:hover{
        background-color: #8493B0;
    }
    .date{
        color: red;
    }
    </style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="container">
            <h2>Meet up request form</h2>
            <label for="Date">
                Choose the best date for your appointment:
            </label><br>

            <input type="date" name="date" class="form"><br>
            <div class="date">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['submit'])){

                        $date = $_POST["date"];

                        if(empty($date)){
                            echo"*Please Choose a Date* <br>";
                            $accept = false;
                        }
                        else
                            $accept = true;
                    }
                }
                ?>
            </div>

            <label for="time">
                Please choose your preferred time:
            </label><br>
            <select name="time" class="form">
                <option value="8am-9:30am">8 a.m. - 9:30 a.m.</option>
                <option value="9:30am-11am">9:30 a.m. - 11 a.m.</option>
                <option value="11am-12:30pm">11 a.m. - 12:30 p.m.</option>
                <option value="1:30pm-3pm">1:30 p.m. - 3 p.m.</option>
                <option value="3pm-4:30">3 p.m. - 4:30 p.m.</option>
                <option value="4:30pm-6pm">4:30 p.m. - 6 p.m.</option>
                <option value="7pm-8:30pm">7 p.m. - 8:30 p.m.</option>
                <option value="8:30pm-10pm">8:30 p.m. - 10 p.m.</option>
            </select> <br>
                
            <label>Reasons for visit:</label><br>
            <textarea name="reason" placeholder="Please briefly explain why you are visiting" class="form"></textarea><br>

            <label>Any special request:</label><br>
            <textarea name="request" class="request" placeholder="If you have any request please do specify" class="form"></textarea><br>

            <input class="submit" type="submit" name="submit" value="Submit">     
            <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
            </form>

            <form action="Homepage.php" method="get">
                    <button type="submit" class="button">Back to homepage</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $accept == true){
                $usrid = $_SESSION["Usr_id"];
                $time = $_POST["time"];
                $reason = "";
                $request = "";
                if (isset($_POST["reason"]))
                    $reason = $_POST["reason"];
                if (isset($_POST["request"]))
                    $request= $_POST["request"];
                $dbconnect = include("Profile/databaseconnect.php");
                $query = "SELECT * FROM meet_ups WHERE Usr_id = :usrid AND Meet_Time = :mtime AND Meet_Date = :mdate";
                $prep = $dbconnect->prepare($query);
                $prep->bindParam(":usrid", $usrid);
                $prep->bindParam(":mtime", $time);
                $prep->bindParam(":mdate", $date);
                $prep->execute();
                $row = $prep->fetch(PDO::FETCH_ASSOC);
                if ($row)
                    echo "You have already booked this time slot, please try requesting another time slot";
                else{
                    $query = "INSERT INTO meet_ups (Usr_id, Dr_id, Meet_Time, Meet_Date, Meet_description, Meet_request) VALUES (:usrid, :drid, :mtime, :mdate, :reason, :request)";
                    $prep = $dbconnect->prepare($query);
                    $prep->bindParam(":usrid", $usrid);
                    $prep->bindParam(":drid", $drid);
                    $prep->bindParam(":mtime", $time);
                    $prep->bindParam(":mdate", $date);
                    $prep->bindParam(":reason", $reason);
                    $prep->bindParam(":request", $request);
                    if($prep->execute())
                    {
                        echo"Thank you for you Submission!!<br>
                                We will review your submission <br>
                                and get too you as soon as possible";
                    }
                    else
                        echo "There was an error while submitting your request<br>
                                Please try again Later";
                }
            }
            ?>
        </div>
        <?php
            
        ?>

</body>
</html>
