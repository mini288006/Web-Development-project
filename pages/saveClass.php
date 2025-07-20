<?php
	function saveclass($usrid, $classid, $request, $date, $time, $dbconnect){
		$query = "Select * FROM takes WHERE Usr_id = :usrid AND Cls_id = :classid AND Cls_date = :bookdate AND Cls_time = :booktime";
		$prep = $dbconnect->prepare($query);
		$prep->bindParam(":usrid", $usrid);
		$prep->bindParam(":classid", $classid);
		$prep->bindParam(":bookdate", $date);
		$prep->bindParam(":booktime", $time);
		$prep->execute();
		$check = $prep->fetch(PDO::FETCH_ASSOC);
		if ($check)
		{
			echo "<h3 style = 'color: red'>You are already in this class<h3>";
			return ;
		}
		$query = "INSERT INTO takes VALUES (:usrid, :classid, :bookdate, :booktime, :request)";
		$prep = $dbconnect->prepare($query);
		$prep->bindParam(":usrid", $usrid);
		$prep->bindParam(":classid", $classid);
		$prep->bindParam(":bookdate", $date);
		$prep->bindParam(":booktime", $time);
		$prep->bindParam(":request", $request);
		if (!$prep->execute())
			echo "<h3 style = 'color: red'>failed to schedule class, pease try again later<h3>";
		else{
			$result = $dbconnect->query("SELECT Cls_price FROM classes WHERE Cls_id = $classid");
			$result = $result->fetch(PDO::FETCH_ASSOC);
			$amount = $result["Cls_price"];
			$dbconnect->query("UPDATE users SET amountowe = (Select amountowe FROM users WHERE Usr_id = $usrid) + $amount WHERE Usr_id = $usrid");
		}
	}
?>