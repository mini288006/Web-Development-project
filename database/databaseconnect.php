<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "huan_fitness_pal_db";
$charset = "utf8mb4";

try{
	$pdo = new PDO("mysql:host=$server;charset=$charset", $username, $password);
} catch (Exception $e){
	die ("Unable to connect to localhost");
}

try {
	$dbconnect = new PDO("mysql:host=$server;dbname=$dbname;charset=$charset", $username, $password);
	$dbconnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo "Databse successfully connected";
	return($dbconnect);
	exit();
} catch (PDOException $e) {
	if (strpos($e, "Unknown database")){
		include("./databasecreate.php");
		if (!createDatabase($pdo, $dbname))
		{
			// echo "Database successfully created<br><br>";
			$dbconnect = new PDO("mysql:host=$server;dbname=$dbname;charset=$charset", $username, $password);
			return($dbconnect);
			exit();
			// if (!$dbconnect)
			// 	echo "Database $dbname failed to connect<br>";
			// else
			// 	echo "Database $dbname successfully connected<br>";
		}
		else
		{
			try{
				$dbconnect = new PDO("mysql:host=$server;dbname=$dbname;charset=$charset", $username, $password);
				if ($dbconnect)
					mysqli_query($connect, "DROP DATABASE $dbname");
			} catch(Exception $e){
				// echo "Database has not been created<br>";
			}
			die("Database failed to create:<br>" . $connect->error);
		}
	}
	else
    	die("Database connection failed: " . $e->getMessage());
}

?>