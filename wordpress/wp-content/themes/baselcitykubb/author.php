<?php
get_header();
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>

    <!-- CONTENT -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/inc/css/sortstyle.css" type="text/css" media="screen" />


    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">


                <?php echo get_avatar(get_the_author_meta('ID', $curauth->ID), '81')?>
                <span><?php echo get_the_author_meta('nickname', $curauth->ID)?></span>
                <?php
               // sort function
                function sortByLostPoints($kubbLigaItem1, $kubbLigaItem2){
                    if($kubbLigaItem1->punkteX == $kubbLigaItem2->punkteX){
                        return 0;
                    }
                    return ($kubbLigaItem1->punkteX < $kubbLigaItem2->punkteX) ? 1 : -1;
                }

                $einzelspieler = getRanking($spiele, $curauth->ID);

                usort($einzelspieler, "sortByLostPoints");

                ?>

                    <table>
                        <caption>Letzte Spiele</caption>
                        <?php
                        for ($spielezaehler = 1; $spielezaehler <= 10; $spielezaehler++){
                            echo "<tr>";
                            $letztesspiel = array_pop($letztespieleX);

                            ?>

                            <tr>
                                <td ><?php
                                    echo substr($letztesspiel[0], 0,5);
                                    ?></td>

                                <td class="visible-xs">
                                    <?php
                                    echo substr($letztesspiel[2], 0, 15);
                                    if(strlen($letztesspiel[2])>15){
                                        echo "...";
                                    }
                                    echo "(".$letztesspiel[4].")";
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
                        }
                        echo "</table>";
                        ?>



                            <table id="angstgegner" class="table table-striped table-condensed table-hover">
                                <caption>Angst- / Lieblingsgegner</caption>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Spieler</th>
                                    <th>Sp.</th>
                                    <th>%S</th>
                                    <th class='sort-default'><b>Punkte</b></th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach($einzelspieler as $ligaItem){
                                    if(count($ligaItem->eloentwicklungX)>0){
                                        $eloentwicklung = $ligaItem->eloentwicklungX;
                                    }
                                    if($ligaItem->anzSpieleX > 0){
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $i; $i++;?>.
                                            </td>

                                            <td><?php
                                                echo "<a href=\"http://baselcitykubb.ch/?author=".$ligaItem->id."\">".substr($ligaItem->name, 0, 15);
                                                if(strlen($ligaItem->name)>15){
                                                    echo "...";
                                                }
                                                echo "</a>";
                                                ?></td>
                                            <td><?php echo $ligaItem->anzSpieleX;?></td>


                                            <td><?php echo 100 - intval($ligaItem->ProzSiegeX);?></td>
                                            <td><b><?php echo -1*round($ligaItem->punkteX,2);?></b></td>


                                        </tr>

                                    <?php } };?>
                                </tbody>
                            </table>
                        <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/inc/js/tablesort.min.js"></script>
                            <script>
                                new Tablesort(document.getElementById('angstgegner'));
                            </script>
                        </div><!--/single-autor-->



                </div><!--/content-left-->

<?php get_footer(); ?>