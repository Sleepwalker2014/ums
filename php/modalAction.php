<?php
    class modalAction {
        public function modalAction () {
        }

        public function getTemp () {
            $th = templateHandler::getTemplateHandler('../html/markerModal.html');
            $th->addContent('modal', ['title' => 'Tier entlaufen', 
                                      'content' => 'Diese Katze ist weg']);
            echo $th->getHTML();
        }
    }
?>