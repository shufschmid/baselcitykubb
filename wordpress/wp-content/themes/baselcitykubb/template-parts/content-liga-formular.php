<?php
if ( is_user_logged_in() ) {
    ?>
    <h3>Resultat melden</h3>
    <form style="text-align:center" method="post" action="/liga/" >
        <select name="spieler1" size="1" style="width:100px">

            <?php
            get_currentuserinfo();
            $neu = get_users();
            echo "<option value=\"".$current_user->id."\" selected=\"selected\">".$current_user->user_nicename."</option>";

            foreach ($neu as $spieler) {
                echo "<option value=\"".$spieler->ID."\">   ".$spieler->user_nicename."</option>";
            }

            ?>
        </select> <select name="spieler2" size="1" style="width:100px">

            <?php
            foreach ($neu as $spieler) {
                echo "<option value=\"".$spieler->ID."\">   ".$spieler->user_nicename."</option>";
            }
            ?>

        </select><br/>

        <input style="width:30px" type="number" name="resultat1"> : <input style="width:30px" type="number" name="resultat2">
        <br/><br/><input type="submit" name="submit" value="Resultat melden">
        <hr/></form>

<?php
}
else {
    echo"<h3>Anmelden</h3>";
    wp_login_form();
}?>