<html>
    <head>
        <title><?php
            if ( !empty( $title ) ) {
                echo $title;
                ?> - <?php
            }
            ?>Ανάπτυξη Web Εφαρμογών<?php
        ?></title>
        <base href="<?php
            global $settings;

            echo $settings[ 'base' ];
        ?>/" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" href="css/style.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery.js"></script>
    </head>
    <body>
        <div class="universe">
