<?php include 'layout/top.php'; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
if(isset($_POST['form_submit'])) {
    try {
        if($_POST['subject'] == "") {
            throw new Exception("Subject can not be empty.");
        }
        if($_POST['message'] == "") {
            throw new Exception("Message can not be empty.");
        }

        $email_message = $_POST['message'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_ENCRYPTION;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_FROM);
            $mail->Subject = $_POST['subject'];
            $mail->Body = nl2br($email_message);
            
            $statement = $pdo->prepare("SELECT * FROM subscribers WHERE status=?");
            $statement->execute([1]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $mail2 = clone $mail;
                $mail2->addAddress($row['email']);
                $mail2->isHTML(true);
                $mail2->send();
            }

            $success_message = "Email is sent successfully.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'subscriber-send-email.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Send Email to Subscribers</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>subscriber-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Previous</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group mb-3">
                                    <label>Subject *</label>
                                    <input type="text" class="form-control" name="subject" autocomplete="off" value="<?php if(isset($_POST['subject'])) {echo $_POST['subject'];} ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Message *</label>
                                    <textarea name="message" class="form-control h_200" cols="30" rows="10"><?php if(isset($_POST['message'])) {echo $_POST['message'];} ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form_submit">Send Email</button>
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