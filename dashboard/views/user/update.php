<?php
    Template( 'header', array( 'title' => 'Ορισμός κωδικού πρόσβασης' ) );
?>
            <h1>Σεμινάριο: Ανάπτυξη Web Εφαρμογών</h1>
            <p>Συγχαρητήρια για την παράδοση της 1ης εργασίας!</p>
            <form action="user/update" method="post">
                <p>Παρακαλούμε ορίστε έναν <strong>κωδικό πρόσβασης</strong>.</p>
                <p class="note">Ο κωδικός αυτός θα χρησιμοποιείται για να έχετε πρόσβαση στο <strong>ιστορικό των εργασιών σας</strong>.</p>
                <?php
                    if ( isset( $mismatch ) ) {
                        ?><p class="error">Οι δύο κωδικοί που πληκτρολογήσατε δεν συμφωνούν.</p><?php
                    }
                    if ( isset( $weak ) ) {
                        ?><p class="error">Ο κωδικός πρόσβασης θα πρέπει να έχει τουλάχιστον 5 γράμματα.</p><?php
                    }
                ?>
                <div>
                    <label for="password">Νέος κωδικός</label>
                    <input type="password" value="" id="password" name="password" />
                </div>

                <div>
                    <label for="password2">Νέος κωδικός (ξανά)</label>
                    <input type="password" value="" id="password2" name="password2" />
                </div>

                <input type="hidden" value="<?php
                echo htmlspecialchars( $userid );
                ?>" name="userid" />
                <input type="hidden" value="<?php
                echo htmlspecialchars( $hash );
                ?>" name="hash" />
                <input type="submit" value="Ορισμός κωδικού" />
            </form>
            <script type="text/javascript">
                document.getElementsByTagName( 'input' )[ 0 ].focus();
                document.getElementsByTagName( 'form' )[ 0 ].onsubmit = function () {
                    var passwords = document.getElementsByTagName( 'input' );

                    if ( passwords[ 0 ].value != passwords[ 1 ].value ) {
                        alert( 'Οι δύο κωδικοί δεν ταιριάζουν' );
                        passwords[ 0 ].value = '';
                        passwords[ 1 ].value = '';
                        passwords[ 0 ].focus();
                        return false;
                    }
                };
            </script>
<?php
    Template( 'footer' );
?>
