<?php
    require_once __DIR__.'/Table.php';
    require_once __DIR__.'/tables/MessagesTable.php';

    interface ConnectionInterface {
        /**
         * Connect to services
         * return connection obj
         *
         * @return mixed
         */
        public static function connect();
    }

    $databaseInstance = false; // Holds database connection, LIMIT 1

    /**
     * PDO Connection
     */
    class PDOConnection implements ConnectionInterface {
        public static function connect() {
            $dbConnection = new PDO( "mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS );
            $dbConnection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // Throw exceptions
            return $dbConnection;
        }
    }

    /**
     * PDO Table fetchAll
     */
    class PDOTableFetchAll implements TableFetchAllInterface {
        public static function fetchAll( $selector ) {
            try {
                $stmt = DatabaseInstance::get()->prepare( $selector ); 
                $stmt->execute();
                $result = $stmt->fetchAll( PDO::FETCH_OBJ ); // Result Array[ Object ]
                return $result;
            } catch( PDOException $e ) {
                return false;
            }
        }
    }

    /**
     * PDO Table fetchColumn
     */
    class PDOTableFetchColumn implements TableFetchColumnInterface {
        public static function fetchColumn( $selector ) {
            try {
                $stmt = DatabaseInstance::get()->prepare( $selector ); 
                $stmt->execute();
                $result = $stmt->fetchColumn();
                return $result;
            } catch( PDOException $e ) {
                return false;
            }
        }
    }

    /**
     * PDO Table row create
     */
    class PDOTableCreateRow implements TableCreateInterface {
        public static function create( $selector, $execute ) {
            try {
                $stmt = DatabaseInstance::get()->prepare( $selector );
                $stmt->execute( $execute );
                return true;
            } catch( PDOException $e ) {
                echo $e;
                return false;
            }
        }
    }

    /**
     * Handle database connection instances
     */
    class DatabaseInstance {
        /**
         * Get database connection instance
         * 
         * @return mixed
         */
        public static function get( ) {
            global $databaseInstance;

            if ( !$databaseInstance ) {
                $databaseInstance = PDOConnection::connect();
            }
            
            return $databaseInstance;
        }
    }
?>
