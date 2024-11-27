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

$shuttles = $cShuttles->getAllShuttles();
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
function displayShuttles($array){
    foreach ($array as $shuttle){
        if ($shuttle['operable'] = 1){
            $buttonClass="good";
        }
        elseif ($shuttle['operable'] = 0){
            $buttonClass="warn";
        }
        elseif ($shuttle['operable'] = -1){
            $buttonClass = "error";
        }
        echo "<button class='button--shuttle $buttonClass'>"; ?>
        <table>
            <tr>
        <?php
        echo "<h3>". $shuttle['serial_number'] . ": " . $shuttle['name'] . "</h3>";
        echo "<td><strong>Class:<br>
        Type:<br>
        Cap:<br>
        Home Base:<br>
        Status:</strong></td>
        <td>";
        echo $shuttle['class'] . "<br>";
        echo $shuttle['type'] . "<br>";
        echo $shuttle['capacity'] . "👤<br>";
        echo $shuttle['base'] . "<br>";
        echo $shuttle['status'] . "<br>";
        echo "</td>";

        // echo "<td></td><strong>Class:</strong> ". $shuttle['class'] . "<br>";
        // echo "<td><strong>Cap:</strong> 👤" . $shuttle['capacity']. " <br><strong>Home Base: </strong>" . $shuttle['base']. "</td>
        // <td>&nbsp;&nbsp;<strong>Type:</strong> " . $shuttle['type']."<br><strong>Status: </strong>" . $shuttle['status']."</td><br>";
        ?>
            </tr>
        </table>
    </button>
</br>
<?php
        }
}
echo "<h3>Available Shuttles</h3>";
echo displayShuttles($readyShuttles);
// echo "<pre>". print_r($shuttles, JSON_PRETTY_PRINT) ."</pre>";


// echo arrayToTable($cShuttles->getAllShuttles());
// echo $cShuttles->getICDate();
// echo $ICDate;
