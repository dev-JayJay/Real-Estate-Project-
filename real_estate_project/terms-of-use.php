<?php include 'header.php'; ?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Terms of Use</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $statement = $pdo->prepare("SELECT * FROM terms_privacy_items WHERE id=?");
                $statement->execute([1]);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php echo $result[0]['terms']; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>