<?php
    class SolutionException extends Exception {};

    class Solution {
        public static function UpdateComments( $solutionid, $comments ) {
            db( 'UPDATE
                    `solutions`
                 SET
                    `solution_comments` = :comments
                 WHERE
                    `solution_id` = :solutionid', compact( 'comments', 'solutionid' ) );
        }

        public static function GetOneNew( $offset = 0 ) {
            $offset = ( int )$offset;

            return mysql_fetch_array(
                db(
                    'SELECT
                        `solution_id` AS id, `solution_userid` AS userid,
                        `solution_assignmentid` AS assignmentid, `solution_comments` AS comments,
                        `user_name` AS username, `user_email` AS email, `user_firstname` AS firstname, `user_lastname` AS lastname
                    FROM
                        `solutions` CROSS JOIN `users`
                            ON `solution_userid` = `user_id`
                    WHERE
                        `solution_comments` = ""
                    LIMIT :offset, 1', compact( 'offset' )
                )
            );
        }

        public static function ListingByUser( $userid ) {
            $res = db( 
                'SELECT 
                    `solution_id` AS id, `solution_userid` AS userid,
                    `solution_assignmentid` AS assignmentid, `solution_comments` AS comments
                FROM
                    `solutions`
                WHERE
                    `solution_userid` = :userid
                ORDER BY
                    assignmentid ASC',
                compact( 'userid' )
            );
            while ( $row = mysql_fetch_array( $res ) ){
                $usersolutions[ $row[ 'id' ] ] = $row;
            }
            return $usersolutions;
        }

        public static function ListingByAssignmentId( $assignmentid ) {
            return db_array( 
                'SELECT 
                    `solution_id` AS id, `solution_userid` AS userid,
                    `solution_assignmentid` AS assignmentid, `solution_comments` AS comments
                FROM
                    `solutions`
                WHERE
                    `solution_assignmentid` = :assignmentid',
                compact( 'assignmentid' )
            );
        }
        
        public static function Item( $solutionid ) {
            $res = db(
                'SELECT
                    `solution_id` AS id, `solution_userid` AS userid,
                    `solution_assignmentid` AS assignmentid, `solution_comments` AS comments
                FROM
                    `solutions` 
                WHERE
                    `solution_id` = :solutionid
                LIMIT 1',
                compact( 'solutionid' )
            );
            return mysql_fetch_array( $res );
        }
        
        public static function Create( $userid, $assignmentid ) {
            db(
                'INSERT INTO `solutions`
                    ( `solution_userid`, `solution_assignmentid` ) 
                VALUES
                    ( :userid, :assignmentid )',
                compact( 'userid', 'assignmentid' )
            );
            return mysql_insert_id();
        }
        
        public static function Listing() {
            $rows = db_array( 
                'SELECT 
                    `solution_id` AS id, `solution_userid` AS userid, `solution_new` AS new,
                    `solution_assignmentid` AS assignmentid, `solution_comments` AS comments,
                    `user_name` AS username
                FROM
                    `solutions` CROSS JOIN `users`
                        ON `solution_userid` = `user_id`
                ORDER BY
                    `solution_new` DESC'
            );
            $newcount = 0;
            foreach ( $rows as $row ) {
                if ( $row[ 'comments' ] == '' ) {
                    ++$newcount;
                }
            }
            return array( 'solutions' => $rows, 'newcount' => $newcount );
        }

        public static function ListingByStatus() {
            return db_array( 
                'SELECT 
                    `solution_id` AS id, `solution_userid` AS userid,
                    `solution_assignmentid` AS assignmentid, `solution_comments` AS comments
                FROM
                    `solutions`
                WHERE
                    `solution_new` = 1'
            );
        }
            
    }
?>
