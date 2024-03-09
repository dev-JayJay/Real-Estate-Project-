<?php include 'header.php'; ?>

<?php
// $allowed_agents = [];
// $q = $pdo->prepare("SELECT agent_id FROM orders WHERE expire_date >= CURDATE() AND currently_active=?");
// $q->execute([1]);
// $result = $q->fetchAll();
// foreach($result as $row) {
//     $allowed_agents[] = $row['agent_id'];
// }
// if(!in_array($_REQUEST['id'],$allowed_agents)) {
//     header('location: ' . BASE_URL);
//     exit;
// }
?>

<?php
$statement = $pdo->prepare("SELECT * FROM agents WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $result[0]['full_name']; ?></h2>
            </div>
        </div>
    </div>
</div>


<div class="agent-detail">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner">
                    <div class="photo">
                        <?php if($result[0]['photo']==''): ?>
                            <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                        <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['photo']; ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="detail">
                        <h3><?php echo $result[0]['full_name']; ?></h3>
                        <?php if($result[0]['desgination']!='' && $result[0]['company']!=''): ?>
                        <h4><?php echo $result[0]['desgination']; ?>, <?php echo $result[0]['company']; ?></h4>
                        <?php endif; ?>

                        <?php echo $result[0]['biography']; ?>
                        <div class="contact d-flex justify-content-center">
                            
                            <?php if($result[0]['address']!=''): ?>
                            <div class="item"><i class="fas fa-map-marker-alt"></i> <?php echo $result[0]['address']; ?>, <?php echo $result[0]['city']; ?>, <?php echo $result[0]['state']; ?>, <?php echo $result[0]['zip_code']; ?></div>
                            <?php endif; ?>

                            <?php if($result[0]['phone']!=''): ?>
                            <div class="item"><i class="fas fa-phone"></i> <?php echo $result[0]['phone']; ?></div>
                            <?php endif; ?>

                            <?php if($result[0]['email']!=''): ?>
                            <div class="item"><i class="far fa-envelope"></i> <?php echo $result[0]['email']; ?></div>
                            <?php endif; ?>

                            <?php if($result[0]['website']!=''): ?>
                            <div class="item"><i class="fas fa-globe"></i> <?php echo $result[0]['website']; ?></div>
                            <?php endif; ?>

                        </div>

                        <?php if($result[0]['facebook'] != '' || $result[0]['twitter'] != '' || $result[0]['linkedin'] != '' || $result[0]['pinterest'] != '' || $result[0]['instagram'] != '' || $result[0]['youtube'] != ''): ?>
                        <ul class="agent-detail-ul">
                            
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
                        <?php endif; ?>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="property">
    <div class="container">
        <div class="row">

            

        <?php

            $statement = $pdo->prepare("SELECT p.*, l.name as location_name, t.name as type_name, a.full_name, a.company, a.photo as agent_photo
                                        FROM properties p
                                        JOIN locations l
                                        ON p.location_id = l.id 
                                        JOIN types t
                                        ON p.type_id = t.id
                                        JOIN agents a
                                        ON p.agent_id = a.id
                                        WHERE p.agent_id=?");
            $statement->execute([$_REQUEST['id']]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $total = $statement->rowCount();
            if(!$total) {
                ?>
                <div class="col-md-12 text-danger text-center">
                    No Property Found
                </div>
                <?php
            }
            else
            {
                foreach ($result as $row) {
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
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
                                        <a href="<?php echo BASE_URL; ?>agent/<?php echo $_REQUEST['id']; ?>"><?php echo $row['full_name']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>



            




        </div>
    </div>
</div>


<?php include 'footer.php'; ?>