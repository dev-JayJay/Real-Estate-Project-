<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
?>

<?php
$statement = $pdo->prepare("DELETE FROM wishlists WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Wishlist is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: '.BASE_URL.'customer-wishlist');
exit;