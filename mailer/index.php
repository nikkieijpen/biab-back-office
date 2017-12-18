<?php

    if(isset($_POST['order_id']) === true && isset($_POST['status']) === true) {
        require_once('vendor/autoload.php');
        include('../config.php');
        include('../database/AbstractMongoDatabase.class.php');
        include('classes/Database.class.php');
        include('classes/Properties.class.php');
        include('classes/PropertyBundle.class.php');

        $db = new Database($config["db_host"], $config["db_url"], $config["db_user"], $config["db_pass"]);

        $order = $db->getOrderById($_POST['order_id']);

        if(isset($order[0])) {
            $order = $order[0];
            $pb = new PropertyBundle($order['locale'], $order['locale'], "locales/");
            $loader = new Twig_Loader_Filesystem('templates/');
            $twig = new Twig_Environment($loader, array(
                'debug' => true,
                'cache' => false,
            ));

            $template = $twig->loadTemplate($_POST['status'].'.'.$order['locale'].'.tpl');
            $text = $template->render(array());

            $trans = array(
                "title" => $pb->getString("title.".$_POST['status']),
                "salution" => $pb->getString("salution"),
                "greeting" => $pb->getString("greeting"),
                "shippingAddress" => $pb->getString("shippingAddress"),
                "name" => $pb->getString("name"),
                "address" => $pb->getString("address"),
                "postalcode" => $pb->getString("postalcode"),
                "city" => $pb->getString("city"),
                "email" => $pb->getString("email"),
                "phone" => $pb->getString("phone"),
                "orderdetails" => $pb->getString("orderdetails"),
                "ordernumber" => $pb->getString("ordernumber"),
                "orderdate" => $pb->getString("orderdate"),
                "orderitems" => $pb->getString("orderitems"),
                "sku" => $pb->getString("sku"),
                "price" => $pb->getString("price"),
                "quantity" => $pb->getString("quantity"),
                "subtotal" => $pb->getString("subtotal"),
                "total" => $pb->getString("total"),
                "text" => $text
            );

            $template = $twig->loadTemplate('mail.tpl');
            $html = $template->render(array("trans" => $trans, "order" => $order, "text" => $text));

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = $config["mailer_host"];
            $mail->SMTPAuth = true;
            $mail->Username = $config["mailer_user"];
            $mail->Password = $config["mailer_pass"];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $config["mailer_port"];

            $mail->setFrom($config["mailer_from_email"], $config["mailer_from_name"]);
            $mail->addAddress($order['shippingAddress']['email'], $order['shippingAddress']['name']);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $pb->getString("subject.".$_POST['status']);
            $mail->Body = $html;

            if($mail->send()) {
                $order = array(
                    "status" => $_POST['status']
                );

                $db->addMailingToOrder($_POST['order_id'], $_POST['status']);
            }
        }
    }

 ?>
