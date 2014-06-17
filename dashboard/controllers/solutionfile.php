<?php
    class ControllerSolutionFile {
        public static function View( $id, $name, $solutionid ) {
            clude( 'models/solutionfile.php' );
            if ( $id > 0 ) {
                $file = SolutionFile::ItemById( $id );
            }
            else {
                $found = false;
                $files = SolutionFile::Listing( $solutionid );
                foreach ( $files as $file ) {
                    if ( $file[ 'name' ] == $name ) {
                        $file = SolutionFile::ItemById( $file[ 'id' ] );
                        $found = true;
                        break;
                    }
                }
                if ( !$found ) {
                    die( 'File not found.' );
                }
            }
            $mime = array(
                'jpg' => 'image/jpeg',
                'gif' => 'image/gif',
                'png' => 'image/png',
                'css' => 'text/css',
                'html' => 'text/html',
                'php' => 'text/plain',
                'txt' => 'text/plain'
            );
            $extension = strtolower( substr( $file[ 'name' ], strrpos( $file[ 'name' ], '.' ) + 1 ) );
            if ( isset( $mime[ $extension ] ) ) {
                $mimetype = $mime[ $extension ];
            }
            else {
                $mimetype = 'text/plain';
            }
            header( "Content-type: " . $mimetype );
            Template( 'solutionfile/view', compact( 'id', 'file' ) );
        }
        public static function Listing() {
        }
    }
?>
