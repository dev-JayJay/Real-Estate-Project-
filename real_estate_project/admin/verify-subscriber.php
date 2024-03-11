<?php include 'header.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM subscribers WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'],$_REQUEST['token']]);
$total = $statement->rowCount();
if($total) {
	$statement = $pdo->prepare("UPDATE subscribers SET token=?,status=? WHERE email=? AND token=?");
	$statement->execute(['',1,$_REQUEST['email'],$_REQUEST['token']]);
    $_SESSION['success_message'] = "Your email subscription has been verified successfully.";
	header('location: '.BASE_URL);
    exit;
} else {
	header('location: '.BASE_URL);
}