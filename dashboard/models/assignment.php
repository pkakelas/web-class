<?php
    class Assignment {
        public static function Listing() {
            $assignments = array();
            $res = db(
                'SELECT 
                    `assignment_id` AS id, `assignment_title` AS title,
                    `assignment_text` AS text,
                    `assignment_announced` AS announced, `assignment_due` AS due
                FROM
                    `assignments`'
            );
            while ( $row = mysql_fetch_array( $res ) ) {
                $assignments[ $row[ 'id' ] ] = $row;
            }
            return $assignments;
        }
        public static function Item( $assignmentid ) {
            $res = db(
                'SELECT
                    `assignment_id` AS id, `assignment_title` AS title,
                    `assignment_text` AS text,
                    `assignment_announced` AS announced, `assignment_due` AS due
                FROM
                    `assignments`
                WHERE 
                    `assignment_id` = :assignmentid
                LIMIT 1',
                compact( 'assignmentid' )
            );
            return mysql_fetch_array( $res );
        }
    }
?>
