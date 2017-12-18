<?php

    class Database extends AbstractMongoDatabase {

        public function getOrderById($id) {
            return MongoDatabaseUtils::cursorToArray(
                $this->selectById("orders", $id)
            );
        }

        public function addMailingToOrder($id, $mail) {
            $item = array(
                "email" => $mail,
                "time" => new MongoDate(time())
            );

            $this->updateByIdAddToArray("orders", $id, "emails", $item);
        }
    }

 ?>
