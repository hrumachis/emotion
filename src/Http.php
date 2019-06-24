<?php
    class HttpGETValue {
        /**
         * Get $_GET variable value
         * 
         * @param string $name
         * @return mixed
         */
        public static function get( $name ) {
            if ( HttpGETState::isAvailable( $name ) ) {
                return $_GET[ $name ];
            } else
                return false;
        }

        /**
         * Get $_GET variable value
         * 
         * @param string $name
         * @return int
         */
        public static function getIntNatural( $name ) {
            if ( HttpGETState::isAvailable( $name ) ) {
                if ( filter_var( $_GET[ $name ], FILTER_VALIDATE_INT ) && $_GET[ $name ] >= 0 ) {
                    return $_GET[ $name ];
                } else {
                    return false;
                }
            } else
                return false;
        }
    }

    class HttpGETState {
        /**
         * Check if $_GET variable is set
         * 
         * @param string $name
         * @return boolean
         */
        public static function isAvailable( $name ) {
            return isset( $_GET[ $name ] );
        }
    }

    class HttpPOSTValue {
        /**
         * Get $_POST variable
         * 
         * @param string $name
         * @return mixed
         */
        public static function get( $name ) {
            if ( HttpPostState::isAvailable( $name ) ) {
                return $_POST[ $name ];
            } else
                return false;
        }
    }

    class HttpPostState {
        /**
         * Check if $_POST variable is set
         * 
         * @param string $name
         * @return boolean
         */
        public static function isAvailable( $name ) {
            return isset( $_POST[ $name ] );
        }
    }

    final class HttpRequestType {
        /**
         * Check if header has HTTP_X_REQUESTED_WITH parameter
         * value 'xmlhttprequest' means it's ajax request
         * 
         * @param string $name
         * @return boolean
         */
        public static function isXML() {
            return !empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest';
        }
    }
?>
