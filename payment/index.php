<?php

    if(isset($_POST['id']) === true) {
        require_once('vendor/autoload.php');
        include('../config.php');
        include('../database/AbstractMongoDatabase.class.php');
        include('classes/Database.class.php');

        $db = new Database($config["db_host"], $config["db_url"], $config["db_user"], $config["db_pass"]);

        $mollie = new Mollie_API_Client;
        $mollie->setApiKey($config["mollie_token"]);

        $payment = $mollie->payments->get($_POST['id']);

        $order_id = $payment->metadata->orderId;
        $order = $db->getOrderById($order_id)[0];

        $db->addPaymentToOrder($order_id, $payment->status, $payment->amount, $payment->method);

        switch($payment->status) {
            case 'cancelled':
                $db->editOrderStatus($order_id, "CANCELLED");
                $db->addStatusChangeToOrder($order_id, $order['status'], "CANCELLED");
                break;
            case 'expired':
                $db->editOrderStatus($order_id, "EXPIRED");
                $db->addStatusChangeToOrder($order_id, $order['status'], "EXPIRED");
                break;
            case 'paid':
                if ($payment->isPaid()) {
                    $db->editOrderStatus($order_id, "PAID");
                    $db->editOrderNumber($order_id, $db->getNewOrderNumber());
                    $db->addStatusChangeToOrder($order_id, $order['status'], "PAID");

                    foreach ($order['items'] as $item) {
                        $db->editProductStock($item['sku'], ($item['quantity'] * -1));
                    }

                    $result = sendEmailRequest($config["mailer_url"], $order_id, "PAID");
                }
                break;
            default: //open, pending, failed, paidout, refunded
                // do nothing
        }
    }

    header("HTTP/1.1 200 OK");

    function sendEmailRequest($url, $order_id, $status) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count(2));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "order_id=".$order_id."&status=".$status);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

 ?>
