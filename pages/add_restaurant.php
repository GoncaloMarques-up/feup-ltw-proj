<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/costumer.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/form.tpl.php');
    require_once(__DIR__ . '/../templates/headfiles.tpl.php');


    if(!$session->isLoggedin()){
        die(header('Location: ../pages/login.php'));
    }

    $db = getDBConnection(__DIR__ . '/../database/data.db');

    $costumer = Costumer::getCostumer($db, $session->getId());

    $categories = Restaurant::getAllCategories($db);

    outputHead();
    add_restaurant_head();
    outputHeader($session, $categories, $costumer);
    outputEditProfileSideMenu();
    outputAds();
    outputAddRestaurantForm($categories);
    outputFooter();
?>