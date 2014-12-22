<?php
    include 'header.php';
    $include_guard = true;
?>
        <?php
            include 'bibliography.php';
        ?>
        <div id="everything">
            <ul id="navigation">
                <li><a href="bibliography.php" class="bibliography" onclick="return false;">Βιβλιογραφία</a></li>
                <li><a href="lectures.php" class="lectures" onclick="return false;">Διαλέξεις</a></li>
                <li><a href="assignments.php">Εργασίες</a></li>
                <li><a href="legal.php" class="legal" id="legal">Οργανωτικά</a></li>
            </ul>
            <h1>Ανάπτυξη Web Εφαρμογών</h1>
            <p>Ένα σεμινάριο στις σύγχρονες εφαρμοσμένες τεχνικές ανάπτυξης μεγάλων εφαρμογών στο σημερινό ιστό.</p>
        </div>
        <div id="cloudcontainer">
            <a href="legal.php" class="legal" id="cloud" title="Τυπικά θέματα που αφορούν το σεμινάριο"></a>
        </div>
        <ul class="toolbox">
            <li class='facebook icon'><a href="http://www.facebook.com/group.php?gid=151549198213806" title="Ομάδα Facebook του σεμιναρίου"><img src="images/face.png" alt="Facebook" /></a></li>
            <li class='forum icon'><a href="http://shmmy.ntua.gr/forum/viewtopic.php?f=5&amp;t=13242" title="Συζήτηση σχετικά με το σεμινάριο"><img src="images/cloud.png" alt="Forum" /></a></li>
        </ul>
        <?php
            include 'lectures.php';
        ?>
        <div id="sea">
            <canvas width="600" height="200"></canvas>
        </div>
        <script type="text/javascript" src="js/wave.js?3"></script>
        <script type="text/javascript" src="js/navigation.js?5"></script>
        <script type="text/javascript" src="js/cloud.js?4"></script>
<?php
    include 'legal.php';
    
    unset( $include_guard );
    include 'footer.php';
?>
