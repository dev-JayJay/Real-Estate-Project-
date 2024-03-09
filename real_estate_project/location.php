<?php include 'header.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM locations WHERE slug=?");
$statement->execute([$_REQUEST['slug']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $id = $row['id'];
    $l_name = $row['name'];
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Properties of <?php echo $l_name; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="property">
    <div class="container">
        <div class="row">

        <?php

            $statement = $pdo->prepare("SELECT p.*, l.name as location_name, t.name as type_name, a.id as agent_id, a.full_name, a.company, a.photo as agent_photo
                                        FROM properties p
                                        JOIN locations l
                                        ON p.location_id = l.id 
                                        JOIN types t
                                        ON p.type_id = t.id
                                        JOIN agents a
                                        ON p.agent_id = a.id
                                        WHERE p.location_id=? AND p.agent_id NOT IN (
                                            SELECT a.id
                                            FROM agents a
                                            JOIN orders o 
                                            ON a.id = o.agent_id
                                            WHERE o.expire_date < ? AND o.currently_active = ?
                                        )");
            $statement->execute([$id,date('Y-m-d'),1]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $total = $statement->rowCount();
            if(!$total) {
                ?>
                <div class="col-md-12">
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
                                        <a href="<?php echo BASE_URL; ?>agent/<?php echo $row['agent_id']; ?>"><?php echo $row['full_name']; ?></a>
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