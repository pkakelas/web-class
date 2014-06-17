<?php
    $code = $file[ 'source' ];
    ?>
    <pre><?php
    $k = 0;
    if ( !isset( $file[ 'validator' ] ) ) {
        $result = array();
        $result[ 'pass' ] = true;
    }
    else {
        $result = $file[ 'validator' ];
    }
    $errorchar = false;
    foreach ( $code as $i => $line ) {
        for ( $j = 0; $j < strlen( $line ); ++$j ) {
            if ( !$result[ 'pass' ] && isset( $result[ 'errors' ][ $k ] ) && $result[ 'errors' ][ $k ][ 'row' ] - 1 == $i && $result[ 'errors' ][ $k ][ 'col' ] - 1 == $j ) {
                ?><span class="codeerror" title="<?php
                echo htmlspecialchars( $result[ 'errors' ][ $k ][ 'description' ] );
                ++$k;
                ?>"><?php
                $errorchar = true;
            }
            switch ( $line[ $j ] ) {
                case '>':
                    echo '&gt;';
                    break;
                case '<':
                    echo '&lt;';
                    break;
                case '&':
                    echo '&amp;';
                    break;
                default:
                    echo $line[ $j ];
            }
            if ( $errorchar ) {
                $errorchar = false;
                ?></span><?php
            }
        }
        echo "\n";
    }
    ?></pre><?php
?>
