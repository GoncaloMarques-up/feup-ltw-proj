<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/review.tpl.php');
    require_once(__DIR__ . '/../templates/form.tpl.php');
    require_once(__DIR__ . '/../templates/headfiles.tpl.php');
    
    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/dish.class.php');
    require_once(__DIR__ . '/../database/costumer.class.php');

    $db = getDBConnection(__DIR__ . '/../database/data.db');

    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));

    $categories = Restaurant::getAllCategories($db);

    if($session->isLoggedin())
        $user = Costumer::getCostumer($db, $session->getId());

    $favorites = isset($user) ? $user->getFavoriteDishesIds($db) : array();

    outputHead();
    restaurant_head();
    outputHeader($session, $categories, $user);
    outputRestaurantSideMenu($restaurant->dishCategories);
    outputShoppingCart();
    ?> <div id="mainDiv" class = "restaurant"> <?php
    outputSingleRestaurant($restaurant, $user);   
    ?> <section id = "dishes"> <?php
    foreach($restaurant->dishCategories as $category){
        $dishes = Dish::getCategoryDishes($db, $restaurant->id, $category['category']);
        outputCategoryDishes($category, $dishes, $favorites, $session);
    }
    ?></section> <?php
    outputReviews($restaurant->reviews, $db, $restaurant->owner === $user->id, $session, $restaurant->id);
    if($session->isLoggedin())
        outputReviewForm();
    ?> </div> </div><?php   
    outputFooter();
?>