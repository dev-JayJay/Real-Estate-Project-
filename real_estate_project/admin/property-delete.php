<?php include 'layouts/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.BASE_URL.'admin-login');
    exit;
}
$statement = $pdo->prepare("SELECT * FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$total = $statement->rowCount();
if(!$total) {
    header('location: '.BASE_URL.'agent-login');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
unlink('uploads/'.$result[0]['featured_photo']);

$statement = $pdo->prepare("DELETE FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $pdo->prepare("SELECT * FROM property_photos WHERE property_id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    unlink('uploads/'.$row['photo']);
}

$statement = $pdo->prepare("DELETE FROM property_photos WHERE property_id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $pdo->prepare("DELETE FROM property_videos WHERE property_id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Property is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'property-view.php');
exit;