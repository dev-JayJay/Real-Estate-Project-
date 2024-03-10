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
            <h1>View Orders</h1>
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
                                            <th>Transaction Id</th>
                                            <th>Package Name</th>
                                            <th>Price</th>
                                            <th>Purchase Date</th>
                                            <th>Expire Date</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT orders.*, orders.id as order_id, packages.name, packages.price 
                                                                    FROM orders 
                                                                    JOIN packages
                                                                    ON orders.package_id = packages.id
                                                                    ORDER BY orders.currently_active DESC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php echo $row['transaction_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['name']; ?>
                                                </td>
                                                <td>
                                                    $<?php echo $row['price']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['purchase_date']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['expire_date']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['payment_method']; ?>
                                                </td>
                                                <td>
                                                    <?php if($row['currently_active'] == 1): ?>
                                                    <span class="badge bg-success">Active</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>order-delete.php?id=<?php echo $row['order_id']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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