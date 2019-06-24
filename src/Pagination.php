<?php
    /**
     * Paginator
     * 
     * PHP version 7.2.4
     * 
     * @since      Class available since Release 0.0.0
     */ 
    class Pagination {
        /**
         * Generate paging links
         * 
         * @param int $current
         * @param int $total
         * @return string
         */
        public static function getHTML( $current, $total ) {
           
            if ( $total > 0 ) {
                $links = " $current ";
                
                /**
                 * Add pages links before current
                 */
                if ( $current-1 >= 1 ) {
                    for ( $i = 1; $i <= PAGING_OFFSET; $i++ ) {
                        $page = $current-$i;

                        if ( $page >= 1 ) {
                            $links = "<a href=\"?page=$page\" title=\"$page\">$page</a> ". $links;
                        } else {
                            break;
                        }
                    }

                    $links = "<a href=\"?page=". ( $current-1 ) ."\" title=\"". ( $current-1 ) ."\">Atgal</a> ". $links;
                }

                /**
                 * Add pages links after current
                 */
                if ( $current+1 <= $total ) {
                    for ( $i = 1; $i <= PAGING_OFFSET; $i++ ) {
                        $page = $current+$i;

                        if ( $page <= $total ) {
                            $links = $links ." <a href=\"?page=$page\" title=\"$page\">$page</a> ";
                        } else {
                            break;
                        }
                    }

                    $links = $links ." <a href=\"?page=". ( $current+1 ) ."\" title=\"". ( $current+1 ) ."\">Toliau</a>";
                }

                /**
                 * Add link to 0 page
                 */
                if ( $current-PAGING_OFFSET > 1 ) {
                    $links = "<a href=\"?page=0\" title=\"0\">Pradžia</a> ". $links;
                }

                return "<p id=\"pages\">". $links ."</p>";
            }
        }
    }
?>