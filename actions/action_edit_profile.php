<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../database/costumer.class.php');

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();

    if(!$session->isLoggedin()){
        header('Location: ../pages/index.php');
        die;
    }

    $db = getDBConnection(__DIR__ . '/../database/data.db');

    if(trim($_POST['name']) === ''){
        $session->addMessage('error', 'You need a name');
        die(header('Location:' . $_SERVER['HTTP_REFERER']));
    }

    if(trim($_POST['email']) === ''){
        $session->addMessage('error', 'Please enter an email address');
        die(header('Location:' . $_SERVER['HTTP_REFERER']));
    }

    if(trim($_POST['address']) === ''){
        $session->addMessage('error', 'home address, NOW!');
        die(header('Location:' . $_SERVER['HTTP_REFERER']));
    }

    if(trim($_POST['phone']) === ''){
        $session->addMessage('error', 'can I get your phone number, friend?');
    }

    $costumer = Costumer::getCostumer($db, $session->getId());

    $costumer->name = trim($_POST['name']);
    $costumer->email = trim($_POST['email']);
    $costumer->address = trim($_POST['address']);
    $costumer->phoneNumber = trim($_POST['phone']);

    $costumer->save($db);

    $session->setName($costumer->name);
    $session->addMessage('success', 'Account update successful!');

    header('Location: ../pages/profile.php');
?>