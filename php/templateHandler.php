<?php
    require_once $root.'/h2o-php-master/h2o.php';
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

        public function setTemplate ($file) {
            $this->h2o->loadTemplate($file);
        }

        public function loadSubTemplate($file) {
            $this->h2o->loadSubTemplate($file);
        }

        public static function getTemplateHandler ($templateFile) {
            return new templateHandler($templateFile);
        }
    }