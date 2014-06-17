<?php
    include 'header.php';
?>

        <div id="bibliography"<?php
            if ( isset( $include_guard ) ) {
                ?> style="display:none"<?php
            }
            ?>>
            <a href="index.php" class="back">Επιστροφή</a>
            <div class="readme">
                <h2>Βιβλιογραφία</h2>
                <p>
                    Καθώς το σεμινάριο αφορά διάφορους τομείς, προτείνουμε μία σειρά από 6 βιβλία.
                    Μερικά από αυτά είναι διαθέσιμα δωρεάν νόμιμα στο Internet από τους εκδότες τους,
                    ενώ για όλα μπορείτε να βρείτε παρόμοιο υλικό στην <a href="http://maps.google.com/maps/ms?ie=UTF8&amp;hl=en&amp;msa=0&amp;msid=102562938840589191672.00048a6eb5e8e26eb1264&amp;ll=37.978164,23.782214&amp;spn=0.0034,0.005466&amp;t=h&amp;z=18&amp;iwloc=000491b81cf8aa7010ca5">βιβλιοθήκη του ΕΜΠ</a>.
                    Αν θεωρήσετε ότι θα τα χρειαστείτε για αναφορά στο μέλλον, υπάρχουν διαθέσιμα
                    για online αγορά από το Amazon σε καλές τιμές, ή από τον Παπασωτηρίου σε λιγότερο καλές.
                </p>
                <p>
                    Τα βιβλία που προτείνουμε είναι τα εξής:
                </p>
                <ul>
                    <li>Patrick Griffiths, <a href="http://htmldog.com/">HTMLDog</a></li>
                    <li>DuBois, <a href="http://www.amazon.com/MySQL-Cookbook-Paul-DuBois/dp/059652708X">MySQL Cookbook</a></li>
                    <li>Trachtenberg, Sklar, <a href="http://www.amazon.com/PHP-Cookbook-Solutions-Examples-Programmers/dp/0596101015">PHP Cookbook</a></li>
                    <li>Welling, Thomson, <a href="http://www.amazon.com/PHP-MySQL-Web-Development-4th/dp/0672329166">PHP and MySQL Web Development</a></li>
                    <li>Peter-Paul Koch, <a href="http://quirksmode.org">ppk on Javascript</a></li>
                    <li><a href="http://svnbook.red-bean.com/en/1.5/index.html">Version Control with Subversion</a></li>
                </ul>
                <p>
                    Επίσης ως σημείο αναφοράς προτείνουμε τις ακόλουθες σελίδες:
                </p>
                <ul>
                    <li><a href="http://php.net/docs">Τεκμηρίωση της PHP</a></li>
                    <li><a href="http://dev.mysql.com">Τεκμηρίωση της MySQL</a></li>
                    <li><a href="http://developer.mozilla.org">Mozilla Developer Center</a></li>
                </ul>
            </div>
            
            <div class="bookcase">
                <h3><img src="images/bookcase.png" alt="Bookcase" id="bookcase" /></h3>
                <ul>
                    <li>
                        <a href="http://htmldog.com/" class="htmldog"><img src="images/htmldog.png" alt="HTMLDog" /></a>
                    </li>
                    <li>
                        <a href="http://www.amazon.com/MySQL-Cookbook-Paul-DuBois/dp/059652708X" class="mysqlcookbook"><img src="images/mysql-cookbook.png" alt="MySQL Cookbook" /></a>
                    </li>
                    <li>
                        <a href="http://www.amazon.com/PHP-Cookbook-Solutions-Examples-Programmers/dp/0596101015" class="phpcookbook"><img src="images/php-cookbook.png" alt="PHP Cookbook" /></a>
                    </li>
                    <li>
                        <a href="http://www.amazon.com/PHP-MySQL-Web-Development-4th/dp/0672329166" class="phpmysql"><img src="images/php-mysql.png" alt="PHP and MySQL Web Development" /></a>
                    </li>
                    <li>
                        <a href="http://quirksmode.org" class="ppk"><img src="images/ppk.png" alt="ppk on Javascript" /></a>
                    </li>
                    <li>
                        <a href="http://svnbook.red-bean.com/en/1.5/index.html" class="svn"><img src="images/subversion.png" alt="Version Control with Subversion" /></a>
                    </li>
                </ul>
            </div>
        </div>
<?php
    include 'footer.php';
?>
