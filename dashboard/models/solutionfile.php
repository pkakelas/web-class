<?php
    define( 'SOLUTION_FILEBASE', '/home/dashboard/uploads' );

    class SolutionFile {
        public static function Create( $filename, $filedata, $solutionid ) {
            $solution = Solution::Item( $solutionid );
            assert( is_array( $solution ) );
            assert( isset( $solution[ 'assignmentid' ] ) );
            assert( is_numeric( $solution[ 'assignmentid' ] ) );
            $assignmentid = $solution[ 'assignmentid' ];
            assert( isset( $solution[ 'userid' ] ) );
            assert( is_numeric( $solution[ 'userid' ] ) );
            $userid = $solution[ 'userid' ];
            $userfolder = SOLUTION_FILEBASE . '/' . $userid;
            $assignmentfolder = $userfolder . '/' . $assignmentid;
            $fullfile = $assignmentfolder . "/" . $filename;
            $fulldir = dirname( $fullfile );
            if ( !file_exists( $fulldir ) ) {
                // uploads/userid/assignmentid/custom/subfolders/of/any/kind/file.css
                if ( strpos( $fullfile, '..' ) !== false ) {
                    // getting outside of allowed path?
                    throw new SolutionException( 'Could not write to path. Permission denied.' );
                }
                mkdir( $fulldir, 0755, true );
            }
            file_put_contents( $fullfile, $filedata );
            chmod( $fullfile, 0644 );
            db(
                'INSERT INTO
                    `solutionfiles`
                SET
                    `file_solutionid`=:solutionid,
                    `file_name`=:filename'
                , compact( 'solutionid', 'filename' )
            );
        }
        public static function Listing( $solutionid ) {
            $res = db( 'SELECT `file_solutionid` AS solutionid, `file_name` AS name, `file_id` AS id FROM `solutionfiles` WHERE `file_solutionid` = :solutionid LIMIT 20;', compact( 'solutionid' ) );
            $files = array();
            while ( $row = mysql_fetch_array( $res ) ) {
                $files[] = $row;
            }
            return $files;
        }
        public static function ItemById( $id ) {
            $res = db( 
                'SELECT
                    `file_solutionid` AS solutionid,
                    `file_name` AS name,
                    `file_id` AS id,
                    `solution_assignmentid` AS assignmentid,
                    `solution_userid` AS userid
                FROM
                    `solutionfiles`
                    LEFT JOIN `solutions` ON
                        `file_solutionid` = `solution_id`
                WHERE
                    `file_id` = :id
                LIMIT 1;', compact( 'id' )
            );
            $file = mysql_fetch_array( $res );
            $userid = $file[ 'userid' ];
            $assignmentid = $file[ 'assignmentid' ];
            $userfolder = SOLUTION_FILEBASE . '/' . $userid;
            $assignmentfolder = $userfolder . '/' . $assignmentid;
            $fullfile = $assignmentfolder . "/" . $file[ 'name' ];
            $file[ 'contents' ] = file_get_contents( $fullfile );
            return $file;
        }
    }
?>
