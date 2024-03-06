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
        if($_POST['name'] == "") {
            throw new Exception("Name can not be empty.");
        }
         // check if location already exits
         $statement = $pdo->prepare("SELECT * FROM locations WHERE name=?");
         $statement->execute([$_POST['name']]);
         $total = $statement->rowCount();
         if($total) {
             throw new Exception("Sorry These name already exist");
         }

        $statement = $pdo->prepare("SELECT * FROM locations WHERE name=?");
        $statement->execute([$_POST['name']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Name already exists");
        }
        if($_POST['slug'] == "") {
            throw new Exception("Slug can not be empty.");
        }
        if(!preg_match('/^[a-z0-9-]+$/', $_POST['slug'])) {
            throw new Exception("Invalid slug format. Slug should only contain lowercase letters, numbers, and hyphens.");
        }
        $statement = $pdo->prepare("SELECT * FROM locations WHERE slug=?");
        $statement->execute([$_POST['slug']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Slug already exists");
        }
        // check if slug already exits
        $statement = $pdo->prepare("SELECT * FROM locations WHERE slug=?");
        $statement->execute([$_POST['slug']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Sorry These slug already exist");
        }

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if($path=='') {
            throw new Exception("Please upload a valid photo");
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = time().".".$extension;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);

        if($mime != 'image/jpeg' && $mime != 'image/png') {
            throw new Exception("Please upload a valid photo");
        }

        move_uploaded_file($path_tmp, '../uploads/'.$filename);

        $statement = $pdo->prepare("INSERT INTO locations (photo, name, slug) VALUES (?, ?, ?)");
        $statement->execute([$filename, $_POST['name'], $_POST['slug']]);

        $success_message = "Location is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'location-add.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Add Location</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>location-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label>Photo *</label>
                                    <div><input type="file" name="photo"></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Name *</label>
                                    <input type="text" class="form-control" name="name" autocomplete="off" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Slug *</label>
                                    <input type="text" class="form-control" name="slug" autocomplete="off" value="<?php if(isset($_POST['slug'])) {echo $_POST['slug'];} ?>">
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