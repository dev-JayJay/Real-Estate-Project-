<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['agent'])) {
    header('location: '.BASE_URL.'agent-login');
    exit;
}
$statement = $pdo->prepare("SELECT * FROM properties WHERE id=? AND agent_id=?");
$statement->execute([$_REQUEST['id'],$_SESSION['agent']['id']]);
$total = $statement->rowCount();
if(!$total) {
    header('location: '.BASE_URL.'agent-login');
    exit;
}
?>

<?php
if(isset($_POST['form_submit'])) {
    try {
        if($_POST['name'] == '') {
            throw new Exception('Name can not be empty');
        }
        if($_POST['slug'] == "") {
            throw new Exception("Slug can not be empty.");
        }
        if(!preg_match('/^[a-z0-9-]+$/', $_POST['slug'])) {
            throw new Exception("Invalid slug format. Slug should only contain lowercase letters, numbers, and hyphens.");
        }
        if($_POST['price'] == '') {
            throw new Exception('Price can not be empty');
        }
        if($_POST['description'] == '') {
            throw new Exception('Description can not be empty');
        }
        if($_POST['bedroom'] == '') {
            throw new Exception('Bedroom can not be empty');
        }
        if($_POST['bathroom'] == '') {
            throw new Exception('Bathroom can not be empty');
        }
        if($_POST['size'] == '') {
            throw new Exception('Size can not be empty');
        }
        if($_POST['floor'] == '') {
            throw new Exception('Floor can not be empty');
        }
        if($_POST['garage'] == '') {
            throw new Exception('Garage can not be empty');
        }
        if($_POST['balcony'] == '') {
            throw new Exception('Balcony can not be empty');
        }
        if($_POST['address'] == '') {
            throw new Exception('Address can not be empty');
        }
        if($_POST['built_year'] == '') {
            throw new Exception('Built Year can not be empty');
        }
        if($_POST['map'] == '') {
            throw new Exception('Map can not be empty');
        }

        if($_POST['is_featured'] == 'Yes') {
            $statement = $pdo->prepare("SELECT * 
                                        FROM orders o
                                        JOIN packages p
                                        ON o.package_id=p.id
                                        WHERE o.agent_id=? AND o.currently_active=?");
            $statement->execute([$_SESSION['agent']['id'],1]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $allowed_featured_properties = $row['allowed_featured_properties'];
            }
            if($allowed_featured_properties == 0) {
                throw new Exception('You have no featured property left. Please upgrade your package.');
            }

            $statement = $pdo->prepare("SELECT * FROM properties WHERE agent_id=? AND is_featured=?");
            $statement->execute([$_SESSION['agent']['id'],'Yes']);
            $total_featured_added = $statement->rowCount();
            if($total_featured_added == $allowed_featured_properties) {
                throw new Exception('You have no featured property left. Please upgrade your package.');
            }
        }

        if(!isset($_POST['amenities'])) {
            throw new Exception('Please select at least one amenity');
        } else {
            $amenities = '';
            for($i=0;$i<count($_POST['amenities']);$i++) {
                if($i==0) {
                    $amenities .= $_POST['amenities'][$i];    
                } else {
                    $amenities .= ",".$_POST['amenities'][$i];    
                }
            }
        }

        $path = $_FILES['featured_photo']['name'];
        $path_tmp = $_FILES['featured_photo']['tmp_name'];

        if($path!='') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time().".".$extension;
    
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);
    
            if($mime != 'image/jpeg' && $mime != 'image/png') {
                throw new Exception("Please upload a valid photo");
            }
            unlink('uploads/'.$_POST['current_featured_photo']);
            move_uploaded_file($path_tmp, 'uploads/'.$filename);
        } else {
            $filename = $_POST['current_featured_photo'];
        }

        $statement = $pdo->prepare("UPDATE properties 
                                    SET 
                                    location_id=?,
                                    type_id=?,
                                    amenities=?,
                                    name=?,
                                    slug=?,
                                    description=?,
                                    featured_photo=?,
                                    price=?,
                                    purpose=?,
                                    bedroom=?,
                                    bathroom=?,
                                    size=?,
                                    floor=?,
                                    garage=?,
                                    balcony=?,
                                    address=?,
                                    built_year=?,
                                    map=?,
                                    is_featured=?
                                    WHERE id=?");
        $statement->execute([
                                $_POST['location_id'],
                                $_POST['type_id'],
                                $amenities,
                                $_POST['name'],
                                $_POST['slug'],
                                $_POST['description'],
                                $filename,
                                $_POST['price'],
                                $_POST['purpose'],
                                $_POST['bedroom'],
                                $_POST['bathroom'],
                                $_POST['size'],
                                $_POST['floor'],
                                $_POST['garage'],
                                $_POST['balcony'],
                                $_POST['address'],
                                $_POST['built_year'],
                                $_POST['map'],
                                $_POST['is_featured'],
                                $_REQUEST['id']
                            ]);
  
        $success_message = 'Property is updated successfully.';
        $_SESSION['success_message'] = $success_message;
        header('location: '.BASE_URL.'agent-property-edit/'.$_REQUEST['id']);
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Update Property</h2>
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
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="current_featured_photo" value="<?php echo $result[0]['featured_photo']; ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $result[0]['name']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Slug *</label>
                            <input type="text" name="slug" class="form-control" value="<?php echo $result[0]['slug']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Price *</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $result[0]['price']; ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Description *</label>
                            <textarea name="description" class="form-control editor" cols="30" rows="10"><?php echo $result[0]['description']; ?></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Location *</label>
                            <select name="location_id" class="form-control select2">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM locations ORDER BY name ASC");
                                $statement->execute();
                                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result1 as $row) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($result[0]['location_id'] == $row['id']) {echo 'selected';} ?>><?php echo $row['name']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Type *</label>
                            <select name="type_id" class="form-control select2">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM types ORDER BY name ASC");
                                $statement->execute();
                                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result1 as $row) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($result[0]['type_id'] == $row['id']) {echo 'selected';} ?>><?php echo $row['name']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Purpose *</label>
                            <select name="purpose" class="form-control select2">
                                <option value="Sale" <?php if($result[0]['purpose'] == 'Sale') {echo 'selected';} ?>>Sale</option>
                                <option value="Rent" <?php if($result[0]['purpose'] == 'Rent') {echo 'selected';} ?>>Rent</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Bedrooms *</label>
                            <input type="number" name="bedroom" class="form-control" min="0" value="<?php echo $result[0]['bedroom']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Bathrooms *</label>
                            <input type="number" name="bathroom" class="form-control" min="0" value="<?php echo $result[0]['bathroom']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Size (Sqft) *</label>
                            <input type="text" name="size" class="form-control" value="<?php echo $result[0]['size']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Floor *</label>
                            <input type="number" name="floor" class="form-control" min="0" value="<?php echo $result[0]['floor']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Garage *</label>
                            <input type="number" name="garage" class="form-control" min="0" value="<?php echo $result[0]['garage']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Balcony *</label>
                            <input type="number" name="balcony" class="form-control" min="0" value="<?php echo $result[0]['balcony']; ?>">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="" class="form-label">Address *</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $result[0]['address']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Built Year *</label>
                            <input type="text" name="built_year" class="form-control" value="<?php echo $result[0]['built_year']; ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Location Map *</label>
                            <textarea name="map" class="form-control h-150" cols="30" rows="10"><?php echo $result[0]['map']; ?></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Is Featured? *</label>
                            <select name="is_featured" class="form-control select2">
                                <option value="Yes" <?php if($result[0]['is_featured'] == 'Yes') {echo 'selected';} ?>>Yes</option>
                                <option value="No" <?php if($result[0]['is_featured'] == 'No') {echo 'selected';} ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Amenities *</label>
                            <div class="row">
                                <?php
                                $i=0;
                                $temp_arr = [];
                                $temp_arr = explode(',',$result[0]['amenities']);
                                $statement = $pdo->prepare("SELECT * FROM amenities ORDER BY name ASC");
                                $statement->execute();
                                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result1 as $row) {
                                    $i++;
                                    ?>
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input name="amenities[]" class="form-check-input" type="checkbox" value="<?php echo $row['id']; ?>" id="chk<?php echo $i; ?>" <?php if(in_array($row['id'],$temp_arr)) {echo 'checked';} ?>>
                                            <label class="form-check-label" for="chk<?php echo $i; ?>">
                                                <?php echo $row['name']; ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Existing Featured Photo</label>
                            <div>
                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['featured_photo']; ?>" alt="" class="w-200">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Change Featured Photo</label>
                            <div>
                                <input type="file" name="featured_photo">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="submit" class="btn btn-primary" name="form_submit" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>