<?php include 'layout/top.php'; ?>

<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php 
if (isset($_POST['forget_password'])) {
    try {
        if ($_POST['email'] == '') {
            throw new Exception("Email is empty please enter email");  
        }
        $q = $pdo->prepare("SELECT * FROM admins WHERE email=?");
        $q->execute([$_POST['email']]);
        $total = $q->rowCount();
        if (!$total) {
            throw new Exception("email is not found please renter your email");    
        }

        $token = time();
        $statement = $pdo->prepare("UPDATE admins SET token=? WHERE email=?");
        $statement->execute([$token, $_POST['email']]);

        $email_message = "please click the link to reset your password";
        $email_message .= '<a href="'.ADMIN_URL.'reset-password.php?email='.$_POST['email'].'& token='.$token.'">Reset_your_password</a>';
         
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
                $mail->Subject = 'Reset Password';
                $mail->Body = $email_message;
                $mail->send();

                $success_massage = 'Please check your email and follow the steps.';

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        

        $success_massage = 'please visit your email and follow instructions to reset password';

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
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email Address" value="" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="forget_password" class="btn btn-primary btn-lg w_100_p">
                                            Send Password Reset Link
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <a href="<?php echo ADMIN_URL; ?>login.php">
                                                Back to login page
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
<?php include 'layout/footer.php'; ?>