<?php
    class ControllerSession {
        public static function View( $wrong ) {
            if ( isset( $_SESSION[ 'user' ] ) ) {
                $user = $_SESSION[ 'user' ];
            }
            else {
                $user = false;
            }
            Template( 'session/create', compact( 'wrong' ) );
        }
        public static function Create( $user = '', $password = '') {
            clude( 'models/user.php' );
            $data = User::Login( $user, $password );
            if ( $data == false ) { 
                $data = User::ItemByName( $user );
                $data = User::Login( $data[ 'email' ], $password );
            }
            $success = $data !== false;
            if ( $success ) {
                global $settings;
                $eofw = 2147483646;
                if ( $data[ 'authtoken' ] == '' ) {
                    $data[ 'authtoken' ] = User::RenewAuthtoken( $data[ 'id' ] );
                }
                $cookie = $data[ 'id' ] . ':' . $data[ 'authtoken' ];
                setcookie( $settings[ 'cookiename' ], $cookie, $eofw, '/', $settings[ 'cookiedomain' ], false, true );
                $_SESSION[ 'user' ] = $data;
                Template( 'solution/listing' );
                Go( "home" );
            }
            else {
                Go( "login?wrong=yes" );
            }
        }
        public static function Delete() {
            global $settings;

            setcookie( $settings[ 'cookiename' ], '', time() - 86400, '/', $settings[ 'cookiedomain' ], false, true );
            clude( 'models/user.php' );
            User::ClearAuthtoken( $_SESSION[ 'user' ][ 'id' ] );
            unset( $_SESSION[ 'user' ] );
            $success = true;

            Template( 'session/delete' );
        }
    }
?>
