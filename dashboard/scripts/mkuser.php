<?php
    $settings = include 'settings.php';
    include 'models/db.php';
    include 'models/user.php';
    
    mb_internal_encoding( 'UTF-8' );

    fprintf( STDOUT, "First name: " );
    fscanf( STDIN, "%s\n", $firstname );

    fprintf( STDOUT, "Last name: " );
    fscanf( STDIN, "%s\n", $lastname );

    fprintf( STDOUT, "E-mail: " );
    fscanf( STDIN, "%s\n", $email );

    try {
        $userid = User::Create( $firstname, $lastname, $email );
        $user = User::Item( $userid );
        $hash = $user[ 'hash' ];
        echo "http://web-seminar.softlab.ntua.gr/dashboard/?userid=" . $userid . "&hash=" . $hash . "\n";
        $pass = crypt( $user[ 'ftppassword' ], 'ts' );
        echo 'useradd -g students -N -m -s /usr/bin/rssh -d /home/students/' . $user[ 'name' ] . " -p $pass $user[name];\n";
        echo "Created dashboard account.\n";
    }
    catch ( UserException $e ) {
        echo "Failed to create dashboard account. Duplicate email?\n";
    }
?>
