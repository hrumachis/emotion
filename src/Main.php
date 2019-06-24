<?php
    require_once __DIR__.'/config.php';
    require_once __DIR__.'/Utility.php';
    require_once __DIR__.'/Http.php';
    require_once __DIR__.'/database/Database.php';
    require_once __DIR__.'/api/Api.php';
    require_once __DIR__.'/Pagination.php';

    interface RunnableInterface {
        /**
         * Initialize services
         */ 
        public static function run();
    }

    /**
     * Main class
     * 
     * PHP version 7.2.4
     * 
     * @author     Andrius Mikalauskas <eu.andrius.mikalauskas@gmail.com>
     * @since      Class available since Release 0.0.0
     */ 
    class Main implements RunnableInterface {
        public static function run() {
            session_start();
            Api::run();
        }
    }

    Main::run();
?>
