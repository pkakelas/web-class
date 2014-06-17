<?php
    Template( 'header', array( 'title' => 'Ανακοινώσεις' ) );
?>
    <h1>
    Ανακοινώσεις:
    </h1>

    <form action="" method="post">
        <table class="announce">
            <tr>
                <th>
                Κείμενο
                </th>
                <th>
                Ημερομηνία
                </th>
                <th>
                Εμφάνιση
                </th>
                <th>
                Διαγραφή
                </th>
            </tr>
            <?php
                krsort( $res );
                foreach ( $res as $key => $value ) {
                    $id = $res[ $key ][ 'id' ];
                    $text = $res[ $key ][ 'text' ];
                    $date = $res[ $key ][ 'date' ];
                    $view = $res[ $key ][ 'view' ];
                    ?><tr>
                    <td id="i_<?= $id ?>"><span><?= $text ?></span></td>
                    <td><?= $date ?></td>
                    <td>
                    <input type="checkbox"
                    <?php
                    if ( $view ) {
                        ?> checked="checked" <?php
                    }
                    ?> /></td><td><img src="images/delete-icon.png" alt="delete" class="delete_announce" id="<?= $id ?>"/></tr><?php
                }
            ?>
        </table>
        <h2>Προσθήκη ανακοίνωσης</h2>
        <input type="text" name="text" id="subm_text"/>
        <input type="submit" value="Προσθήκη"/>
    </form>

    <script src="js/announce.js"></script>
<?php
    Template( 'footer' );
?>
