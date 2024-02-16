<?php include 'layout/top.php'; ?>

<?php

$statement = $pdo->prepare("SELECT * FROM locations WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
unlink('../uploads/'.$result[0]['photo']);

$statement = $pdo->prepare("DELETE FROM locations WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "loaction deleted successfully";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'location-view.php');
exit;