<?php
    /**
     * Controller
     * Post message into database
     * 
     * PHP version 7.2.4
     * 
     * @since      Class available since Release 0.0.0
     */
    class SendMessageController implements ControllerAPI {
        public static function response( ) {
            $errors = array(); // array<string>
            $results = array(
                "success" => false
            );

            if ( HttpRequestType::isXML() ) {
                $fullName = HttpGETValue::get( 'fullName' ); // string
                $birthdate = HttpGETValue::get( 'birthdate' ); // date "Y-m-d"
                $email = HttpGETValue::get( 'email' ); // string
                $message = htmlspecialchars( HttpGETValue::get( 'message' ) ); // string
            } else {
                $fullName = HttpPOSTValue::get( 'fullName' ); // string
                $birthdate = HttpPOSTValue::get( 'birthdate' ); // date "Y-m-d"
                $email = HttpPOSTValue::get( 'email' ); // string
                $message = htmlspecialchars( HttpPOSTValue::get( 'message' ) ); // string
            }
            
            /**
             * Validate full name
             */
            if ( strlen( $fullName ) <= 0 ) {
                $errors[ 'fullName' ] = "Įveskite savo vardą ir pavardę.";
            } else if ( !preg_match( "/^[a-zA-Z]+ [a-zA-Z]+$/", $fullName ) || strlen( $fullName ) > 255 ) {
                $errors[ 'fullName' ] = "Blogai įvestas jūsų vardas pavardė.";
            }

            /**
             * Validate email
             */
            if ( strlen( $email ) > 0 || strlen( $email ) > 255 ) {
                if ( !preg_match( "/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email ) ) {
                    $errors[ 'email' ] = "Blogai įvestas el-pašto adresas.";
                }
            }

            /**
             *  Validate birthdate
             */
            if ( strlen( $birthdate ) <= 0 || strlen( $birthdate ) > 255 ) {
                $errors[ 'birthdate' ] = "Įveskite savo gimimo datą.";
            } else {
                $birthdateRaw = new DateTime( $birthdate );

                if ( !checkdate( $birthdateRaw->format( 'm' ), $birthdateRaw->format( 'd' ), $birthdateRaw->format( 'Y' ) ) ) {
                    $errors[ 'birthdate' ] = "Blogai įvesti gimimo metai.";
                } else if ( $birthdateRaw >= new DateTime() ) { // Check if date is past
                    $errors[ 'birthdate' ] = "Blogai įvesti gimimo metai.";
                }
            }

            /**
             * Validate message
             */
            if ( strlen( $message ) <= 0 ) {
                $errors[ 'message' ] = "Įveskite savo žinutę.";
            } else if ( strlen( $message ) >= MSG_LENGTH_MAX ) {
                $errors[ 'message' ] = "Žinutė negali būti ilgesnė " .MSG_LENGTH_MAX. " simbolių.";
            }

            // If there is errors formate error response
            if ( count( $errors ) > 0 ) {
                $results[ 'errors' ] = $errors;
                return $results;
            } else {
                MessagesTable::create( $fullName, $birthdate, $email, $message );
                $results[ 'success' ] = true;
                $results[ 'age' ] = CalculateYears::calc( $birthdate );
                return $results;
            }
        }
    }
?>
