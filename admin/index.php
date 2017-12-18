<?php
    session_start();

    require_once('vendor/autoload.php');
    include('../config.php');
    include('../database/AbstractMongoDatabase.class.php');
    include('classes/ActionController.class.php');
    include('classes/Database.class.php');
    include('classes/ViewController.class.php');

    $db = new Database($config["db_host"], $config["db_url"], $config["db_user"], $config["db_pass"]);
    $ActionController = new ActionController($db, $config);
    $ViewController = new ViewController($db, $config);

    if(isset($_POST['action']) === true) {
        $messages = $ActionController->execute($_POST['action']);
    }

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Brazil In A Box</title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Bootstrap Core CSS -->
        <link href="libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

		<!-- Google Web Fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

		<!-- CSS Files -->
		<link href="libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="styles/style.css" rel="stylesheet">
        <link href="styles/admin.css" rel="stylesheet">

	</head>

	<body>
		<div id="wrapper" class="container">
            <?php if(isset($_SESSION['biab_admin']) === true) { ?>
            <nav id="main-menu" class="navbar" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-cat-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <div class="collapse navbar-collapse navbar-cat-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="?s=categories&amp;p=list">Categories</a>
                        </li>
                        <li>
                            <a href="?s=products&amp;p=list">Products</a>
                        </li>
                        <li>
                            <a href="?s=orders&amp;p=list">Orders</a>
                        </li>
                        <li>
                            <a href="?s=users&amp;p=list">Users</a>
                        </li>
                        <li>
                            <a href="?s=users&amp;p=logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php } ?>
            <?php

                if(isset($messages) === true && is_array($messages) === true && count($messages) > 0) {
                    echo $ViewController->showMessages($messages);
                }

                if(isset($_GET['success']) === true) {
                    echo '<div class="alert alert-success">The changes have been successfully applied.</div>';
                }

			    echo $ViewController->getPage();
            ?>

		</div>

        <script src="libs/jquery/dist/jquery.min.js"></script>
		<script src="libs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="libs/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>

	</body>
</html>
