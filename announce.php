            <?php
                global $settings;
                $settings = include 'dashboard/settings.php';
                include 'dashboard/models/db.php';
                include 'dashboard/models/announce.php';
                $res = Announce::Listing();
                krsort( $res )
            ?>
            <div id="announce">
                <h2>Ανακοινώσεις</h2>
                <ul>
                    <?php
                        foreach( $res as $key => $value ) {
                            if ( $res[ $key ][ 'view' ] == 1 ) {
                    ?>
                    <li>
                        <strong>
                            <?php echo $res[ $key ][ 'date' ]; ?>
                        </strong>
                        <?php echo $res[ $key ][ 'text' ]; ?>
                    </li>
                    <?php
                            }
                        }
                    ?>
                </ul>
            </div>
