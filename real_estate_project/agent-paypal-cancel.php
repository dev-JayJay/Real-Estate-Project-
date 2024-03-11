<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['agents'])) {
    header('location: '.BASE_URL.'agent-login');
    exit;
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Payment Cancel</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Payment is cancelled!</h3>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>