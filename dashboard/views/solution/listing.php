<?php
    Template( 'header', array( 'title' => 'Λίστα όλων των εργασιών' ) );

    if ( $teacher ) {
        ?>
            <h1>Όλες οι εργασίες</h1>
            Υπάρχουν <?php
            echo $newcount;
            ?> εργασίες προς διόρθωση.
            <a href="solution/correctme">Ώρα να διορθώσουμε</a>
            <form method="post" action="solution/update">
                <table>
                    <thead>
                        <tr>
                            <th>Εργασία</th>
                            <th>Μαθητής</th>
                            <th>Σχόλια</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ( $solutions as $solution ) {
                            ?><tr>
                                <td>
                                    <?php
                                    echo $solution[ 'assignmentid' ];
                                    ?>
                                    <input type="hidden" name="solutionids[]" value="<?= $solution[ 'id' ] ?>" />
                                </td> 
                                <td>
                                    <?php
                                    echo $solution[ 'username' ];
                                    ?>
                                </td>
                                <td>
                                    <textarea name="comments[]" cols="50" rows="10"><?= htmlspecialchars( $solution[ 'comments' ] ) ?></textarea>
                                </td>
                            </tr><?php
                        }
                        ?>
                    </tbody>
                </table>
                <input type="submit" value="Αποθήκευση" />
            </form>
        <?php
    }
    else {
        ?>Οι διορθώσεις των εργασιών θα αναρτηθούν σύντομα.<?php 
    }

    Template( 'footer' );
?>
