<?php
    require_once 'php/templateHandler.php';
    $template = new templateHandler('html/map.html');

    echo $template->getHTML();
?>