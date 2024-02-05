<?php
include 'header.php';
unset($_SESSION['agents']);
$_SESSION['success_message'] = "Logout succesful";
header('location:'.BASE_URL.'agent-login');
exit;