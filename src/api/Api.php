<?php
    require_once __DIR__.'/Controller.php';

    /**
     * Database, user services API
     * 
     * PHP version 7.2.4
     * 
     * @since      Class available since Release 0.0.0
     */ 
    class Api implements RunnableInterface {
        public static function run() {
            if ( ApiDependencies::isApproved() ) {
                Router::use( 'POST', 'sendMessage', array( 'SendMessageController', 'response' ) );
            } else {
                if ( HttpRequestType::isXml() ) {
                    ApiResponse::res( "ERROR 404" );
                }
            }

            if ( HttpRequestType::isXml() ) {
                exit; // Don't return HTML document
            }
        }
    }

    $responseAPI = false; // Holds api response

    class ApiDependencies {
        /**
         * Check header parameters and other security variables
         *
         * @return boolean
        */
        static public function isApproved() {
            return HttpGETState::isAvailable( 'action' ) && ApiRequestTime::isValidated(); // Header must have 'action' GET parameter
        }
    }

    class Router {
        /**
         * Main routing function
         * check which route to use
         *
         * @param string $type
         * @param string $action
         * @param array(string, string) $controllerAPI
         */
        public static function use( $type, $action, $controllerAPI ) {
            // Select route
            if ( $action == HttpGETValue::get( 'action' )
                && $type == $_SERVER[ 'REQUEST_METHOD' ] ) {

                // Call controller
                ApiRequestTime::set();
                ApiResponse::res( call_user_func( $controllerAPI ) );
            }
        }
    }

    class ApiResponse {
        /**
         * Formate api response according to headers
         *
         * @param mixed $data
         */
        public static function res( $data ) {
            $res = array();
            $res['res'] = $data;
            
            if ( HttpRequestType::isXML() ) {
                header( 'Content-Type: application/json' );
                echo json_encode( $res, JSON_UNESCAPED_UNICODE );
            } else {
                global $responseAPI;
                $responseAPI = $res;
            }
        }
    }

    /**
     * Request antiflood protection
     * Can be abused if user deletes cookies
     */
    class ApiRequestTime {
        /**
         * Set last request time in session variable
         */
        public static function set() {
            if ( session_status() != PHP_SESSION_NONE ) {
                $_SESSION[ 'API_REQUEST_TIMESTAMP' ] = time();
            }
        }

        /**
         * Check time margin between requests
         * uses session variable
         */
        public static function isValidated() {
            if ( session_status() != PHP_SESSION_NONE && isset( $_SESSION[ 'API_REQUEST_TIMESTAMP' ] ) ) {
                if ( time() - $_SESSION[ 'API_REQUEST_TIMESTAMP' ] < 2 ) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
    }

    class ApiErr {
        /**
         * Check api response if field validation returned error
         *
         * @param string $name
         * @return boolean
         */
        public static function isError( $name ) {
            global $responseAPI;

            if ( $responseAPI && isset( $responseAPI[ 'res' ] ) && isset( $responseAPI[ 'res' ][ 'errors' ] ) ) {
                return isset( $responseAPI[ 'res' ][ 'errors' ][ $name ] );
            } else {
                return false;
            }
        }
    }
?>
