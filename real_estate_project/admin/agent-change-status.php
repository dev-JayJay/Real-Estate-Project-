<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM agents WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $status = $row['status'];
}

if($status == 1) {
    $statement = $pdo->prepare("UPDATE agents SET status=? WHERE id=?");
    $statement->execute(array(0,$_REQUEST['id']));
    header('location: '.ADMIN_URL.'agent-view.php');
} else {
    $statement = $pdo->prepare("UPDATE agents SET status=? WHERE id=?");
    $statement->execute(array(1,$_REQUEST['id']));
    header('location: '.ADMIN_URL.'agent-view.php');
}
