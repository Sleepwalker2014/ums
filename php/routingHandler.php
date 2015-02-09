<?php
    require_once 'templateHandler.php';
    if (!empty($_POST)) {
        foreach ($_POST as $paramKey => $paramValue) {
            resolveUrl($_POST);
        }
    }

    function resolveUrl ($urlParams) {
        if (!empty($urlParams['actionCode'])) {
            require 'modalAction.php';
            $handler = array( 'modalAction', 'getTemp');
            call_user_func_array($handler, []);
        }
    }
?>