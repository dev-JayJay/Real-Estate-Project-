<?php include 'header.php'; ?>

<?php
if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    $transaction = $gateway->completePurchase(array(
        'payer_id' => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));
    $response = $transaction->send();
    if ($response->isSuccessful()) {
        $arr_body = $response->getData();
 
        $payment_id = $arr_body['id'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = PAYPAL_CURRENCY;
        $payment_status = $arr_body['state'];
 
        // Previous currently_active to 0
        $statement = $pdo->prepare("UPDATE orders SET currently_active=? WHERE agent_id=? AND currently_active=?");
        $statement->execute(array(0,$_SESSION['agents']['id'],1));

        // Insert into database
        $statement = $pdo->prepare("INSERT INTO orders (agent_id, package_id, transaction_id, payment_method, paid_amount, status, purchase_date, expire_date, currently_active) VALUES (?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            $_SESSION['agents']['id'],
            $_SESSION['package_id'],
            $payment_id,
            'PayPal',
            $_SESSION['price'],
            'Completed',
            date('Y-m-d'),
            date('Y-m-d', strtotime('+'.$_SESSION['allowed_days'].' days')),
            1
        ));

		$_SESSION['success_message'] = 'Payment is successful.';

        unset($_SESSION['package_id']);
        unset($_SESSION['price']);
        unset($_SESSION['allowed_days']);

        header('location: '.BASE_URL.'agent-orders');
        exit;
    } else {
        echo $response->getMessage();
    }
} else {
    header('location: '.PAYPAL_CANCEL_URL);
}
?>