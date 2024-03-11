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
        

        $statement = $pdo->prepare("INSERT INTO why_choose_items (heading,text,icon) VALUES (?,?,?)");
        $statement->execute([$_POST['heading'],$_POST['text'],$_POST['icon']]);

        $success_message = "Why Choose Item is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'why-choose-view.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Add Why Choose Item</h1>
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
                                    <input type="text" class="form-control" name="heading" autocomplete="off" value="">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Text *</label>
                                    <textarea name="text" class="form-control h_100" cols="30" rows="10"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Icon *</label>
                                    <input type="text" class="form-control" name="icon" autocomplete="off" value="">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form_submit">Submit</button>
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