<?php
    require_once 'colour.php';
    require_once 'sex.php';
    class animal {
        private $animal = null;
        private $name        = null;
        private $birthDay    = null;
        private $specification = null;
        private $sex         = null;
        private $race        = null;
        private $species     = null;
        private $size        = null;
        private $furColour   = null;
        public $h2o_safe     = ['getName', 'getAnimal', 'getBirthDay'];

        public function animal ($name, $birthDay, $sex, $furColour, $eyeColour, $species, $race, $specification) {
            $this->name = $name;
            $this->birthDay = $birthDay;
            $this->sex = $sex;
            $this->furColour = $furColour;
            $this->eyeColour = $eyeColour;
            $this->species = $species;
            $this->race = $race;
            $this->specification = $specification;
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
                $animalDb = new animal($row['name'],
                                       $row['birthDay'],
                                       $row['sex'],
                                       $row['furColour'],
                                       $row['eyeColour'],
                                       $row['species'],
                                       $row['race'],
                                       $row['specification']);
                $animalDb->animal    = $row['animal'];
                $animalDb->size      = $row['size'];
            }
            return $animalDb;
        }

        /**
         * @param int $id
         */
        public static function getAllAnimals ($id) {
            $animalDb = null;
        
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');
        
            $sql = 'SELECT *
                    FROM
                    animals
                    WHERE animal = '.$id.';';
            $result = $db->query($sql);
        
            if ($row = $result->fetch_assoc()) {
                $animalDb = new animal($row['name'],
                        $row['birthDay'],
                        $row['sex'],
                        $row['furColour'],
                        $row['eyeColour'],
                        $row['species'],
                        $row['race'],
                        $row['specification']);
                $animalDb->animal    = $row['animal'];
                $animalDb->size      = $row['size'];
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
            return date('d.m.Y', strtotime($this->birthDay));
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

        public function persist () {
            $result = null;
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'INSERT INTO
                    animals
                    VALUES (null,"'.$this->name.'","'.$this->birthDay.'",'.$this->sex.','.
                                $this->furColour.','.$this->eyeColour.',1, 0, "'.$this->specification.'",'.$this->race.');';

            $result = $db->query($sql);

            return $db->getLastInsertId();
        }

//         public function update () {
//             $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

//             $sql = 'UPDATE animals
//                     SET name='Alfred Schmidt', City='Hamburg'
//                     WHERE animal='.$this->getAnimal().';';

//             $result = $db->query($sql);

//             return $this->getAnimal();
//         }
    }