<?php
    class ValidatorException extends Exception {} ;
    class Validator {
        public static function HTML_Validate( $url, $type = "file" ) {
            clude( 'models/validator/Services/W3C/HTMLValidator.php' );

            $v = new Services_W3C_HTMLValidator();
            
            if ( $type == "file") {
                if ( !file_exists( $url ) ) {
                    echo 'File not found.';
                    die();
                }
                $r = $v->validateFile($url);
            }
            else if ( $type == "url" ) {
                $r = $v->validate($url);
            }
            if ( $type != "file" && $type != "url" ) {
                throw New ValidatorException( "Invalid type specified: Type must be 'file' or 'url'." );
            }
            else {
                if ( $r->isValid() ) {
                    $r = get_object_vars($r);
                    $info[ 'pass' ] = true;
                    $info[ 'errors' ] = array();
                    $info[ 'warnings' ] = array();
                }
                else {
                    $r = get_object_vars($r);
                    $info[ 'pass' ] = false;
                    for ( $i = 0; $i < count( $r[ 'errors' ] ); ++$i ) {
                        $errors = get_object_vars( $r[ 'errors' ][ $i ] );
                        $warnings = get_object_vars( $r[ 'errors' ][ $i ] );
                        $info[ 'errors' ][ $i ][ 'description' ] = $errors[ 'message' ];
                        $info[ 'errors' ][ $i ][ 'row' ] = $errors[ 'line' ];
                        $info[ 'errors' ][ $i ][ 'col' ] = $errors[ 'col' ];
                    }
                    for ( $i = 0; $i < count( $r[ 'warnings' ] ); ++$i ) {
                        $warnings = get_object_vars( $r[ 'warnings' ][ $i ] );
                        $info[ 'warnings' ][ $i ][ 'description' ] = $warnings[ 'message' ];
                    }
                }
                return $info;
            }
        }
    }
?>
