<?php

//kubbtour-ranking

//hole die Turnier-ID aus dem custom field
//$key_1_value = get_post_meta( get_the_ID(), 'kubbtourID', true );

//kreiere Turnier-ID aus Keyword
$posttags = get_the_tags();
foreach($posttags as $posttag){
    $turnierslug = $posttag->slug;
    
}
if($turnierslug == "fisikubbopen"){
    $turnier_id = 22;
}
if($turnierslug == "fribourgerkubbm3eting"){
    $turnier_id = 28;
}
if($turnierslug == "gruyere"){
    $turnier_id = 17;
}
if($turnierslug == "kcuacup"){
    $turnier_id = 20;
}
if($turnierslug == "kubbitup"){
    $turnier_id = 8;
}
if($turnierslug == "kubbmaister"){
    $turnier_id = 2;
}
if($turnierslug == "kubbmastersbern"){
    $turnier_id = 7;
}
if($turnierslug == "masters"){
    $namensaenderung = mysql2date("Y", $post->post_date_gmt);
    if($namensaenderung < 2015) {
        $turnier_id = 13;
    }
    else{
        $turnier_id = 27;
    }
}
if($turnierslug == "mighty"){
    $turnier_id = 11;
}
if($turnierslug == "schweizermeisterschaft"){
    $turnier_id = 16;
}
if($turnierslug == "spryssecup"){
    $turnier_id = 6;
}
if($turnierslug == "stauseederby"){
    $turnier_id = 30;
}
if($turnierslug == "sureshot"){
    $turnier_id = 9;
}
if($turnierslug == "tenedo"){
    $turnier_id = 10;
}
if($turnierslug == "trinamo"){
    $turnier_id = 12;
}


if($turnier_id) {
    //hole resultate von kubbtour.ch
    $post_year = mysql2date("Y", $post->post_date_gmt);
    $kubbtour_url = "http://kubbtour.ch/inc_content/api_rank2.php?data=turnier&turnier_id=" . $turnier_id . "&year=" . $post_year . "&view=json";

    $json_data = file_get_contents($kubbtour_url);

    if(strlen($json_data) > 100) {
        $json_data = json_decode(substr($json_data, 1, -3), true);

        $index = 0;
        $index_anzeigen = 1;
        $punkte_zuvor = 0;

        echo "<h3>Rangliste</h3><table>";
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

$the_query = new WP_Query( 'tag='.$turnierslug );
$index_archiv = 1;
while ( $the_query->have_posts() ) : $the_query->the_post();
    if($index_archiv == 2){
        echo "<h3>Archiv: ".ucfirst($turnierslug)."</h3>";
    }
    if($index_archiv > 1) {
        get_template_part('template-parts/content_teasersmall');

    }
    $index_archiv++;
endwhile;
wp_reset_postdata();


?>

