<?php
use Symfony\Component\Validator\Constraints\Date;
use Endroid\QrCode\QrCode;
$root = dirname ( dirname ( __FILE__ ) ) . '/';

require_once 'templateHandler.php';
require_once 'databaseHandler.php';
require_once 'sessionHandler.php';
require_once 'user.php';
require_once '../vendor/autoload.php';
require_once '../config.php';

$sessionHandler = new session ();
$errorMessage = null;

if (empty ( $_POST ['actionCode'] )) {
	if (! $sessionHandler->getSessionUser ()) {
		$th = templateHandler::getTemplateHandler ( $root . '/html/login.html' );
		if (! empty ( $_POST ['loginName'] ) && ! empty ( $_POST ['loginPassword'] )) {
			if ($sessionUser = UserDb::getUserByLogin ( $_POST ['loginName'], $_POST ['loginPassword'] )) {
				$sessionHandler->setSessionUser ( $sessionUser );
				$th = templateHandler::getTemplateHandler ( $root . '/html/main.html' );
			} else {
				$errorMessage = 'Überprüfen Sie ihren Benutzernamen oder Passwort.' . $_POST ['loginName'];
			}
		}
	} else {
		$th = templateHandler::getTemplateHandler ( $root . '/html/main.html' );
	}
} else {
	resolveActions ( $_POST, $sessionHandler, $root );
}

