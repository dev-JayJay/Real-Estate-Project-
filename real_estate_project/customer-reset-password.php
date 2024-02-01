<?php include 'header.php'; ?>

<?php 
$statement = $pdo->prepare("SELECT * FROM customers WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'],$_REQUEST['token']]);
$total = $statement->rowCount();
if (!$total) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
?> 

<?php 
if (isset($_POST['forget_password'])) {
    try {
       if ($_POST['password'] == '' || $_POST['retype_password'] == '') {
        throw new Exception("password cannot be empty");  
       }
       if ($_POST['password'] != $_POST['retype_password']) {
        throw new Exception("password does not match");    
       }

       $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
       $q = $pdo->prepare("UPDATE customers SET token=NULL, password=? WHERE email=? and token=?");
       $q->execute([$new_password, $_REQUEST['email'], $_REQUEST['token']]);

       $_SESSION['success_message'] = "Password Changed Succesfully. You can Login Now";
       
       header('location: '.BASE_URL.'customer-login');
       exit;

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
                <h2>Customer Reset Password</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-form">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">password *</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Retype password *</label>
                            <input type="password" name="retype_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="forget_password" class="btn btn-primary bg-website">
                                Submit
                            </button>
                        </div>                          
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>