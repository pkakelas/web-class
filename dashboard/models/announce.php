<?php
    class Announce {
        public static function Update( $announceid, $view, $text = false ) {
            $set[] = "`announce_view` = :view";
            if ( $text !== false ) {
                $set[] = "`announce_text` = :text";
            }
            db( "UPDATE
                    `announcements`
                SET
                    " . implode( ",", $set ) . "
                WHERE
                    `announce_id` = :announceid",
                compact( 'text', 'view', 'announceid' )
            );
        }
        public static function Add( $text, $view = 1 ) {
            db( 'INSERT INTO `announcements`
                    ( `announce_text`, `announce_date`, `announce_view` )
                VALUES
                    ( :text, NOW(), :view )',
                compact( 'text', 'view' )
            );
        }
        
        public static function Listing() {
            $res = db( 'SELECT 
                            `announce_id` AS id, `announce_text` AS text, `announce_date` AS date,
                            `announce_view` AS view
                        FROM
                            `announcements`
                    ');
            while ( $row = mysql_fetch_array( $res ) ) {
                $row1[ $row[ 'id' ] ] = $row;
            }
            return $row1;
        }
        public static function Edit( $text, $date, $view ) {
            db( 'UPDATE `announcements`
                SET 
                    `announce_text` = :text,
                    `announce_date` = :date,
                    `announce_view` = :view',
                compact( 'text', 'date', 'view' )
            );
        }
        public static function Delete( $id ) {
            db( 'DELETE 
                FROM
                    `announcements`
                WHERE
                    `announce_id` = :id
                LIMIT 1',
                compact( 'id' )
            );
        }
    }
?>
