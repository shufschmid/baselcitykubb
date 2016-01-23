<?php

//kubbtour-ranking

//hole die Turnier-ID aus dem custom field
$key_1_value = get_post_meta( get_the_ID(), 'kubbtourID', true );
if($key_1_value) {
    //hole resultate von kubbtour.ch
    $post_year = mysql2date("Y", $post->post_date_gmt);
    $kubbtour_url = "http://kubbtour.ch/inc_content/api_rank2.php?data=turnier&turnier_id=" . $key_1_value . "&year=" . $post_year . "&view=json";

    $json_data = file_get_contents($kubbtour_url);

    if(strlen($json_data) > 100) {
        $json_data = json_decode(substr($json_data, 1, -3), true);

        $index = 0;
        $index_anzeigen = 1;
        $punkte_zuvor = 0;

        echo "<h4>Rangliste</h4><table>";
        foreach ($json_data["results"] as $data) {
            $index++;
            if ($data["points"] < $punkte_zuvor) {
                $index_anzeigen = $index;
            }
            $punkte_zuvor = $data["points"];

            echo "<tr><td class=\"ranking_cell\">" . $index_anzeigen . ".</td><td class=\"ranking_cell\">" . $data["teamname"] . "</td></tr>";

        }
        ?>
        <tr>
            <td class="ranking_cell" colspan="3">powered by <a href="http://www.kubbtour.ch/">kubbtour.ch</a></td>
        </tr>
        </table>
    <?php
    }

}
//zeige "#kubblive"-Widget an, wenn Post nicht älter als fünf Tage
$post_age = (date('U') - get_post_time('U'))/60;
if($post_age < 7200){
    ?>

    <a class="twitter-timeline" href="https://twitter.com/hashtag/kubblive" data-widget-id="685860130982871041">#kubblive-Tweets</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php
}

//baselcitykubb-archiv

//hole Bezeichnung des Turniers aus dem Beitrag
$posttags = get_the_tags();

$the_query = new WP_Query( 'tag='.$posttags[0]->name );
$index_archiv = 1;
while ( $the_query->have_posts() ) : $the_query->the_post();
    if($index_archiv == 1){
        echo "<h4>".$posttags[0]->name."-Turnierberichte aus dem Archiv:</h4>";
    }
    get_template_part('template-parts/content_teasersmall');
    $index_archiv++;
endwhile;
wp_reset_postdata();


?>

