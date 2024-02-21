<?php include 'layout/top.php'; ?>

<?php

$statement = $pdo->prepare("DELETE FROM types WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Type deleted successfully";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'type-view.php');
exit;