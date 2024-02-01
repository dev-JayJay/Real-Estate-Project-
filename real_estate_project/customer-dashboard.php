<?php include 'header.php'; ?>

<?php 
if (!isset($_SESSION['customers'])) {
    header('location:'.BASE_URL.'customer-login');
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
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
                <h3><?php echo $_SESSION['customers']['full_name']; ?></h3>
                <p>See all the statistics at a glance:</p>

                <div class="row box-items">
                    <div class="col-md-4">
                        <div class="box1">
                            <h4>12</h4>
                            <p>Active Properties</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box2">
                            <h4>3</h4>
                            <p>Pending Properties</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box3">
                            <h4>5</h4>
                            <p>Featured Properties</p>
                        </div>
                    </div>
                </div>

                <h3 class="mt-5">Recent Properties</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>1375 Stanley Avenue</td>
                                <td>Villa</td>
                                <td>New York</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td>
                                    <a href="" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                    <a href="" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>3780 Ash Avenue</td>
                                <td>Condo</td>
                                <td>Boston</td>
                                <td>
                                    <span class="badge bg-danger">Pending</span>
                                </td>
                                <td>
                                    <a href="" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                    <a href="" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>