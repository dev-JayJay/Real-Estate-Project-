<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['agents'])) {
    header('location: '.BASE_URL.'agent-login');
    exit;
}

// If this agent did not purchase any package, he will be redirected to payment page
// $statement = $pdo->prepare("SELECT * FROM orders WHERE agent_id=?");
// $statement->execute(array($_SESSION['agents']['id']));
// $total = $statement->rowCount();
// if(!$total) {
//     $_SESSION['error_message'] = 'Please purchase a package first';
//     header('location: '.BASE_URL.'agent-payment');
//     exit;
// }
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>All Properties</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <?php include 'agent-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Thumbnail</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th class="w-100">Options</th>
                                <th class="w-60">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=0;
                            $statement = $pdo->prepare("SELECT properties.*, locations.name as locations_name, types.name as types_name, GROUP_CONCAT(amenities.name) as amenity_names
                                                FROM properties 
                                                JOIN locations
                                                ON properties.location_id = locations.id
                                                JOIN types
                                                ON properties.type_id = types.id
                                                JOIN amenities
                                                ON FIND_IN_SET(amenities.id, properties.amenities)
                                                WHERE properties.agent_id=?
                                                GROUP BY properties.id
                                                ORDER BY properties.id DESC");
                            $statement->execute([$_SESSION['agents']['id']]);
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            // $total = $statement->rowCount(); 
                            foreach ($result as $row) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <img src="<?php BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="" class="w-100">
                                    </td>
                                    <td>
                                        <?php echo $row['name']; ?><br>
                                        <?php if($row['is_featured'] == 'Yes'): ?>
                                        <span class="badge bg-success">Featured</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['locations_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['types_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['purpose']; ?>
                                    </td>
                                    <td>
                                        <?php if($row['status'] == 'Active'): ?>
                                        <span class="badge bg-success"><?php echo $row['status']; ?></span>
                                        <?php else: ?>
                                        <span class="badge bg-danger"><?php echo $row['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="w-150">
                                        <a href="<?php echo BASE_URL; ?>agent-photo-gallery/<?php echo $row['id']; ?>" class="btn btn-primary btn-sm btn-sm-custom w-100-p mb_5">Photo Gallery</a>
                                        <a href="<?php echo BASE_URL; ?>agent-video-gallery/<?php echo $row['id']; ?>" class="btn btn-primary btn-sm btn-sm-custom w-100-p mb_5">Video Gallery</a>
                                    </td>
                                    <td class="w-150">
                                        <a href="" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $i; ?>"><i class="fas fa-eye"></i></a>
                                        <a href="<?php echo BASE_URL; ?>agent-property-edit/<?php echo $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                        <a href="<?php echo BASE_URL; ?>agent-property-delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                                        <div class="modal fade" id="modal_<?php echo $i; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Featured Photo: </label></div>
                                                            <div class="col-md-8">
                                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="" class="w-200">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Property Name: </label></div>
                                                            <div class="col-md-8"><?php echo $row['name']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Location: </label></div>
                                                            <div class="col-md-8"><?php echo $row['locations_name']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Type: </label></div>
                                                            <div class="col-md-8"><?php echo $row['types_name']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Purpose: </label></div>
                                                            <div class="col-md-8"><?php echo $row['purpose']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Amenities: </label></div>
                                                            <div class="col-md-8">
                                                                <?php
                                                                $amenities = explode(',',$row['amenity_names']);
                                                                foreach ($amenities as $amenity) {
                                                                    echo '- '.$amenity.'<br>';
                                                                }
                                                                $amenities = $row['amenities'];
                                                                $amenities = explode(',', $amenities);
                                                                foreach ($amenities as $amenity) {
                                                                    $statement = $pdo->prepare("SELECT * FROM amenities WHERE id=?");
                                                                    $statement->execute([$amenity]);
                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($result as $row1) {
                                                                        echo $row1['name'] . ', ';
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Slug: </label></div>
                                                            <div class="col-md-8"><?php echo $row['slug']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Description: </label></div>
                                                            <div class="col-md-8"><?php echo $row['description']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Price: </label></div>
                                                            <div class="col-md-8">$<?php echo $row['price']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Bedroom: </label></div>
                                                            <div class="col-md-8"><?php echo $row['bedroom']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Bathroom: </label></div>
                                                            <div class="col-md-8"><?php echo $row['bathroom']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Size: </label></div>
                                                            <div class="col-md-8"><?php echo $row['size']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Floor: </label></div>
                                                            <div class="col-md-8"><?php echo $row['floor']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Garage: </label></div>
                                                            <div class="col-md-8"><?php echo $row['garage']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Balcony: </label></div>
                                                            <div class="col-md-8"><?php echo $row['balcony']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Address: </label></div>
                                                            <div class="col-md-8"><?php echo $row['address']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Built Year: </label></div>
                                                            <div class="col-md-8"><?php echo $row['built_year']; ?></div>
                                                        </div>
                                                        <div class="form-group row bdb1 pt_10 mb_0">
                                                            <div class="col-md-4"><label class="form-label">Map: </label></div>
                                                            <div class="col-md-8 map1">
                                                                <?php echo $row['map']; ?>
                                                            </div>
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

<?php include 'footer.php'; ?>