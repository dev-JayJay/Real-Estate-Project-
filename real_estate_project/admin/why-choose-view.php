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
            <h1>View Why Choose Items</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>why-choose-add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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
                                            <th>Icon</th>
                                            <th>Heading</th>
                                            <th>Text</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT * FROM why_choose_items ORDER BY id ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><i class="<?php echo $row['icon']; ?>"></i></td>
                                                <td><?php echo $row['heading']; ?></td>
                                                <td><?php echo $row['text']; ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>why-choose-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>why-choose-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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