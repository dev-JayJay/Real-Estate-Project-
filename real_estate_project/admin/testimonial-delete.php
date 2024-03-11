<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM testimonials WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
unlink('../uploads/'.$result[0]['photo']);

$statement = $pdo->prepare("DELETE FROM testimonials WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Testimonial is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('location: '.ADMIN_URL.'testimonial-view.php');
exit;