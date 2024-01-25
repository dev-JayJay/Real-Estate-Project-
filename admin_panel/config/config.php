<?php

$dbhost = 'localhost';
$dbname = 'admin_panel';
$dbuser = 'root';
$dbpwsd = '';

try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpwsd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $exception) {
    echo "Connection error :" . $exception->getMessage();
}
define("BASE_URL", "http://localhost/PHP/admin_panel/");
define("ADMIN_URL", BASE_URL."admin/");

define("SMTP_HOST", "sandbox.smtp.mailtrap.io");
define("SMTP_PORT", "587");
define("SMTP_USERNAME", "2793e0bad694e8");
define("SMTP_PASSWORD", "d11ece4ccaaa64");