<?php
    $test = $_GET[ 'run' ];
    if ( $test != "" ) {
        include 'tests/' . $test . '.php';
    }
?>