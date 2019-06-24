<?php
    /**
     * Manage Database Messages table
     * 
     * PHP version 7.2.4
     * 
     * @since      Class available since Release 0.0.0
     */ 
    class MessagesTable {
        /**
         * Read database table row
         * 
         * @param int $limit
         * @param int $offset
         * @return array<Object>
         */
        public static function read( $limit = false, $offset = false ) {
            $selector = "SELECT id, fullName, email, birthdate, message, post_date FROM messages";

            if ( $limit ) {
                $selector = $selector. " LIMIT ". $limit;
            }

            if ( $offset ) {
                $selector = $selector. " OFFSET $offset";
            }

            return TableModule::fetchAll( $selector );
        }

        /**
         * Return rows count
         * 
         * @return int
         */
        public static function total() {
            $selector = "SELECT count(*) FROM messages";
            return (int) TableModule::fetchColumn( $selector );
        }

        /**
         * Create database table row
         * 
         * @param string @fullName
         * @param string @birthdate
         * @param string @email
         * @param string @message
         * @return boolean
         */
        public static function create( $fullName, $birthdate, $email, $message ) {
            $post_date = date( 'Y m d h:i', time() );
            $selector = "INSERT INTO messages ( fullName, email, birthdate, message, post_date ) VALUES ( :fullName, :email, :birthdate, :message, :post_date )";
            $execute = array( 'fullName' => $fullName, 'email' => $email, 'birthdate' => $birthdate, 'message' => $message, 'post_date' => $post_date );

            return TableModule::create( $selector, $execute );
        }
    }
?>
