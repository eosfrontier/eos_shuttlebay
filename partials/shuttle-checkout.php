
<form class="checking-form">
    <label>Current date</label><br />
    <input type="text" required name="ic_date" value="<?php echo $ICDateString; ?>" readonly="readonly"/><br />
    <label>Current time</label><br />
    <input id="time" type="text" name="ic_time" readonly="readonly" /><br />
    <label>Comment</label><br />
    <textarea name="comment"></textarea><br />
    <label>Mission Name</label><br />
    <input type="text" required name="mission_name"/><br />
    <label>Mission Leader</label><br />
    <input type="text" required name="mission_leader"/><br />
    <input type="hidden" name="status_updated_by" value="<?php echo $aRes["characterID"]; ?>" />
    <input type="hidden" name="shuttleID" value="<?php echo $_POST['selected_shuttle']; ?>" />
    <input type="hidden" name="status" value="<?php echo $status; ?>" /> <!--2 is the status id for on mission -->
    <input type="hidden" name="xf" value="checkout" />
    <input type="submit" class="checkinout-button" value="<?php echo $value; ?>" />
</form>
<div class="checking-success">
    <strong><?php echo $aRes["character_name"] ?> has been <?php echo $success; ?>.</strong><br />
    Returning to scanner in 3 seconds.
</div>