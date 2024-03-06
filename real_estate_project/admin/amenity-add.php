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
         $statement = $pdo->prepare("SELECT * FROM amenities WHERE name=?");
         $statement->execute([$_POST['name']]);
         $total = $statement->rowCount();
         if($total) {
             throw new Exception("Sorry These name already exist");
         }
        //  end
        $statement = $pdo->prepare("SELECT * FROM amenities WHERE name=?");
        $statement->execute([$_POST['name']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Name already exists");
        }
        
        $statement = $pdo->prepare("INSERT INTO amenities (name) VALUES (?)");
        $statement->execute([$_POST['name']]);

        $success_message = "Amenity is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'amenity-add.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Add Amenity</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>amenity-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data"> 
                                <div class="form-group mb-3">
                                    <label>Name *</label>
                                    <input type="text" class="form-control" name="name" autocomplete="off" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
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