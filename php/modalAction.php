<?php
    class modalAction {
        public function modalAction () {
        }

        public function getTemp () {
            $th = templateHandler::getTemplateHandler('../html/markerModal.html');
            $db = databaseHandler::getInstance ('localhost', 'marcel', 'Deutschrock', 'animal');

            $resultArray = $db->select('notifications', '*', "H");
            $resultArray['speciesCode'][0] .= '.png';

            $th->addContent('modal', $resultArray);
            echo $th->getHTML();
        }
    }
?>