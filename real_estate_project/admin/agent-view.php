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
            <h1>View Agents</h1>
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
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Change Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT * FROM agents ORDER BY full_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php if($row['photo'] == ''): ?>
                                                        <!-- <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="" class="w_80"> -->
                                                    <?php else: ?>
                                                        <!-- <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" class="w_80"> -->
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $row['full_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <?php
                                                    if($row['status'] == 1) {
                                                        echo '<span class="badge badge-success">Active</span>';
                                                    } else {
                                                        echo '<span class="badge badge-danger">Inactive</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo ADMIN_URL; ?>agent-change-status.php?id=<?php echo $row['id']; ?>">Change Status</a>
                                                </td>
                                                <td class="pt_10 pb_10">
                                                    <a href="" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $i; ?>"><i class="fas fa-eye"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>agent-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                                                    <div class="modal fade" id="modal_<?php echo $i; ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Name: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['full_name']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Email: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['email']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Phone: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['phone']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Company: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['company']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Designation: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['designation']; ?></div>
                                                                    </div>

                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Biography: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['biography']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Country: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['country']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Address: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['address']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">State: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['state']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">City: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['city']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Zip Code: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['zip_code']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Website: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['website']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Facebook: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['facebook']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Twitter: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['twitter']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Linkedin: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['linkedin']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Pinterest: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['pinterest']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Instagram: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['instagram']; ?></div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Youtube: </label></div>
                                                                        <div class="col-md-8"><?php echo $row['youtube']; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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