<?php include 'layout/top.php'; ?>

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Setting</h1>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="partial-item">
                                            <div class="form-group mb-3">
                                                <label>Existing Photo</label>
                                                <div>
                                                    <img src="<?php echo BASE_URL;?>uploads/logo.png" alt="" class="w_100">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Change Photo</label>
                                                <div>
                                                    <input type="file" name="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="partial-item">
                                            <div class="form-group mb-3">
                                                <label>Heading</label>
                                                <input type="text" class="form-control" name="" value="Our Services">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Subheading</label>
                                                <input type="text" class="form-control" name="" value="You will get some awesome services from us">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Status</label>
                                                <div class="toggle-container">
                                                    <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="" value="Show" checked>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt_30">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
<?php include 'layout/footer.php'; ?>