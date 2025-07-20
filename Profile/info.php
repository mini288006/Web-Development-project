<div class = "infocontainer">
	<div class = "info">
		<h3>First Name: </h3>
		<h3><?php echo $_SESSION["Fname"]?></h3>
	</div>
	<div class = "info">
		<h3>Last Name: </h3>
		<h3><?php echo $_SESSION["Lname"]?></h3>
	</div>
</div>
<br><br><br>
<div class = "infocontainer">
	<div class = "info">
		<h3>Contact: </h3>
		<h3><?php echo ($_SESSION["contact"] != "" ? $_SESSION["contact"] : "Not Provided") ?></h3>
	</div>
	<div class = "info">
	</div>
</div>
<br><br><br>
<div class = "infocontainer">
	<div class = "info">
		<h3>Username: </h3>
		<h3><?php echo $_SESSION["Usr_username"]?></h3>
	</div>
	<div class = "info">
		<h3>Email: </h3>
		<h3><?php echo $_SESSION["email"]?></h3>
	</div>
</div>
<!-- <?php echo (isset($_SESSION["DOB"]) ? $_SESSION["DOB"] : "Not Provided")?> -->