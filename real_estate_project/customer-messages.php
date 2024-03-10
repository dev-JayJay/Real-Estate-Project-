<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Messages</h2>
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
                <a href="<?php echo BASE_URL; ?>customer-message-create" class="btn btn-primary btn-sm mb_20">New Message</a>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Subject</th>
                                <th>Agent</th>
                                <th>Posted On</th>
                                <th class="w-100">Action</th>
                            </tr>

                            <?php
                            $i=0;
                            $statement = $pdo->prepare("SELECT m.*, m.id as message_id, a.full_name
                                                        FROM messages m
                                                        JOIN agents a
                                                        ON m.agent_id = a.id
                                                        WHERE m.customer_id=?");
                            $statement->execute([$_SESSION['customers']['id']]);
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['full_name']; ?></td>
                                    <td><?php echo $row['posted_on']; ?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>customer-message/<?php echo $row['message_id']; ?>" class="btn btn-primary btn-sm text-white"><i class="fas fa-eye"></i></a>
                                        <a href="<?php echo BASE_URL; ?>customer-message-delete.php?id=<?php echo $row['message_id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>