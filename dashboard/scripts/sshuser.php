<?php
    $settings = include 'settings.php';
    include 'models/db.php';
    include 'models/user.php';
    
    mb_internal_encoding( 'UTF-8' );

    fprintf( STDOUT, "Username: " );
    fscanf( STDIN, "%s\n", $username );

    $user = User::ItemByName( $username );
    if ( $user === false ) {
        die( "No such user.\n" );
    }
    $pass = crypt( $user[ 'ftppassword' ], 'ts' );
    echo 'useradd -g students -N -m -s /usr/bin/rssh -d /home/students/' . $user[ 'name' ] . " -p $pass $user[name];\n";
?>

