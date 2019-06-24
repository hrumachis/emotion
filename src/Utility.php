<?php
    /**
     * Calculate years from given date to present
     *
     * @param string $value "Y-m-d"
     * @return int
    */
    class CalculateYears {
        public static function calc( $date ) {
            // Explode the date to get month, day and year
            $birthDate = explode( "-", $date );

            // Get age from date or birthdate
            $age = ( date( "md", date( "U", mktime( 0, 0, 0, $birthDate[ 1 ], $birthDate[ 2 ], $birthDate[ 0 ] ) ) ) > date( "md" )
                ? ( ( date( "Y" ) - $birthDate[ 0 ] ) - 1 )
                : ( date( "Y" ) - $birthDate[ 0 ] ) );

            return $age;
        }
    }
?>
