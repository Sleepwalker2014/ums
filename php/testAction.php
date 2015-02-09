<?php
    require_once 'templateHandler.php';
    class testAction {
        public function testAction () {
        }

        public function getTemp () {
            $th = templateHandler::getTemplateHandler('../html/markerModal.html');
            $th->addContent('modal', ['title' => 'Tier entlaufen', 
                                      'content' => 'Diese Katze ist weg']);
            echo $th->getHTML();
        }
    }
?>