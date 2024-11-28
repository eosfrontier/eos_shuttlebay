<?php

$shuttles = $cShuttles->getAllShuttles();
$readyShuttles=[];
$prepShuttles=[];
$onMissionShuttles=[];
$inRepairShuttles=[];
$missingShuttles=[];
$inoperableShuttles=[];

foreach ($shuttles as $shuttle){
    if ($shuttle['operable'] = 1 || $shuttle['operable'] = 0){
        if ($shuttle['status'] = "Ready"){
            $readyShuttles[] = $shuttle;
        }
        else if ($shuttle['status'] = "Prep"){
            $prepShuttles[] = $shuttle;
        }
        else if ($shuttle['status'] = "On Mission"){
            $onMissionShuttles[] = $shuttle;
        }
        else if ($shuttle['status'] = "Missing"){
            $missingShuttles[] = $shuttle;
        }
        else if ($shuttle['status'] = "In-Repair"){
            $inRepairShuttles[] = $shuttle;
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
        ?>
        <button class='button--shuttle <?php echo $buttonClass; ?>'>
        <table class="shuttle-button">
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
        ?>
            </tr>
        </table>
    </button>
</br>
<?php
        }
}
?>
<table class="shuttle-status-board">
    <tr>
    <td>
    <h3>Available/Prepping Shuttles</h3>
        <?php echo displayShuttles($readyShuttles); ?>
        <?php echo displayShuttles($prepShuttles); ?>
    </td>
    <td>
    <h3>Shuttles On-Mission</h3>
        <?php echo displayShuttles($onMissionShuttles); ?>
    </td>
    <td>
    <h3>Unavailable Shuttles</h3>
        <?php echo displayShuttles($inRepairShuttles); ?>
        <?php echo displayShuttles($missingShuttles); ?>
        <?php echo displayShuttles($inoperableShuttles); ?>
    </td>
    </tr>
</table>


