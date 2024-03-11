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
        if($_POST['title'] == "") {
            throw new Exception("Title can not be empty.");
        }
        $statement = $pdo->prepare("SELECT * FROM posts WHERE title=? AND id!=?");
        $statement->execute([$_POST['title'], $_REQUEST['id']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Title already exists");
        }
        if($_POST['slug'] == "") {
            throw new Exception("Slug can not be empty.");
        }
        if(!preg_match('/^[a-z0-9-]+$/', $_POST['slug'])) {
            throw new Exception("Invalid slug format. Slug should only contain lowercase letters, numbers, and hyphens.");
        }
        $statement = $pdo->prepare("SELECT * FROM posts WHERE slug=? AND id!=?");
        $statement->execute([$_POST['slug'], $_REQUEST['id']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Slug already exists");
        }
        if($_POST['short_description'] == "") {
            throw new Exception("Short Description can not be empty.");
        }
        if($_POST['description'] == "") {
            throw new Exception("Description can not be empty.");
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

        $statement = $pdo->prepare("UPDATE posts 
                                    SET 
                                    title=?,
                                    slug=?,
                                    short_description=?,
                                    description=?,
                                    photo=?
                                    WHERE id=?");
        $statement->execute([
                                $_POST['title'],
                                $_POST['slug'],
                                $_POST['short_description'],
                                $_POST['description'],
                                $filename,
                                $_REQUEST['id']
                            ]);

        $success_message = "Post is updated successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'post-view.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Post</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>post-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
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
                                    <label>Title *</label>
                                    <input type="text" class="form-control" name="title" autocomplete="off" value="<?php echo $result[0]['title']; ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Slug *</label>
                                    <input type="text" class="form-control" name="slug" autocomplete="off" value="<?php echo $result[0]['slug']; ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Short Description *</label>
                                    <textarea name="short_description" class="form-control h_100" cols="30" rows="10"><?php echo $result[0]['short_description']; ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Description *</label>
                                    <textarea name="description" class="form-control editor" cols="30" rows="10"><?php echo $result[0]['description']; ?></textarea>
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