<?php
function arrayToTable($array)
{
    echo '<table border="2">';
    echo "<thead><tr>";

    foreach (array_keys($array[0]) as $header) {
        echo "<th>$header</th>";
    }
    echo "</tr></thead>";
    echo "<tbody>";
    foreach ($array as $items) {
        echo "<tr>";
        foreach ($items as $key => $value) {
            echo "<td>$value</td>";
        }
    }
    echo "</tbody></table>";
}

$readyShuttles=[];
$prepShuttles=[];
$onMissionShuttles=[];
$inRepairShuttles=[];
$missingShuttles=[];
$inoperableShuttles=[];

foreach ($shuttles as $shuttle){
    if ($shuttle['operable'] = 1 || $shuttle['operable'] = 9){
        if ($shuttle['status'] = "Ready"){
            $readyShuttles[] = $shuttle;
        }
        if ($shuttle['status'] = "Prep"){
            $prepShuttles[] = $shuttle;
        }
        if ($shuttle['status'] = "On Mission"){
            $onMissionShuttles[] = $shuttle;
        }
        if ($shuttle['status'] = "Missing"){
            $inRepairShuttles[] = $shuttle;
        }
        if ($shuttle['status'] = "In-Repair"){
            $onMissionShuttles[] = $shuttle;
        }
    }
    else {
        $inoperableShuttles[] = $shuttle;
    }
}

echo "<h3>Available Shuttles</h3>";
echo displayShuttles($readyShuttles);
// echo "<pre>". print_r($shuttles, JSON_PRETTY_PRINT) ."</pre>";


// echo arrayToTable($cShuttles->getAllShuttles());
// echo $cShuttles->getICDate();
// echo $ICDate;
