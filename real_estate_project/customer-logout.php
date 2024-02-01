<?php
include 'header.php';
unset($_SESSION['customers']);
$_SESSION['success_message'] = "Logout succesful";
header('location:'.BASE_URL.'customer-login');
exit;