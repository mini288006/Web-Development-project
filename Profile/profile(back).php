<!DOCTYPE html>
<html>
	<head>
		<meta content="zh-cn" http-equiv="Content-Language" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<style>
			<?php include("../style.css");?>
		</style>
	</head>
	<body>
		<header>
			<div class="Logo">
				<img class="logo" src="../weblogo.webp">
				<h1 class="title">Huan Fitness Pal</h1>
			</div>

			<!-- Nav bar -->
			<div class="navbar">
				<nav>
					<ul class="navlink">
						<li><a href="../Homepage.php"><i class="fa-solid fa-house"></i></i></i></a></li>
						<li><a href=""><i class="fa-solid fa-handshake"></i></i></a></li>
						<li><a href=""><i class="fa-solid fa-circle-info"></i></a></li>
						<li><a href=""><i class="fa-solid fa-phone"></i></i></a></li>
						<li><a href="profile.php"><i class="fa fa-user"></i></a></li>
					</ul>
				</nav>
			</div>
		</header>
		<main>
			<?php
				session_name("profile");
				session_start();
				if (!isset($_SESSION["Usr_id"]))
				{
					header("Location: Assignmentloginpage.php");
					exit();
				}
			?>
			<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{
						if (isset($_POST["submit"]))
							if ($_POST["submit"] == "Save")
							{
								include("info.php");
								include("showphysical.php");
								echo '<input type="submit" name="submit" value="Edit Profile">';
								echo '<input type="submit" name="submit" value="Update Height & Weight">';
							}
							else if ($_POST["submit"] == "Update Height & Weight")
							{
								include("info.php");
								include("editphysical.php");
								echo '<input type="submit" name="submit" value="Save">';
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
						echo '<input type="submit" name="submit" value="Edit Height & Weight">';
					}
				?>
			</form>
			
		</main>
		<footer>

		</footer>
	</body>
</html>