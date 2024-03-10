<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
try {
    $statement = $pdo->prepare("DELETE FROM messages WHERE agent_id=?");
    $statement->execute([$_REQUEST['id']]);

    $statement = $pdo->prepare("DELETE FROM message_replies WHERE agent_id=?");
    $statement->execute([$_REQUEST['id']]);

    $statement = $pdo->prepare("SELECT * FROM agents WHERE id=?");
    $statement->execute([$_REQUEST['id']]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $photo = $row['photo'];
        if($photo != '') {
            unlink('../uploads/'.$photo);
        }
    }

    $statement = $pdo->prepare("DELETE FROM agents WHERE id=?");
    $statement->execute([$_REQUEST['id']]);

    $statement = $pdo->prepare("DELETE FROM orders WHERE agent_id=?");
    $statement->execute([$_REQUEST['id']]);

    $statement = $pdo->prepare("SELECT * FROM properties WHERE agent_id=?");
    $statement->execute([$_REQUEST['id']]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        unlink('../uploads/'.$row['featured_photo']);

        $statement1 = $pdo->prepare("SELECT * FROM property_photos WHERE property_id=?");
        $statement1->execute([$row['id']]);
        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result1 as $row1) {
            unlink('../uploads/'.$row1['photo']);
        }

        $statement1 = $pdo->prepare("DELETE FROM property_photos WHERE property_id=?");
        $statement1->execute([$row['id']]);

        $statement1 = $pdo->prepare("DELETE FROM property_videos WHERE property_id=?");
        $statement1->execute([$row['id']]);
    }

    $statement = $pdo->prepare("DELETE FROM properties WHERE agent_id=?");
    $statement->execute([$_REQUEST['id']]);

    
    $success_message = "Agent is deleted successfully.";
    $_SESSION['success_message'] = $success_message;
    header('location: '.ADMIN_URL.'agent-view.php');
    exit;

} catch (Exception $e) {
    $error_message = $e->getMessage();
    $_SESSION['error_message'] = $error_message;
    header('location: '.ADMIN_URL.'agent-view.php');
    exit;
}
