<?php

/**
 * Template-File für die Kubb-Statistiken.
 * Template Name: stats
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package baselcitykubb
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main" style="margin-top:24px;">
        <h1>Kubb-Statistiken</h1>

        <?php
        //Team-IDs laden von kubbtour.ch
        $json_data = file_get_contents("http://kubbtour.ch/inc_content/api_rank2.php?data=tour&year=0&view=json");
        $stats_teamIDs = json_decode(substr($json_data,1,-3), true);

        //array-erstellen [id]-->Teamname (alle mit mehr als 9 punkten auf der aktuellen Kubbtour)
        foreach($stats_teamIDs["results"] as $stats_teamID) {

            if($stats_teamID["points"]> 30){
                $teamnamenarrayTopteams[$stats_teamID["team_id"]]= $stats_teamID["teamname"];
                //var_dump($teamnamenarray);
            }
            if($stats_teamID["points"]> 9){
                $teamnamenarray[$stats_teamID["team_id"]]= $stats_teamID["teamname"];
                //var_dump($teamnamenarray);
            }
        }
        //alle mit mehr als 9 punkten auf Kubbtour durchrattern:
        foreach($teamnamenarray as $teamID =>$teamnamen) {

            $json_url = "http://kubbtour.ch/inc_content/api_rank2.php?data=team&team_id=" . $teamID . "&view=json";
            $json_data = file_get_contents($json_url);


            $stats_teamresults = json_decode(substr($json_data, 1, -3), true);
            //mindestens drei Spiele gespielt
            if (count($stats_teamresults["results"]) > 1) {
                foreach ($stats_teamresults["results"] as $aktuelles_teamArray) {
                    //Topteam --> Möglicher Kandidat für "längste Durststrecke"
                    if (array_key_exists($teamID, $teamnamenarrayTopteams)) {
                        if ($aktuelles_teamArray["stage"] == "Winner" || substr($aktuelles_teamArray["stage"], 0, 8) == "Winner +") {

                            $datestring = $aktuelles_teamArray["day"] . "-" . $aktuelles_teamArray["month"] . "-" . $aktuelles_teamArray["year"];
                            $datum = date_create_from_format('d-m-Y', $datestring);
                            $datumtotal = $datum->format('Ymd');
                            $arraymitturnierinfos[0] = $teamID;
                            $arraymitturnierinfos[1] = $datestring;
                            $arraymitturnierinfos[2] = $aktuelles_teamArray["name"];
                            $arraymitturnierinfos[3] = $datum;

                            $durststrecke_winner[$datumtotal] = $arraymitturnierinfos;
                            $siegerteams[$file] = "ja";

                            continue 2;// = nächstes team
                        }
                    }
                }
                //siegerteams überspringen, die nicht mehr zu topteams gehören
                foreach ($stats_teamresults["results"] as $aktuelles_teamArray) {
                    if ($aktuelles_teamArray["medal"] == "gold") {

                        continue 2;// = nächstes team
                    }
                }
                //meiste 2. plätze ohne sieg
                foreach ($stats_teamresults["results"] as $aktuelles_teamArray) {
                    if ($aktuelles_teamArray["medal"] == "silber") {
                        $silberteams[$teamID] += 1;
                    }
                }
                //wenn noch nie im Final
                if($silberteams[$teamID] == NULL){
                    foreach ($stats_teamresults["results"] as $aktuelles_teamArray) {
                        if ($aktuelles_teamArray["medal"] == "bronze" || $aktuelles_teamArray["stage"] == "Halbfinal") {
                            $halbfinalteams[$teamID] += 1;
                        }
                    }
                }
                //wenn noch nie im Halbfinal
                if($silberteams[$teamID] == NULL && $halbfinalteams[$teamID] == NULL){
                    foreach ($stats_teamresults["results"] as $aktuelles_teamArray) {
                        if ($aktuelles_teamArray["stage"] == "Viertelfinal") {
                            $viertelfinalteams[$teamID] += 1;
                        }
                    }
                }
            }


        }




        echo "<h2>Längste Durststrecke</h2>";
        echo "berücksichtigt werden Teams, die mind. 3 Turniere gespielt haben und aktuell über 30 Punkte in der Kubb-Tour-Rangliste vorweisen.<br><br>";
        ksort($durststrecke_winner);
        $codefuerstartseite = "<table><tr><td class=\"ranking_cell\" style=\"font-weight:bolder;color:red;\">Längste Durststrecke:</td></tr>"; $indexstartseitewinner = 0;
        foreach($durststrecke_winner as $winner){


            $now = time(); // or your date as well
            $your_date = strtotime($winner[1]);
            $datediff = $now - $your_date;

            //echo floor($datediff/(60*60*24))." Tage: ".$teamnamenarray[$winner[0]] ."(".$winner[2].")<br>";
            echo "<b>".$teamnamenarray[$winner[0]]."</b>: ".floor($datediff/(60*60*24))." Tage (".$winner[2].")<br/>";
            if($indexstartseitewinner <2){
                $codefuerstartseite .= "<tr><td class=\"ranking_cell\"><b>".substr($teamnamenarray[$winner[0]],0,17)."</b>: ".floor($datediff/(60*60*24))." Tage</td></tr>";
                $indexstartseitewinner++;
            }

        }

        $startseite_stats = get_template_directory()."/startseite_stats.txt";

        $codefuerstartseite .= "<tr><td class=\"ranking_cell\" style=\"font-weight:bolder;color:red;\">Heiss auf den 1. Sieg:</td></tr>";

        echo "<h2>Anzahl Finals und noch kein Sieg</h2>";
        arsort($silberteams);
        $indexstartseiteheiss = 0;
        foreach ($silberteams as $key => $silberteam) {

            echo $teamnamenarray[$key] . "(" . $silberteam . ")<br>";
            if($indexstartseiteheiss < 2){
                $codefuerstartseite .= "<tr><td class=\"ranking_cell\"><b>".substr($teamnamenarray[$key],0,17)."</b> (".$silberteam." Finalniederlagen) </td></tr>";
                $indexstartseiteheiss++;
            }
        }

        echo "<h2>Anzahl Halbfinals und noch kein Final:</h2>";
        arsort($halbfinalteams);
        $indexstartseitehalbfinal = 0;

        $codefuerstartseite .= "<tr><td class=\"ranking_cell\" style=\"font-weight:bolder;color:red;\">Heiss auf Final:</td></tr>";

        foreach ($halbfinalteams as $key => $halbfinalteam) {

            echo $teamnamenarray[$key] . "(" . $halbfinalteam . ")<br>";
            if($indexstartseitehalbfinal < 1){
                $codefuerstartseite .= "<tr><td class=\"ranking_cell\"><b>".substr($teamnamenarray[$key],0,17)."</b> (".$halbfinalteam." Halbfinals) </td></tr>";
                $indexstartseitehalbfinal++;
            }
        }

        echo "<h2>Anzahl Viertelfinals und noch kein Halbfinal:</h2>";
        arsort($viertelfinalteams);
        $indexstartseiteviertelfinal = 0;

        $codefuerstartseite .= "<tr><td class=\"ranking_cell\" style=\"font-weight:bolder;color:red;\">Heiss auf Halbfinal:</td></tr>";

        foreach ($viertelfinalteams as $key => $viertelfinalteam) {

            echo $teamnamenarray[$key] . "(" . $viertelfinalteam . ")<br>";
            if($indexstartseiteviertelfinal < 1){
                $codefuerstartseite .= "<tr><td class=\"ranking_cell\"><b>".substr($teamnamenarray[$key],0,17)."</b> (".$viertelfinalteam." Viertelfinals) </td></tr>";
                $indexstartseiteviertelfinal++;
            }
        }
        $codefuerstartseite .= "<tr><td class=\"ranking_cell\">Mehr <a href=\"kubb-statistiken/\">Kubb-Statistiken</a></td></tr></table>";
        file_put_contents($startseite_stats, $codefuerstartseite);





/*

                    }
                    echo "<h2>längste_durststrecke (Anzahl Tage seit letztem Sieg)</h2>";
                    ksort($durststrecke_winner);
                    foreach($durststrecke_winner as $winner){
                        $aktuelleteamid = substr($winner[0],0,-4);

                        $now = time(); // or your date as well
                        $your_date = strtotime($winner[1]);
                        $datediff = $now - $your_date;
                        echo floor($datediff/(60*60*24));

                        echo $teamnamenarray[$aktuelleteamid] ." am ".floor($datediff/(60*60*24))." (".$winner[2].")<br>";
                    }

                    //ewiger zweiter
                    foreach($files1 as $file) {
                        if ($siegerteams[$file] != "ja") {
                            $aktuelle_url = get_template_directory() . "/stats/" . $file;
                            $aktuelles_team_json = file_get_contents($aktuelle_url);
                            $aktuelles_team = json_decode($aktuelles_team_json, true);
                            foreach ($aktuelles_team["results"] as $aktuelles_resultat) {
                                if ($aktuelles_resultat["medal"] == "silber") {
                                    $silberteams[$file] += 1;
                                }
                            }
                        }

                    }
                    echo "<h2>Anzahl Finals und noch kein Sieg</h2>";
                    arsort($silberteams);
                    foreach ($silberteams as $key => $silberteam) {
                        //echo $key;
                        $aktuelleteamid = substr($key, 0, -4);
                        echo $teamnamenarray[$aktuelleteamid] . "(" . $silberteam . ")<br>";
                    }

                    //Anzahl Halbfinals und noch nie im Final
                    echo "<h2>Anzahl Halbfinals und noch nie im Final</h2>";
                    foreach($files1 as $file) {
                        if ($siegerteams[$file] != "ja" && $silberteams[$file] == NULL) {
                            $aktuelle_url = get_template_directory() . "/stats/" . $file;
                            $aktuelles_team_json = file_get_contents($aktuelle_url);
                            $aktuelles_team = json_decode($aktuelles_team_json, true);
                            foreach ($aktuelles_team["results"] as $aktuelles_resultat) {
                                if ($aktuelles_resultat["medal"] == "bronze" || $aktuelles_resultat["stage"] == "Halbfinal") {
                                    $nochnieimfinalteams[$file] += 1;

                                }
                            }
                        }

                    }
                    arsort($nochnieimfinalteams);
                    foreach ($nochnieimfinalteams as $key => $nochnieimfinalteam) {
                        //echo $key;
                        $aktuelleteamid = substr($key, 0, -4);
                        echo $teamnamenarray[$aktuelleteamid] . "(" . $nochnieimfinalteam . ")<br>";
                    }
                    //Anzahl Halbfinals und noch nie im Final
                    echo "<h2>Anzahl Viertelfinals und noch nie im Halbfinal</h2>";
                    foreach($files1 as $file) {
                        if ($siegerteams[$file] != "ja" && $silberteams[$file] == NULL && $nochnieimfinalteams[$file] == NULL) {
                            $aktuelle_url = get_template_directory() . "/stats/" . $file;
                            $aktuelles_team_json = file_get_contents($aktuelle_url);
                            $aktuelles_team = json_decode($aktuelles_team_json, true);
                            foreach ($aktuelles_team["results"] as $aktuelles_resultat) {
                                if ($aktuelles_resultat["stage"] == "Viertelfinal") {
                                    $nochnieimhalbfinalteams[$file] += 1;

                                }
                            }
                        }

                    }
                    arsort($nochnieimhalbfinalteams);
                    foreach ($nochnieimhalbfinalteams as $key => $nochnieimhalbfinalteam) {
                        //echo $key;
                        $aktuelleteamid = substr($key, 0, -4);
                        echo $teamnamenarray[$aktuelleteamid] . "(" . $nochnieimhalbfinalteam . ")<br>";
                    }
                    //Anzahl Achtelfinals und noch nie im Viertelfinal
                    echo "<h2>Anzahl Achtelfinals und noch nie im Viertelfinal</h2>";
                    foreach($files1 as $file) {
                        if ($siegerteams[$file] != "ja" && $silberteams[$file] == NULL && $nochnieimfinalteams[$file] == NULL && $nochnieimhalbfinalteams[$file] == NULL) {
                            $aktuelle_url = get_template_directory() . "/stats/" . $file;
                            $aktuelles_team_json = file_get_contents($aktuelle_url);
                            $aktuelles_team = json_decode($aktuelles_team_json, true);
                            foreach ($aktuelles_team["results"] as $aktuelles_resultat) {
                                if ($aktuelles_resultat["stage"] == "Achtelfinal") {
                                    $nochnieimviertelfinalteams[$file] += 1;

                                }
                            }
                        }

                    }
                    arsort($nochnieimviertelfinalteams);
                    foreach ($nochnieimviertelfinalteams as $key => $nochnieimviertelfinalteam) {
                        //echo $key;
                        $aktuelleteamid = substr($key, 0, -4);
                        echo $teamnamenarray[$aktuelleteamid] . "(" . $nochnieimviertelfinalteam . ")<br>";
                    }
                    /*

                    foreach($stats_teamIDs["results"] as $stats_teamID){

                        $json_url = "http://kubbtour.ch/inc_content/api_rank2.php?data=team&team_id=".$stats_teamID["team_id"]."&view=json";
                        $json_data = file_get_contents($json_url);


                        $stats_teamresults = json_decode(substr($json_data,1,-3), true);
                        //mind. 3 spiele in aktuelles Jahr - 1 (für 2016=2016 + 2015) --> kommt in statistik
                         nur für daten holen von swisskubb
                        if($stats_teamresults["results"][2]["year"] > (date("Y")-2)){
                            echo $json_data;
                            $file = get_template_directory()."/stats/".$stats_teamID["team_id"].".txt";
                            file_put_contents($file, substr($json_data,1,-3));
                        }


                        //daten lokal holen

                        $file = get_template_directory()."/stats/".$stats_teamID["team_id"].".txt";
                        $file_json = file_get_contents($file);
                        $file_data = json_decode($file_json, true);

                        foreach($file_data["results"] as $file_teamresult) {

                        }
                            //echo $stats_jahr;
                        //$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');


                        //}
                    }*/



        ?>




</div>
    </div>

    </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
            ?>
