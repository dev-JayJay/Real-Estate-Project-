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
            <h1>View Properties</h1>
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
                                            <th>Thumbnail</th>
                                            <th>Name</th>
                                            <th>Agent</th>
                                            <th>Location</th>
                                            <th>Type</th>
                                            <th>Purpose</th>
                                            <th class="w-60">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=0;
                                        $statement = $pdo->prepare("SELECT properties.*, agents.full_name, agents.photo as agent_photo, agents.email, locations.name as locations_name, types.name as types_name, GROUP_CONCAT(amenities.name) as amenity_names
                                                            FROM properties 
                                                            JOIN locations
                                                            ON properties.location_id = locations.id
                                                            JOIN types
                                                            ON properties.type_id = types.id
                                                            JOIn agents
                                                            ON properties.agent_id = agents.id
                                                            JOIN amenities
                                                            ON FIND_IN_SET(amenities.id, properties.amenities)
                                                            GROUP BY properties.id
                                                            ORDER BY properties.is_featured DESC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="" class="w_100">
                                                </td>
                                                <td>
                                                    <?php echo $row['name']; ?><br>
                                                    <?php if($row['is_featured'] == 'Yes'): ?>
                                                    <span class="badge bg-success">Featured</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['agent_photo']; ?>" alt="" class="w_50"><br>
                                                    <?php echo $row['full_name']; ?><br>
                                                    <?php echo $row['email']; ?>
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
                                                <td class="pt_10 pb_10">
                                                    <a href="" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $i; ?>"><i class="fas fa-eye"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>property-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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
                                                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="" class="w_200">
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
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Photo Gallery: </label></div>
                                                                        <div class="col-md-8">
                                                                            <?php
                                                                            $statement1 = $pdo->prepare("SELECT * FROM properties_photos WHERE property_id=?");
                                                                            $statement1->execute(array($row['id']));
                                                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach ($result1 as $row1) {
                                                                                ?>
                                                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row1['photo']; ?>" alt="" class="w_200">
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row bdb1 pt_10 mb_0">
                                                                        <div class="col-md-4"><label class="form-label">Video Gallery: </label></div>
                                                                        <div class="col-md-8 video-all">
                                                                            <?php
                                                                            $statement1 = $pdo->prepare("SELECT * FROM property_videos WHERE property_id=?");
                                                                            $statement1->execute(array($row['id']));
                                                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach ($result1 as $row1) {
                                                                                ?>
                                                                                <div class="item">  
                                                                                 <a class="video-button" href="http://www.youtube.com/watch?v=<?php echo $row1['video_id']; ?>">
                                                                                    <img src="http://img.youtube.com/vi/<?php echo $row1['video_id']; ?>/0.jpg" alt="" />
                                                                                    <div class="icon">
                                                                                        <i class="far fa-play-circle"></i>
                                                                                    </div>
                                                                                    <div class="bg"></div>
                                                                                </a>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
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
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>