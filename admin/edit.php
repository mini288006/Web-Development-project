<?php
$dbconnect = include '../Profile/databaseconnect.php';
session_name("admin");
session_start();
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true ) {
    header("Location: ../Assignmentloginpage.php");
    exit();
}

// Check whether the database connection is successful
if (!isset($dbconnect)) {
    die("Database connection failed");
}
include '../Styling/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['meetid'])) {
	$_SESSION['meet_id'] = $_POST['meetid'];
}


	try {
		$meet_id = $_SESSION['meet_id'];
		$sql = "SELECT M.Meet_id, M.Usr_id, M.Dr_id, CONCAT(N.Fname, ' ', N.Lname) AS 
			'Doctor Name', M.Meet_Date, M.Meet_Time, M.Meet_description, M.Meet_request FROM meet_ups M INNER JOIN doctors N ON M.Dr_id = N.Dr_id WHERE Meet_id = :mid";
		$stmt = $dbconnect->prepare($sql);
		$stmt->execute([':mid' => $meet_id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		 // check
		if (!$row) {
			die("No appointment found with this ID");
    }
	} catch (PDOException $e) {
		echo "<br>Query error: " . $e->getMessage();
	}


try {
    $sql = "SELECT Dr_id, CONCAT(Fname, ' ', Lname) AS 'Doctor Name'
    FROM doctors 
    GROUP BY Dr_id;";
	$drid = $row['Dr_id'];
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
$date = null;

if (isset($_POST["submit"])) {	//update the default data
	$drid = $_POST["doctor"];
	foreach($doctors as $d) {
		if($d["Dr_id"] == $drid) {
			$doctorName = $d["Doctor Name"];
		}
	}
	$date = $_POST["date"];
	$reason = $_POST["reason"];
	$request = $_POST["request"];
}
else {	//set old data as default value if user havent submit
	$drid = $row['Dr_id'];
	$doctorName = $row['Doctor Name'];
	$date = $row['Meet_Date'];
	$reason = $row['Meet_description'];
	$request = $row['Meet_request'];
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="requestForm">
	<h2>Edit Nutritionist Appointment Form</h2>
	
	<label>Nutritionist</label><br>
	<select name="doctor" required>
		<option value="<?= $drid?>"><?= htmlspecialchars($doctorName); ?></option>
        <?php foreach($doctors as $d) {
        // Skip if this doctor is the current doctor to avoid duplicate
        if($d['Dr_id'] != $drid) { ?>
			<option value="<?= $d['Dr_id']?>"><?= htmlspecialchars($d['Doctor Name']); ?></option>
    <?php } 
		}?>
	</select><br>
	
	<label for="Date">Choose your preferred date:</label><br>
	<input class="form" type="date" name="date" value="<?= htmlspecialchars($date); ?>" required><br>
	<div class="date">
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
			if (isset($_POST["date"])) {
				if ($_POST["date"] < $today) {
					echo "* The appointment must be placed at least one day in advance. Please choose another date.<br>";
				} else {
					$accept = true;
				}
			} else {
				echo "Please choose a date.";
			}
		}
		?>
	</div>

	<label for="time">Choose your preferred time:</label><br>
	<select name="time" class="form" required>
	<?php
	$defaultTime = $row['Meet_Time'];
	$times = [
	"8am-9:30am" => "8 a.m. - 9:30 a.m.",
	"9:30am-11am" => "9:30 a.m. - 11 a.m.",
	"11am-12:30pm" => "11 a.m. - 12:30 p.m.",
	"1:30pm-3pm" => "1:30 p.m. - 3 p.m.",
	"3pm-4:30" => "3 p.m. - 4:30 p.m.",
	"4:30pm-6pm" => "4:30 p.m. - 6 p.m.",
	"7pm-8:30pm" => "7 p.m. - 8:30 p.m.",
	"8:30pm-10pm" => "8:30 p.m. - 10 p.m.",
	];

	foreach ($times as $value => $label) {
		$selected = ($value === $defaultTime) ? 'selected' : '';
		echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
	}
	?>
	</select><br>

	<label>Reasons for visit:</label><br>
	<textarea class="form" name="reason" placeholder="Please briefly explain the reason for your visit, so that we can prepare relevant information in advance for you?" required><?php echo $reason?></textarea><br>

	<label>Remark:</label><br>
	<textarea name="request" class="request" placeholder="If you have any request please do specify"><?php echo $request;?></textarea><br>
			
	<button class="cancel"><a href="admin.php">Back</a></button>
	<input class="submit" type="submit" name="submit" value="Submit">    
	<?php

	if($_SERVER['REQUEST_METHOD'] == "POST" && $accept == true) {
		$userName = $row['Usr_id'];
		$doctor = $_POST['doctor'];
		$date = $_POST["date"];
		$time = $_POST['time'];
		$reason = null;
		if(isset($_POST['reason']))
			$reason = $_POST['reason'];
		$request = null;
		if(isset($_POST['request']))
			$request = $_POST['request'];

		$sql = "SELECT * FROM meet_ups WHERE Usr_id = :usrid AND Meet_Time = :mtime AND Meet_Date = :mdate AND meet_status != 'completed'";
		$prep = $dbconnect->prepare($sql);
		$prep->bindParam(":usrid", $uid);
		$prep->bindParam(":mtime", $time);
		$prep->bindParam(":mdate", $date);
		$prep->execute();
		$result = $prep->fetch(PDO::FETCH_ASSOC);
		if ($result > 0)
			echo "You have already booked this time slot, please try requesting another time slot";
		else{
			$query = "UPDATE meet_ups SET Dr_id = :drid, Meet_Time = :mtime, Meet_Date = :mdate, Meet_description = :reason, Meet_request = :request WHERE Meet_id = :mid";
			$prep = $dbconnect->prepare($query);
			$prep->bindParam(":mid", $meet_id);
			$prep->bindParam(":drid", $doctor);
			$prep->bindParam(":mtime", $time);
			$prep->bindParam(":mdate", $date);
			$prep->bindParam(":reason", $reason);
			$prep->bindParam(":request", $request);
			if($prep->execute())
			{
				echo"<br>Update sucessfully";
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