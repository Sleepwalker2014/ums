<?php
    require 'databaseHandler.php';
    class modalAction {
        public function modalAction () {
        }

        public function getTemp () {
            $th = templateHandler::getTemplateHandler('../html/markerModal.html');
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animals');
            $th->addContent('modal', ['title' => 'Tier entlaufen', 
                                      'content' => 'Diese Katze ist weg']);
            echo $th->getHTML();
        }
    }
?>