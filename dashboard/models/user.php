<?php
    class UserException extends Exception {
    }

    class User {
        public static function ItemByName( $name ) {
            $name = ( string )$name;
            if ( $name == "" ) {
                return false;   
            }
            $res = db(
                'SELECT
                    `user_id` AS id, `user_email` AS email,
                    `user_name` AS name, `user_firstname` AS firstname, `user_lastname` AS lastname,
                    `user_email` AS mail, `user_ftppassword` AS ftppassword
                FROM
                    `users`
                WHERE
                    `user_name` = :name
                    OR
                    `user_email` = :name
                LIMIT 1;', compact( 'name' )
            );
            return mysql_fetch_array( $res );
        }


        public function IsAdmin( $userid ) {
            $row = User::Item( $userid );
            return $row[ 'permissions' ] > 0;
        }

        public static function Item( $userid ) {
            $res = db(
                'SELECT
                    `user_id` AS id, `user_name` AS name, `user_firstname` AS firstname, `user_lastname` AS lastname,
                    `user_email` AS mail, `user_ftppassword` AS ftppassword, `user_hash` AS hash,
                    `user_permissions` AS permissions
                FROM
                    `users`
                WHERE
                    `user_id` = :userid
                LIMIT 1;', compact( 'userid' )
            );
            return mysql_fetch_array( $res );
        }
        public static function Login( $email, $password ) {
            if ( !$email || !$password ) {
                return false;
            }
            $res = db(
                'SELECT
                    `user_id` AS id, `user_email` AS email,
                    `user_name` AS name, `user_ftppassword` AS ftppassword,
                    `user_authtoken` AS authtoken,
                    `user_firstname` AS firstname, `user_lastname` AS lastname,
                    ( `user_permissions` > 0 ) AS admin
                FROM
                    `users`
                WHERE
                    ( `user_email` = :email
                    OR LEFT(`user_email`, LOCATE("@", `user_email`)) = :email )
                    AND `user_password` = MD5( :password )
                LIMIT 1',
                compact( 'email', 'password' )
            );
            if ( mysql_num_rows( $res ) ) {
                $row = mysql_fetch_array( $res );
                $row[ 'id' ] = ( int )$row[ 'id' ];
                return $row;
            }
            return false;
        }
        public static function RenewAuthtoken( $userid ) {
            $userid = ( int )$userid;

            // generate authtoken
            // first generate 16 random bytes
            // generate 8 pseurandom 2-byte sequences 
            // (that's bad but generally conventional pseudorandom generation algorithms do not allow very high limits
            // unless they repeatedly generate random numbers, so we'll have to go this way)
            $bytes = array(); // the array of all our 16 bytes
            for ( $i = 0; $i < 8 ; ++$i ) {
                $bytesequence = rand( 0, 65535 ); // generate a 2-bytes sequence
                // split the two bytes
                // lower-order byte
                $a = $bytesequence & 255; // a will be 0...255
                // higher-order byte
                $b = $bytesequence >> 8; // b will also be 0...255
                // append the bytes
                $bytes[] = $a;
                $bytes[] = $b;
            }
            // now that we have 16 "random" bytes, create a string of 32 characters,
            // each of which will be a hex digit 0...f
            $authtoken = ''; // start with an empty string
            foreach ( $bytes as $byte ) {
                // each byte is two authtoken digits
                // split them up
                $first = $byte & 15; // this will be 0...15
                $second = $byte >> 4; // this will be 0...15 again
                // convert decimal to hex and append
                // order doesn't really matter, it's all random after all
                $authtoken .= dechex( $first ) . dechex( $second );
            }
            
            clude( 'models/db.php' );
            db(
                'UPDATE
                    `users`
                SET
                    `user_authtoken`=:authtoken
                WHERE
                    `user_id`=:userid
                LIMIT 1', compact( 'userid', 'authtoken' )
            );

            return $authtoken;
        }
        public static function ClearAuthtoken( $userid ) {
            $userid = ( int )$userid;
            
            clude( 'models/db.php' );
            $authtoken = '';
            
            db(
                'UPDATE
                    `users`
                SET
                    `user_authtoken`=:authtoken
                WHERE
                    `user_id`=:userid
                LIMIT 1', compact( 'userid', 'authtoken' )
            );
            
            return true;
        }

        public static function SetPassword( $id, $password ) {
            db(
                'UPDATE 
                    `users` 
                SET 
                    `user_password` = MD5( :password )
                WHERE
                    `user_id` = :id
                LIMIT 1', compact( 'id', 'password' )
            );
        }
        
        public static function HashValid( $id, $hash ) {
            $res = db(
                'SELECT
                    `user_hash` FROM `users`
                WHERE
                    `user_id` = :id
                    AND `user_hash`= :hash
                LIMIT 1', compact( 'id', 'hash' ) );
            return mysql_num_rows( $res ) == 1;
        }

        public static function GenerateHash( $length ) {
           $bytes = array(); // the array of all our 15 bytes
            for ( $i = 0; $i < $length ; ++$i ) {
                $bytesequence = rand( 0, 65535 ); // generate a 2-bytes sequence
                // split the two bytes
                // lower-order byte
                $a = $bytesequence & 255; // a will be 0...255
                // higher-order byte
                $b = $bytesequence >> 8; // b will also be 0...255
                // append the bytes
                $bytes[] = $a;
                $bytes[] = $b;
            }
            // now that we have 16 "random" bytes, create a string of 32 characters,
            // each of which will be a hex digit 0...f
            $authtoken = ''; // start with an empty string
            foreach ( $bytes as $byte ) {
                // each byte is two authtoken digits
                // split them up
                $first = $byte & 15; // this will be 0...15
                $second = $byte >> 4; // this will be 0...15 again
                // convert decimal to hex and append
                // order doesn't really matter, it's all random after all
                $authtoken .= dechex ( $first ) . dechex ( $second );
            }
            return $authtoken;
        }
        
        public static function CreateFTPHome( $userid ) {
            $getid = db(
                'SELECT 
                    `user_name`, `user_ftppassword`
                FROM
                    `users`
                WHERE 
                    `user_id` = :userid
                LIMIT 1 ',
                compact( 'userid' )
            );
            $res = mysql_fetch_array( $getid );
            $dir = "/home/ftp/" . $res[ 'user_name' ];
            mkdir( $dir, 0755 );
            chown( $dir, 'ftp' );
            chgrp( $dir, 'www-data' );
            exec( "htpasswd -b /etc/vsftpd_pwdfile " . $res[ 'user_name' ] . " " . $res[ 'user_ftppassword' ] );
        }
        
        public static function Create( $firstname, $lastname, $email ) {
            $hash = User::GenerateHash( 8 );
            $ftppassword = User::GenerateHash( 2 );
            $username = explode( "@", $email );
            $username = $username[ 0 ];
            
            try { 
                db( 'INSERT INTO `users`
                        ( `user_firstname`, `user_lastname`, `user_email`, `user_name`, `user_hash`, `user_ftppassword` )
                    VALUES ( :firstname, :lastname, :email, :username, :hash, :ftppassword )',
                    compact( 'firstname', 'lastname', 'email', 'hash', 'ftppassword', 'username' ) );
            }
            catch ( DBException $e ) {
                throw New UserException( "User creation failed: Duplicate e-mail" );
            }

            User::CreateFTPHome( mysql_insert_id() ); 
            
            return mysql_insert_id();
        }
        
        public static function ItemByEmail( $email ) {
            return mysql_fetch_array(
                db(
                    'SELECT
                        `user_id` AS id,
                        `user_name` AS name,
                        `user_hash` AS hash
                    FROM
                        `users`
                    WHERE
                        `user_email` = :email
                    LIMIT 1',
                    compact( 'email' )
                )
            );
        }
    }
?>
