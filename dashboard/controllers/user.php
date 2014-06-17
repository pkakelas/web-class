<?php
    class ControllerUser {
        public static function View( $userid, $hash ) {
            clude( 'models/user.php' );

            if ( $userid > 0 ) {
                // user account creation
                $userid = ( int )$userid;
                if ( !preg_match( '#^[0-9a-f]{16}$#', $hash ) ) {
                    $hash = '';
                }
                if ( !User::HashValid( $userid, $hash ) ) {
                    die( 'Έχεις ήδη ορίσει τον κωδικό σου. Αν αντιμετωπίζεις οποιοδήποτε πρόβλημα, επικοινώνησε μαζί μας στο web-seminar@softlab.ntua.gr' );
                }
                $_SESSION[ 'user' ] = User::Item( $userid );
                Template( 'user/update', compact( 'userid', 'hash' ) );
            }
        }
        public static function Listing() {
        }
        public static function Create() {
        }
        public static function Update( $password ) {
            if ( !isset( $_SESSION[ 'user' ] ) ) {
                die( 'You must be logged in to do that.' );
            }

            clude( 'models/user.php' );

            User::SetPassword( $_SESSION[ 'user' ][ 'id' ], $password );

            Go( 'home' );
        }
        public static function Delete() {
        }
    }
?>
