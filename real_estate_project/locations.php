<?php include 'header.php'; ?>

<?php
$allowed_agents = [];
$q = $pdo->prepare("SELECT agent_id FROM orders WHERE expire_date >= CURDATE() AND currently_active=?");
$q->execute([1]);
$result = $q->fetchAll();
foreach($result as $row) {
    $allowed_agents[] = $row['agent_id'];
}
$agent_list = implode(',',$allowed_agents);
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Locations</h2>
            </div>
        </div>
    </div>
</div>

<div class="location pb_40">
    <div class="container">
        <div class="row">
            <?php
                
                $per_page = 20;
                $q = $pdo->prepare("SELECT l.id,l.name as location_name, l.photo as location_photo, l.slug as location_slug, COUNT(*) as location_count
                                    FROM properties p
                                    JOIN locations l
                                    ON p.location_id = l.id
                                    WHERE p.agent_id IN ($agent_list)
                                    GROUP BY l.id,l.name, l.photo, l.slug
                                    ORDER BY location_count DESC");
                $q->execute();
                $total = $q->rowCount();

                $total_pages = ceil($total/$per_page);    

                if(!isset($_REQUEST['p'])) {
                    $start = 1;
                } else {
                    $start = $per_page * ($_REQUEST['p']-1) + 1;
                }

                $j=0;
                $k=0;
                $arr1 = [];
                $res = $q->fetchAll();
                foreach($res as $row) {
                    $j++;
                    if($j>=$start) {
                        $k++;
                        if($k>$per_page) {break;}
                        $arr1[] = $row['id'];
                    }
                }
                ?>
                <?php
                foreach ($res as $row) {
                    if(!in_array($row['id'],$arr1)) {
                        continue;
                    }
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="item">
                            <div class="photo">
                                <a href="<?php echo BASE_URL; ?>location/<?php echo $row['location_slug']; ?>"><img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['location_photo']; ?>" alt=""></a>
                            </div>
                            <div class="text">
                                <h2><a href="<?php echo BASE_URL; ?>location/<?php echo $row['location_slug']; ?>"><?php echo $row['location_name']; ?></a></h2>
                                <h4>(<?php echo $row['location_count']; ?> Properties)</h4>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                if($total_pages>1):
                if(isset($_REQUEST['p'])) {
                    if($_REQUEST['p'] == 1) {
                        echo '<a class="links" href="javascript:void;" style="background:#ddd;"> << </a>';
                    } else {
                        echo '<a class="links" href='.BASE_URL.'"locations/'.($_REQUEST['p']-1).'"> << </a>';
                    }
                } else {
                    echo '<a class="links" href="javascript:void;" style="background:#ddd;"> << </a>';
                }


                for($i=1;$i<=$total_pages;$i++) {
                    echo '<a class="links" href="'.BASE_URL.'locations/'.$i.'">'.$i.'</a>';
                }

                if(isset($_REQUEST['p'])) {
                    if($_REQUEST['p'] == $total_pages) {
                        echo '<a class="links" href="javascript:void;" style="background:#ddd;"> >> </a>';
                    } else {
                        echo '<a class="links" href="'.BASE_URL.'locations/'.($_REQUEST['p']+1).'"> >> </a>';
                    }
                } else {
                    echo '<a class="links" href="'.BASE_URL.'locations/2"> >> </a>';
                }
                endif;
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>