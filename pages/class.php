<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #4A628A;
        }

        h1 {
            text-align: center;
            font-size: 50px;
        }

        h2 {
            font-size: 25px;
            text-align: center;
        }
        h5{
            font-size: 25px;
        }

        .big_container,
        .big_container_2 {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .container {
            width: 600px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: row;
            padding: 20px;
            background-color: #B0C1D8;
        }

        .container img {
            width: 150px;
            height: 200px;
            border-radius: 10px;
        }

        .content {
            flex-grow: 1;
        }

        .content h1 {
            font-size: 20px;
            margin: 0 0 10px 0;
        }

        .content h3 {
            font-size: 16px;
            color: #555;
        }

        .dropdown_button {
            margin-top: 10px;
            background-color: #3675c2;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 110px;
            height: 30px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .dropdown_button:hover {
            background-color: #6b96c9;
            color: black;
        }

        .dropdown_content {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #8E9EBE;
            box-shadow: 0px 4px 8px rgba(0.5, 0.5, 0.5, 0.5);
        }

        .button_absolute input {
            background-color: #455171;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button_absolute input:hover {
            background-color: #7b90b8;
            color: black;
        }
        .date{
        color: red;
        }
        .submit:hover{
            background-color: #8493B0;
        }

        .submit{
        height: 23px;
        background-color: #A3B3D1;
        font-size: 15px;
        border-radius: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Want to join our classes and sessions?</h1>   
        <h2>Come have fun with us while having a good workout</h2><br>
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                include("saveClass.php");
                $dbconnect = include("Profile/databaseconnect.php");
                $usrid = $_SESSION["Usr_id"];
                $request = $_POST["reason"];
                $date = $_POST["date"];
                $time = $_POST["time"];
                if ($_POST["submit"] == "Book yoga class")
                    $classid = 1;
                else if ($_POST["submit"] == "Book kickboxing class")
                    $classid = 2;
                else if ($_POST["submit"] == "Book tabata class")
                    $classid = 3;
                else if ($_POST["submit"] == "Book pilates class")
                    $classid = 4;
                saveclass($usrid, $classid, $request, $date, $time, $dbconnect);
            }
        ?>
        <!-- Sample -->
        <div class="big_container">
            <div class="container">
                <div class="container_child" >
                    <h5>Yoga Classes</h5>
                </div>

                <div class="container_child" >
                    <img src="yoga.webp" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            Yoga Classes<br>
                            Guided Mind-Body Practice <br>
                            Focuses on flexibility, strength, relaxation <br>
                            and mindfulness through various poses and breathing techniques.
                        </h3>
                        <div class="dropdown" id="cl1">
                            <button class="dropdown_button" onclick="toggleDropdown('cl1')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                    <label for="Date">
                                        Choose the best date for your appointment:
                                    </label><br>

                                    <input type="date" name="date" class="form" required><br>
                                    <div class="date">
                                        <?php
                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            if(isset($_POST['submit'])){

                                            $date = $_POST["date"];

                                            if(empty($date)){
                                            echo"*Please Choose a Date* <br>";
                                            }
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
                                    </select><br>
                                    <label>Any special request:</label><br>
                                    <textarea name="reason" placeholder="If there is any request, please tell us" class="form"></textarea><br>
                                    <input class="submit" type="submit" name="submit" value="Book yoga class">
                                    <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1);?>">
                                    </form>
                                    </h4>
                                    <?php
            
                                    if(isset($_POST["submit"]) && $_POST["submit"] == "Book yoga class" && isset($date) && !empty($date)){
                                            
                                        echo"Thank you for you Submission!!<br>
                                             We will review your submission <br>
                                            and get too you as soon as possible";
                                        }
                                    ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="container_child">
                    <h5>Kick Boxing</h5>
                </div>

                <div class="container_child">
                    <img src="kickboxing.jpeg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            Kickboxing Classes <br>
                            High-Intensity Cardio Workout <br>
                            Combines martial arts techniques with cardio <br>
                            to improve strength, agility, and endurance.
                        </h3>
                        <div class="dropdown" id="cl2">
                            <button class="dropdown_button" onclick="toggleDropdown('cl2')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
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
                                            }
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
                                    </select><br>
                                    <label>Any special request:</label><br>
                                    <textarea name="reason" placeholder="If there is any request, please tell us" class="form"></textarea><br>
                                    <input class="submit" type="submit" name="submit" value="Book kickboxing class">
                                    <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
                                    </form>
                                    </h4>
                                    <?php
            
                                    if(isset($_POST["submit"]) && $_POST["submit"] == "Book kickboxing class" && isset($date) && !empty($date)){
                                        echo"Thank you for you Submission!!<br>
                                             We will review your submission <br>
                                            and get too you as soon as possible";
                                        }
                                    ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="big_container_2">
            <div class="container">
                <div class="container_child">
                    <h5>Tabata Session</h5>
                </div>
                <div class="container_child">
                    <img src="tabata.jpeg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>
                            Tabata Classes <br>
                            High-Intensity Interval Training <br>
                            Involves short bursts of intense exercise  <br>
                            followed by brief rest periods to improve cardiovascular fitness and burn fat.
                        </h3>
                        <div class="dropdown" id="cl3">
                            <button class="dropdown_button" onclick="toggleDropdown('cl3')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
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
                                            }
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
                                    </select><br>
                                    <label>Any special request:</label><br>
                                    <textarea name="reason" placeholder="If there is any request, please tell us" class="form"></textarea><br>
                                    <input class="submit" type="submit" name="submit" value="Book tabata class">
                                    <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
                                    </form>
                                    <?php
            
                                    if(isset($_POST["submit"]) && $_POST["submit"] == "Book tabata class" && isset($date) && !empty($date)){
                                            
                                        echo"Thank you for you Submission!!<br>
                                             We will review your submission <br>
                                            and get too you as soon as possible";
                                        }
                                    ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="container_child">
                    <h5>Pilates Session</h5>
                </div>
                <div class="container_child">
                    <img src="pilates.jpeg" height="200px" width="153.9px">
                    <div class="container_child" style="flex-grow: 1;">
                        <h3>     
                            Pilates Session <br>
                            Core Strength and Flexibility Training <br>
                            Focuses on controlled movements to improve posture,
                            flexibility, and core <br>
                            strength while promoting body alignment.
                        </h3>
                        <div class="dropdown" id="cl4">
                            <button class="dropdown_button" onclick="toggleDropdown('cl4')">show details</button>
                                <div class="dropdown_content">
                                    <h4>
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
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
                                            }
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
                                    </select><br>
                                    <label>Any special request:</label><br>
                                    <textarea name="reason" placeholder="If there is any request, please tell us" class="form"></textarea><br>
                                    <input class="submit" type="submit" name="submit" value="Book pilates class">
                                    <input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
                                    </form>
                                    <?php
            
                                    if(isset($_POST["submit"]) && $_POST["submit"] == "Book pilates class" && isset($date) && !empty($date)){
                                            
                                        echo"Thank you for you Submission!!<br>
                                             We will review your submission <br>
                                            and get too you as soon as possible";
                                        }
                                    ?>
                                    </h4>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

<script>
    function toggleDropdown(id){
        const dropdown = document.getElementById(id);
        const dropdownContent = dropdown.getElementsByClassName("dropdown_content")[0];

        if (dropdownContent.style.display == "block"){
            dropdownContent.style.display = "none";
        }
        else{
            dropdownContent.style.display = "block";
        }
    }

    window.onclick = function(event){
        // Check if the click is outside the dropdown and the button
        if(!event.target.matches('.dropdown_button') && !event.target.closest('.dropdown_content')){
            const dropdowns = document.querySelectorAll('.dropdown_content');
            dropdowns.forEach(function(dropdown){
                dropdown.style.display = 'none';
            });
        }
    };
</script>
