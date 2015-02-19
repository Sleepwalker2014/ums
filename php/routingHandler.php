<?php
    require_once 'templateHandler.php';
    require_once 'databaseHandler.php';
    $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');
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
                    $notification = notification::getFromDb(1);
                    $animal = $notification->getAnimal();

                    $th = templateHandler::getTemplateHandler('../html/markerModal.html');

                    $th->addContent('modal', ['animalName'      => $animal->getName(),
                                              'animalSex'       => $animal->getSex(),
                                              'animalBirthDay'  => $animal->getBirthDay(),
                                              'animalEyeColor'  => $animal->getEyeColour(),
                                              'creationDate'    => $notification->getCreationDate(),
                                              'description'     => $notification->getDescription()]);
                    echo $th->getHTML();
            }
        }
    }
?>
