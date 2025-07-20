<!DOCTY>
<?php
	session_start("profile");
	$dbconnect = include("databaseconnect.php");
	$usrid = $_SESSION["Usr_id"]
	$query = 
	"SELECT * FROM meet_ups
	WHERE Usr_id = $usrid";
	$result = $dbconnect->query($query);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	while ($row)
	{
		echo ""
	}
?>