<?php
    $hostname = '{imap.gmail.com:993/imap/ssl}Web Seminar';
    $username = 'dionyziz@gmail.com';
    $password = 'Mortadela--Papardela';

    if ( !function_exists( 'imap_open' ) ) {
        die( "PHP IMAP library is not installed. Please install the IMAP library for PHP and try again.\n" );
    }

    include 'mailhelper.php';
    $settings = include 'settings.php';
    include 'models/db.php';
    include 'models/user.php';
    
    function mb_ucfirst( $str ) {
        return mb_strtoupper( mb_substr( $str, 0, 1 ) ) . mb_substr( $str, 1 );
    }
    function fix_sigma( $str ) {
        if ( mb_substr( $str, -1 ) == 'σ' ) {
            $str = mb_substr( $str, 0, -1 ) . 'ς';
        }
        return $str;
    }

    mb_internal_encoding( 'UTF-8' );

    $inbox = imap_open( $hostname, $username, $password ) or die( 'Could not connect to GMail. ' . imap_last_error() );   

    $emails = imap_search( $inbox, 'ALL' );

    if ( is_array( $emails ) && count( $emails ) ) {
        rsort( $emails );
        echo count( $emails ) . ' email';
        if ( count( $emails ) != 1 ) {
            echo 's';
        }
        echo " loaded.\n";

        $i = 0;
        foreach ( $emails as $mid ) {
            $overview = imap_fetch_overview( $inbox, $mid, 0 );
            $from = imap_utf8( $overview[ 0 ]->from );
            $parts = explode( ' ', $from );
            $firstname = $parts[ 0 ];
            $lastname = $parts[ 1 ];
            $parts = explode( '<', $from );
            $parts = explode( '>', $parts[ 1 ] );
            $email = strtolower( $parts[ 0 ] );
            if ( empty( $email ) ) {
                $email = strtolower( $from ); // no name specified
                $firstname = '';
                $lastname = '';
            }
            if ( strpos( $firstname, '<' ) !== false ) {
                $firstname = '';
            }
            if ( strpos( $lastname, '<' ) !== false ) {
                $lastname = '';
            }
            $mime = mail_mime_to_array( $inbox, $mid );
            $numparts = count( $mime );
            $firstname = fix_sigma( mb_ucfirst( mb_strtolower( $firstname ) ) );
            $lastname = fix_sigma( mb_ucfirst( mb_strtolower( $lastname ) ) );
            echo "First: $firstname\tLast: $lastname\tE-mail: $email\n";
            $attachment = false;
            $data = '';
            $filename = '';
            foreach ( $mime as $pid => $part ) {
                foreach ( $part as $attribute => $value ) {
                    switch ( $attribute ) {
                        case 'is_attachment':
                            $attachment = true;
                            break;
                        case 'filename':
                            $filename = $value;
                            $filename = mb_strtolower( imap_utf8( $filename ) );
                            break;
                        case 'data':
                            $data = $value;
                            break;
                    }
                }
                if ( $attachment && $data != '' && $filename != '' ) {
                    echo "Found attachment: " . $filename . "\n";
                }
            }
            if ( $attachment ) {
                echo "Found attachment. ";
                try {
                    User::Create( "", "", $email );
                    echo "Created dashboard account.\n";
                }
                catch ( UserException $e ) {
                    echo "Failed to create dashboard account. Duplicate email?\n";
                }
            }
            /* 
            ++$i;
            if ( $i > 10 ) {
                die();
            }
            echo "\n";
            */
        }
    }
    else {
        echo "No e-mail messages found.\n";
    }

    imap_close( $inbox );
?>
