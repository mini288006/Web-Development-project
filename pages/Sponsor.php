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
    <title>Huan Fitness Pal</title>
    <style>
        header{
            margin: 40px;
        }
        body {
            background-color: #4A628A;
            display: flex;
            flex-direction: column;
        }
        .S1 {
            height: 490px;
            width: 760px;
            float: left;
            margin-right: 20px; 
            padding:30px;
        }
        .title{
            text-align: center;
        }
        .prime {
            font-family: 'Arial', sans-serif; 
            font-size: 16px;
            float: left; 
            width: calc(100% - 780px); 
            padding-top: 160px;
            color: white; 
            padding-right:10px;
        }

        .S2 {
            height: 490px;
            width: 760px;
            float: right; /* Float the image to the right */
            margin-left: 20px; /* Add space between the paragraph and the image */
            padding: 30px;
        }

        .lunch {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            float: left; /* Float the paragraph to the left */
            width: calc(100% - 780px); /* Adjust the width to fit the layout */
            padding-top: 160px; /* Add padding to align with the image */
            color: white;
            padding-left: 30px;
        }
    </style>
</head>

<body>

        <img class="S1" src="prime.jpg" alt="PRIME">
        <p class="prime">We created PRIME to showcase what happens when rivals come together as brothers and business partners to fill the void where great taste meets function.  ​

We dropped our first product, PRIME Hydration in 2022 and since then, we've continued to work countless hours to expand in retailers, reach new markets and formulate new products we know you'll love. ​

We’ve been humbled by the process of creating a real brand & surpassing some of the biggest beverage companies in the world. As underdogs, we always cherish the opportunity to show the world what’s possible. ​

Now that we’re both fighting for the same team, we truly believe the sky is the limit.</p>

        <img class="S2" src="lunch.webp" alt="LUNCHLY">
        <p class="lunch">LUNCHLYTM is changing the grab-and-go game with an innovative approach that prioritizes quality ingredients and delicious flavors.

We're here to fuel your fun from the lunchroom to the breakroom by packing every LUNCHLYTM box with a PRIME Hydration and a Feastables Bar.

Driven by our commitment to great quality and taste, we're confident there's no better value on the market. Remember, leave no crumbs =).</p>
    </main>

<?php
    include ("Styling/footer.php");
?>

</html>


