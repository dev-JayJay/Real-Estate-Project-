<?php include 'layout/top.php'; ?>

<?php 
if (isset($_POST['form_submit'])) {
    try {
        if ($_POST['name'] == '') {
            throw new Exception("Name Cannot Be Empty");  
        }
        if ($_POST['price'] == '') {
            throw new Exception("Price Cannot Be Empty");  
        }
        if ($_POST['allowed_days'] == '') {
            throw new Exception("Allowed_days Cannot Be Empty");  
        }
        if ($_POST['allowed_properties'] == '') {
            throw new Exception("Allowed_properties Cannot Be Empty");  
        }
        if ($_POST['allowed_featured_properties'] == '') {
            throw new Exception("	allowed_featured_properties Cannot Be Empty");  
        }
        if ($_POST['allowed_photo'] == '') {
            throw new Exception("allowed_photo Cannot Be Empty");  
        }
        if ($_POST['allowed_videos'] == '') {
            throw new Exception("allowed_videos Cannot Be Empty");  
        }

        $statement = $pdo->prepare("INSERT INTO pakages (name,price,allowed_days,allowed_properties,allowed_featured_properties,allowed_photo,allowed_videos)
        VALUES (?,?,?,?,?,?,?)");
        $statement->execute(array($_POST['name'],$_POST['price'],$_POST['allowed_days'],$_POST['allowed_properties'],$_POST['allowed_featured_properties'],$_POST['allowed_photo'],$_POST['allowed_videos']));

        $success_massage = "Package added successfully";

        $_SESSION['success_message'] = $success_massage;
        header('location: '.ADMIN_URL.'package-add.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Add Packages</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>package-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group mb-3">
                                    <label>Name *</label>
                                    <input type="text" class="form-control" name="name" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Price *</label>
                                    <input type="text" class="form-control" name="price" value="<?php if(isset($_POST['price'])) {echo $_POST['price'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Allowed Days *</label>
                                    <input type="text" class="form-control" name="allowed_days" value="<?php if(isset($_POST['allowed_days'])) {echo $_POST['allowed_days'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Allowed Properties *</label>
                                    <input type="text" class="form-control" name="allowed_properties" value="<?php if(isset($_POST['allowed_properties'])) {echo $_POST['allowed_properties'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Allowed Featured Properties *</label>
                                    <input type="text" class="form-control" name="allowed_featured_properties" value="<?php if(isset($_POST['allowed_featured_properties'])) {echo $_POST['allowed_featured_properties'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Allowed Photo *</label>
                                    <input type="text" class="form-control" name="allowed_photo" value="<?php if(isset($_POST['allowed_photo'])) {echo $_POST['allowed_photo'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Allowed Videos *</label>
                                    <input type="text" class="form-control" name="allowed_videos" value="<?php if(isset($_POST['allowed_videos'])) {echo $_POST['allowed_videos'];} ?>">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="form_submit" class="btn btn-primary">Submit</button>
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