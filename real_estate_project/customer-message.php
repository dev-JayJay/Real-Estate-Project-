<?php include 'header.php'; ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}

$statement = $pdo->prepare("SELECT * 
                            FROM messages 
                            WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM agents WHERE id=?");
$statement->execute([$result[0]['agent_id']]);
$result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result1 as $row) {
    $agent_name = $row['full_name'];
    $agent_email = $row['email'];
    $agent_photo = $row['photo'];
}
?>

<?php
if(isset($_POST['form_submit'])) {
    try {

        if($_POST['reply'] == '') {
            throw new Exception("Reply can not be empty");
        }

        $statement = $pdo->prepare("INSERT INTO message_replies (message_id,customer_id,agent_id,sender,reply,reply_on) VALUES (?,?,?,?,?,?)");
        $statement->execute([$_REQUEST['id'],$_SESSION['customers']['id'],$result[0]['agent_id'],'Customer',$_POST['reply'],date('Y-m-d H:i:s')]);


        $link = BASE_URL.'agent-message/'.$_REQUEST['id'];
        $email_message = 'A customer has sent you message. So please login to your account and check that.<br>';
        $email_message .= '<a href="'.$link.'">'.$link.'</a>';

        

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

            $success_message = 'Reply is sent successfully.';
            $_SESSION['success_message'] = $success_message;
            header('location: '.BASE_URL.'customer-message/'.$_REQUEST['id']);
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
                <h2>Subject: <?php echo $result[0]['subject']; ?></h2>
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


                <div class="message-reply">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Reply *</label>
                            <div class="form-group">
                                <textarea name="reply" class="form-control h-200" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <input name="form_submit" type="submit" class="btn btn-primary btn-sm mt_10" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="message-heading">
                    Main Message
                </div>
                <div class="message-item message-item-main">
                    <div class="message-top">
                        <div class="photo">
                            <?php if($_SESSION['customers']['photo'] == ''): ?>
                                <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                            <?php else: ?>
                                <!-- <img src="<?php echo BASE_URL; ?>uploads/<?php echo $_SESSION['customers']['photo']; ?>" alt=""> -->
                            <?php endif; ?>
                        </div>
                        <div class="text">
                            <h6><?php echo $_SESSION['customers']['full_name']; ?> <span class="badge rounded-pill text-bg-primary">Customer</span></h6>
                            <p>Posted on: <?php echo $result[0]['posted_on']; ?></p>
                        </div>
                    </div>
                    <div class="message-bottom">
                        <!-- <?php echo $result[0]['message']; ?> -->
                    </div>
                </div>


                <div class="message-heading">
                    All Replies
                </div>

                <?php
                $statement = $pdo->prepare("SELECT * 
                                            FROM message_replies
                                            WHERE message_id=? 
                                            ORDER BY id ASC");
                $statement->execute([$_REQUEST['id']]);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $total = $statement->rowCount();
                if(!$total) {
                    echo '<div class="message-item text-danger">No reply found</div>';
                }
                foreach($result as $row) {
                    ?>
                    <div class="message-item">
                        <div class="message-top">
                            <div class="photo">

                                <?php if($row['sender'] == 'Customer'): ?>
                                    <!-- <?php if($_SESSION['customers']['photo'] == ''): ?> -->
                                        <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                    <?php else: ?>
                                        <!-- <img src="<?php echo BASE_URL; ?>uploads/<?php echo $_SESSION['customers']['photo']; ?>" alt=""> -->
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if($row['sender'] == 'Agent'): ?>
                                    <?php if($agent_photo == ''): ?>
                                        <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                    <?php else: ?>
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $agent_photo; ?>" alt="">
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                            <div class="text">
                                <h6>
                                    <?php if($row['sender'] == 'Customer'): ?>
                                        <?php echo $_SESSION['customers']['full_name']; ?>  <span class="badge rounded-pill text-bg-primary">Customer</span>
                                    <?php else: ?>
                                        <?php echo $agent_name; ?>  <span class="badge rounded-pill text-bg-success">Agent</span>
                                    <?php endif; ?>
                                </h6>
                                <p>Posted on: <?php echo $row['reply_on']; ?></p>
                            </div>
                        </div>
                        <div class="message-bottom">
                            <?php echo $row['reply']; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
               
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>