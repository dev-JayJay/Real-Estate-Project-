<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>View Messages</h1>
            <div class="ml-auto">
                
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Subject</th>
                                            <th>Customer</th>
                                            <th>Agent</th>
                                            <th>Posted On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT m.*, m.id as message_id, c.full_name as customer_name, c.email as customer_email, a.full_name as agent_name, a.email as agent_email
                                                                    FROM messages m
                                                                    JOIN customers c
                                                                    ON m.customer_id = c.id
                                                                    JOIN agents a
                                                                    ON m.agent_id = a.id");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['subject']; ?></td>
                                                <td>
                                                    <?php echo $row['customer_name']; ?><br>
                                                    <?php echo $row['customer_email']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['agent_name']; ?><br>
                                                    <?php echo $row['agent_email']; ?>
                                                </td>
                                                <td><?php echo $row['posted_on']; ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>message-detail.php?id=<?php echo $row['message_id']; ?>" class="btn btn-primary btn-sm text-white"><i class="fas fa-eye"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>message-delete.php?id=<?php echo $row['message_id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
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
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>