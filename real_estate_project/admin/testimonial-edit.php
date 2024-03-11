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
        if($_POST['designation'] == "") {
            throw new Exception("Designation can not be empty.");
        }
        if($_POST['comment'] == "") {
            throw new Exception("Comment can not be empty.");
        }

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if($path!='') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time().".".$extension;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);

            if($mime != 'image/jpeg' && $mime != 'image/png') {
                throw new Exception("Please upload a valid photo");
            }
            unlink('../uploads/'.$_POST['current_photo']);
            move_uploaded_file($path_tmp, '../uploads/'.$filename);
        } else {
            $filename = $_POST['current_photo'];
        }

        $statement = $pdo->prepare("UPDATE testimonials 
                                    SET 
                                    name=?,
                                    designation=?,
                                    comment=?,
                                    photo=?
                                    WHERE id=?");
        $statement->execute([
                                $_POST['name'],
                                $_POST['designation'],
                                $_POST['comment'],
                                $filename,
                                $_REQUEST['id']
                            ]);

        $success_message = "Testimonial is updated successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'testimonial-view.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM testimonials WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Testimonial</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>testimonial-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="current_photo" value="<?php echo $result[0]['photo']; ?>">
                                <div class="form-group mb-3">
                                    <label>Existing Photo</label>
                                    <div>
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['photo']; ?>" alt="" class="w_200">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Change Photo</label>
                                    <div><input type="file" name="photo"></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Name *</label>
                                    <input type="text" class="form-control" name="name" autocomplete="off" value="<?php echo $result[0]['name']; ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Designation *</label>
                                    <input type="text" class="form-control" name="designation" autocomplete="off" value="<?php echo $result[0]['designation']; ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Comment *</label>
                                    <textarea name="comment" class="form-control h_100" cols="30" rows="10"><?php echo $result[0]['comment']; ?></textarea>
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