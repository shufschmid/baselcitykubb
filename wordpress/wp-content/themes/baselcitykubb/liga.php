<?php

/**
 * Template-File für die Kubb-Liga.
 * Template Name: liga
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
        if(isset($_POST['resultat1'])) {
            #Spiel hinzufügen
            $spieldatetime = date("Y-m-d H:i:s");
            $wpdb->insert(
                'liga_spiele',
                array(
                    'date' => $spieldatetime,
                    'spieler1' => $_POST['spieler1'],
                    'spieler2' => $_POST['spieler2'],
                    'resultat1' => $_POST['resultat1'],
                    'resultat2' => $_POST['resultat2']
                )
            );
        }

        get_template_part( 'template-parts/content-liga-formular');



        $ranking = getRanking($spiele, $current_user->id);
        ?>

            <table class="table table-striped table-condensed table-hover">
                <caption>Die letzten Spiele</caption>
                <?php
                for ($spielezaehler = 1; $spielezaehler <= 10; $spielezaehler++){
                    echo "<tr>";
                    $letztesspiel = array_pop($letztespiele);

                    ?>

                    <tr>
                        <td><?php
                            echo substr($letztesspiel[0], 0, 7);
                            ?></td>

                        <td>
                            <?php
                            echo substr($letztesspiel[1], 0, 15);
                            if(strlen($letztesspiel[1])>15){
                                echo "...";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo substr($letztesspiel[2], 0, 15);
                            if(strlen($letztesspiel[2])>15){
                                echo "...";
                            }
                            ?>
                        </td>
                        <td><?php
                            echo $letztesspiel[5].":".$letztesspiel[6];
                            ?>
                        </td>
                        <td><b><?php
                                echo round($letztesspiel[7], 2);
                                ?>
                            </b></td>
                    </tr>
                    <?php
                    $ticker .= "<li><span>".substr($letztesspiel[0], 0, 7)."</span><a href=\"liga/\">".$letztesspiel[1]." vs. ".$letztesspiel[2]." ".$letztesspiel[5].":".$letztesspiel[6]."</a></li>";
                }
                $file = get_template_directory()."/ticker.txt";
                echo $file;
                file_put_contents($file, $ticker);

                ?>


                                <table class="table table-striped table-condensed table-hover">

                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Sp.</th>
                                        <th>%S</th>
                                        <th>Elo G</th>
                                        <th><b>Elo</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($ranking as $ligaItem){
                                        if($ligaItem->elo != 1500){
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i; $i++;?>.
                                                </td>
                                                <td>
                                                    <?php echo get_avatar( $ligaItem->id, 20 ); ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo "<a href=\"http://localhost/?author=".$ligaItem->id."\">".substr($ligaItem->name, 0, 15);
                                                    if(strlen($ligaItem->name)>15){
                                                        echo "...";
                                                    }
                                                    echo "</a>";
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $ligaItem->anzSpiele;?>
                                                </td>

                                                <td>
                                                    <?php echo intval($ligaItem->ProzSiege);?>%
                                                </td>
                                                <td>
                                                    <?php echo intval($ligaItem->EloGegner);?>
                                                </td>

                                                <td><b>
                                                        <?php echo intval($ligaItem->elo);?>
                                                    </b></td>
                                            </tr>

                                        <?php } };?>
                                    </tbody>
                                </table>

                    </div>
                </div>

</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
