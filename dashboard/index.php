<?php
    ob_start();
    
    session_start();
    error_reporting( E_ERROR | E_WARNING | E_PARSE | E_NOTICE );

    global $settings;
    $settings = include 'settings.php';
    
    $resource = $method = '';
    !isset( $_GET[ 'resource' ] ) or $resource = $_GET[ 'resource' ];
    !isset( $_GET[ 'method' ] ) or $method = $_GET[ 'method' ];

    if ( !in_array( $resource, array(
        'user', 'home', 'session', 'solution', 'solutionfile', 'announce'
    ) ) ) {
        $resource = 'user';
        $method = 'view';
    }

    if ( $method == 'create' || $method == 'delete' || $method == 'update' ) {
        $vars = $_POST;
        $_SERVER[ 'REQUEST_METHOD' ] == 'POST' or die( 'Non-idempotent REST method cannot be applied with the idempotent HTTP request method "' . $_SERVER[ 'REQUEST_METHOD' ] . '"' );

        // check http referer
        if ( !isset( $_SERVER[ 'HTTP_REFERER' ] ) ) {
            // allow
        }
        else {
            $referer = $_SERVER[ 'HTTP_REFERER' ];
            $pieces = explode( "/", $referer );
            if ( isset( $pieces[ 2 ] ) ) {
                if ( $pieces[ 2 ][ strlen( $pieces[ 2 ] ) - 1 ] == '#' ) {
                    // remove possible # suffix
                    $pieces[ 2 ] = substr( $pieces[ 2 ], 0, -1 );
                }
                $domain = $pieces[ 2 ];
                $domain = substr( $domain, -strlen( 'softlab.ntua.gr' ) );
                $domain = strtolower( $domain );
                /*
                if ( $domain != 'softlab.ntua.gr' && $referer !== "" ) {
                    throw New Exception( 'Not Valid Post Referer - ' . $domain  );
                }
                */
            }
        }
    }
    else {
        unset( $_GET[ 'resource' ], $_GET[ 'method' ] );
        $vars = $_GET;
        $method == 'view' or $method = 'listing';
    }
    
    function Template( $path, $variables = array() ) {
        foreach ( $variables as $_name => $_value ) {
            $$_name = $_value; // MAGIC!
        }
        include 'views/' . $path . '.php';
    }
    
    function clude( $path ) {
        static $included = array();
        if ( !isset( $included[ $path ] ) ) {
            $included[ $path ] = true;
            return include $path;
        }
        return true;
    }

    function Go( $url ) {
        global $settings;

        header( 'Location: ' . $settings[ 'base' ] . '/' . $url );
        die();
    }
    
    // echo "<?xml version=\"1.0\" encoding=\"utf-8\">\n";

    clude( 'models/db.php' );
    clude( 'controllers/' . $resource . '.php' );
    
    $refl = New ReflectionClass( 'Controller' . $resource );
    $func = $refl->getMethod( $method );
    
    $params = array();
    
    $paramlist = $func->getParameters();
    
    if ( !empty( $paramlist ) && $paramlist[ 0 ]->getName() == 'multiargs' ) {
        // pass arguments compacted
        $params[ 'multiargs' ] = $vars;
    }
    else {
        foreach ( $paramlist as $parameter ) {
            $paramname = $parameter->getName();
            if ( isset( $vars[ $paramname ] ) ) {
                $params[] = $vars[ $paramname ];
            }
            else {
                if ( !$parameter->isDefaultValueAvailable() ) {
                    $params[] = null;
                }
                else { 
                    $params[] = $parameter->getDefaultValue();
                }
            }
        }
    }
    call_user_func_array( array( 'Controller' . $resource, $method ), $params );
?>
