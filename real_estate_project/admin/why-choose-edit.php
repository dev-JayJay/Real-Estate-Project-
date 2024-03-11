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
        if($_POST['heading'] == "") {
            throw new Exception("Heading can not be empty.");
        }
        if($_POST['text'] == "") {
            throw new Exception("Text can not be empty.");
        }
        if($_POST['icon'] == "") {
            throw new Exception("Icon can not be empty.");
        }
        
        $statement = $pdo->prepare("UPDATE why_choose_items 
                                    SET 
                                    heading=?,
                                    text=?,
                                    icon=?
                                    WHERE id=?");
        $statement->execute([
                                $_POST['heading'],
                                $_POST['text'],
                                $_POST['icon'],
                                $_REQUEST['id']
                            ]);

        $success_message = "Why Choose Item is updated successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'why-choose-view.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM why_choose_items WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Why Choose Item</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>why-choose-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group mb-3">
                                    <label>Heading *</label>
                                    <input type="text" class="form-control" name="heading" autocomplete="off" value="<?php echo $result[0]['heading']; ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Text *</label>
                                    <textarea name="text" class="form-control h_100" cols="30" rows="10"><?php echo $result[0]['text']; ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Icon *</label>
                                    <input type="text" class="form-control" name="icon" autocomplete="off" value="<?php echo $result[0]['icon']; ?>">
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

<?php include 'layouts/footer.php'; ?>