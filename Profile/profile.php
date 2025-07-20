<!DOCTYPE html>
<?php
    session_name("profile");
    session_start();
    if (!isset($_SESSION["Usr_id"]))
    {
        header("Location: Assignmentloginpage.php");
    	exit();
    }
	if (!isset($_SESSION["submitted"])){
		$_SESSION["submitted"] = 0;
	}
	else{
		$_SESSION["submitted"]++;
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($_SESSION["submitted"] != $_POST["submitted"])
		{
			header("Location: Assignmentloginpage.php");
			exit();
		}
	}
    $dbconnect = include("databaseconnect.php");
?>
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
            .profile{
                max-width: 700px;
                margin: 50px auto;
                background-color:#fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid #ddd;
            }
            

            h1 {
                font-family: Arial, sans-serif;
                text-align: center;
                color:  #4A628A;
            }
            label {
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
                color: #555;
            }
            .img{
                height:180px;
                width:180px;
                padding: 30px;
            }
            .Eprofile{
                text-align: center;
                margin:10px;
            }
            .but, .but1, .but2{
                color:  #4A628A;
                background-color: #E0F7FA;
                text-align: center;
                padding: 6px;
            }
            .but{
                margin-left:33%;
            }
            .but1{
                margin-left:45%;
            }
            .infocontainer{
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-left: 10%;
                margin-right: 10%;
            }

            .info{
                height: 100px;
                width: 170px;
            }
            <?php include("../Styling/style.css") ?>
        </style>
    </head>
        <body>
        <header>
            <div class="Logo">
                <a href=""><img class="logo" src="weblogo.webp"></a>
                <h1 class="title">Huan Fitness Pal</h1>
            </div>

            <div class="navbar">
                <nav>
                    <ul class="navlink">
                        <?php if(isset($_SESSION['Usr_id'])) { ?>
                            <li><a href="../Homepage.php"><i class="fa-solid fa-house"></i></a><p>Home</p></li>
                            
                            <li><a href="../history.php"><i class="fa-solid fa-phone"></i></a><p>Appointment</p></li>
                            <li><a href="profile.php"><i class="fa fa-user"></i></a><p>Profile</p></li>
                            <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a><p>Logout</p></li>
                        <?php }?>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <div class="profile">
            <div class="Eprofile">
                <h1>YOUR PROFILE</h1>
                <img src="img.png" class="img"> <br><br> 
            </div>
				<form class="profile" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{
					if (isset($_POST["submit"]))
					if ($_POST["submit"] == "Save")
					{
						include("info.php");
						include("showphysical.php");
						echo '<input type="submit" class="but" name="submit" value="Edit Profile">';
                        echo "<button class='but2' formaction = 'records.php'>Physical Record</button>";//button for physical record and class name "but2"
                        $fname = $_SESSION["Fname"];
						$lname = $_SESSION["Lname"];
                        $phone = $_SESSION["contact"];
                        $changef = false;
                        $changel = false;
                        $changec = false;
                        $update = true;
						if (isset($_POST["fname"]) && !empty(trim($_POST["fname"]))){
							$fname = trim($_POST["fname"]);
                            $changef = true;
                            if(!preg_match("/^[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*$/", $fname)){
                                echo("<br>Not a valid first name");
                                $update = false;
                            }
                        }
						if (isset($_POST["lname"]) && !empty(trim($_POST["lname"]))){
							$lname = trim($_POST["lname"]);
                            $changel = true;
                            if(!preg_match("/^[A-Za-z]+((\s)?(['|\-\.]?[A-Za-z]+))*$/", $lname)){
                                echo("<br>Not a valid last name");
                                $update = false;
                            }
						}

                        if (isset($_POST["contact"]) && !empty(trim($_POST["contact"]))){
							$phone = trim($_POST["contact"]);
                            $changec = true;
                            if(!preg_match("/^\+60(\d{1,2}-\d{7,8}|\d{3}-\d{7,8})$/", $phone)){
                                echo("<br>Not a valid contact number(Example: '+60 12-3456789')");
                                $update = false;
                            }
                        }

                        if (($changef || $changel || $changec) && $update){
                            $query = "UPDATE users SET Fname = :fname, lname = :lname";
                            $prep = $dbconnect->prepare($query);
                            $prep->bindParam(":fname", $fname);
                            $prep->bindParam(":lname", $lname);
                            if ($prep->execute())
                            {
                                if (isset($_POST["fname"]) && !empty(trim($_POST["fname"])))
                                    $_SESSION["Fname"] = trim($_POST["fname"]);
                                if (isset($_POST["lname"]) && !empty(trim($_POST["lname"]))){
                                    $_SESSION["Lname"] = trim($_POST["lname"]);
                                }
                                if (isset($_POST["contact"]) && !empty(trim($_POST["contact"]))){
                                    $_SESSION["contact"] = trim($_POST["contact"]);
                                }
                                echo "<br>Your first name, last name and contact have been saved<br>Please refresh the page to comfirm that your details have been saved";
                            }
                            else
                                echo "<br>Failed to save data, please try again later";
                        }
                        else if ($update)
                            echo "<br>Nothing to save";
					}
					else
					{
						include("editing.php");
						include("showphysical.php");
						echo '<div><input class="but1" type="submit" name="submit" value="Save"></div>';
					}
				}
				else
				{
				include("info.php");
				include("showphysical.php");
				echo '<input class="but" type="submit" name="submit" value="Edit Profile">'; //added class name 'but' for css
                echo "<button class='but2' formaction = 'records.php'>Physical Record</button>";//button for physical record and class name "but2"
				}
				?>
				<input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
				</form>
            </div>
            <footer>
                <div class="footer_content">
                    <ul>
						<li><a href="../Sponsor.php"><i class="fa-solid fa-handshake"></i></a><p>Sponsor</p></li>
						<li><a href="../aboutUs.php"><i class="fa-solid fa-circle-info"></i></a><p>About Us</p></li>
                        <a href="../address.php"><li>Address</li></a>
                        <a href="../term.php"><li>Terms & Condition</li></a>
                        <a href="../privacy.php"><li>Privacy Policy</li></a>
                    </ul>
                </div>
            </footer>
        </main>
        </body>
        </html>
    </body>


</html>