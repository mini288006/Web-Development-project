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
        <style>
            <?php include("../style.css");?>
            .profile{
                max-width: 700px;
                margin: 50px auto;
                background-color:#fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid #ddd;
            }
            
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                background-color: #4A628A;
            }

            h1 {
                text-align: center;
                color: #333;
            }
            label {
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
                color: #555;
            }
            
        </style>
    </head>
    <body>
        <header>
            <div class="Logo">
                <a href="../Homepage.php"><img class="logo" src="../weblogo.webp"></a>
                <h1 class="title">Huan Fitness Pal</h1>
            </div>

            <!-- Nav bar -->
            <div class="navbar">
                <nav>
                    <ul class="navlink">
                        <li><a href="../Homepage.php"><i class="fa-solid fa-house"></i></a></li>
                        <li><a href=""><i class="fa-solid fa-handshake"></i></a></li>
                        <li><a href=""><i class="fa-solid fa-circle-info"></i></a></li>
                        <li><a href=""><i class="fa-solid fa-phone"></i></a></li>
                        <li><a href="profile.php"><i class="fa fa-user"></i></a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <div class="profile">
                <h1>Your Profile</h1>
				<form class="profile" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{
					if (isset($_POST["submit"]))
					if ($_POST["submit"] == "Save")
					{
						include("info.php");
						include("showphysical.php");
						echo '<input type="submit" name="submit" value="Edit Profile">';
						$fname = $_SESSION["Fname"];
						$lname = $_SESSION["Lname"];
                        $changef = false;
                        $changel = false;
						if (isset($_POST["fname"]) && !empty(trim($_POST["fname"]))){
							$fname = trim($_POST["fname"]);
                            $changef = true;
                        }
						if (isset($_POST["lname"]) && !empty(trim($_POST["lname"]))){
							$lname = trim($_POST["lname"]);
                            $changel = true;
						}
                        if ($changef || $changel){
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
                                echo "<br>Your first name and last name have been saved<br>Please refresh the page to comfirm that your details have been saved";
                            }
                            else
                                echo "<br>Failed to save data, please try again later";
                        }
                        else
                            echo "<br>Nothing to save";
					}
					else
					{
						include("editing.php");
						include("showphysical.php");
						echo '<input type="submit" name="submit" value="Save">';
					}
				}
				else
				{
				include("info.php");
				include("showphysical.php");
				echo '<input type="submit" name="submit" value="Edit Profile">';
				}
				?>
				<input type = "hidden" name = "submitted" value = "<?php echo ($_SESSION["submitted"] + 1)?>">
				</form>
            </div>
        </main>
        <footer></footer>
    </body>
</html>