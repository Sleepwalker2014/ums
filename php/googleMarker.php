<?php
    class notification () {
        private latitude  = null;
        private longitude = null;
        private animal    = null;
        public notification () {
            
        }
        
        public getAnimal ($byId = false) {
            if ($byId === true) {
                return $this->animal;
            }
        }
    }
?>
