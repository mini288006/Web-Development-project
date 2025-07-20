<?php
	$usrid = $_SESSION["Usr_id"];
	$result = $dbconnect->query("SELECT Usr_Weight, Usr_Height FROM users WHERE Usr_id = $usrid");
	$result = $result->fetch(PDO::FETCH_ASSOC);
	if($result && ($result["Usr_Weight"] != 0 || $result["Usr_Height"] != 0))
	{
?>
<br><br><br>
<div class = "infocontainer">
	<div class = "info">
		<h3>Weight: </h3>
		<h3><?php echo $result["Usr_Weight"]?></h3>
	</div>
	<div class = "info">
		<h3>Height: </h3>
		<h3><?php echo $result["Usr_Height"]?></h3>
	</div>
</div>
<?php
	}
	else
	{
?>
<div class = "infocontainer">
	<h3 style="text-align: center">To show your current physical condition, please go to the <a href = "../BMI.php">BMI calculation page</a> and update your details</h3>
</div>
<?php
	}
?>