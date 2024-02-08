<?php include 'layout/top.php'; ?>

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
                                        <tr>
                                            <td>1</td>
                                            <td>Laptop</td>
                                            <td>$100</td>
                                            <td class="pt_10 pb_10">
                                                <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal_1"><i class="fas fa-eye"></i></a>
                                                <a href="" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="" class="btn btn-danger" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                            <div class="modal fade" id="modal_1" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row bdb1 pt_10 mb_0">
                                                                <div class="col-md-4"><label class="form-label">Item Name</label></div>
                                                                <div class="col-md-8">Laptop</div>
                                                            </div>
                                                            <div class="form-group row bdb1 pt_10 mb_0">
                                                                <div class="col-md-4"><label class="form-label">Description</label></div>
                                                                <div class="col-md-8">This is a very good product. This is a very good product. This is a very good product. This is a very good product. This is a very good product. This is a very good product. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
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