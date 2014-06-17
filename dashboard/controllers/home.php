<?php
    class ControllerHome {
        public static function View() {
            if ( !isset( $_SESSION[ 'user' ] ) ) {
                die( 'You must be logged in to do that.' );
            }
            $username = $_SESSION[ 'user' ][ 'name' ];
            $ftppassword = $_SESSION[ 'user' ][ 'ftppassword' ];
            Template( 'home/view', compact( 'username', 'ftppassword' ) );
        }
        public static function Listing() {
        }
        public static function Create() {
        }
        public static function Update() {
        }
        public static function Delete() {
        }
    }
?>
