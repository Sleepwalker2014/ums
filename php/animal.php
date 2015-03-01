<?php
    require_once 'colour.php';
    require_once 'sex.php';
    require_once 'race.php';
    class animal {
        private $animal = null;
        private $name        = null;
        private $birthDay    = null;
        private $specification = null;
        private $sex         = null;
        private $race        = null;
        private $size        = null;
        private $furColour   = null;
        private $eyeColour   = null;

        public function animal () {
            
        }

        /**
         * @param int $id
         */
        public static function getFromDb ($id) {
            $animalDb = null;

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    animals
                    WHERE animal = '.$id.';';
            $result = $db->query($sql);

            if ($row = $result->fetch_assoc()) {
                $animalDb = new animal();
                $animalDb->animal    = $row['animal'];
                $animalDb->name      = $row['name'];
                $animalDb->sex       = $row['sex'];
                $animalDb->race      = $row['race'];
                $animalDb->size      = $row['size'];
                $animalDb->birthDay  = $row['birthDay'];
                $animalDb->furColour = $row['furColour'];
                $animalDb->eyeColour = $row['eyeColour'];
                $animalDb->specification = $row['specification'];
            }
            return $animalDb;
        }

        public function getAnimal () {
            return $this->animal;
        }

        public function getName () {
            return $this->name;
        }

        public function getBirthDay () {
            return $this->birthDay;
        }

        public function getSex () {
            return $this->sex;
        }

        public function getSize () {
            return $this->size;
        }

        public function getRace () {
            return $this->race;
        }

        public function getFurColour () {
            return $this->furColour;
        }

        public function getEyeColour () {
            return $this->eyeColour;
        }

        public function getSpecification () {
            return $this->specification;
        }
    }