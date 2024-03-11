<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("DELETE FROM faqs WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "FAQ is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'faq-view.php');
exit;