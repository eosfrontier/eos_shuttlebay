<?php if ($_GET["operation"] == "checkin") {
    $currentMission = $cShuttles->getCurrentShuttleMission($_POST["selected_shuttle"]);
}
?>
<form class="checking-form" method="post">
    <label>Current date</label><br />
    <input type="text" required name="ic_date" value="<?php echo $ICDateString; ?>" readonly="readonly" /><br />
    <label>Current time</label><br />
    <input id="time" type="text" name="ic_time" readonly="readonly" /><br />
    <label>Mission Name</label><br />
    <?php if ($_GET["operation"] == "checkout") { ?>
        <select name="mission_name" required>
            <option value="">Choose a mission</option>
            <?php
            $missions = json_decode($cShuttles->getMissions(), true);
            foreach ($missions as $mission) {
                echo '<option  class = "mission.' . $mission['colorcode'] . '" value="' . $mission['title'] . '"  >' . $mission['title'] . ' - ' . $mission['goal'] . '</option>';
            }
            ?>
        </select><br />
    <?php } else { ?>
        <input type="text" required name="mission_name" value="<?php echo $currentMission[0]["mission_name"]; ?>"
            readonly="readonly" /><br />
    <?php } ?>
    <label>Mission Leader</label><br />
    <?php if ($_GET["operation"] == "checkout") { ?>
        <select name="mission_leader" required>
            <option value="">Choose a mission leader</option>
            <?php
            $characters = $cShuttles->get_characters_upcoming_event();

            foreach ($characters as $char) {
                echo '<option  value="' . $char['characterID'] . '"  >' . $char['character_name'] . '</option>';
            }
            ?>
        </select><br />
    <?php } else {
        $missionLeader = $cShuttles->getCharacterByID($currentMission[0]["mission_leader"]);
        ?>
        <input type="text" required name="mission_leader" value="<?php echo $missionLeader[0]["character_name"]; ?>"
            readonly="readonly" disabled /><br />
        <input type="hidden" required name="mission_leader" value="<?php echo $currentMission[0]["mission_leader"]; ?>"
            readonly="readonly" /><br />
    <?php } ?>
    <label>Comment</label><br />
    <textarea name="comment"></textarea><br />
    <input type="hidden" name="status_updated_by" value="<?php echo $aRes["characterID"]; ?>" />
    <input type="hidden" name="shuttleID" value="<?php echo $_POST['selected_shuttle']; ?>" />
    <input type="hidden" name="status" value="<?php echo $status; ?>" /> <!--2 is the status id for on mission -->
    <input type="hidden" name="xf" value="<?php echo $_GET["operation"]; ?>" />
    <input type="submit" class="checkinout-button" value="<?php echo $value; ?>" />
</form>
<script src="scripts/clock.js"></script>
<div class="checking-success">
    <strong><?php echo $aRes["character_name"] ?> has been <?php echo $success; ?>.</strong><br />
    Returning to scanner in 3 seconds.
</div>