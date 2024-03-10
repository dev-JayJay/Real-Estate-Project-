<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
// next auto increment id
$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'messages'");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row) {
    $next_id = $row['Auto_increment'];
}
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(isset($_POST['form_submit'])) {
    try {

        if($_POST['subject'] == '') {
            throw new Exception("Subject can not be empty");
        }
        if($_POST['message'] == '') {
            throw new Exception("Message can not be empty");
        }
       
        $statement = $pdo->prepare("INSERT INTO messages (subject,message,customer_id,agent_id,posted_on) VALUES (?,?,?,?,?)");
        $statement->execute([$_POST['subject'],$_POST['message'],$_SESSION['customers']['id'],$_POST['agent_id'],date('Y-m-d H:i:s')]);


        $link = BASE_URL.'agent-message/'.$next_id;
        $email_message = 'A customer has sent you message. So please login to your account and click on this link:<br>';
        $email_message .= '<a href="'.$link.'">'.$link.'</a>';

        $statement = $pdo->prepare("SELECT * FROM agents WHERE id=?");
        $statement->execute([$_POST['agent_id']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $agent_email = $row['email'];
        }

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
            $mail->addAddress($agent_email);
            //$mail->addReplyTo('contact@example.com');
            $mail->isHTML(true);
            $mail->Subject = 'Customer Message';
            $mail->Body = $email_message;
            $mail->send();

            $success_message = 'Message is sent successfully.';
            $_SESSION['success_message'] = $success_message;
            header('location: '.BASE_URL.'customer-messages');
            exit;

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
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
                <h2>Create New Message</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <?php include 'customer-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <a href="<?php echo BASE_URL; ?>customer-messages" class="btn btn-primary btn-sm mb_20">All Messages</a>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Subject *</label>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Message *</label>
                            <div class="form-group">
                                <textarea name="message" class="form-control editor" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Select Agent *</label>
                            <div class="form-group">
                                <select name="agent_id" class="form-select select2">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM agents WHERE status=? ORDER BY full_name ASC");
                                    $statement->execute([1]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name'].' - '.$row['email']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="form_submit" type="submit" class="btn btn-primary" value="Send Message">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>