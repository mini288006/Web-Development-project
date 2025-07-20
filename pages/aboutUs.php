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
    if (!isset($_SESSION["submitted"])){
        $_SESSION["submitted"] = 0;
    }
    else{
        $_SESSION["submitted"]++;
    }
    include ("Styling/header.php");
?>
<head>
    <style>
        header{
            margin: 40px;
            text-align: center;
        }
        body {
            background-color: #4A628A;
            padding-bottom: 20%;
        }
        .aboutMain{
            padding:60px;
        }
        .team-member {
            display: flex; /* Align image and text in a row */
            align-items: center; /* Vertically align the text with the image */
            margin-bottom: 30px; /* Add space between team members */
            color: white; /* Text color */
        }

        .team-member img {
            height: 280px;
            width: 450px;
            margin-right: 20px; /* Space between the image and text */
            border-radius: 10px; /* Optional: Rounded corners for the image */
        }

        .team-member p {
            font-family: 'Arial', sans-serif; 
            font-size: 16px; /* Text size */
            line-height: 1.5; /* Line spacing for readability */
            margin: 0; /* Remove default paragraph margin */
        }
        footer {
            width:100%;
            background-color: #43A047;
            padding: 20px;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
            bottom: 0px;
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
    </style>
</head>

<body>
<main class="aboutMain">
		<section id="about-us">
			<h2 style="color:white">About Us</h2><br><br>
			<p style="color:white">We're a team of passionate fitness enthusiasts dedicated to creating innovative and effective fitness solutions for people of all levels.</p>
			<img src="weblogo.webp" alt="Playbox Logo" style="height:280px;width:450px"><br><br>
			<h3 style="color:white">Our Story</h3><br>
			<p style="color:white">Founded in 2024, Huan Fitness Pal has grown from a small fitness startup to a trusted leader in the health and wellness industry. Our mission is to empower individuals to achieve their fitness goals and embrace a healthier lifestyle.</p><br><br>
			<h3 style="color:white">Our Values</h3><br>
			<ul>
				<li style="color:white"> We're committed to providing premium fitness products and resources that deliver real results.</li>
				<li style="color:white"> We continuously innovate to bring cutting-edge tools and techniques to the fitness world.</li>
				<li style="color:white">We believe fitness is for everyone, and we're here to support you every step of the way on your journey to success.</li>
			</ul>
			<br><br>
            <h3 style="color:white">Meet Our Team</h3><br>
<div class="team-member">
    <img src="prof1.webp" alt="Darren">
    <p>Darren, Founder & Head Coach</p>
</div>
<div class="team-member">
    <img src="prof2.webp" alt="Mizhan">
    <p>Mizhan, Fitness Program Designer</p>
</div>
<div class="team-member">
    <img src="prof3.webp" alt="Dexmund">
    <p>Dexmund, Equipment and Supply Manager</p>
</div>
<div class="team-member">
    <img src="prof4.webp" alt="Victor">
    <p>Victor, Community Engagement Lead</p>
</div>
<div class="team-member">
    <img src="prof5.webp" alt="Nevision">
    <p>Nevision, Wellness and Nutrition Advisor</p>
</div>

</ul>
        <?php include("Contact.php")?>
				<br>
			</ul>
		</section>
	</main>
</body>

<?php
    include ("Styling/footer.php");
?>
</html>