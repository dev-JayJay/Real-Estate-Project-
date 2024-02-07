<?php include 'layout/top.php'; ?>
<?php 
if (isset($_SESSION['admin'])) {
    header('location:' .ADMIN_URL. 'dashboard.php');
}
?>

<?php 
if (isset($_POST['form_login'])) {
    try {
        if ($_POST['email'] == '') {
            throw new Exception("Email connot be empty");
        }
        if ($_POST['password'] == '') {
            throw new Exception('password cannot be empty');
        }

        $q = $pdo->prepare("SELECT * FROM admins WHERE email=?");
        $q->execute([$_POST['email']]);
        $total = $q->rowCount();
        if (!$total) {
            throw new Exception("Email not found try again");           
        } else {
            $result = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $password = $row['password'];
                if (!password_verify($_POST['password'], $password)) {
                    throw new Exception("incorrect password please try again");                  
                }
            }
        }
        $_SESSION ['admin'] = $row;
        header('location:' .ADMIN_URL. 'dashboard.php');
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
                        <h4 class="text-center">Admin Panel Login</h4>
                    </div>
                    <div class="card-body card-body-auth">
                        <form method="POST" action="">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" value="" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password"  placeholder="Password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg w_100_p" name="form_login">
                                    Login
                                </button>
                            </div>
                            <div class="form-group">
                                <div>
                                    <a href="<?php echo ADMIN_URL; ?>forget-password.php">
                                        Forget Password?
                                    </a>
                                </div>
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