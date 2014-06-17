<?php
    Template( 'header', array( 'title' => 'Dashboard' ) );
?>

    <p>
    Για την παράδοση της <strong>2ης εργασίας</strong> θα χρειαστείτε τα ακόλουθα στοιχεία:
    </p>

    <div class="box">
        FTP Username: <?= $username ?><br />
        FTP Password: <?= $ftppassword ?><br />
        FTP Server: web-seminar.softlab.ntua.gr
    </div>

<?php
    Template( 'footer' );
?>
