<?php 
include '../config/config.php';
include 'layout/header.php';

$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
if ($cur_page != "login.php") {
    include 'layout/nav.php';
    include 'layout/sidenav.php';
}

?>

