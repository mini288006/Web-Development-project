
<?php
include '../Profile/databaseconnect.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    try {
        $action = $_POST['action'];
        $appointment_id = $_POST["appointment_id"];
			$uid = $_POST["uid"];
		
        $sql = "UPDATE meet_ups SET meet_status = :status WHERE Meet_id = :id";
        $stmt = $dbconnect->prepare($sql);
        
        switch($action) {
			case 'approved':
            case 'rejected':
            case 'cancelled':
            case 'completed':
                $stmt->execute([':status' => $action, ':id' =>$appointment_id]);
				if($action == 'completed') {
				$query = "UPDATE users SET amountowe = amountowe + 20 WHERE Usr_id = :uid";
                $prep = $dbconnect->prepare($query);
                $prep->execute([':uid' => $uid]); 
				}
			break;
        }
		header("Location: admin.php");
		exit();
    } catch (PDOException $e) {
        echo "<br>Update error: " . $e->getMessage();
    }
}

include '../Styling/header.php';



$search_method = ["user", "contact", "nutritionist", "date", "time"];
$result = null;

$select = "M.Meet_id, CONCAT(M.Meet_id, '/', M.Usr_id, '/', M.Dr_id) AS 'Mid' , M.Usr_id,
			U.Usr_username, U.gender, CONCAT(U.Fname, ' ', U.Lname) AS 
			'Usr_name', U.contact,  M.Dr_id, CONCAT(N.Fname, ' ', N.Lname) AS 
			'Doctor Name', M.Meet_Date, M.Meet_Time, M.Meet_description, 
			M.created_at, M.meet_status, M.Meet_request";
            			
$from = "meet_ups M INNER JOIN users U ON M.Usr_id = U.Usr_id INNER JOIN doctors N ON M.Dr_id = N.Dr_id";

$where = "";

if(!$where) {
	try {
		$sql = "SELECT $select FROM $from ORDER BY M.Meet_Date DESC, M.Meet_Time ASC";
		$stmt = $dbconnect->prepare($sql);
		$stmt->execute();
		$result = $stmt;
	} catch (PDOException $e) {
		echo "<br>Query error: " . $e->getMessage();
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit'])) {
    
    $params = [];	// Use parameter binding to prevent SQL injection
    
    $search_term = isset($_GET['search']) ? trim($_GET['search']) : "";	// Get and filter search parameters
    $method = isset($_GET['method']) ? $_GET['method'] : "";	// check the search method and set "" as default

    if ($search_term !== "") {	
        switch($method) {
            case 'u': // user search
                $where = "(U.Usr_username LIKE :search OR U.Fname LIKE :search OR U.Lname LIKE :search)";
                $params[':search'] = "%$search_term%";
                break;
            case 'c': // contact search
                $where = "U.contact = :contact";
                $params[':contact'] = $search_term;
                break;
            case 'n':  // nutritionist search
                $where = "(N.Fname LIKE :search OR N.Lname LIKE :search)";
                $params[':search'] = "%$search_term%";
                break;
            case 'd': // date search
                $where = "(M.Meet_Date LIKE :search OR M.created_at LIKE :search)";
                $params[':search'] = "%$search_term%";
                break;
            case 't': // time search
                $where = "M.Meet_Time LIKE :search";
                $params[':search'] = "%$search_term%";
                break;
        }
        
        if ($where) {
            try {
                $sql = "SELECT $select FROM $from WHERE $where ORDER BY M.Meet_Date DESC, M.Meet_Time ASC";
                $stmt = $dbconnect->prepare($sql);
                $stmt->execute($params);
                $result = $stmt;
            } catch (PDOException $e) {
                echo "<br>Query error: " . $e->getMessage();
            }
        }
    }
}

$userTH = ["User Name", "Gender", "Name", "Contact Number"];
$meetupTH = ["Nutritionist Name", "Preferred Time", "Preferred Date", "Description", "Request Time"];

$userTD = ["Usr_username", "gender", "Usr_name", "contact"];
$meetupTD = ["Doctor Name", "Meet_Date", "Meet_Time", "Meet_description", "created_at"];
?>


<br>
<div class="search">
    <form method="GET">
        <select name="method">
            <?php foreach($search_method as $method) { ?>
                <option value="<?= substr($method, 0, 1) ?>"><?= strtoupper($method); ?></option>
            <?php }?>
        </select>
        <input type="search" name="search" placeholder="Search..." size=50 required>
        <button type="submit" name="submit" value="search"><i class="fa fa-search"></i></button>
    </form>
</div>
<br>

<div class="aTable">
<table class="resultTable"><thead>
<tr class="nResult"><th colspan=13 >
<p>Number of result: 
<?php
	echo $result->rowCount(). "</p>";
	
if ($result && $result->rowCount() > 0) {
?>
</th></tr>
	
        
            <tr>
				<th class="meetupC">Meet Up ID</th>
            <?php foreach($userTH as $uTH) {?>
                <th class="userC"><?= htmlspecialchars($uTH); ?></th>
            <?php }?>
			<?php foreach($meetupTH as $mTH) {?>
                <th class="meetupC"><?= htmlspecialchars($mTH); ?></th>
            <?php }?>
				<th class="controlT">Status</th>
				<th class="controlT">Control</th>
				<th class="meetupC">Remark</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
				<td class="meetupC" name="appointment_id" value="<?= htmlspecialchars($row['Meet_id']); ?>"><?php echo htmlspecialchars($row['Mid']);?></td>
				
            <?php foreach($userTD as $uTD) {?>
                <td class="userC"><?= htmlspecialchars($row[$uTD]); ?></td>
            <?php }?>
			<?php foreach($meetupTD as $mTD) {?>
                <td class="meetupC"><?= htmlspecialchars($row[$mTD]); ?></td>
            <?php }?>
                <td class="controlData">
                    <?php if($row['meet_status'] == 'pending') {?>
                    <form class="controlF" method="POST">
						<input type="hidden" name="appointment_id" value="<?= htmlspecialchars($row['Meet_id']); ?>">
                        <button type="submit" name="action" value="approved">Approve</button><br>
                        <button type="submit" name="action" value="rejected">Reject</button>
                    </form>
                    <?php } elseif($row['meet_status'] == 'approved') { ?>
                    <form class="controlF" method="POST">
						<input type="hidden" name="appointment_id" value="<?= htmlspecialchars($row['Meet_id']); ?>">
						<input type="hidden" name="uid" value="<?= htmlspecialchars($row['Usr_id']); ?>">
                        <button type="submit" name="action" value="cancelled">Cancelled</button><br>
                        <button type="submit" name="action" value="completed">Completed</button>
                    </form>
                    <?php } else { 
                        echo htmlspecialchars($row['meet_status']);
                    }?>
                </td>
				
				<td class="controlB">
					<?php if($row['meet_status'] == 'pending' || $row['meet_status'] == 'approved') {?>
					<form action="edit.php" method="post">
					<button type="submit" name="meetid" value="<?= htmlspecialchars($row['Meet_id']); ?>">   
						Edit
					</button>
					</form>
					<?php }?>
				</td>

				<td class="meetupC"><?= htmlspecialchars($row['Meet_request'])?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php }?>
</main>
</body>
</html>