if (isset ( $th )) {
	echo json_encode ( [ 
			'templateData' => $th->getHTML (),
			'message' => $errorMessage 
	] );
}
function resolveActions($urlParams, $sessionHandler, $root) {
	if (! empty ( $urlParams ['actionCode'] )) {
		switch ($urlParams ['actionCode']) {
			case 2 :
				require_once 'notification.php';
				notification::getAllMarkerInformation ();
				break;
			case 1 :
				if (! empty ( $_POST ['markerId'] )) {
					require_once 'notification.php';
					require_once 'animal.php';
					$notification = notification::getFromDb ( $_POST ['markerId'] );
					$animal = $notification->getAnimal ();
					
					$th = templateHandler::getTemplateHandler ( '../html/markerModal.html' );
					
					$th->addContent ( 'modal', [ 
							'animalName' => $animal->getName (),
							'animalSex' => sex::getFromDb ( $animal->getSex () )->getCode (),
							'size' => $animal->getSize (),
							'animalBirthDay' => date ( 'd.m.Y', strtotime ( $animal->getBirthDay () ) ),
							'animalRace' => race::getFromDb ( $animal->getRace () )->getName (),
							'specification' => $animal->getSpecification (),
							'eyeColour' => 'public/images/' . colour::getFromDb ( $animal->getEyeColour () )->getCode () . '_eye.png',
							'furColour' => 'public/images/' . colour::getFromDb ( $animal->getFurColour () )->getCode () . '_eye.png',
							'sexCode' => 'public/images/' . sex::getFromDb ( $animal->getSex () )->getCode () . '.png',
							'creationDate' => $notification->getCreationDate (),
							'description' => $notification->getDescription () 
					] );
					echo $th->getHTML ();
				}
				break;
			case 3 :
				require_once 'race.php';
				require_once 'colour.php';
				$output = [ ];
				$th = templateHandler::getTemplateHandler ( '../html/notificationModalBody.html' );
				
				$th->addContent ( 'modal', [ 
						'races' => race::getRaces (),
						'colours' => colour::getAllColours (),
						'sexes' => [ 
								'female' => 1,
								'male' => 2 
						] 
				] );
				
				$output ['modalBody'] = $th->getHTML ();
				
				$th->setTemplate ( '../html/saveButton.html' );
				$output ['modalFooter'] = $th->getHTML ();
				
				echo json_encode ( $output, true );
				break;
			case 4 :
				require_once 'notification.php';
				require_once 'animal.php';
				require_once 'race.php';
				
				$date = new DateTime ( $_POST ['birthDay'] );
				$animal = new animal ( $_POST ['name'], $date->format ( 'Y-m-d' ), $_POST ['sex'], $_POST ['furColour'], $_POST ['eyeColour'], $_POST ['species'], $_POST ['race'], $_POST ['specification'] );
				$animalId = $animal->persist ();
				
				$notification = new notification ( $_POST ['latitude'], $_POST ['longitude'], $animalId, null, $_POST ['description'] );
				$notificationId = $notification->persist ();
				
				echo json_encode ( [ 
						'id' => $notificationId,
						'iconPath' => 'public/images/' . 'dog.png' 
				] );
				break;
			case 6 :
				$raceQuery = new RacesQuery ();
				$allRaces = $raceQuery->find ();
				$select2Races = [ ];
				
				foreach ( $allRaces as $race ) {
					$select2Races [] = [ 
							'id' => $race->getRace (),
							'text' => $race->getName () 
					];
				}
				
				echo json_encode ( $select2Races, true );
				break;
			case 7 :
				$sessionHandler->closeSession ();
				header ( 'Location: http://www.example.com/' );
				break;
			case 8 :
				$th = templateHandler::getTemplateHandler ( '../html/settings.html' );
				echo $th->getHTML ();
				break;
			case 9 :
				$th = templateHandler::getTemplateHandler ( '../html/animalOverview.html' );
				
				$animalQuery = new AnimalsQuery ();
				$animals = $animalQuery->filterByUserid ( $sessionHandler->getSessionUser () )->joinWithColoursRelatedByEyecolourid ()->find ();
				
				$output = [ ];
				foreach ( $animals as $animal ) {
					$eyeColour = $animal->getColoursRelatedByEyecolourid ();
					$furColour = $animal->getColoursRelatedByFurcolourid ();
					$sex = $animal->getSexes()->getCode();
					$tmpAnimal = [ 
							'name' => $animal->getName (),
							'birthday' => $animal->getBirthDay ()->format ( 'd.m.Y' ),
							'race' => $animal->getRaces ()->getName (),
							'animal' => $animal->getAnimal (),
							'specification' => $animal->getSpecification (),
							'eyeColour' => $eyeColour->getName (),
							'furColour' => $furColour->getName (),
							'sex' => $sex
					];
					
					$animalImage = $animal->getImage ();
					if ($animalImage) {
						$tmpAnimal ['imagePath'] = 'pictures/' . $animal->getImage ();
					} else {
						$tmpAnimal ['imagePath'] = 'pictures/placeholder.png';
					}
					
					$output [] = $tmpAnimal;
				}
				
				$th->addContent ( 'animals', $output );
				
				echo $th->getHTML ();
				break;
			case 10 :
				$th = templateHandler::getTemplateHandler ( '../html/editAnimal.html' );
				
				if (! empty ( $_POST ['animal'] )) {
					$animalsQuery = new AnimalsQuery ();
					$animal = $animalsQuery->findPk ( $_POST ['animal'] );
					
					$sexes = [ ];
					$colours = [ ];
					
					$imagePath = 'pictures/placeholder.png';
					if ($animal->getImage ()) {
						$imagePath = 'pictures/' . $animal->getImage ();
					}
					
					$th->addContent ( 'animal', [ 
							'animal' => $animal->getAnimal (),
							'name' => $animal->getName (),
							'specification' => $animal->getSpecification (),
							'size' => $animal->getSize (),
							'birthDay' => $animal->getBirthday ( 'dd.mm.YYYY' ),
							'sex' => $animal->getSexes ()->getCode (),
							'species' => $animal->getSpecies ()->getDescription (),
							'speciesId' => $animal->getSpeciesid (),
							'race' => $animal->getRaces ()->getName (),
							'raceId' => $animal->getRaceid (),
							'eyeColour' => $animal->getEyecolourid (),
							'imagePath' => $imagePath 
					] );
				}
				foreach ( SexesQuery::create ()->find () as $sex ) {
					$sexes [$sex->getCode ()] = $sex->getSex ();
				}
				
				foreach ( ColoursQuery::create ()->find () as $colour ) {
					$colours [$colour->getColour ()] = $colour->getName ();
				}
				syslog ( 0, print_r ( $colours, true ) );
				$th->addContent ( 'sexes', $sexes );
				$th->addContent ( 'colours', $colours );
				
				echo $th->getHTML ();
				break;
			case 11 :
				require_once 'animal.php';
				
				$date = new DateTime ( $_POST ['birthDay'] );
				$animal = new animal ( $_POST ['name'], $date->format ( 'Y-m-d' ), $_POST ['sex'], $_POST ['furColour'], $_POST ['eyeColour'], $_POST ['species'], $_POST ['race'], $_POST ['specification'] );
				$animalId = $animal->persist ();
				break;
			case 12 :
				$speciesQuery = new SpeciesQuery ();
				$allSpecies = $speciesQuery->find ();
				$select2Species = [ ];
				
				foreach ( $allSpecies as $species ) {
					$select2Species [] = [ 
							'id' => $species->getSpecies (),
							'text' => $species->getDescription () 
					];
				}
				
				echo json_encode ( $select2Species, true );
				
				break;
			case 13 :
				syslog ( 0, print_r ( $_POST, true ) );
				$animalData = [ ];
				
				$animalId = null;
				if (! empty ( $_POST ['animal'] )) {
					$animalId = $_POST ['animal'];
				}
				
				$animalData ['Name'] = null;
				if (filter_var ( $_POST ['name'], FILTER_SANITIZE_STRING )) {
					$animalData ['Name'] = $_POST ['name'];
				}
				
				$animalData ['Birthday'] = null;
				if (! empty ( $_POST ['birthDay'] )) {
					$date = $date = new DateTime ( $_POST ['birthDay'] );
					$animalData ['Birthday'] = $date->format ( 'Y-m-d' );
				}
				
				$animalData ['Sexid'] = null;
				if (! empty ( $_POST ['sex'] )) {
					$animalData ['Sexid'] = $_POST ['sex'];
				}
				
				$animalData ['Furcolourid'] = null;
				if (! empty ( $_POST ['furColour'] )) {
					$animalData ['Furcolourid'] = $_POST ['furColour'];
				}
				
				$animalData ['Eyecolourid'] = null;
				if (! empty ( $_POST ['eyeColour'] )) {
					$animalData ['Eyecolourid'] = $_POST ['eyeColour'];
				}
				
				$animalData ['Speciesid'] = null;
				if (! empty ( $_POST ['species'] )) {
					$animalData ['Speciesid'] = $_POST ['species'];
				}
				
				$animalData ['Size'] = null;
				if (! empty ( $_POST ['size'] )) {
					$animalData ['Size'] = $_POST ['size'];
				}
				
				$animalData ['Raceid'] = null;
				if (! empty ( $_POST ['race'] )) {
					$animalData ['Raceid'] = $_POST ['race'];
				}
				
				$animalData ['Specification'] = null;
				if (! empty ( $_POST ['specification'] )) {
					$animalData ['Specification'] = $_POST ['specification'];
				}
				
				$animalData ['Image'] = null;
				if (! empty ( $_FILES ["image"] ["tmp_name"] )) {
					$imageId = uniqid ();
					move_uploaded_file ( $_FILES ["image"] ["tmp_name"], $root . 'pictures/' . $imageId . '.png' );
					$animalData ['Image'] = $imageId . '.png';
				}
				
				if (! empty ( $animalId )) {
					AnimalsQuery::create ()->filterByPrimaryKey ( $animalId )->update ( $animalData );
				} else {
					$animalObject = new Animals ();
					
					$animalObject->setName ( $animalData ['Name'] )->setBirthday ( $animalData ['Birthday'] )->setSexid ( $animalData ['Sexid'] )->setFurcolourid ( $animalData ['Furcolourid'] )->setEyecolourid ( $animalData ['Eyecolourid'] )->setSpeciesid ( $animalData ['Speciesid'] )->setSize ( $animalData ['Size'] )->setRaceid ( $animalData ['Raceid'] )->setSpecification ( $animalData ['Specification'] )->setImage ( $imageId . '.png' );
					$animalObject->save ();
				}
				
				break;
			case 14 :
				$th = templateHandler::getTemplateHandler ( '../html/announcesOverview.html' );
				$userAnimals = userDb::getFromDb ( $sessionHandler->getSessionUser () )->getAnimals ();
				
				$th->addContent ( 'animals', $userAnimals );
				
				echo $th->getHTML ();
				break;
			case 15 :
				$th = templateHandler::getTemplateHandler ( '../html/animalSearch.html' );
				$th->addContent ( 'animalId', $_POST ['animalId'] );
				
				echo $th->getHTML ();
				break;
			case 16 :
				$dateTime = new DateTime ();
				$animalQuery = new AnimalsQuery ();
				$animal = $animalQuery->findPk ( $_POST ['animalId'] );
				
				$notificationTypeQuery = new NotificationtypeQuery ();
				$notificationType = $notificationTypeQuery->findOneByCode ( 'missing' );
				
				$missingDate = new DateTime ( $_POST ['missingDate'] );
				
				$notificationObject = new Notifications ();
				$notificationObject->setNotificationtype ( $notificationType )->setCreationdate ( $dateTime->format ( 'Y-m-d' ) )->setLocation ( $_POST ['missingLocation'] )->setDescription ( $_POST ['additionalInfo'] )->setAnimals ( $animal )->setLatitude ( 40.45 )->setLongitude ( 40.45 )->setUser ( $sessionHandler->getSessionUser () )->save ();
				
				$searchNotificationObject = new Searchnotifications ();
				$searchNotificationObject->setAdditionalinformation ( $_POST ['additionalInfo'] )->setNotifications ( $notificationObject )->setMissingdate ( $missingDate->format ( 'Y-m-d' ) )->setReward ( $_POST ['reward'] )->save ();
				
				$qrCode = new QrCode ();
				$qrCode->setSize ( 50 );
				$qrCode->setText ( 'http://www.pawhub.de/notifications/' + ( int ) $notificationObject->getNotification () )->render ( '../pictures/' . ( int ) $notificationObject->getNotification () . '.png' );
				
				$th = templateHandler::getTemplateHandler ( '../html/animalSearch.html' );
				echo $th->getHTML ();
				break;
			case 17 :
				$root = dirname ( dirname ( __FILE__ ) ) . '/';
				$notificationQuery = new NotificationsQuery ();
				$searchNotificationQuery = new SearchnotificationsQuery ();
				$notifications = $notificationQuery->filterByUser ( $sessionHandler->getSessionUser () )->joinWithSearchnotifications ()->find ();
				
				$output = [ ];
				foreach ( $notifications as $notification ) {
					$notificationAnimal = $notification->getAnimals ();
					$searchNotification = $notification->getSearchNotificationss ();
					
					$tmp = [ 
							'name' => $notificationAnimal->getName (),
							'notification' => $notification->getNotification (),
							'creationDate' => $notification->getCreationDate ()->format ( 'd.m.Y' ),
							'lastSeen' => $searchNotification [0]->getMissingDate ()->format ( 'd.m.Y' ),
							'location' => $notification->getLocation (),
							'reward' => $searchNotification [0]->getReward (),
							'qrUrl' => 'pictures/' . ( int ) $notification->getNotification () . '.png' 
					];
					
					if ($notificationAnimal->getImage ()) {
						$tmp ['imagePath'] = 'pictures/' . $notificationAnimal->getImage ();
					}
					$output [] = $tmp;
				}
				
				$th = templateHandler::getTemplateHandler ( '../html/searchOverview.html' );
				$th->addContent ( 'animals', $output );
				echo $th->getHTML ();
				break;
			case 18 :
				$notificationQuery = new NotificationsQuery ();
				$searchNotificationQuery = new SearchnotificationsQuery ();
				$searchNotificationQuery->filterByNotification ( $_POST ['notification'] )->delete ();
				
				$notificationQuery->filterByPrimaryKey ( $_POST ['notification'] )->delete ();
				break;
			case 19 :
				$notificationQuery = new NotificationsQuery ();
				$searchNotificationQuery = new SearchnotificationsQuery ();
				$searchNotificationQuery->filterByNotification ( $_POST ['notification'] )->delete ();
				
				$notificationQuery->filterByPrimaryKey ( $_POST ['notification'] )->delete ();
				break;
			case 20 :
				$notificationQuery = new NotificationsQuery ();
				$notifications = $notificationQuery->filterByUser ( $sessionHandler->getSessionUser () )->filterByNotification ($_POST['notificationId'])->joinWithSearchnotifications()->find();

				$output = [ ];
				foreach ( $notifications as $notification ) {
					$searchNotification = $notification->getSearchNotificationss ();
					
					$tmp = [ 
							'notification' => $notification->getNotification (),
							'creationDate' => $notification->getCreationDate ()->format ( 'd.m.Y' ),
							'lastSeen' => $searchNotification [0]->getMissingDate ()->format ( 'd.m.Y' ),
							'location' => $notification->getLocation (),
							'reward' => $searchNotification [0]->getReward (),
							'qrUrl' => 'pictures/' . ( int ) $notification->getNotification () . '.png' 
					];
					
					$output['missingDate'] = $searchNotification [0]->getMissingDate ()->format ( 'd.m.Y' );
					$output['location'] = $notification->getLocation ();
					$output['reward'] = $searchNotification[0]->getReward ();
					$output['additionalInformation'] = $searchNotification[0]->getAdditionalInformation ();
				}
				$th = templateHandler::getTemplateHandler ( '../html/animalSearch.html' );
				$th->addContent ( 'animal', $output );
				echo $th->getHTML ();
				break;
		}
	}
}
?>
