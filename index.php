<?php

    $root = dirname(__FILE__);

    require_once $root.'/php/templateHandler.php';
    require_once $root.'/php/databaseHandler.php';

    if (isset($_GET['action']) && filter_var($_GET['action'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 50]])) {
        handleActionCode($_GET['action']);
    } 
    else {
        $template = new templateHandler($root.'/html/main.html');

        echo $template->getHTML();
    }

    function handleActionCode ($actionCode) {
        switch ($actionCode) {
            case 1:
                $template = new templateHandler(dirname(__FILE__).'/html/map.html');
                echo $template->getHTML();
                break;
            case 2:
                require_once dirname(__FILE__).'/php/notification.php';
                notification::getAllMarkerInformation();
                break;
            case 3:
                if (!empty($_POST['markerId'])) {
                    require dirname(__FILE__).'/php/notification.php';
                    $notification = notification::getFromDb($_POST['markerId']);
                    $animal = $notification->getAnimal();

                    $th = templateHandler::getTemplateHandler(dirname(__FILE__).'/html/markerModal.html');

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
            case 4:
                require dirname(__FILE__).'/php/race.php';
                $th = templateHandler::getTemplateHandler(dirname(__FILE__).'/html/newNotificationModal.html');

                $th->addContent('modal', ['races' => race::getRaces()]);

                echo $th->getHTML();
                break;
            case 5:
                require_once dirname(__FILE__).'/php/notification.php';
                require_once dirname(__FILE__).'/php/race.php';
                $notification = new notification();


                syslog(0, race::getIdByCode('BKH'));
                $notification->persist();
        }
    }