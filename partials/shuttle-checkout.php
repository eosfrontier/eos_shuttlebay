
<form class="checking-form">
                    <label>Current date</label><br />
                    <input type="text" required name="date" value="<?php echo $ICDateString; ?>" readonly="readonly"/><br />
                    <label>Current time</label><br />
                    <input id="time" type="text" name="time" readonly="readonly" /><br />
                    <label>Reason</label><br />
                    <textarea name="reason" autofocus></textarea><br />
                    <label>Notes</label><br />
                    <textarea name="note"></textarea><br />
                    <input type="hidden" name="character_id" value="<?php echo $aRes[1]["characterID"]; ?>" />
                    <input type="hidden" name="access" value="<?php echo $access; ?>" />
                    <input type="hidden" name="xf" value="checkin" />
                    <input type="submit" class="checkinout-button" value="<?php echo $value; ?>" />
                </form>
                <div class="checking-success">
                    <strong><?php echo $aRes[1]["character_name"] ?> has been <?php echo $success; ?>.</strong><br />
                    Returning to scanner in 3 seconds.
                </div>