<?php
include '../Profile/databaseconnect.php';
session_name('admin');
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: Assignmentloginpage.php");
    exit();
}

include '../Styling/header.php';

try {
    $sql = "SELECT Dr_id, CONCAT(Fname, ' ', Lname) AS 'Doctor Name'
    FROM doctors 
    GROUP BY Dr_id;";
    $stmt = $dbconnect->prepare($sql);
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<br>Query error: " . $e->getMessage();
    $doctors = []; // Ensures there is an empty array even if the query fails
}

$accept = false;
$iuid = null;
$today = date('Y-m-d');
$nextday = date('Y-m-d', strtotime(strtotime($today). 'day + 1'));


?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="requestForm">
	<h2>Nutritionist Appointment Form</h2>
	<label>User Name: </label><br>
	<input type="text" name="user" required><br>
	<?php echo $iuid?>
	
	<label>Nutritionist</label><br>
	<select name="doctor" required>
    <option value=""></option>
    <?php foreach($doctors as $d) {?>
        <option value="<?= $d['Dr_id']?>"><?= $d['Doctor Name']?></option>
    <?php }?>
	</select><br>

	<label for="Date">Choose your preferred date:</label><br>
	<input class="form" type="date" name="date" required><br>
	<div class="date">
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if($_POST["date"] < $today){
				echo "* The appointment must be placed at least one day in advance. Please choose another date.<br>";
			}else
				$accept = true;
		}
		?>
	</div>

	<label for="time">Choose your preferred time:</label><br>
	<select name="time" class="form" required>
		<option value=""></option>
		<option value="8am-9:30am">8 a.m. - 9:30 a.m.</option>
                                            <option value="9:30am-11am">9:30 a.m. - 11 a.m.</option>
                                            <option value="11am-12:30pm">11 a.m. - 12:30 p.m.</option>
                                            <option value="1:30pm-3pm">1:30 p.m. - 3 p.m.</option>
                                            <option value="3pm-4:30">3 p.m. - 4:30 p.m.</option>
                                            <option value="4:30pm-6pm">4:30 p.m. - 6 p.m.</option>
                                            <option value="7pm-8:30pm">7 p.m. - 8:30 p.m.</option>
                                            <option value="8:30pm-10pm">8:30 p.m. - 10 p.m.</option>
	</select><br>

	<label>Reasons for visit:</label><br>
	<textarea class="form" name="reason" placeholder="Please briefly explain the reason for your visit, so that we can prepare relevant information in advance for you?" required></textarea><br>

	<label>Remark:</label><br>
	<textarea name="request" placeholder="If you have any request please do specify" class="form"></textarea><br>
			
	<button class="cancel"><a href="admin.php">Back</a></button>
	<input class="submit" type="submit" name="submit" value="Submit">    
	<?php

	if($_SERVER['REQUEST_METHOD'] == "POST" && $accept == true) {
		$userName = $_POST['user'];
		$doctor = $_POST['doctor'];
		if($_POST["date"] > $today) 
			$date = $_POST["date"];
		$time = $_POST['time'];
		if(isset($_POST['reason']))
			$reason = $_POST['reason'];
		if(isset($_POST['request']))
			$request = $_POST['request'];
	
		try {
			$sql = "SELECT Usr_id  
			FROM users 
			WHERE Usr_username = :uid;";
			$stmt = $dbconnect->prepare($sql);
			$stmt->bindParam(":uid", $userName);
			$stmt->execute();
			$user = $stmt->fetch();
		
			if($stmt->rowCount() == 1) {
				$uid = $user['Usr_id'];
			} else
				$iuid = "Username does not exist.";
		} catch (PDOException $e) {
			echo "<br>Query error: " . $e->getMessage();
		}

		$sql = "SELECT * FROM meet_ups WHERE Usr_id = :usrid AND Meet_Time = :mtime AND Meet_Date = :mdate AND meet_status != 'completed'";
		$prep = $dbconnect->prepare($sql);
		$prep->bindParam(":usrid", $uid);
		$prep->bindParam(":mtime", $time);
		$prep->bindParam(":mdate", $date);
		$prep->execute();
		$row = $prep->fetch(PDO::FETCH_ASSOC);
		if ($row > 0)
			echo "You have already booked this time slot, please try requesting another time slot";
		else{
			$query = "INSERT INTO meet_ups (Usr_id, Dr_id, Meet_Time, Meet_Date, Meet_description, Meet_request) VALUES (:usrid, :drid, :mtime, :mdate, :reason, :request)";
			$prep = $dbconnect->prepare($query);
			$prep->bindParam(":usrid", $uid);
			$prep->bindParam(":drid", $doctor);
			$prep->bindParam(":mtime", $time);
			$prep->bindParam(":mdate", $date);
			$prep->bindParam(":reason", $reason);
			$prep->bindParam(":request", $request);
			if($prep->execute())
			{
				echo"<br>Thank you for you Submission!!<br>
					We will review your submission <br>
					and get too you as soon as possible";
			}
			else
				echo "<br>There was an error while submitting your request<br>
					Please try again Later";
			}	
	}

	?>
</div>
</form>
</main>
</body>
</html>