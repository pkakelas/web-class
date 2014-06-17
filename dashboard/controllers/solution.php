<?php
    class ControllerSolution {
        public static function View( $correctme, $offset = 0 ) {
            global $settings;

            if ( $correctme ) {
                clude( 'models/solution.php' );
                clude( 'models/validator/validator.php' );
                clude( 'models/cssvalidator/validator.php' );
                clude( 'models/solutionfile.php' );
                $solution = Solution::GetOneNew( $offset );
                $assignmentid = $solution[ 'assignmentid' ];
                $userid = $solution[ 'userid' ];
                $userfolder = SOLUTION_FILEBASE . '/' . $userid;
                $assignmentfolder = $userfolder . '/' . $assignmentid;
                $files = SolutionFile::Listing( $solution[ 'id' ] );
                foreach ( $files as $i => $file ) {
                    $filename = $file[ 'name' ];
                    $fullfile = $assignmentfolder . "/" . $filename;
                    switch ( strtolower( substr( $file[ 'name' ], -strlen( 'html' ) ) ) ) {
                        case 'html':
                        case '.htm':
                            // $files[ $i ][ 'validator' ] = Validator::HTML_Validate( $fullfile, 'file' );
                            if ( strpos( $fullfile, '/.' ) === false ) {
                                $files[ $i ][ 'source' ] = file( $fullfile, FILE_IGNORE_NEW_LINES );
                                $files[ $i ][ 'validator' ] = Validator::HTML_Validate( $settings[ 'base' ] . "/solutionfile/s" . $file[ 'solutionid' ] . "/" . $file[ 'name' ], 'url' );
                                $files[ $i ][ 'type' ] = 'html';
                            }
                            break;
                        case '.css':
                            if ( strpos( $fullfile, '/.' ) === false ) {
                                try {
                                    $files[ $i ][ 'validator' ] = CSSValidator::Validate( $settings[ 'base' ] . '/solutionfile/s' . $file[ 'solutionid' ] . '/' . $file[ 'name' ] );
                                    $files[ $i ][ 'validator' ][ 'pass' ] = false;
                                }
                                catch ( CSSValidatorException $e )  {
                                    $files[ $i ][ 'validator' ][ 'pass' ] = true;
                                }
                                $files[ $i ][ 'source' ] = file( $fullfile, FILE_IGNORE_NEW_LINES );
                                $files[ $i ][ 'type' ] = 'css';
                            }
                            break;
                    }
                }
                Template( 'solution/view', compact( 'solution', 'files', 'offset' ) );
            }
        }
        public static function Listing() {
            clude( 'models/solution.php' );
            clude( 'models/user.php' );
            $userid = $_SESSION[ 'user' ][ 'id' ];
            if ( User::IsAdmin( $userid ) ) {
                $data = Solution::Listing();
                $solutions = $data[ 'solutions' ];
                $newcount = $data[ 'newcount' ];
                $teacher = true;
            }
            else {
                $solutions = Solution::ListingByUser( $userid );
                $teacher = false;
                $newcount = 0;
            }
            Template( 'solution/listing', compact( 'solutions', 'teacher', 'newcount' ) );
        }
        public static function Update( $solutionid, $solutionids, $comments ) {
			clude( 'models/user.php' );
            ( isset( $_SESSION[ 'user' ] ) && User::IsAdmin( $_SESSION[ 'user' ][ 'id' ] ) ) or die( 'Permission denied' );

            clude( 'models/solution.php' );

            if ( is_array( $solutionids ) ) { // multiple corrections submitted
                $i = 0;
                foreach ( $solutionids as $solutionid ) {
                    $comment = $comments[ $i ];
                    Solution::UpdateComments( $solutionid, $comment );
                    ++$i;
                }
                Go( 'solution/listing' );
            }
            else {
                Solution::UpdateComments( $solutionid, $comments );
                Go( 'solution/correctme' );
            }
        }
    }
?>
