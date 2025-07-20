<?php
	function saveinfo($fname, $lname, $usrname, $phone, $email, $gender, $pass){
		$dbconnect = include("databaseconnect.php");
		$insertquery = 
		"INSERT INTO users (Fname, Lname, Usr_username, contact, email, gender, pass) VALUES ('$fname', '$lname', '$usrname', '$phone', '$email', '$gender', '$pass');";
		try{
			if ($dbconnect->query($insertquery)){
				echo "<h2>Registration Successful</h2>";
				echo "<p>Here are your registered details:</p>";
				echo "<ul>";
				echo "<li><strong>First Name:</strong> $fname</li>";
				echo "<li><strong>Last Name:</strong> $lname</li>";
				echo "<li><strong>Username:</strong> $usrname</li>";
				echo "<li><strong>Email:</strong> $email</li>";
				echo "<li><strong>Gender:</strong> $gender</li>";
				if ($phone != null)
					echo "<li><strong>Phone:</strong> $phone</li>";
				echo "</ul>";
				return (0);
			}
			else{
				return (1);
			}
		} catch (Exception $e){
			return ($e);
		}
	}
?>