<?php
// start session
session_name("profile");
session_start();

// Clear all session variables
$_SESSION = array();

// delete the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// delete session
session_destroy();

// back to main page
header('Location: Assignmentloginpage.php');
exit();