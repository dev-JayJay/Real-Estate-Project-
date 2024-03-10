<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("DELETE FROM messages WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $pdo->prepare("DELETE FROM message_replies WHERE message_id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Message is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'message-view.php');
exit;
