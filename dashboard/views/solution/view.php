<?php
    Template( 'header' );
?>
<ul class="correctmemenu">
    <li><a class="next" href="solution/correctme?offset=<?= $offset + 1 ?>"></a></li> 
    <?php
    if ( $offset >= 1 ) {
        ?><li><a class="prev" href="solution/correctme?offset=<?= $offset - 1 ?>"></a></li><?php
    }
    ?>
</ul>
Λύση <?php
    echo $solution[ 'assignmentid' ];
?>ης εργασίας από <?php
    echo $solution[ 'username' ];
?>.<br /><ul><?

foreach ( $files as $file ):
    ?><li><a href="solutionfile/s<?= $file[ 'solutionid' ] ?>/<?= $file[ 'name' ] ?>"><?= $file[ 'name' ]; ?></a>
    <?php
    if ( isset( $file[ 'validator' ] ) ) {
        if ( $file[ 'validator' ][ 'pass' ] ) {
            if ( $file[ 'type' ] == 'html' ) {
                ?> <span class="validates">Έγκυρο HTML</span><?php
            }
            else {
                ?> <span class="validates">Έγκυρο CSS</span><?php
            }
        }
        else {
            ?> <span class="validatesnot"><?php
            echo count( $file[ 'validator' ][ 'errors' ] );
            if ( count( $file[ 'validator' ][ 'errors' ] ) == 1 ) {
                ?> σφάλμα εγκυρότητας<?php
            }
            else {
                ?> σφάλματα εγκυρότητας<?php
            }
            ?> </span><?php
        }
        Template( 'validator', compact( 'file' ) );
    }
    else if ( isset( $file[ 'source' ] ) ) {
        Template( 'validator', compact( 'file' ) );
    }
    ?>
    </li><?php
endforeach;

?></ul>

<form action="solution/update" method="post">
    <input type="hidden" name="solutionid" value="<?= $solution[ 'id' ] ?>" /> 
    <textarea name="comments" cols="50" rows="20"></textarea>
    <input type="submit" value="Αποθήκευση" />
</form>
<?php
    Template( 'footer' );
?>
