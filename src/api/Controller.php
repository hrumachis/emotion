<?php
    interface ControllerAPI {
        /**
         * Api controller main logic
         *
         * @return mixed
        */
        public static function response();
    }
    
    // Controllers
    require_once __DIR__.'/controllers/SendMessageController.php';
?>
