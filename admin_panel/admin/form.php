<?php include 'layout/top.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Form</h1>
            <div class="ml-auto">
                <a href="" class="btn btn-primary"><i class="fas fa-plus"></i> Button</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Text</label>
                                            <input type="text" class="form-control" name="" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Color</label>
                                            <input type="text" class="form-control jscolor" name="" value="A2A5FF">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Datepicker</label>
                                            <input type="text" id="datepicker" class="form-control" name="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Timepicker</label>
                                            <input type="text" id="timepicker" class="form-control" name="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Textarea</label>
                                    <textarea name="" class="form-control h_100" cols="30" rows="10"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Textarea</label>
                                    <textarea name="" class="form-control editor" cols="30" rows="10"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Photo</label>
                                    <div>
                                        <input type="file" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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