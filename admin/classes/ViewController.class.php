<?php

    class ViewController {

        private $twig;
        private $db;
        private $config;

        public function __construct($db, $config) {
            $this->db = $db;
            $loader = new Twig_Loader_Filesystem('pages/');
            $this->twig = new Twig_Environment($loader, array(
                'debug' => true,
                'cache' => false,
            ));
            $this->config = $config;
        }

        public function getPage() {
            if(isset($_SESSION['biab_admin']) === false) {
                return $this->getLogin();
            } elseif($_SESSION['biab_admin']['reset'] == 1) {
                return $this->getUserPasswordReset();
            } elseif(isset($_GET['s']) === true &&isset($_GET['p']) === true && file_exists('pages/'.$_GET['s'].'/'.$_GET['p'].'.tpl') === true) {
                switch($_GET['s']) {
                    case "categories":
                        switch($_GET['p']) {
                            case "list": return $this->getCategories(); break;
                            case "create": return $this->getCategoryCreate(); break;
                            case "edit": return $this->getCategoryEdit(); break;
                            case "delete": return $this->getCategoryDelete(); break;
                        }
                        break;
                    case "products":
                        switch($_GET['p']) {
                            case "list": return $this->getProducts(); break;
                            case "create": return $this->getProductCreate(); break;
                            case "stock": return $this->getProductStock(); break;
                            case "price": return $this->getProductPrice(); break;
                            case "image-list": return $this->getProductImageList(); break;
                            case "images": return $this->getProductImages(); break;
                            case "image-delete": return $this->getProductImageDelete(); break;
                            case "edit": return $this->getProductEdit(); break;
                            case "delete": return $this->getProductDelete(); break;
                        }
                        break;
                    case "orders":
                        switch($_GET['p']) {
                            case "list": return $this->getOrders(); break;
                            case "status": return $this->getOrderStatus(); break;
                            case "view": return $this->getOrder(); break;
                        }
                        break;
                    case "users":
                        switch($_GET['p']) {
                            case "list": return $this->getUsers(); break;
                            case "create": return $this->getUserCreate(); break;
                            case "password": return $this->getUserPassword(); break;
                            case "edit": return $this->getUserEdit(); break;
                            case "delete": return $this->getUserDelete(); break;
                            case "logout": return $this->getLogout(); break;
                        }
                        break;
                    default: return $this->getHome();
                }
            } else {
                return $this->getHome();
            }
        }

        public function showMessages($messages) {
            $template = $this->twig->loadTemplate('messages.tpl');
            return $template->render(array('messages' => $messages));
        }

        private function getHome() {
            $template = $this->twig->loadTemplate('home.tpl');
            return $template->render(array());
        }

        private function getLogin() {
            $template = $this->twig->loadTemplate('users/login.tpl');
            return $template->render(array());
        }

        private function getLogout() {
            $template = $this->twig->loadTemplate('users/logout.tpl');
            return $template->render(array());
        }

        /* CATEGORIES */

        private function getCategories() {
            $categories = $this->db->getCategories();

            $template = $this->twig->loadTemplate('categories/list.tpl');
            return $template->render(array('categories' => $categories));
        }

        private function getCategoryCreate() {
            $number = ++$this->db->getMaxCategoryNumber()[0]['number'];

            $template = $this->twig->loadTemplate('categories/create.tpl');
            return $template->render(array('number' => $number));
        }

        private function getCategoryEdit() {
            $category = $this->db->getCategoryById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('categories/edit.tpl');
            return $template->render(array('category' => $category));
        }

        private function getCategoryDelete() {
            $numProducts = count($this->db->getProductsByCategory($_GET['id']));
            $category = $this->db->getCategoryById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('categories/delete.tpl');
            return $template->render(array('numProducts' => $numProducts, 'category' => $category));
        }

        /* PRODUCTS */
        private function getProducts() {
            $products = $this->db->getProducts();

            $template = $this->twig->loadTemplate('products/list.tpl');
            return $template->render(array('products' => $products));
        }

        private function getProductCreate() {
            $maxSKU = $this->db->getMaxProductSKU();

            $sku = isset($maxSKU[0]['sku']) ? ++$maxSKU[0]['sku'] : 0;
            $categories = $this->db->getCategories();

            $template = $this->twig->loadTemplate('products/create.tpl');
            return $template->render(array('sku' => $sku, 'categories' => $categories));
        }

        private function getProductStock() {
            $product = $this->db->getProductById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('products/stock.tpl');
            return $template->render(array('product' => $product));
        }

        private function getProductPrice() {
            $product = $this->db->getProductById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('products/price.tpl');
            return $template->render(array('product' => $product));
        }

        private function getProductImageList() {
            $product = $this->db->getProductById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('products/image-list.tpl');
            return $template->render(array('product' => $product, 'root' => $this->config['cdn_url']));
        }

        private function getProductImages() {
            $product = $this->db->getProductById($_GET['id'])[0];
            $position = (isset($_GET['position']) === true) ? $_GET['position'] : (isset($product['imageCount']) === true) ? $product['imageCount'] : 0;

            $images = array();

            foreach($this->config["image_sizes"] as $size) {
                $src = $this->config['cdn_url'].$product['sku'].'-'.$position.'-'.$size.'.png';

                if(file_exists($src) === true) {
                    $images[$size] = $src;
                } else {
                    $images[$size] = 'null';
                }
            }

            $template = $this->twig->loadTemplate('products/images.tpl');
            return $template->render(array('product' => $product, 'images' => $images, 'position' => $position));
        }

        private function getProductImageDelete() {
            $product = $this->db->getProductById($_GET['id'])[0];
            $src = $this->config['cdn_url'].$product['sku'].'-'.$_GET['position'].'-120.png';

            $template = $this->twig->loadTemplate('products/image-delete.tpl');
            return $template->render(array('product' => $product, 'src' => $src, 'position' => $_GET['position']));
        }

        private function getProductEdit() {
            $product = $this->db->getProductById($_GET['id'])[0];
            $categories = $this->db->getCategories();

            $template = $this->twig->loadTemplate('products/edit.tpl');
            return $template->render(array('product' => $product, 'categories' => $categories));
        }

        private function getProductDelete() {
            $product = $this->db->getProductById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('products/delete.tpl');
            return $template->render(array('product' => $product));
        }

        /* ORDERS */

        private function getOrders() {
            $orders = $this->db->getOrders();

            $template = $this->twig->loadTemplate('orders/list.tpl');
            return $template->render(array('orders' => $orders));
        }

        private function getOrderStatus() {
            $order = $this->db->getOrderById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('orders/status.tpl');
            return $template->render(array('order' => $order, 'status' => strtoupper($_GET['status'])));
        }

        private function getOrder() {
            $order = $this->db->getOrderById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('orders/view.tpl');
            return $template->render(array('order' => $order));
        }


        /* USERS */

        private function getUsers() {
            $users = $this->db->getUsers();

            $template = $this->twig->loadTemplate('users/list.tpl');
            return $template->render(array('users' => $users));
        }

        private function getUserCreate() {
            $template = $this->twig->loadTemplate('users/create.tpl');
            return $template->render(array());
        }

        private function getUserPassword() {
            $user = $this->db->getUserById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('users/password.tpl');
            return $template->render(array('user' => $user));
        }

        public function getUserPasswordReset() {
            $user = $this->db->getUserById($_SESSION['biab_admin']['_id'])[0];

            $template = $this->twig->loadTemplate('users/reset.tpl');
            return $template->render(array('user' => $user));
        }

        private function getUserEdit() {
            $user = $this->db->getUserById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('users/edit.tpl');
            return $template->render(array('user' => $user));
        }

        private function getUserDelete() {
            $user = $this->db->getUserById($_GET['id'])[0];

            $template = $this->twig->loadTemplate('users/delete.tpl');
            return $template->render(array('user' => $user));
        }
    }

 ?>
