<?php 

include 'header.php';

if (!isset($_REQUEST['email']) || !isset($_REQUEST['token'])) {
    header('location: '.BAESE_URL);
}

$statement = $pdo->prepare("SELECT * FROM customers WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'],$_REQUEST['token']]);
$total = $statement->rowCount();

if ($total) {
    $statement = $pdo->prepare("UPDATE customers SET token=?, status=? WHERE email=? AND token=?");
    $statement->execute(['', 1, $_REQUEST['email'], $_REQUEST['token']]);
    $_SESSION['success_message'] = "Registration verification Successful. please login now";
    header('location: '.BASE_URL.'customer-login');
} else {
    header('location:'.BASE_URL);
}
?>