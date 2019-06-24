<?php
    interface TableFetchAllInterface {
        /**
         * Fetch all selected from database table
         * 
         * @param string $selector
         * @return array<Object>
         */
        public static function fetchAll( $selector );
    }

    interface TableFetchColumnInterface {
        /**
         * Fetch table column
         * 
         * @param string $selector
         * @return array<string>
         */
        public static function fetchColumn( $selector );
    }

    interface TableCreateInterface {
        /**
         * Create database table row
         * 
         * @param string $selector
         * @param collection $execute
         * @return boolean
         */
        public static function create( $selector, $execute );
    }

    /**
     * Handle database table services.
     * Read, Create
     */
    class TableModule implements TableFetchAllInterface, TableFetchColumnInterface, TableCreateInterface {
        public static function fetchAll( $selector ) {
            return PDOTableFetchAll::fetchAll( $selector );
        }

        public static function fetchColumn( $selector ) {
            return PDOTableFetchColumn::fetchColumn( $selector );
        }

        public static function create( $selector, $execute ) {
            return PDOTableCreateRow::create( $selector, $execute );
        }
    }
?>
