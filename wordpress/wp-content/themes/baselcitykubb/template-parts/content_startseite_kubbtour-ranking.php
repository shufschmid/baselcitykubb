<?php ?><table><tr><td colspan="3" class="swipertitle"><a href="http://kubbtour.ch/kubbtour.php">Kubbtour</a></td> </tr>
    <?php
    $json_data = file_get_contents("http://kubbtour.ch/inc_content/api_rank2.php?data=tour&year=0&view=json");
    $json_data = json_decode(substr($json_data,1,-3), true);
    $index = 1;
    foreach($json_data["results"] as $data){
        echo "<tr><td class=\"ranking_cell\">".$index."</td><td class=\"ranking_cell\">".substr($data["teamname"],0,17)."</td><td class=\"ranking_cell\">".$data["points"]."</td></tr>";

        //var_dump($data[1]["teamname"]);

        if (++$index == 11) break;
    }
    //<tr><td class="ranking_cell credits" colspan="3"><a href="http://www.kubbtour.ch/">kubbtour.ch</a></td></tr>
    ?>

</table>