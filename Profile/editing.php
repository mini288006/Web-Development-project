<div class = "infocontainer">
	<div class = "info">
		<h3>First Name: </h3>
		<input type="text" name = "fname" placeholder="<?php echo $_SESSION["Fname"]?>">
	</div>
	<div class = "info">
		<h3>Last Name: </h3>
		<input type="text" name = "lname" placeholder="<?php echo $_SESSION["Lname"]?>">
	</div>
</div>
<br><br><br>
<div class = "infocontainer">
	<div class = "info">
		<h3>Contact: </h3>
		<input type="text" name = "contact" placeholder="<?php echo ($_SESSION["contact"] != "" ? $_SESSION["contact"] : "Not Provided") ?>">
		<?php echo "<br>Example:<br>'+6012-3456789'"?>
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
	<div class = "info" style = "width: 170px">
		<h3>Email: </h3>
		<h3><?php echo $_SESSION["email"]?></h3>
	</div>
</div>