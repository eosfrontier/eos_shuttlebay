<?php

$shuttles = $cShuttles->getAllShuttles();
$readyShuttles=[];
$prepShuttles=[];
$onMissionShuttles=[];
$inRepairShuttles=[];
$missingShuttles=[];
$inoperableShuttles=[];

foreach ($shuttles as $shuttle){
    if ($shuttle['operable'] = 1 || $shuttle['operable'] = 9){
        if ($shuttle['status_name'] == "Ready"){
            $readyShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "Prep"){
            $prepShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "On Mission"){
            $onMissionShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "Missing"){
            $missingShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "In-Repair"){
            $inRepairShuttles[] = $shuttle;
        }
    }
    else {
        $inoperableShuttles[] = $shuttle;
    }
}

?>
<table class="shuttle-status-board">
    <tr>
    <td>
    <h3>Available/Prepping Shuttles</h3>
        <?php echo displayShuttles($readyShuttles, 'disabled'); ?>
        <?php echo displayShuttles($prepShuttles, 'disabled'); ?>
    </td>
    <td>
    <h3>Shuttles On-Mission</h3>
        <?php echo displayShuttles($onMissionShuttles, 'disabled'); ?>
    </td>
    <td>
    <h3>Unavailable Shuttles</h3>
        <?php echo displayShuttles($inRepairShuttles, 'disabled'); ?>
        <?php echo displayShuttles($missingShuttles, 'disabled'); ?>
        <?php echo displayShuttles($inoperableShuttles, 'disabled'); ?>
    </td>
    </tr>
</table>


