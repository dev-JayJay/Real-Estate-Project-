<?php include 'header.php'; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php 
if (isset($_POST['form_submit'])) {
    try {
        if ($_POST['full_name'] == '') {
            throw new Exception("Full Name cannot be empty");            
        }
        if ($_POST['email'] == '') {
            throw new Exception("Email cannot be empty");            
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invaild");   
        }
        if ($_POST['password'] == '' || $_POST['retype_password'] == '') {
            throw new Exception("Password cannnot be empty");           
        }
        if ($_POST['password'] !== $_POST['retype_password'] ) {
            throw new Exception("Password does not match enter same password");           
        }

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = time();

        $statement = $pdo->prepare("INSERT INTO customers (full_name, email, photo, password, token, status) VALUES(?,?,?,?,?,?)");
        $statement->execute([$_POST['full_name'],$_POST['email'], '',$password, $token, 0]);

        $link = BASE_URL."customer-registration-verify.php?email=".$_POST['email']."&token=".$token;
        $email_message = "please click on these link to verify your resgistration <br>";
        $email_message .= '<a href="'.$link.'">Click Here</a>';

        try {
            $mail = new PHPMailer (true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_FROM);
            $mail->addAddress($_POST['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Registration Verification Email';
            $mail->Body = $email_message;
            $mail->send();
            $success_message = 'Please check your email and follow the steps.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        $success_massage = "Registeration Successful check email and comfirm account";
        unset($_POST['full_name']);
        unset($_POST['email']);

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
                <h2>Customer Registration</h2>
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
                            <label for="" class="form-label">Full Name *</label>
                            <input type="text" name="full_name" class="form-control" value="<?php if(isset($_POST['full_name'])) { echo $_POST['full_name']; } ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address *</label>
                            <input type="text" name="email" class="form-control" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Confirm Password *</label>
                            <input type="password" name="retype_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="form_submit" class="btn btn-primary bg-website">
                                Create Account
                            </button>
                        </div>
                    </form>
                    <div class="mb-3">
                        <a href="<?php echo BASE_URL; ?>customer-login" class="primary-color">Existing User? Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>