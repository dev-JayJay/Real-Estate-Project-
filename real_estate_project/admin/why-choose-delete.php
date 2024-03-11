<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("DELETE FROM why_choose_items WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Why Choose Item is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'why-choose-view.php');
exit;