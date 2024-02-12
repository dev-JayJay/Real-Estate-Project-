<?php include 'layout/top.php'; ?>

<?php
$statement = $pdo->prepare("DELETE FROM pakages WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Package deleted successfully";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'package-view.php');
exit;