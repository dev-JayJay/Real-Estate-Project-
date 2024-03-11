<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
if(isset($_POST['form_submit'])) {
    try {
        if($_POST['terms'] == "") {
            throw new Exception("Terms can not be empty.");
        }
        
        $statement = $pdo->prepare("UPDATE terms_privacy_items 
                                    SET terms=?
                                    WHERE id=?");
        $statement->execute([
                                $_POST['terms'],
                                1
                            ]);

        $success_message = "Data is updated successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'terms-view.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM terms_privacy_items WHERE id=?");
$statement->execute([1]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Terms Page Content</h1>
            <div class="ml-auto">
                
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group mb-3">
                                    <label>Content *</label>
                                    <textarea name="terms" class="form-control editor" cols="30" rows="10"><?php echo $result[0]['terms']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form_submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>