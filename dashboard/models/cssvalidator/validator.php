<?php
    class CSSValidatorException extends Exception {} ;
    class CSSValidator {
        public static function Validate( $file ) {
            $xml = file_get_contents( 'http://jigsaw.w3.org/css-validator/validator?uri=' . urlencode( $file ) . '&warning=0&profile=css2&output=soap12' );
            $results = array();
            $replace = array( "<?xml version='1.0' encoding=" . '"utf-8"?>', 'env:', 'm:' );
            $errortree = array( 'Body', 'cssvalidationresponse', 'result', 'errors', 'errorlist' );
            foreach ( $replace as $value ) {
                $xml = str_replace( $value, '', $xml );
            }
            $object = simplexml_load_string( $xml );
            $object = get_object_vars( $object );
            foreach ( $errortree as $value ) {
                $object = get_object_vars( $object[ $value ] );
                if ( $value == "errors" ) {
                    $results[ 'errorcount' ] = $object[ 'errorcount' ];
                    if ( $results[ 'errorcount' ] == 0 ) {
                        throw New CSSValidatorException( "This document validates as CSS level 2.1 !" );
                    }
                }
            }
            for ( $i = 0; $i < $results[ 'errorcount' ]; ++$i ) {
                $results[ 'errors' ][ $i ] = get_object_vars( $object[ 'error' ][ $i ] );
                $results[ 'errors' ][ $i ][ 'row' ] = $results[ 'errors' ][ $i ][ 'line' ];
                $results[ 'errors' ][ $i ][ 'col' ] = 0;
            }
            return $results;
        }
    }
?>
