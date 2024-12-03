<?php


$readyShuttles = [];
$prepShuttles = [];
$onMissionShuttles = [];
$inRepairShuttles = [];
$missingShuttles = [];
$inoperableShuttles = [];

foreach ($shuttles as $shuttle) {
    if ($shuttle['operable'] = 1 || $shuttle['operable'] = 9) {
        if ($shuttle['status_name'] == "Ready") {
            $readyShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "Prep") {
            $prepShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "On Mission") {
            $onMissionShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "Missing") {
            $missingShuttles[] = $shuttle;
        }
        if ($shuttle['status_name'] == "In-Repair") {
            $inRepairShuttles[] = $shuttle;
        }
    } else {
        $inoperableShuttles[] = $shuttle;
    }
}

if (isset($_GET["operation"]) && ($_GET["operation"] == "checkout")) {
    ?>

    <h3>Available/Prepping Shuttles</h3>
    <?php echo displayShuttles($readyShuttles); ?>
    <?php echo displayShuttles($prepShuttles); ?>
<?php }
if (isset($_GET["operation"]) && $_GET["operation"] == "checkin") { ?>

    <h3>Shuttles On-Mission</h3>
    <?php echo displayShuttles($onMissionShuttles);
} ?>