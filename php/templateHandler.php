<?php
    require '../h2o-php-master/h2o.php';
    class templateHandler {
        private $inputFile = null;
        private static $templateHandler = null;
        private $h2o = null;
        private $templateContents = [];

        public function templateHandler($templateFile) {
            $this->h2o = new H2o($templateFile);
        }

        public function addContent ($key, $tContent) {
            $this->templateContents[$key] = $tContent;
        }

        public function getHTML () {
            return $this->h2o->render($this->templateContents);
        }

        public static function getTemplateHandler ($templateFile) {
            if (self::$templateHandler) {
                return self::$templateHandler;
            } else {
                return self::$templateHandler = new templateHandler($templateFile);
            }
        }
    }
?>