<?php
get_header();
$prefix = 'tk_';
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>

<!-- CONTENT -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://www.baselcitykubb.ch/wp-content/themes/novelti-child/sortstyle.css">
<div class="content left category-page">
    <div class="wrapper">
        <div class="content-full left">

            <div class="content-left left">

                    <?php echo get_avatar(get_the_author_meta('ID', $curauth->ID), '81')?>
                    <span><?php echo get_the_author_meta('nickname', $curauth->ID)?></span>
                    <?php
                    chdir('wp-admin/liga');
                    include('kubbmaister.php'); //aber es macht nix

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

                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-hover">
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
                                    <td class="hidden-xs">
                                        <?php
                                        echo $letztesspiel[2]." (".$letztesspiel[4].")";
                                        ?>
                                    </td>
                                    <td class="visible-xs">
                                        <?php
                                        echo substr($letztesspiel[2], 0, 7);
                                        if(strlen($letztesspiel[2])>7){
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
                            echo "</table></div>";
                            ?>


                            <div class="table-responsive">
                                <table id="angstgegner" class="table table-striped table-condensed table-hover">
                                    <caption>Angst- / Lieblingsgegner</caption>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Spieler</th>
                                        <th>Sp.</th>
                                        <th>%S</th>
                                        <th class='sort-default'><b>Punkte</b></th>
                                        <th class="hidden-xs" class='no-sort'>Sätze G : V</th>
                                        <th class="hidden-xs">Elo G</th>

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
                                        echo "<a href=\"http://baselcitykubb.ch/?author=".$ligaItem->id."\">".substr($ligaItem->name, 0, 7);
                                        if(strlen($ligaItem->name)>7){
                                            echo "...";
                                        }
                                        echo "</a>";
                                        ?></td>
                                    <td><?php echo $ligaItem->anzSpieleX;?></td>


                                    <td><?php echo 100 - intval($ligaItem->ProzSiegeX);?></td>
                                    <td><b><?php echo -1*round($ligaItem->punkteX,2);?></b></td>
                                    <td class="hidden-xs"><?php echo $ligaItem->saetzeVX.":".$ligaItem->saetzeGX;?></td>
                                    <td class="hidden-xs"><?php echo intval($ligaItem->elo);?></td>


                                </tr>

                            <?php } };?>
                                    </tbody>
                    </table>
                                <script src='http://www.baselcitykubb.ch/wp-content/themes/novelti-child/tablesort.min.js'></script>
                                <script>
                                    new Tablesort(document.getElementById('angstgegner'));
                                </script>
                </div><!--/single-autor-->



            </div><!--/content-left-->

            <?php
            /* include sidebar */
            tk_get_sidebar('Right', 'Archive/Search');
            ?>

        </div><!--/content-full-->
    </div><!--/wrapper-->
</div><!--/content-->

<?php get_footer(); ?>