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
            <h1>View Posts</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>post-add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
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
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Posted On</th>
                                            <th>Total View</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT * FROM posts ORDER BY total_view DESC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" class="w_200">
                                                </td>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['slug']; ?></td>
                                                <td><?php echo $row['posted_on']; ?></td>
                                                <td><?php echo $row['total_view']; ?></td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>post-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>post-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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