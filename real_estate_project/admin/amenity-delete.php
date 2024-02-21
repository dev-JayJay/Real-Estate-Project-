<?php include 'layout/top.php'; ?>

<?php

$statement = $pdo->prepare("DELETE FROM amenities WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Amenity deleted successfully";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'amenity-view.php');
exit;