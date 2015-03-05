<?php
    $root = dirname(__FILE__);

    require_once $root.'/php/templateHandler.php';
    require_once $root.'/php/databaseHandler.php';

    if (!empty($_GET['action'])) {

    } else {
        $template = new templateHandler('html/map.html');

        echo $template->getHTML();
    }