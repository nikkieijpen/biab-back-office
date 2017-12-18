<?php

    class Database extends AbstractMongoDatabase {

        /* CATEGORIES */

        public function getCategories() {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "categories",
                array(
                    "sort" => array("name.en_GB" => "ASC")
                )
            ));
        }

        public function getMaxCategoryNumber() {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "categories",
                array(
                    "select" => array("number"),
                    "sort" => array("number" => "DESC"),
                    "limit" => 1,
                )
            ));
        }

        public function getCategoryById($id) {
            return MongoDatabaseUtils::cursorToArray(
                $this->selectById("categories", $id)
            );
        }

        public function insertCategory($category) {
            $this->insert("categories", $category);
        }

        public function editCategory($id, $changes) {
            $this->updateById("categories", $id, $changes);
        }

        public function deleteCategory($id) {
            $this->deleteById("categories", $id);
        }

        /* PRODUCTS */
        public function getProducts() {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "products",
                array(
                    "sort" => array("sku" => "ASC")
                )
            ));
        }

        public function getProductsByCategory($id) {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "products",
                array(
                    "conditions" => array("category" => new MongoId($id))
                )
            ));
        }

        public function getMaxProductSKU() {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "products",
                array(
                    "select" => array("sku"),
                    "sort" => array("sku" => "DESC"),
                    "limit" => 1,
                )
            ));
        }

        public function getProductById($id) {
            return MongoDatabaseUtils::cursorToArray(
                $this->selectById("products", $id)
            );
        }

        public function insertProduct($product) {
            $this->insert("products", $product);
        }

        public function editProduct($id, $changes) {
            $this->updateById("products", $id, $changes);
        }

        public function editProductStock($sku, $change) {
            $this->update("products", array("sku" => $sku), array("stock" => $change), '$inc');
        }

        public function deleteProduct($id) {
            $this->deleteById("products", $id);
        }

        /* ORDERS */
        public function getOrders() {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "orders",
                array(
                    "sort" => array("_id" => "DESC")
                )
            ));
        }

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

            return (isset($order[0]['number']) === true ? $order[0]['number']+1 : 0);
        }

        public function editOrder($id, $changes) {
            $this->updateById("orders", $id, $changes);
        }

        public function addStatusChangeToOrder($id, $user, $old_status, $new_status) {
            $item = array(
                "time" => new MongoDate(time()),
                "user" => $user,
                "oldStatus" => $old_status,
                "newStatus" => $new_status
            );

            $this->updateByIdAddToArray("orders", $id, "statusChanges", $item);
        }

        /* USERS */

        public function getUsers() {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "users",
                array(
                    "sort" => array("name" => "ASC")
                )
            ));
        }

        public function getUserMyEmailAndPassword($email, $password) {
            return MongoDatabaseUtils::cursorToArray($this->select(
                "users",
                array(
                    "conditions" => array(
                        "email" => $email,
                        "password" => md5($password)
                    )
                )
            ));
        }

        public function getUserById($id) {
            return MongoDatabaseUtils::cursorToArray(
                $this->selectById("users", $id)
            );
        }

        public function insertUser($user) {
            $this->insert("users", $user);
        }

        public function editUser($id, $changes) {
            $this->updateById("users", $id, $changes);
        }

        public function deleteUser($id) {
            $this->deleteById("users", $id);
        }


    }

 ?>
