<?php include 'header.php'; ?>

<?php
if(!isset($_SESSION['customers'])) {
    header('location: '.BASE_URL.'customer-login');
    exit;
}

try {

    $statement = $pdo->prepare("SELECT * FROM wishlists WHERE customer_id=? AND property_id=?");
    $statement->execute([$_SESSION['customers']['id'],$_REQUEST['id']]);
    $total = $statement->rowCount();
    if($total) {
        throw new Exception('Property is already added to your wishlist.');
    }

    $statement = $pdo->prepare("INSERT INTO wishlists (customer_id,property_id) VALUES (?,?)");
    $statement->execute([$_SESSION['customers']['id'],$_REQUEST['id']]);

    $_SESSION['success_message'] = 'Property is added to your wishlist.';
    header('location: '.BASE_URL.'customer-wishlist');
    exit;

} catch(Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('location: '.BASE_URL.'customer-wishlist');
    exit;    
}