<?php include 'header.php'; ?>

<?php
if(!isset($_REQUEST['id']) || !isset($_REQUEST['slug'])) {
    header('location: '.BASE_URL);
    exit;
}

$statement = $pdo->prepare("SELECT p.*, l.name as location_name, t.id as type_id, t.name as type_name, a.full_name, a.email, a.phone, a.photo as agent_photo, a.desgination, a.company, a.website, a.facebook, a.twitter, a.linkedin, a.youtube, a.instagram, a.pinterest
                            FROM properties p
                            JOIN locations l
                            ON p.location_id = l.id
                            JOIN types t
                            ON p.type_id = t.id
                            JOIN agents a 
                            ON p.agent_id = a.id
                            WHERE p.id=? AND p.slug=? AND p.agent_id NOT IN (
                                SELECT a.id
                                FROM agents a
                                JOIN orders o 
                                ON a.id = o.agent_id
                                WHERE o.expire_date < ? AND o.currently_active = ?
                            )");
$statement->execute([$_REQUEST['id'], $_REQUEST['slug'], date('Y-m-d'),1]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
if(!$result) {
    header('location: '.BASE_URL);
    exit;
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $result[0]['name']; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="property-result pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="left-item">
                    <div class="main-photo">
                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['featured_photo']; ?>" alt="">
                    </div>
                    <h2>
                        Description
                    </h2>
                    <?php echo $result[0]['description']; ?>
                </div>


                <?php
                $statement = $pdo->prepare("SELECT * FROM properties_photos WHERE property_id=?");
                $statement->execute([$_REQUEST['id']]);
                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                $total_photos = $statement->rowCount();
                ?>
                <?php if($total_photos > 0): ?>
                <div class="left-item">
                    <h2>
                        Photos
                    </h2>
                    <div class="photo-all">
                        <div class="row">
                            <?php
                            foreach ($result1 as $row) {
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="item">
                                        <a href="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" class="magnific">
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" />
                                            <div class="icon">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            <div class="bg"></div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>



                <?php
                $statement = $pdo->prepare("SELECT * FROM property_videos WHERE property_id=?");
                $statement->execute([$_REQUEST['id']]);
                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                $total_videos = $statement->rowCount();
                ?>
                <?php if($total_videos > 0): ?>
                <div class="left-item">
                    <h2>
                        Videos
                    </h2>
                    <div class="video-all">
                        <div class="row">
                            <?php
                            foreach ($result1 as $row) {
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="item">
                                        <a class="video-button" href="http://www.youtube.com/watch?v=<?php echo $row['video_id']; ?>">
                                            <img src="http://img.youtube.com/vi/<?php echo $row['video_id']; ?>/0.jpg" alt="" />
                                            <div class="icon">
                                                <i class="far fa-play-circle"></i>
                                            </div>
                                            <div class="bg"></div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>



                <div class="left-item mb_50">
                    <h2>Share</h2>
                    <div class="share">
                        <?php
                        $share_url = BASE_URL.'property/'.$_REQUEST['id'].'/'.$_REQUEST['slug'];
                        $share_photo = BASE_URL.'uploads/'.$result[0]['featured_photo'];
                        $share_title = $result[0]['name'];
                        $share_text = $result[0]['description'];
                        ?>
                        <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>&picture=<?php echo $share_photo; ?>" target="_blank">
                            Facebook
                        </a>
                        <a class="twitter" href="https://twitter.com/share?url=<?php echo $share_url; ?>&text=<?php echo $share_text; ?>" target="_blank">
                            Twitter
                        </a>
                        <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>&summary=<?php echo $share_text; ?>" target="_blank">
                            LinkedIn
                        </a>
                    </div>
                </div>


                <div class="left-item">
                    <h2>
                        Related Properties
                    </h2>
                    <div class="property related-property pt_0 pb_0">
                        <div class="row">

                            <?php
                            $statement = $pdo->prepare("SELECT p.*, l.name as location_name, t.name as type_name, a.full_name, a.photo as agent_photo
                                                        FROM properties p
                                                        JOIN locations l
                                                        ON p.location_id = l.id
                                                        JOIN types t
                                                        ON p.type_id = t.id
                                                        JOIN agents a 
                                                        ON p.agent_id = a.id
                                                        WHERE p.type_id=?
                                                        LIMIT 4");
                            $statement->execute([$result[0]['type_id']]);
                            $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $total = $statement->rowCount();
                            foreach ($result2 as $row) {
                                if($_REQUEST['id'] == $row['id']) {
                                    continue;
                                }
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="item">
                                        <div class="photo">
                                            <img class="main" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="">
                                            <div class="top">
                                                <div class="status-<?php if($row['purpose']=='Rent') {echo 'rent';} else {echo 'sale';} ?>">
                                                    For <?php echo $row['purpose']; ?>
                                                </div>
                                                <?php if($row['is_featured'] == 'Yes'): ?>
                                                <div class="featured">
                                                    Featured
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="price">$<?php echo $row['price']; ?></div>
                                            <div class="wishlist"><a href="<?php echo BASE_URL; ?>customer-wishlist-add.php?id=<?php echo $row['id']; ?>"><i class="far fa-heart"></i></a></div>
                                        </div>
                                        <div class="text">
                                            <h3><a href="<?php echo BASE_URL; ?>property/<?php echo $row['id']; ?>/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a></h3>
                                            <div class="detail">
                                                <div class="stat">
                                                    <div class="i1"><?php echo $row['size']; ?> sqft</div>
                                                    <div class="i2"><?php echo $row['bedroom']; ?> Bed</div>
                                                    <div class="i3"><?php echo $row['bathroom']; ?> Bath</div>
                                                </div>
                                                <div class="address">
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo $row['address']; ?>
                                                </div>
                                                <div class="type-location">
                                                    <div class="i1">
                                                        <i class="fas fa-edit"></i> <?php echo $row['type_name']; ?>
                                                    </div>
                                                    <div class="i2">
                                                        <i class="fas fa-location-arrow"></i> <?php echo $row['location_name']; ?>
                                                    </div>
                                                </div>
                                                <div class="agent-section">
                                                    <?php if($row['agent_photo'] == ''):  ?>
                                                        <img class="agent-photo" src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                                    <?php else:  ?>
                                                        <img class="agent-photo" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['agent_photo']; ?>" alt="">
                                                    <?php endif;  ?>
                                                    <a href=""><?php echo $row['full_name']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">

                <div class="right-item">
                    <h2>Agent</h2>
                    <div class="agent-right d-flex justify-content-start">
                        <div class="left">
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['agent_photo']; ?>" alt="">
                        </div>
                        <div class="right">
                            <h3><a href=""><?php echo $result[0]['full_name']; ?></a></h3>
                            <h4><?php echo $result[0]['desgination']; ?>, <?php echo $result[0]['company']; ?></h4>
                        </div>
                    </div>
                    <div class="table-responsive mt_25">
                        <table class="table table-bordered">
                            <tr>
                                <td>Posted On: </td>
                                <td>
                                    <?php 
                                    $ts = strtotime($result[0]['posted_on']);
                                    echo date("F j, Y", $ts);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Email: </td>
                                <td><?php echo $result[0]['email']; ?></td>
                            </tr>
                            
                            <?php if($result[0]['phone'] != ''): ?>
                            <tr>
                                <td>Phone: </td>
                                <td><?php echo $result[0]['phone']; ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if($result[0]['website'] != ''): ?>
                            <tr>
                                <td>Website: </td>
                                <td><?php echo $result[0]['website']; ?></td>
                            </tr>
                            <?php endif; ?>


                            <?php if($result[0]['facebook'] != '' || $result[0]['twitter'] != '' || $result[0]['linkedin'] != '' || $result[0]['pinterest'] != '' || $result[0]['instagram'] != '' || $result[0]['youtube'] != ''): ?>
                            <tr>
                                <td>Social: </td>
                                <td>
                                    <ul class="agent-ul">

                                        <?php if($result[0]['facebook'] != ''): ?>
                                        <li><a href="<?php echo $result[0]['facebook']; ?>"><i class="fab fa-facebook-f"></i></a></li>
                                        <?php endif; ?>

                                        <?php if($result[0]['twitter'] != ''): ?>
                                        <li><a href="<?php echo $result[0]['twitter']; ?>"><i class="fab fa-twitter"></i></a></li>
                                        <?php endif; ?>

                                        <?php if($result[0]['linkedin'] != ''): ?>
                                        <li><a href="<?php echo $result[0]['linkedin']; ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                        <?php endif; ?>

                                        <?php if($result[0]['pinterest'] != ''): ?>
                                        <li><a href="<?php echo $result[0]['pinterest']; ?>"><i class="fab fa-pinterest-p"></i></a></li>
                                        <?php endif; ?>

                                        <?php if($result[0]['instagram'] != ''): ?>
                                        <li><a href="<?php echo $result[0]['instagram']; ?>"><i class="fab fa-instagram"></i></a></li>
                                        <?php endif; ?>

                                        <?php if($result[0]['youtube'] != ''): ?>
                                        <li><a href="<?php echo $result[0]['youtube']; ?>"><i class="fab fa-youtube"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                            </tr>
                            <?php endif; ?>


                        </table>
                    </div>
                </div>

                <div class="right-item">
                    <h2>Features</h2>
                    <div class="summary">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td><b>Price</b></td>
                                    <td>$<?php echo $result[0]['price']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Location</b></td>
                                    <td><?php echo $result[0]['location_name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Type</b></td>
                                    <td><?php echo $result[0]['type_name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Purpose</b></td>
                                    <td><?php echo $result[0]['purpose']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Bedroom:</b></td>
                                    <td><?php echo $result[0]['bedroom']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Bathroom:</b></td>
                                    <td><?php echo $result[0]['bathroom']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Size:</b></td>
                                    <td><?php echo $result[0]['size']; ?> sqft</td>
                                </tr>
                                <tr>
                                    <td><b>Floor:</b></td>
                                    <td><?php echo $result[0]['floor']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Garage:</b></td>
                                    <td><?php echo $result[0]['garage']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Balcony:</b></td>
                                    <td><?php echo $result[0]['balcony']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Address:</b></td>
                                    <td><?php echo $result[0]['address']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Built Year:</b></td>
                                    <td><?php echo $result[0]['built_year']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="right-item">
                    <h2>Amenities</h2>
                    <div class="amenity">
                        <ul class="amenity-ul">
                            
                            <?php
                            $temp_arr = [];
                            $temp_arr = explode(',',$result[0]['amenities']);

                            $statement = $pdo->prepare("SELECT * FROM amenities ORDER BY name ASC");
                            $statement->execute();
                            $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result1 as $row) {
                                if(in_array($row['id'],$temp_arr)) {
                                    echo '<li><i class="fas fa-check-square"></i> '.$row['name'].'</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="right-item">
                    <h2>Location Map</h2>
                    <div class="location-map">
                        <?php echo $result[0]['map']; ?>
                    </div>
                </div>

                <div class="right-item">
                    <h2>Enquery Form</h2>
                    <div class="enquery-form">
                        <form action="<?php echo BASE_URL; ?>ajax-enquery.php" method="post" class="form_enquery">
                            <input type="hidden" name="agent_email" value="<?php echo $result[0]['email']; ?>">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="Full Name">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" />
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="phone" placeholder="Phone Number" />
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control h-150" rows="3" name="message" placeholder="Message"></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
(function($){
	"use strict";
	$(document).ready(function(){
		$(".form_enquery").on('submit', function(e){
			e.preventDefault();
			let formData = new FormData(this);
			let form = this;
			$.ajax({
				url: this.action,
	            type: 'POST',
	            data: formData,
				success: function(data) {
					data = JSON.parse(data);
					if(data.error_message) {
						//alert(data.error_message);
                        iziToast.show({
                            message: data.error_message,
                            position: 'topRight',
                            color: 'red',
                        });
					} else {
						form.reset();
						//alert(data.success_message);
                        iziToast.show({
                            message: data.success_message,
                            position: 'topRight',
                            color: 'green',
                        });
					}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		});
	});
})(jQuery);
</script>

<?php include 'footer.php'; ?>