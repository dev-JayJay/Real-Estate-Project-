<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['agent'])) {
    header('location: '.BASE_URL.'agent-login');
    exit;
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
if(isset($_POST['form_submit'])) {
    try {

        $statement = $pdo->prepare("SELECT * 
                            FROM orders 
                            JOIN packages
                            ON orders.package_id = packages.id
                            WHERE orders.agent_id=? AND orders.currently_active=?");
        $statement->execute(array($_SESSION['agent']['id'],1));
        $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result1 as $row) {
            $allowed_videos = $row['allowed_videos'];
        }

        $statement = $pdo->prepare("SELECT * FROM property_videos WHERE property_id=?");
        $statement->execute(array($_REQUEST['id']));
        $total_videos = $statement->rowCount();
        if($total_videos == $allowed_videos) {
            throw new Exception("You have reached your maximum limit of videos. Please upgrade your package. or delete existing videos to add new video.");
        }
        
        if($_POST['video_id'] == '') {
            throw new Exception('Video Id can not be empty');
        }

        $statement = $pdo->prepare("INSERT INTO property_videos (property_id,video_id) VALUES (?, ?)");
        $statement->execute([$_REQUEST['id'], $_POST['video_id']]);

        $success_message = "Video is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: '.BASE_URL.'agent-video-gallery/'.$_REQUEST['id']);
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
if(isset($_POST['form_delete'])) {
    $statement = $pdo->prepare("DELETE FROM property_videos WHERE id=?");
    $statement->execute([$_REQUEST['gallery_id']]);
    
    $success_message = "Video is deleted successfully.";
    $_SESSION['success_message'] = $success_message;
    header('location: '.BASE_URL.'agent-video-gallery/'.$_REQUEST['id']);
    exit;
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Video Gallery of "<?php echo $result[0]['name']; ?>"</h2>
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
                <h4>Add Video</h4>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input type="text" name="video_id" class="form-control" placeholder="Enter Video Id Here">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" name="form_submit" value="Submit">
                        </div>
                    </div>
                </form>

                <h4 class="mt-4">Existing Videos</h4>
                <div class="video-all">
                    <div class="row">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM property_videos WHERE property_id=?");
                        $statement->execute([$_REQUEST['id']]);
                        $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $total = $statement->rowCount();
                        if(!$total) {
                            echo '<div class="col-md-12 text-danger"><p>No video added yet.</p></div>';
                        }
                        foreach($result1 as $row) {
                            ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="item item-delete">
                                    <a class="video-button" href="http://www.youtube.com/watch?v=<?php echo $row['video_id']; ?>">
                                        <img src="http://img.youtube.com/vi/<?php echo $row['video_id']; ?>/0.jpg" alt="" />
                                        <div class="icon">
                                            <i class="far fa-play-circle"></i>
                                        </div>
                                        <div class="bg"></div>
                                    </a>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="gallery_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="badge bg-danger mb_20 custom-delete-button" name="form_delete" onClick="return confirm('Are you sure?');">Delete</button>
                                </form>
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

<?php include 'footer.php'; ?>