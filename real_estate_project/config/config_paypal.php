<?php

// PayPal
require_once "vendor/autoload.php"; 
use Omnipay\Omnipay;
 
define('CLIENT_ID', 'ATCMI4_1b1RqMVzdmNOuLhmkt_qAPt2CcKCNBWG5CfkqFfT4lIhshNx5l8Uq0swfNce6g0yVDmNyNBbb');
define('CLIENT_SECRET', 'EFxtXDt3HUJumJXFQfd5E8KC5q9oPYRW5oycouIqvy0GwjxBHAik1B2Cck_0sAoP1wQBgQiNlSDLNZ1Z');
 
define('PAYPAL_RETURN_URL', BASE_URL.'agent-paypal-success.php');
define('PAYPAL_CANCEL_URL', BASE_URL.'agent-paypal-cancel.php');
define('PAYPAL_CURRENCY', 'USD'); // set your currency here
 
$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true); //set it to 'false' when go live