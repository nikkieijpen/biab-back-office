<?php

    class Database extends AbstractMongoDatabase {

        public function getOrderById($id) {
            return MongoDatabaseUtils::cursorToArray(
                $this->selectById("orders", $id)
            );
        }

        public function getNewOrderNumber() {
            $order = MongoDatabaseUtils::cursorToArray($this->select(
                "orders",
                array(
                    "select" => array("number"),
                    "sort" => array("number" => "DESC"),
                    "limit" => 1,
                )
            ));

            return (isset($order[0]['number']) === true) ? $order[0]['number']+1 : 0;
        }

        public function editOrderStatus($id, $new_status) {
            $order = array(
                "status" => $new_status
            );

            $this->updateById("orders", $id, $order);
        }

        public function editOrderNumber($id, $number) {
            $order = array(
                "number" => $number
            );

            $this->updateById("orders", $id, $order);
        }

        public function addStatusChangeToOrder($id, $old_status, $new_status) {
            $item = array(
                "time" => new MongoDate(time()),
                "user" => "Payment",
                "oldStatus" => $old_status,
                "newStatus" => $new_status
            );

            $this->updateByIdAddToArray("orders", $id, "statusChanges", $item);
        }

        public function addPaymentToOrder($id, $status, $amount, $method) {
            $item = array(
                "time" => new MongoDate(time()),
                "status" => $status,
                "amount" => $amount,
                "method" => $method
            );

            $this->updateByIdAddToArray("orders", $id, "payments", $item);
        }

        public function editProductStock($sku, $change) {
            $this->update("products", array("sku" => $sku), array("stock" => $change), '$inc');
        }
    }

 ?>
