<?php

// start session
session_start();

// Destroy user session
unset($_SESSION['user_id']);
session_destroy();

// Redirect to home index.php page
header("Location: /../index.php"); // Redirect user to validate auth code
?>