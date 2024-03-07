<?php include 'header.php'; ?>

<?php 
if (!isset($_SESSION['agents'])) {
    header('location:'.BASE_URL.'agent-login');
    exit;
}
?>

<?php 
if (isset($_POST['form_update'])) {
    try {
        // Name and email update code block
        if ($_POST['full_name'] == '') {
            throw new Exception("full name cannot be empty"); 
        }
        if ($_POST['email'] == '') {
            throw new Exception("email cannot be empty");           
        }

        // check if email already exits
        $statement = $pdo->prepare("SELECT * FROM agents WHERE email=? AND id=?");
        $statement->execute([$_POST['email'],$_SESSION['agents']['id']]);
        $total = $statement->rowCount();
        if($total) {
            throw new Exception("Sorry These email already exist");
        }
        
        $statement = $pdo->prepare("UPDATE agents SET 
                                    full_name=?,
                                    email=?,
                                    company=?,
                                    desgination=?,
                                    biography=?,
                                    phone=?
                                    country=?
                                    address=?
                                    state=?
                                    zip_code=?
                                    website=?
                                    facebook=?
                                    twitter=?
                                    pinterest=?
                                    instagram=?
                                    youtube=?
                                    WHERE id=?");

        $statement->execute([$_POST['full_name'],
                            $_POST['email'],
                            $_POST['company'],
                            $_POST['desgination'],
                            $_POST['biography'],
                            $_POST['phone'],
                            $_POST['country'],
                            $_POST['address'],
                            $_POST['state'],
                            $_POST['zip_code'],
                            $_POST['website'],
                            $_POST['facebook'],
                            $_POST['twitter'],
                            $_POST['pinterest'],
                            $_POST['instagram'],
                            $_POST['youtube'],
                            $_SESSION['agents']['id']]);

        // Password reset code block
        if ($_POST['password'] == '' || $_POST['retype_password'] == '') {
            throw new Exception("Password cannot be empty");
        }
        if ($_POST['password'] != $_POST['retype_password']) {
            throw new Exception("Passwrod does not match");               
        } else {
            $password  = password_hash($_POST['retype_password'], PASSWORD_DEFAULT);
            $statement = $pdo->prepare("UPDATE agents SET password=? WHERE id=?");
            $statement->execute([$password,$_SESSION['agents']['id']]);
        }

        // Update Photo
        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];
        if ($path != '') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time().".".$extension;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);

            if ($_SESSION['agents']['photo'] != '') {
                unlink('./uploads/'.$_SESSION['agents']['[photo]']);
            }

            if ($mime == 'image/jpeg' || $mime == 'image/png') {
                move_uploaded_file($path_tmp, './uploads/'.$filename);

                $statement = $pdo->prepare("UPDATE agents SET photo=? WHERE id=?");
                $statement->execute([$filename,$_SESSION['agents']['id']]);
                $_SESSION['agents']['photo'] = $filename;
            } else {
                throw new Exception("please upload a valid Photo");           
            }
        }

        $success_massage = "Profile data update successfully";

        $_SESSION['agents']['full_name'] = $_POST['full_name'];
        $_SESSION['agents']['email'] = $_POST['email'];
        $_SESSION['agents']['company'] = $_POST['company'];
        $_SESSION['agents']['desgination'] = $_POST['desgination'];
        $_SESSION['agents']['biography'] = $_POST['biography'];
        $_SESSION['agents']['phone'] = $_POST['phone'];
        $_SESSION['agents']['country'] = $_POST['country'];
        $_SESSION['agents']['address'] = $_POST['address'];
        $_SESSION['agents']['state'] = $_POST['state'];
        $_SESSION['agents']['city'] = $_POST['city'];
        $_SESSION['agents']['zip_code'] = $_POST['zip_code'];
        $_SESSION['agents']['website'] = $_POST['website'];
        $_SESSION['agents']['facebook'] = $_POST['facebook'];
        $_SESSION['agents']['twitter'] = $_POST['twitter'];
        $_SESSION['agents']['linkedin'] = $_POST['linkedin'];
        $_SESSION['agents']['pinteres'] = $_POST['pinteres'];
        $_SESSION['agents']['instagram'] = $_POST['instagram'];
        $_SESSION['agents']['youtube'] = $_POST['youtube'];

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Profile</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                
            <?php include 'agent-sidebar.php'; ?>

            </div>
            <div class="col-lg-9 col-md-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">Existing Photo</label>
                            <div class="form-group">
                                <?php if($_SESSION['agents']['photo'] == ''): ?>
                                    <img src="uploads/default.png" alt="" class="user-photo">
                                <?php else: ?>
                                    <img src="uploads/<?php echo $_SESSION['agents']['photo']; ?>" alt="" class="user-photo">
                                <?php endif; ?>
                                <img src="uploads/user-photo.jpg" alt="" class="user-photo">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Change Photo</label>
                            <div class="form-group">
                                <input type="file" name="photo">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Full Name *</label>
                            <div class="form-group">
                                <input type="text" name="full_name" class="form-control" value="<?php echo $_SESSION['agents']['full_name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Email Address *</label>
                            <div class="form-group">
                            <input type="text" name="email" class="form-control" value="<?php echo $_SESSION['agents']['email']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">password *</label>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Retype Password *</label>
                            <div class="form-group">
                                <input type="password" name="retype_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Company *</label>
                            <div class="form-group">
                                <input type="text" name="company" class="form-control" value="<?php echo $_SESSION['agents']['company']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Designation *</label>
                            <div class="form-group">
                                <input type="text" name="desgination" class="form-control" value="<?php echo $_SESSION['agents']['desgination']; ?>">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Biography</label>
                            <textarea name="biography" class="form-control editor" cols="30" rows="10"><?php echo $_SESSION['agents']['biography']; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Phone *</label>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="<?php echo $_SESSION['agents']['phone']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Country *</label>
                            <div class="form-group">
                                <input type="text" name="country" class="form-control" value="<?php echo $_SESSION['agents']['country']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Address *</label>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" value="<?php echo $_SESSION['agents']['address']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">State *</label>
                            <div class="form-group">
                                <input type="text" name="state" class="form-control" value="<?php echo $_SESSION['agents']['state']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">City *</label>
                            <div class="form-group">
                                <input type="text" name="city" class="form-control" value="<?php echo $_SESSION['agents']['city']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Zip Code *</label>
                            <div class="form-group">
                                <input type="text" name="zip_code" class="form-control" value="<?php echo $_SESSION['agents']['zip_code']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Website *</label>
                            <div class="form-group">
                                <input type="text" name="website" class="form-control" value="<?php echo $_SESSION['agents']['website']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Facebook *</label>
                            <div class="form-group">
                                <input type="text" name="facebook" class="form-control" value="<?php echo $_SESSION['agents']['facebook']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Twitter *</label>
                            <div class="form-group">
                                <input type="text" name="twitter" class="form-control" value="<?php echo $_SESSION['agents']['twitter']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Linkedin *</label>
                            <div class="form-group">
                                <input type="text" name="linkedin" class="form-control" value="<?php echo $_SESSION['agents']['linkedin']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Pinterest *</label>
                            <div class="form-group">
                                <input type="text" name="pinterest" class="form-control" value="<?php echo $_SESSION['agents']['pinterest']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Instagram *</label>
                            <div class="form-group">
                                <input type="text" name="instagram" class="form-control" value="<?php echo $_SESSION['agents']['instagram']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Youtube *</label>
                            <div class="form-group">
                                <input type="text" name="youtube" class="form-control" value="<?php echo $_SESSION['agents']['youtube']; ?>">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="form_update" type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>