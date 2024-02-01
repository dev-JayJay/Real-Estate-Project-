<?php include 'layout/top.php'; ?>

<?php 
$statement = $pdo->prepare("SELECT * FROM admins WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'],$_REQUEST['token']]);
$total = $statement->rowCount();
if (!$total) {
    header('location: '.ADMIN_URL.'dashboard.php');
    exit;
}
?> 

<?php 
if (isset($_POST['reset_password'])) {
    try {
       if ($_POST['password_one'] == '' || $_POST['password_two'] == '') {
        throw new Exception("password cannot be empty");  
       }
       if ($_POST['password_one'] != $_POST['password_two']) {
        throw new Exception("password does not match");    
       }

       $new_password = password_hash($_POST['password_one'], PASSWORD_DEFAULT);
       $q = $pdo->prepare("UPDATE admins SET token=NULL, password=? WHERE email=? and token=?");
       $q->execute([$new_password, $_REQUEST['email'], $_REQUEST['token']]);
       
       header('location: '.ADMIN_URL.'login.php');
       exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

        <section class="section">
            <div class="container container-login">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary border-box">
                            <div class="card-header card-header-auth">
                                <h4 class="text-center">Reset Password</h4>
                            </div>
                            <div class="card-body card-body-auth">
                                <?php 
                                if (isset($success_message)) {
                                    echo $success_message;
                                }
                                if (isset($error_message)) {
                                    echo $error_message;
                                }
                                ?>
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password_one" placeholder="Password" value="" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password_two" placeholder="Retype Password" value="">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="reset_password" class="btn btn-primary btn-lg w_100_p">
                                        Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php include 'layout/footer.php'; ?>