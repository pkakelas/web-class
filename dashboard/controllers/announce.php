<?php   
    class ControllerAnnounce {
        public static function Create( $text ) {
            clude( 'models/announce.php' );
            if ( !isset( $_SESSION[ 'user' ] ) || !$_SESSION[ 'user' ][ 'admin' ] ) {
                die( 'You are not authorized to do this action.' );
            }
            Announce::Add( $text );
        }
        public static function Delete( $announceid ) {
            clude( 'models/announce.php' );
            if ( !isset( $_SESSION[ 'user' ] ) || !$_SESSION[ 'user' ][ 'admin' ] ) {
                die( 'You are not authorized to do this action.' );
            }
            Announce::Delete( $announceid );
        }
        public static function Update( $announceid, $text, $view ) {
            $view = ( $view == 'true' );
            if ( !isset( $_SESSION[ 'user' ] ) || !$_SESSION[ 'user' ][ 'admin' ] ) {
                die( 'You are not authorized to do this action.' );
            } 
            clude( 'models/announce.php' );
            if ( $text == '' ) {
                Announce::Update( $announceid, $view );
            }
            else {
                Announce::Update( $announceid, $view, $text );
            }
        }
        public static function View() {
            clude( 'models/announce.php' );
            if ( isset( $_POST[ 'text' ] ) != false ) {
                $text = $_POST[ 'text' ];
                Announce::Add( $text );
            }
            $res = Announce::Listing();
            Template( 'announce/view', compact( 'res' ) );
        }
    }
?>
