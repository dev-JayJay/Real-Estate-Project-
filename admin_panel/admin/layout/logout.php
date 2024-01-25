<?php
ob_start();
session_start();
unset($_SESSION['admin']);
header('location:' .ADMIN_URL. 'login.php');
exit;