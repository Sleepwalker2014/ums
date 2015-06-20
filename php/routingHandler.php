<?php
    $root = dirname(dirname(__FILE__)).'/';

    require_once 'templateHandler.php';
    require_once 'databaseHandler.php';
    require_once 'sessionHandler.php';
    require_once 'user.php';
    require_once $root.'/vendor/endroid/qrcode/src/Endroid/QrCode/QrCode.php';

    $sessionHandler = new session();
    $errorMessage = null;

    if (empty($_POST['actionCode'])) {
        if (!$sessionHandler->getSessionUser()) {
            $th = templateHandler::getTemplateHandler($root.'/html/login.html');
            if (!empty($_POST['loginName']) && !empty($_POST['loginPassword'])) {
                if ($sessionUser = UserDb::getUserByLogin($_POST['loginName'], $_POST['loginPassword'])) {
                    $sessionHandler->setSessionUser($sessionUser);
                    $th = templateHandler::getTemplateHandler($root.'/html/main.html');
                } else {
                    $errorMessage = 'Überprüfen Sie ihren Benutzernamen oder Passwort.';
                }
            }
        } else {
            $th = templateHandler::getTemplateHandler($root.'/html/main.html');
        }
    } else {
        resolveActions($_POST, $sessionHandler);
    }

    if (isset($th)) {
             echo json_encode(['templateData' => $th->getHTML(),
                               'message'      => $errorMessage]);
    }

     function resolveActions ($urlParams, $sessionHandler) {
        if (!empty($urlParams['actionCode'])) {
            switch ($urlParams['actionCode']) {
                case 2:
                    require_once 'notification.php';
                    notification::getAllMarkerInformation();
                break;
                case 1:
                    if (!empty($_POST['markerId'])) {
                        require_once 'notification.php';
                        require_once 'animal.php';
                        $notification = notification::getFromDb($_POST['markerId']);
                        $animal = $notification->getAnimal();

                        $th = templateHandler::getTemplateHandler('../html/markerModal.html');

                        $th->addContent('modal', ['animalName'      => $animal->getName(),
                                                  'animalSex'       => sex::getFromDb($animal->getSex())->getCode(),
                                                  'size'       => $animal->getSize(),
                                                  'animalBirthDay'  => date('d.m.Y', strtotime($animal->getBirthDay())),
                                                  'animalRace'  => race::getFromDb($animal->getRace())->getName(),
                                                  'specification' => $animal->getSpecification(),
                                                  'eyeColour' => 'public/images/'.colour::getFromDb($animal->getEyeColour())->getCode().'_eye.png',
                                                  'furColour' => 'public/images/'.colour::getFromDb($animal->getFurColour())->getCode().'_eye.png',
                                                  'sexCode'   => 'public/images/'.sex::getFromDb($animal->getSex())->getCode().'.png',
                                                  'creationDate'    => $notification->getCreationDate(),
                                                  'description'     => $notification->getDescription()]);
                       echo $th->getHTML();
                    }
                break;
                case 3:
                    require_once 'race.php';
                    require_once 'colour.php';
                    $output = [];
                    $th = templateHandler::getTemplateHandler('../html/notificationModalBody.html');

                    $th->addContent('modal', ['races'   => race::getRaces(),
                                              'colours' => colour::getAllColours(),
                                              'sexes'   => ['female' => 1,
                                                            'male'   => 2]]);

                    $output['modalBody'] = $th->getHTML();

                    $th->setTemplate('../html/saveButton.html');
                    $output['modalFooter'] = $th->getHTML();

                    echo json_encode($output, true);
                break;
                case 4:
                    require_once 'notification.php';
                    require_once 'animal.php';
                    require_once 'race.php';

                    $date = new DateTime($_POST['birthDay']);
                    $animal = new animal($_POST['name'], 
                                         $date->format('Y-m-d'),
                                         $_POST['sex'],
                                         $_POST['furColour'],
                                         $_POST['eyeColour'],
                                         $_POST['species'],
                                         $_POST['race'],
                                         $_POST['specification']);
                    $animalId = $animal->persist();

                    $notification = new notification($_POST['latitude'],
                                                     $_POST['longitude'],
                                                     $animalId,
                                                     null,
                                                     $_POST['description']);
                    $notificationId = $notification->persist();

                    echo json_encode(['id' => $notificationId,
                                      'iconPath' => 'public/images/'.'dog.png']);
                break;
                case 6:
                    require_once 'race.php';

                    echo json_encode(race::getRaces(), true);
                    break;
                case 7:
                    $sessionHandler->closeSession();
                    header('Location: http://www.example.com/');
                    break;
                case 8:
                    $th = templateHandler::getTemplateHandler('../html/settings.html');
                    echo $th->getHTML();
                    break;
                case 9:
                    $th = templateHandler::getTemplateHandler('../html/editAnimals.html');
                    $userAnimals = userDb::getFromDb($sessionHandler->getSessionUser())->getAnimals();

                    $th->addContent('animals', $userAnimals);

                    echo $th->getHTML();
                    break;
            }
        }
    }
?>
