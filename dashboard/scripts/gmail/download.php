<?php
    $hostname = '{imap.gmail.com:993/imap/ssl}web-seminar';
    $username = 'petrosagg@gmail.com';

    printf( "Enter GMail password for " . $username . ": " );
    system( 'stty -echo' );
    $password = trim( fgets( STDIN ) );
    system( 'stty echo' );
    // add a new line since the users CR didn't echo
    echo "\n";

    if ( !function_exists( 'imap_open' ) ) {
        die( "PHP IMAP library is not installed. Please install the IMAP library for PHP and try again.\n" );
    }

    include 'mailhelper.php';
    $settings = include 'settings.php';
    include 'models/db.php';
    include 'models/user.php';
    include 'models/solution.php';
    include 'models/solutionfile.php';
    
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

    $inbox = imap_open( $hostname, $username, $password ) or die( 'Could not connect to GMail. ' . imap_last_error() . "\n" );

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
            // echo "First: $firstname\tLast: $lastname\tE-mail: $email\n";
            $attachment = false;
            $data = '';
            $filename = '';
            $user = User::ItemByEmail( $email );
            if ( $user === false ) {
                echo "No corresponding user found for " . $email . ". \n";
            }
            else {
                assert( is_array( $user ) );
                assert( isset( $user[ 'id' ] ) );
                $solutions = Solution::ListingByUser( $user[ 'id' ] ); 
                $solutionid = 0;
                if ( is_array( $solutions ) ) {
                    foreach ( $solutions as $solution ) {
                        if ( $solution[ 'assignmentid' ] == 1 ) {
                            $solutionid = $solution[ 'id' ];
                            break;
                        }
                    }
                }
                if ( $solutionid == 0 ) {
                    echo "No solutions submitted by user " . $email . ". \n";
                    continue;
                }
                assert( is_array( $mime ) );
                foreach ( $mime as $pid => $part ) {
                    assert( is_array( $part ) );
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
                        echo $email . "\n";
                        echo "Found attachment: " . $filename . "\n";
                        $unzipped = false;
                        if ( strtolower( substr( $filename, -4 ) ) == '.zip' ) {
                            echo "Extracting archive... \n";
                            $tmp = tempnam( "/tmp", "dashboard" );
                            file_put_contents( $tmp, $data );
                            $zip = zip_open( $tmp );
                            if ( is_resource( $zip ) ) {
                                while ( $zipentry = zip_read( $zip ) ) {
                                    $completePath = $zipDir . dirname( zip_entry_name( $zipentry ) );
                                    $completeName = $zipDir . zip_entry_name( $zipentry );
                                    if ( zip_entry_open( $zip, $zipentry, "r" ) ) {
                                        echo "Extracted file " . zip_entry_name( $zipentry ) . ". Uploading...\n";
                                        SolutionFile::Create(
                                            zip_entry_name( $zipentry ),
                                            zip_entry_read( $zipentry, zip_entry_filesize( $zipentry ) ),
                                            $solutionid
                                        );
                                        zip_entry_close( $zipentry );
                                    }
                                    else {
                                        SolutionFile::CreateFolder( zip_entry_name( $zipentry ), $solutionid );
                                    }
                                }
                                zip_close( $zip );
                                unlink( $tmp );
                                $unzipped = true;
                            }
                        }
                        if ( !$unzipped ) {
                            echo "Uploading...\n";
                            SolutionFile::Create( $filename, $data, $solutionid );
                        }
                    }
                }
            }
            /*
            ++$i;
            if ( $i > 10 ) {
                break;
            }
            */
        }
    }
    else {
        echo "No e-mail messages found.\n";
    }

    imap_close( $inbox );
?>
