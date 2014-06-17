<?php
    return;
    $out = array();

    function unrar( $folder ) {
        $dir = opendir( $folder );
        while ( $file = readdir( $dir ) ) {
            if ( strtolower( substr( $file, -strlen( '.rar' ) ) ) == '.rar' ) {
                chdir( $folder );
                exec( 'unrar x -c- -y ' . escapeshellarg( $folder . '/' . $file ) . '|tail --lines=+7|head --lines=-1', $out );
                foreach ( $out as $extracted ) {
                    $data = extract( "\t", $extracted );
                    $filename = $data[ 1 ];
                    // TODO: Call File::Create etc.
                }
            }
        }
    }

    unrar( '/home/dashboard/uploads' );

    echo implode( "\n", $out );
?>
