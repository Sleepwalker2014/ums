<?php
    require_once 'templateHandler.php';
    if (!empty($_POST)) {
        foreach ($_POST as $paramKey => $paramValue) {
            resolveUrl($_POST);
        }
    }

    function resolveUrl ($urlParams) {
        if (!empty($urlParams['actionCode'])) {
            switch ($urlParams['actionCode']) {
                case 2:
                    require 'modalAction.php';
                    $handler = array( 'modalAction', 'getTemp');
                    call_user_func_array($handler, []);
                break;
                case 1:
                    require 'notification.php';
                    notification::getFromDb(1);
            }
        }
    }
?>
