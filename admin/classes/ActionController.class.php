<?php

    class ActionController {

        private $db;
        private $messages = array();

        public function __construct($db, $config) {
            $this->db = $db;
            $this->config = $config;
        }

        public function execute($action) {
            if($this->validate($_POST['action']) === true) {

                switch ($_POST['action']) {
                    /* LOGIN */
                    case 'login':
                        $this->login();
                        $this->redirect("home");
                        break;

                    case 'logout':
                        $this->logout();
                        $this->redirect("home");
                        break;

                    /* CATEGORY */
                    case 'category_create':
                        $this->categoryCreate();
                        $this->redirect("categories");
                        break;
                    case 'category_edit':
                        $this->categoryEdit();
                        $this->redirect("categories");
                        break;
                    case 'category_delete':
                        $this->categoryDelete();
                        $this->redirect("categories");
                        break;

                    /* PRODUCT */
                    case 'product_create':
                        $this->productCreate();
                        $this->redirect("products");
                        break;
                    case 'product_stock':
                        $this->productStock();
                        $this->redirect("products");
                        break;
                    case 'product_price':
                        $this->productPrice();
                        $this->redirect("products");
                        break;
                    case "product_image":
                        $this->productImages();
                        $this->redirect("products", "image-list", "id=".$_POST['id']);
                        break;
                    case 'product_image_delete':
                        $this->productImageDelete();
                        $this->redirect("products", "image-list", "id=".$_POST['id']);
                        break;
                    case 'product_edit':
                        $this->productEdit();
                        $this->redirect("products");
                        break;
                    case 'product_delete':
                        $this->productDelete();
                        $this->redirect("products");
                        break;

                    /* ORDER */
                    case 'order_status':
                        $this->orderStatus();
                        $this->redirect("orders");
                        break;

                    /* USER */
                    case 'user_create':
                        $this->userCreate();
                        $this->redirect("users");
                        break;
                    case 'user_password':
                        $this->userPassword();
                        $this->redirect("users");
                        break;
                    case 'user_password_reset':
                        $this->userPasswordReset();
                        $this->redirect("home");
                        break;
                    case 'user_edit':
                        $this->userEdit();
                        $this->redirect("users");
                        break;
                    case 'user_delete':
                        $this->userDelete();
                        $this->redirect("users");
                        break;
                }
            } else {
                return $this->messages;
            }
        }

        private function redirect($section, $page = "list", $args = "") {
            $url = $_SERVER['HTTP_ORIGIN'].str_replace($_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);
            $url = $url.'s='.$section.'&p='.$page.'&success&'.$args;

            header("Location: $url");
        }

        private function addMessage($message) {
            $this->messages[] = $message;
        }

        private function validate($form) {
            $valid = true;
            switch($form) {
                case 'login':
                    $user = $this->db->getUserMyEmailAndPassword($_POST['email'], $_POST['password']);

                    if(count($user) != 1) {
                        $this->addMessage("The username and password combination could not be found.");
                        $valid = false;
                    }
                    break;

                case 'user_create':
                case 'user_password':
                case 'user_password_reset':
                    if($_POST['password'] != $_POST['password_confirm']) {
                        $this->addMessage("The passwords don't match.");
                        $valid = false;
                    }

                    if(strlen($_POST['password']) < 8) {
                        $this->addMessage("The password should be at least 8 characters long.");
                        $valid = false;
                    }
                    break;
            }

            return $valid;

        }

        /* LOGIN */

        public function login() {
            $user = $this->db->getUserMyEmailAndPassword($_POST['email'], $_POST['password'])[0];
            $_SESSION['biab_admin'] = $user;
        }

        public function logout() {
            unset($_SESSION['biab_admin']);
        }

        /* CATEGORY */

        private function categoryCreate() {
            $category = array(
                "number" => $_POST['number'],
                "name" => array(
                    'en_GB' => $_POST['name_EN'],
                    'nl_NL' => $_POST['name_NL'],
                    'pt_BR' => $_POST['name_PT'],
                )
            );

            $this->db->insertCategory($category);
        }

        private function categoryEdit() {
            $category = array(
                "name" => array(
                    'en_GB' => $_POST['name_EN'],
                    'nl_NL' => $_POST['name_NL'],
                    'pt_BR' => $_POST['name_PT'],
                )
            );

            $this->db->editCategory($_POST['id'], $category);
        }

        private function categoryDelete() {
            $this->db->deleteCategory($_POST['id']);
        }

        /* PRODUCT */

        private function productCreate() {
            $tags = (isset($_POST['tags']) === true ? $_POST['tags'] : array());

            $product = array(
                "sku" => (int) $_POST['sku'],
                "category" => new MongoId($_POST['category']),
                "title" => array(
                    'en_GB' => $_POST['title_EN'],
                    'nl_NL' => $_POST['title_NL'],
                    'pt_BR' => $_POST['title_PT']
                ),
                "description" => array(
                    'en_GB' => $_POST['description_EN'],
                    'nl_NL' => $_POST['description_NL'],
                    'pt_BR' => $_POST['description_PT']
                ),
                "brand" => $_POST['brand'],
                "fromPrice" => (double) $_POST['fromPrice'],
                "price" => (double) $_POST['price'],
                "stock" => (int) $_POST['stock'],
                "imageCount" => 0,
                "reviews" => array(),
                "tags" => $tags
            );

            $this->db->insertProduct($product);
        }

        private function productStock() {
            $product = array(
                "stock" => (int) $_POST['stock']
            );

            $this->db->editProduct($_POST['id'], $product);
        }

        private function productPrice() {
            $product = array(
                "fromPrice" => (double) $_POST['fromPrice'],
                "price" => (double) $_POST['price']
            );

            $this->db->editProduct($_POST['id'], $product);
        }

        private function productImages() {
            $product = $this->db->getProductById($_POST['id'])[0];
            $updateImageCount = false;

            foreach($this->config["image_sizes"] as $size) {
                if(isset($_FILES[$size]['tmp_name']) === true) {
                    $src = $this->config['cdn_url'].$product['sku'].'-'.$_POST['position'].'-'.$size.'.png';

                    if(file_exists($src) === true) {
                        unlink($src);
                    }

                    move_uploaded_file($_FILES[$size]['tmp_name'], $src);
                    $updateImageCount = true;
                }
            }

            if($updateImageCount === true && (isset($product['imageCount']) === false || $_POST['position'] >= $product['imageCount'])) {
                $product = array(
                    "imageCount" => (int) ($_POST['position']+1)
                );

                $this->db->editProduct($_POST['id'], $product);
            }
        }

        private function productImageDelete() {
            $product = $this->db->getProductById($_POST['id'])[0];

            for($i = $_POST['position']; $i < $product['imageCount']; $i++) {
                foreach($this->config["image_sizes"] as $size) {
                    $src = $this->config['cdn_url'].$product['sku'].'-'.$i.'-'.$size.'.png';

                    if(file_exists($src) === true) {
                        if($i == $_POST['position']) {
                            unlink($src);
                        } else {
                            rename(
                                 $src,
                                 $this->config['cdn_url'].$product['sku'].'-'.($i-1).'-'.$size.'.png'
                            );
                        }
                    }
                }
            }

            $product = array(
                "imageCount" => (int) ($product['imageCount']-1)
            );

            $this->db->editProduct($_POST['id'], $product);
        }

        private function productEdit() {
            $tags = (isset($_POST['tags']) === true ? $_POST['tags'] : array());

            $product = array(
                "category" => $_POST['category'],
                "title" => array(
                    'en_GB' => $_POST['title_EN'],
                    'nl_NL' => $_POST['title_NL'],
                    'pt_BR' => $_POST['title_PT']
                ),
                "description" => array(
                    'en_GB' => $_POST['description_EN'],
                    'nl_NL' => $_POST['description_NL'],
                    'pt_BR' => $_POST['description_PT']
                ),
                "brand" => $_POST['brand'],
                "tags" => $tags
            );

            $this->db->editProduct($_POST['id'], $product);
        }

        private function productDelete() {
            $this->db->deleteProduct($_POST['id']);
        }

        /* ORDER */

        private function orderStatus() {
            $order = $this->db->getOrderById($_POST['id'])[0];
            $this->db->addStatusChangeToOrder($_POST['id'], $_SESSION['biab_admin']['name'], $order['status'], $_POST['status']);

            $new_order = array(
                "status" => $_POST['status']
            );

            $this->db->editOrder($_POST['id'], $new_order);

            if($_POST['status'] == 'PAID') {
                $new_order = array(
                    "number" => $this->db->getNewOrderNumber()
                );

                $this->db->editOrder($_POST['id'], $new_order);
            }

            if(
                in_array($order['status'], array('STAGING','CANCELLED', 'EXPIRED')) === true &&
                in_array($_POST['status'], array('PAID', 'PACKED')) === true
            ) {
                foreach ($order['items'] as $item) {
                    $this->db->editProductStock($item['sku'], ($item['quantity'] * -1));
                }
            } elseif(
                in_array($order['status'], array('PAID', 'PACKED')) === true &&
                in_array($_POST['status'], array('CANCELLED', 'EXPIRED')) === true
            ) {
                foreach ($order['items'] as $item) {
                    $this->db->editProductStock($item['sku'], $item['quantity']);
                }
            }

            if(in_array($_POST['status'], array('PAID', 'PACKED')) === true) {
                $this->sendMail($_POST['id'], $_POST['status']);
            }
        }

        /* USER */

        private function userCreate() {
            $user = array(
                "name" => $_POST['name'],
                "email" => $_POST['email'],
                "password" => md5($_POST['password']),
                "reset" => "0"
            );

            $this->db->insertUser($user);
        }

        private function userEdit() {
            $user = array(
                "name" => $_POST['name'],
                "email" => $_POST['email']
            );

            $this->db->editUser($_POST['id'], $user);
        }

        private function userPassword() {
            $user = array(
                "password" => md5($_POST['password']),
                "reset" => "1"
            );

            $this->db->editUser($_POST['id'], $user);
        }

        private function userPasswordReset() {
            $user = array(
                "password" => md5($_POST['password']),
                "reset" => "0"
            );

            $this->db->editUser($_POST['id'], $user);

            $_SESSION['biab_admin']['reset'] = 0;
        }

        private function userDelete() {
            $this->db->deleteUser($_POST['id']);
        }

        private function sendMail($order_id, $status) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->config["mailer_url"]);
            curl_setopt($ch, CURLOPT_POST, count(2));
            curl_setopt($ch, CURLOPT_POSTFIELDS, "order_id=".$order_id."&status=".$status);
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        }
    }

 ?>
