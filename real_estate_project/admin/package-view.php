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
            <h1>View Packages</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>package-add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT * FROM packages ORDER BY id ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>$<?php echo $row['price']; ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $i; ?>"><i class="fas fa-eye"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>package-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>package-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                                                </td>
                                                <div class="modal fade" id="modal_<?php echo $i; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Name</label></div>
                                                                    <div class="col-md-8"><?php echo $row['name']; ?></div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Price</label></div>
                                                                    <div class="col-md-8">$<?php echo $row['price']; ?></div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Allowed Days</label></div>
                                                                    <div class="col-md-8"><?php echo $row['allowed_days']; ?></div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Allowed Properties</label></div>
                                                                    <div class="col-md-8">
                                                                        <?php if($row['allowed_properties'] == '-1'): ?>
                                                                        Unlimited
                                                                        <?php else: ?>
                                                                        <?php echo $row['allowed_properties']; ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Allowed Featured Properties</label></div>
                                                                    <div class="col-md-8">
                                                                        <?php if($row['allowed_featured_properties'] == '-1'): ?>
                                                                        Unlimited
                                                                        <?php else: ?>
                                                                        <?php echo $row['allowed_featured_properties']; ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Allowed Photos</label></div>
                                                                    <div class="col-md-8">
                                                                        <?php if($row['allowed_photos'] == '-1'): ?>
                                                                        Unlimited
                                                                        <?php else: ?>
                                                                        <?php echo $row['allowed_photos']; ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row bdb1 pt_10 mb_0">
                                                                    <div class="col-md-4"><label class="form-label">Allowed Videos</label></div>
                                                                        <div class="col-md-8"><?php if($row['allowed_videos'] == '-1'): ?>
                                                                        Unlimited
                                                                        <?php else: ?>
                                                                        <?php echo $row['allowed_videos']; ?>
                                                                        <?php endif; ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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