<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM messages WHERE id=? AND customer_id=?");
$statement->execute([$_REQUEST['id'],$_SESSION['customers']['id']]);
$total = $statement->rowCount();
if(!$total) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
else {
    $statement = $pdo->prepare("DELETE FROM messages WHERE id=? AND customer_id=?");
    $statement->execute([$_REQUEST['id'],$_SESSION['customers']['id']]);

    $statement = $pdo->prepare("DELETE FROM message_replies WHERE message_id=? AND customer_id=?");
    $statement->execute([$_REQUEST['id'],$_SESSION['customers']['id']]);

    $success_message = "Message is deleted successfully.";
    $_SESSION['success_message'] = $success_message;
    header('location: '.BASE_URL.'customer-messages');
    exit;
}