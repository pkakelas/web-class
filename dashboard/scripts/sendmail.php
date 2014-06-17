<?php
    die( 'This script has already done its job.' );

    function Email_FormatSubject( $subject ) {
        if ( preg_match( "#^[a-z0-9 _-]*+$#i", $subject ) ) {
            // trivial case: subject is simple ASCII with no control characters
            return $subject;
        }
        $subject = preg_replace( "#([^a-z ])#ie", 'sprintf( "=%02x", ord( "\\1" ) )', $subject );
        $subject = str_replace( ' ', '_', $subject );

        return "=?utf-8?Q?$subject?=";
    }

    $bodygeneric =
    "Καλημέρα!

Λάβαμε την λύση στην 1η εργασία σας και οι παρατηρήσεις και διορθώσεις θα είναι διαθέσιμες σύντομα.

Για την πρόσβαση στο ιστορικό των εργασιών καθώς και στις παρατηρήσεις, θα χρησιμοποιηθεί ο κωδικός που θα ορίσετε στο 
προσωπικό σας dashboard.
Αφού ορίσετε τον κωδικό αυτό, θα λάβετε και ένα FTP username καθώς και ένα FTP password (διαφορετικό από αυτό που θα
ορίσετε) το οποίο θα χρησιμοποιηθεί για την παράδοση της 2ης εργασίας.

Για να ορίσετε τον κωδικό σας, χρησιμοποιήστε τον παρακάτω σύνδεσμο:

%s

Ελπίζουμε να σας αρέσει το σεμινάριο μέχρι στιγμής, και να ανταποκριθούμε στις προσδοκίες σας και στο μέλλον!

Φιλικά,
Πέτρος και Διονύσης.";

    $subject = "[Ανάπτυξη Web Εφαρμογών] Οριμός κωδικού και FTP πρόσβαση";
    $subject = Email_FormatSubject( $subject );
    $fromemail = $replyto = 'web-seminar@softlab.ntua.gr';

    mysql_connect( 'web-seminar.softlab.ntua.gr', 'seminar', '3899aAa' );
    mysql_select_db( 'seminar' );
    $res = mysql_query( 'SELECT `user_id`, `user_email`, `user_hash` FROM `users`' );
    while( $row = mysql_fetch_array( $res ) ) {
        $email = $row[ 'user_email' ];
        $id    = $row[ 'user_id' ];
        $hash  = $row[ 'user_hash' ];
        $link = 'http://web-seminar.softlab.ntua.gr/dashboard/?userid=' . $id . '&hash=' . $hash;

        $body = sprintf( $bodygeneric, $link );
        echo "E-mailed " . $email . "\n";

        $headers = "From: $fromemail\r\n"
                 . "Reply-To: $replyto\r\n"
                 . "Content-type: text/plain; charset=utf-8";

        mail( $email, $subject, $body, $headers );
    }
?>
