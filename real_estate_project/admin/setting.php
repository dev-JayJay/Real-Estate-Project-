<?php include 'layout/top.php'; ?>

<?php
if(!isset($_SESSION['admin'])) {
    header('location: '.ADMIN_URL.'login.php');
    exit;
}
?>

<?php
if(isset($_POST['form_update'])) {
    try {
        
        if($_POST['address'] == "") {
            throw new Exception("Address can not be empty.");
        }
        if($_POST['email'] == "") {
            throw new Exception("Email can not be empty.");
        }
        if($_POST['phone'] == "") {
            throw new Exception("Phone can not be empty.");
        }
        if($_POST['copyright'] == "") {
            throw new Exception("Copyright Text can not be empty.");
        }
        if($_POST['map'] == "") {
            throw new Exception("Map can not be empty.");
        }
        if($_POST['hero_heading'] == "") {
            throw new Exception("Hero Heading can not be empty.");
        }
        if($_POST['hero_subheading'] == "") {
            throw new Exception("Hero Subheading can not be empty.");
        }
        if($_POST['featured_property_heading'] == "") {
            throw new Exception("Featured Property Heading can not be empty.");
        }
        if($_POST['featured_property_subheading'] == "") {
            throw new Exception("Featured Property Subheading can not be empty.");
        }
        if($_POST['why_choose_heading'] == "") {
            throw new Exception("Why Choose Heading can not be empty.");
        }
        if($_POST['why_choose_subheading'] == "") {
            throw new Exception("Why Choose Subheading can not be empty.");
        }
        if($_POST['agent_heading'] == "") {
            throw new Exception("Agent Heading can not be empty.");
        }
        if($_POST['agent_subheading'] == "") {
            throw new Exception("Agent Subheading can not be empty.");
        }
        if($_POST['location_heading'] == "") {
            throw new Exception("Location Heading can not be empty.");
        }
        if($_POST['location_subheading'] == "") {
            throw new Exception("Location Subheading can not be empty.");
        }
        if($_POST['testimonial_heading'] == "") {
            throw new Exception("Testimonial Heading can not be empty.");
        }
        if($_POST['post_heading'] == "") {
            throw new Exception("Post Heading can not be empty.");
        }
        if($_POST['post_subheading'] == "") {
            throw new Exception("Post Subheading can not be empty.");
        }


        $path_logo = $_FILES['logo']['name'];
        $path_tmp_logo = $_FILES['logo']['tmp_name'];
        if($path_logo!='') {
            $extension_logo = pathinfo($path_logo, PATHINFO_EXTENSION);
            $filename_logo = "logo.".$extension_logo;
            $finfo_logo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_logo = finfo_file($finfo_logo, $path_tmp_logo);
            if($mime_logo != 'image/jpeg' && $mime_logo != 'image/png') {
                throw new Exception("Please upload a valid logo");
            }
            unlink('../uploads/'.$_POST['current_logo']);
            move_uploaded_file($path_tmp_logo, '../uploads/'.$filename_logo);
        } else {
            $filename_logo = $_POST['current_logo'];
        }


        $path_favicon = $_FILES['favicon']['name'];
        $path_tmp_favicon = $_FILES['favicon']['tmp_name'];
        if($path_favicon!='') {
            $extension_favicon = pathinfo($path_favicon, PATHINFO_EXTENSION);
            $filename_favicon = "favicon.".$extension_favicon;
            $finfo_favicon = finfo_open(FILEINFO_MIME_TYPE);
            $mime_favicon = finfo_file($finfo_favicon, $path_tmp_favicon);
            if($mime_favicon != 'image/jpeg' && $mime_favicon != 'image/png') {
                throw new Exception("Please upload a valid favicon");
            }
            unlink('../uploads/'.$_POST['current_favicon']);
            move_uploaded_file($path_tmp_favicon, '../uploads/'.$filename_favicon);
        } else {
            $filename_favicon = $_POST['current_favicon'];
        }


        $path_banner = $_FILES['banner']['name'];
        $path_tmp_banner = $_FILES['banner']['tmp_name'];
        if($path_banner!='') {
            $extension_banner = pathinfo($path_banner, PATHINFO_EXTENSION);
            $filename_banner = "banner.jpg";
            $finfo_banner = finfo_open(FILEINFO_MIME_TYPE);
            $mime_banner = finfo_file($finfo_banner, $path_tmp_banner);
            if($mime_banner != 'image/jpeg' && $mime_banner != 'image/png') {
                throw new Exception("Please upload a valid banner");
            }
            unlink('../uploads/banner.jpg');
            move_uploaded_file($path_tmp_banner, '../uploads/'.$filename_banner);
        } else {
            $filename_banner = 'banner.jpg';
        }



        $path_hero_photo = $_FILES['hero_photo']['name'];
        $path_tmp_hero_photo = $_FILES['hero_photo']['tmp_name'];
        if($path_hero_photo!='') {
            $extension_hero_photo = pathinfo($path_hero_photo, PATHINFO_EXTENSION);
            $filename_hero_photo = "hero_photo.".$extension_hero_photo;
            $finfo_hero_photo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_hero_photo = finfo_file($finfo_hero_photo, $path_tmp_hero_photo);
            if($mime_hero_photo != 'image/jpeg' && $mime_hero_photo != 'image/png') {
                throw new Exception("Please upload a valid hero photo");
            }
            unlink('../uploads/'.$_POST['current_hero_photo']);
            move_uploaded_file($path_tmp_hero_photo, '../uploads/'.$filename_hero_photo);
        } else {
            $filename_hero_photo = $_POST['current_hero_photo'];
        }


        if(isset($_POST['featured_property_status']) && $_POST['featured_property_status'] == 'Show') {
            $featured_property_status = $_POST['featured_property_status'];
        } else {
            $featured_property_status = "Hide";
        }


        $path_why_choose_photo = $_FILES['why_choose_photo']['name'];
        $path_tmp_why_choose_photo = $_FILES['why_choose_photo']['tmp_name'];
        if($path_why_choose_photo!='') {
            $extension_why_choose_photo = pathinfo($path_why_choose_photo, PATHINFO_EXTENSION);
            $filename_why_choose_photo = "why_choose_photo.".$extension_why_choose_photo;
            $finfo_why_choose_photo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_why_choose_photo = finfo_file($finfo_why_choose_photo, $path_tmp_why_choose_photo);
            if($mime_why_choose_photo != 'image/jpeg' && $mime_why_choose_photo != 'image/png') {
                throw new Exception("Please upload a valid why choose photo");
            }
            unlink('../uploads/'.$_POST['current_why_choose_photo']);
            move_uploaded_file($path_tmp_why_choose_photo, '../uploads/'.$filename_why_choose_photo);
        } else {
            $filename_why_choose_photo = $_POST['current_why_choose_photo'];
        }

        if(isset($_POST['why_choose_status']) && $_POST['why_choose_status'] == 'Show') {
            $why_choose_status = $_POST['why_choose_status'];
        } else {
            $why_choose_status = "Hide";
        }


        if(isset($_POST['agent_status']) && $_POST['agent_status'] == 'Show') {
            $agent_status = $_POST['agent_status'];
        } else {
            $agent_status = "Hide";
        }


        if(isset($_POST['location_status']) && $_POST['location_status'] == 'Show') {
            $location_status = $_POST['location_status'];
        } else {
            $location_status = "Hide";
        }


        $path_testimonial_photo = $_FILES['testimonial_photo']['name'];
        $path_tmp_testimonial_photo = $_FILES['testimonial_photo']['tmp_name'];
        if($path_testimonial_photo!='') {
            $extension_testimonial_photo = pathinfo($path_testimonial_photo, PATHINFO_EXTENSION);
            $filename_testimonial_photo = "testimonial_photo.".$extension_testimonial_photo;
            $finfo_testimonial_photo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_testimonial_photo = finfo_file($finfo_testimonial_photo, $path_tmp_testimonial_photo);
            if($mime_testimonial_photo != 'image/jpeg' && $mime_testimonial_photo != 'image/png') {
                throw new Exception("Please upload a valid why choose photo");
            }
            unlink('../uploads/'.$_POST['current_testimonial_photo']);
            move_uploaded_file($path_tmp_testimonial_photo, '../uploads/'.$filename_testimonial_photo);
        } else {
            $filename_testimonial_photo = $_POST['current_testimonial_photo'];
        }

        if(isset($_POST['testimonial_status']) && $_POST['testimonial_status'] == 'Show') {
            $testimonial_status = $_POST['testimonial_status'];
        } else {
            $testimonial_status = "Hide";
        }




        if(isset($_POST['post_status']) && $_POST['post_status'] == 'Show') {
            $post_status = $_POST['post_status'];
        } else {
            $post_status = "Hide";
        }

        
        $statement = $pdo->prepare("UPDATE settings 
                                    SET 
                                    logo=?,
                                    favicon=?,
                                    banner=?,
                                    address=?,
                                    email=?,
                                    phone=?,
                                    copyright=?,
                                    facebook=?,
                                    twitter=?,
                                    linkedin=?,
                                    instagram=?,
                                    youtube=?,
                                    map=?,
                                    hero_heading=?,
                                    hero_subheading=?,
                                    hero_photo=?,
                                    featured_property_heading=?,
                                    featured_property_subheading=?,
                                    featured_property_status=?,
                                    why_choose_heading=?,
                                    why_choose_subheading=?,
                                    why_choose_photo=?,
                                    why_choose_status=?,
                                    agent_heading=?,
                                    agent_subheading=?,
                                    agent_status=?,
                                    location_heading=?,
                                    location_subheading=?,
                                    location_status=?,
                                    testimonial_heading=?,
                                    testimonial_photo=?,
                                    testimonial_status=?,
                                    post_heading=?,
                                    post_subheading=?,
                                    post_status=?

                                    WHERE id=?");
        $statement->execute([
                                $filename_logo,
                                $filename_favicon,
                                $filename_banner,
                                $_POST['address'],
                                $_POST['email'],
                                $_POST['phone'],
                                $_POST['copyright'],
                                $_POST['facebook'],
                                $_POST['twitter'],
                                $_POST['linkedin'],
                                $_POST['instagram'],
                                $_POST['youtube'],
                                $_POST['map'],
                                $_POST['hero_heading'],
                                $_POST['hero_subheading'],
                                $filename_hero_photo,
                                $_POST['featured_property_heading'],
                                $_POST['featured_property_subheading'],
                                $featured_property_status,
                                $_POST['why_choose_heading'],
                                $_POST['why_choose_subheading'],
                                $filename_why_choose_photo,
                                $why_choose_status,
                                $_POST['agent_heading'],
                                $_POST['agent_subheading'],
                                $agent_status,
                                $_POST['location_heading'],
                                $_POST['location_subheading'],
                                $location_status,
                                $_POST['testimonial_heading'],
                                $filename_testimonial_photo,
                                $testimonial_status,
                                $_POST['post_heading'],
                                $_POST['post_subheading'],
                                $post_status,
                                1
                            ]);

        $success_message = "Data is updated successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.ADMIN_URL.'setting.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM settings WHERE id=?");
$statement->execute([1]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

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
                                <input type="hidden" name="current_logo" value="<?php echo $result[0]['logo']; ?>">
                                <input type="hidden" name="current_favicon" value="<?php echo $result[0]['favicon']; ?>">
                                <input type="hidden" name="current_hero_photo" value="<?php echo $result[0]['hero_photo']; ?>">
                                <input type="hidden" name="current_why_choose_photo" value="<?php echo $result[0]['why_choose_photo']; ?>">
                                <input type="hidden" name="current_testimonial_photo" value="<?php echo $result[0]['testimonial_photo']; ?>">

                                <div class="partial-header">Logo & Favicon</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Existing Logo</label>
                                        <div>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['logo']; ?>" alt="" class="w_100">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Logo</label>
                                        <div>
                                            <input type="file" name="logo">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing Favicon</label>
                                        <div>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['favicon']; ?>" alt="" class="w_50">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Favicon</label>
                                        <div>
                                            <input type="file" name="favicon">
                                        </div>
                                    </div>
                                </div>


                                <div class="partial-header">Banner</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Existing Banner</label>
                                        <div>
                                            <img src="<?php echo BASE_URL; ?>uploads/banner.jpg" alt="" class="w_300">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Banner</label>
                                        <div>
                                            <input type="file" name="banner">
                                        </div>
                                    </div>
                                </div>


                                <div class="partial-header">Footer</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Address *</label>
                                        <input type="text" class="form-control" name="address" value="<?php echo $result[0]['address']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Email *</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $result[0]['email']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Phone *</label>
                                        <input type="text" class="form-control" name="phone" value="<?php echo $result[0]['phone']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Copyright Text *</label>
                                        <input type="text" class="form-control" name="copyright" value="<?php echo $result[0]['copyright']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control" name="facebook" value="<?php echo $result[0]['facebook']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Twitter</label>
                                        <input type="text" class="form-control" name="twitter" value="<?php echo $result[0]['twitter']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Liknedin</label>
                                        <input type="text" class="form-control" name="linkedin" value="<?php echo $result[0]['linkedin']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Instagram</label>
                                        <input type="text" class="form-control" name="instagram" value="<?php echo $result[0]['instagram']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Youtube</label>
                                        <input type="text" class="form-control" name="youtube" value="<?php echo $result[0]['youtube']; ?>">
                                    </div>
                                </div>


                                <div class="partial-header">Contact Page Map</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Map iframe code *</label>
                                        <textarea name="map" class="form-control h_100" cols="30" rows="10"><?php echo $result[0]['map']; ?></textarea>
                                    </div>
                                </div>


                                <div class="partial-header">Home Page - Hero Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="hero_heading" value="<?php echo $result[0]['hero_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Subheading *</label>
                                        <input type="text" class="form-control" name="hero_subheading" value="<?php echo $result[0]['hero_subheading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing Photo</label>
                                        <div>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['hero_photo']; ?>" alt="" class="w_300">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Photo</label>
                                        <div>
                                            <input type="file" name="hero_photo">
                                        </div>
                                    </div>
                                </div>


                                <div class="partial-header">Home Page - Featured Properties Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="featured_property_heading" value="<?php echo $result[0]['featured_property_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Subheading *</label>
                                        <input type="text" class="form-control" name="featured_property_subheading" value="<?php echo $result[0]['featured_property_subheading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status *</label>
                                        <div class="toggle-container">
                                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="featured_property_status" value="Show" <?php if($result[0]['featured_property_status'] == 'Show') {echo "checked";} ?>>
                                        </div>
                                    </div>
                                </div>


                                <div class="partial-header">Home Page - Why Choose Us Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="why_choose_heading" value="<?php echo $result[0]['why_choose_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Subheading *</label>
                                        <input type="text" class="form-control" name="why_choose_subheading" value="<?php echo $result[0]['why_choose_subheading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing Photo</label>
                                        <div>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['why_choose_photo']; ?>" alt="" class="w_300">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Photo</label>
                                        <div>
                                            <input type="file" name="why_choose_photo">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status *</label>
                                        <div class="toggle-container">
                                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="why_choose_status" value="Show" <?php if($result[0]['why_choose_status'] == 'Show') {echo "checked";} ?>>
                                        </div>
                                    </div>
                                </div>



                                <div class="partial-header">Home Page - Agent Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="agent_heading" value="<?php echo $result[0]['agent_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Subheading *</label>
                                        <input type="text" class="form-control" name="agent_subheading" value="<?php echo $result[0]['agent_subheading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status *</label>
                                        <div class="toggle-container">
                                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="agent_status" value="Show" <?php if($result[0]['agent_status'] == 'Show') {echo "checked";} ?>>
                                        </div>
                                    </div>
                                </div>



                                <div class="partial-header">Home Page - Location Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="location_heading" value="<?php echo $result[0]['location_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Subheading *</label>
                                        <input type="text" class="form-control" name="location_subheading" value="<?php echo $result[0]['location_subheading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status *</label>
                                        <div class="toggle-container">
                                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="location_status" value="Show" <?php if($result[0]['location_status'] == 'Show') {echo "checked";} ?>>
                                        </div>
                                    </div>
                                </div>



                                <div class="partial-header">Home Page - Testimonial Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="testimonial_heading" value="<?php echo $result[0]['testimonial_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing Photo</label>
                                        <div>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['testimonial_photo']; ?>" alt="" class="w_300">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Photo</label>
                                        <div>
                                            <input type="file" name="testimonial_photo">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status *</label>
                                        <div class="toggle-container">
                                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="testimonial_status" value="Show" <?php if($result[0]['testimonial_status'] == 'Show') {echo "checked";} ?>>
                                        </div>
                                    </div>
                                </div>



                                <div class="partial-header">Home Page - Latest Post Section</div>
                                <div class="partial-item">
                                    <div class="form-group mb-3">
                                        <label>Heading *</label>
                                        <input type="text" class="form-control" name="post_heading" value="<?php echo $result[0]['post_heading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Subheading *</label>
                                        <input type="text" class="form-control" name="post_subheading" value="<?php echo $result[0]['post_subheading']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Status *</label>
                                        <div class="toggle-container">
                                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="post_status" value="Show" <?php if($result[0]['post_status'] == 'Show') {echo "checked";} ?>>
                                        </div>
                                    </div>
                                </div>
                                



                                <div class="form-group mt_30">
                                    <button type="submit" class="btn btn-primary" name="form_update">Update</button>
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