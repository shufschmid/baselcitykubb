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
        <h1>Einzelspieler-Liga</h1>

        <?php
        set_time_limit ( 200 );
        $json_data = file_get_contents("http://kubbtour.ch/inc_content/api_rank2.php?data=tour&year=0&view=json");
        $stats_teamIDs = json_decode(substr($json_data,1,-3), true);

        //array-erstellen [id]-->Teamname (alle mit mehr als 9 punkten auf der aktuellen Kubbtour)
        foreach($stats_teamIDs["results"] as $stats_teamID) {
            if($stats_teamID["points"]> 9){
                $teamnamenarray[$stats_teamID["team_id"]]= $stats_teamID["teamname"];
                //var_dump($teamnamenarray);
            }
        }

        foreach($teamnamenarray as $teamID =>$teamnamen){

            $json_url = "http://kubbtour.ch/inc_content/api_rank2.php?data=team&team_id=".$teamID."&view=json";
            $json_data = file_get_contents($json_url);


            $stats_teamresults = json_decode(substr($json_data,1,-3), true);
            var_dump($stats_teamresults)
            }
        die;



        foreach($teamnamenarray as $aktuelles_teamID => $aktuelles_teamArray){
            var_dump($aktuelles_teamArray);}}
        /*if($aktuelles_teamArray["results"]["medal"] == "gold") {
                $datestring = $aktuelles_resultat["day"] . "-" . $aktuelles_resultat["month"] . "-" . $aktuelles_resultat["year"];
                $datum = date_create_from_format('d-m-Y', $datestring);
                $datumtotal = $datum->format('Ymd');
                $arraymitturnierinfos[0] = $file;
                $arraymitturnierinfos[1] = $datestring;
                $arraymitturnierinfos[2] = $aktuelles_resultat["name"];
                $arraymitturnierinfos[3] = $datum;

                $durststrecke_winner[$datumtotal] = $arraymitturnierinfos;
                $siegerteams[$file] = "ja";
            break;
            }
        }*/

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
