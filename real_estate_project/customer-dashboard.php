<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM wishlists WHERE customer_id=?");
$statement->execute(array($_SESSION['customers']['id']));
$total_wishlist = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM messages WHERE customer_id=?");
$statement->execute(array($_SESSION['customers']['id']));
$total_messages = $statement->rowCount();
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <?php include 'customer-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <h3 class="mb_20">Hello, <?php echo $_SESSION['customers']['full_name']; ?></h3>
                <div class="row box-items">
                    <div class="col-md-4">
                        <div class="box1">
                            <h4><?php echo $total_wishlist; ?></h4>
                            <p>Wishlist Items</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box2">
                            <h4><?php echo $total_messages; ?></h4>
                            <p>Messages</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>