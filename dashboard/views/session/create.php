<?php
    Template( 'header', array( 'title' => 'Είσοδος' ) );
?>
            <h1>Σεμινάριο: Ανάπτυξη Web Εφαρμογών</h1>
            <form action="session/create" method="post">
                <?php
                if ( $wrong ) {
                    ?><p class="important">Τα στοιχεία που δώσατε δεν είναι σωστά. Παρακαλώ ξαναδοκιμάστε.</p><?php
                }
                ?>
                <p>Εισάγετε παρακάτω τα στοιχεία εισόδου για να αποκτήσετε πρόσβαση.</p>
                <div>
                    <label for="username">E-Mail ή Ψευδώνυμο</label>
                    <input type="text" value="" id="username" name="user" />
                </div>

                <div>
                    <label for="password">Κωδικός</label>
                    <input type="password" value="" id="password" name="password" />
                </div>
                <input type="submit" value="Σύνδεση" />
            </form>
<?php
    Template( 'footer' );
?>
