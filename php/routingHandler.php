<?php
    require_once 'templateHandler.php';
    require_once 'databaseHandler.php';
    $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');
    if (!empty($_POST)) {
        resolveUrl($_POST);
    }

    function resolveUrl ($urlParams) {
        if (!empty($urlParams['actionCode'])) {
            switch ($urlParams['actionCode']) {
                case 2:
                    syslog(0,  "je");
                    require_once 'notification.php';
                    notification::getAllMarkerInformation();
                break;
                case 1:
                    if (!empty($_POST['markerId'])) {
                        require 'notification.php';
                        $notification = notification::getFromDb($_POST['markerId']);
                        $animal = $notification->getAnimal();

                        $th = templateHandler::getTemplateHandler('../html/markerModal.html');

                        $th->addContent('modal', ['animalName'      => $animal->getName(),
                                                  'animalSex'       => sex::getFromDb($animal->getSex())->getCode(),
                                                  'size'       => $animal->getSize(),
                                                  'animalBirthDay'  => $animal->getBirthDay(),
                                                  'animalRace'  => race::getFromDb($animal->getRace())->getName(),
                                                  'specification' => $animal->getSpecification(),
                                                  'eyeColour' => 'public/images/'.colour::getFromDb($animal->getEyeColour())->getCode().'_eye.png',
                                                  'furColour' => 'public/images/'.colour::getFromDb($animal->getFurColour())->getCode().'_eye.png',
                                                  'creationDate'    => $notification->getCreationDate(),
                                                  'description'     => $notification->getDescription()]);
                        echo $th->getHTML();
                    }
                break;
                case 3:
                    require 'race.php';
                    $th = templateHandler::getTemplateHandler('../html/newNotificationModal.html');

                    $th->addContent('modal', ['races' => race::getRaces()]);

                    echo $th->getHTML();
                break;
                case 4:
                    require_once 'notification.php';
                    require_once 'race.php';
                    $notification = new notification();

                    syslog(0, race::getIdByCode('BKH'));
                    $notification->persist();
                break;
            }
        }
    }
?>
