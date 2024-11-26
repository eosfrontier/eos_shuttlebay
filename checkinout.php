<?php
include ('includes/include.php');
$post = 0;
if (isset($_POST["id"])) {
    $cDouane = new douane();
    $sId = $_POST["id"];
    $aRes = $cDouane->getChecking($sId);
    if ($aRes != "empty") {
        $post = 1;
        if (isset($aRes[2])) {
            $travels = $aRes[2];
        }
    }


}
?>

<?php
include ('includes/inc.header.php');
?>
<div id="main">
    <div class="container">
        <?php if ($post == 0) { ?>
            <div class="welcome">
                Please scan the identity badge.
                <form action="./checkinout.php" method="post">
                    <input name="id" type="text" class="badge-scan" autofocus />
                </form>
            </div>
        <?php } ?>
        <?php if ($post == 1) { ?>
            <?php if ($aRes[0]["returning"] == "empty") {
                ?>
                <div class="logging-message">
                    <strong>This person hasn't been on the Bastion yet.</strong>
                </div>
                <?php
            }
            ?>
            <?php if ($aRes[1]["douane_disposition"] == "DETAIN") { ?>
                <div class="check-warning">
                    WARNING -- DETAIN -- WARNING
                </div>
            <?php } ?>
            <div class="checkinout-left">
                <?php
                if ($aRes[0]["access"] == 0) {
                    $value = "Check in";
                    $access = "1";
                    $success = "Checked in";
                } else {
                    $value = "Check out";
                    $access = "0";
                    $success = "Checked out";
                }
                ?>
                <form class="checking-form">
                    <label>Current date</label><br />
                    <input type="text" required name="date" autofocus /><br />
                    <label>Current time</label><br />
                    <input id="time" type="text" name="time" readonly="readonly" /><br />
                    <label>Reason</label><br />
                    <textarea name="reason"></textarea><br />
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
            </div>
            <div class="checkinout-right">

                <div class="check-image">
                    <?php
                    $status = $aRes[1]["status"];
                    if (str_contains($status, "figu")) {
                        $sImage = "./images/mugs/npc/" . $aRes[1]["figu_accountID"] . ".jpg";
                    } else {
                        $sImage = "./images/mugs/" . $aRes[1]["characterID"] . ".jpg";
                    }
                    if (file_exists($sImage)) {
                        echo '<img class="portrait" src="' . $sImage . '" />';
                    } else { ?>
                        <img class="portrait" src="./images/pending.png" />
                    <?php } ?>

                    <img src="./images/logos/<?php echo $aRes[1]["faction"] ?>.png" />
                </div>
                <div class="check-right">
                    <div class="check-name check-doublecolumn">
                        <?php echo $aRes[1]["character_name"] ?>
                    </div>
                    <div class="check-faction">
                        <span class="check-subtitle">
                            Faction:
                        </span>
                        <?php echo $aRes[1]["faction"] ?>
                    </div>
                    <?php if ($aRes[1]["rank"]) { ?>
                        <div class="check-faction">
                            <span class="check-subtitle">
                                Rank:
                            </span>
                            <?php echo $aRes[1]["rank"] ?>
                        </div>
                    <?php } ?>
                    <div class="check-faction">
                        <span class="check-subtitle">
                            Disposition:
                        </span>
                        <?php echo $aRes[1]["douane_disposition"] ?>
                    </div>
                    <div class="check-faction">
                        <span class="check-subtitle">
                            Threat level:
                        </span>
                        <?php
                        $sLevel = 5;
                        $sDanger = $sLevel - $aRes[1]["threat_assessment"];
                        $i = 0;
                        while ($i < $aRes[1]["threat_assessment"]) {
                            ?>
                            <i class="fas fa-circle"></i>
                            <?php
                            $i++;
                        }
                        $i = 0;
                        while ($i < $sDanger) {
                            ?>
                            <i class="far fa-circle"></i>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="check-faction">
                        <span class="check-subtitle">
                            Clearance level:
                        </span>
                        <?php
                        $sLevel = 3;
                        $sDanger = $sLevel - $aRes[1]["bastion_clearance"];
                        $i = 0;
                        while ($i < $aRes[1]["bastion_clearance"]) {
                            ?>
                            <i class="fas fa-circle"></i>
                            <?php
                            $i++;
                        }
                        $i = 0;
                        while ($i < $sDanger) {
                            ?>
                            <i class="far fa-circle"></i>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <?php if ($aRes[1]["ic_birthday"]) { ?>
                        <div class="check-faction">
                            <span class="check-subtitle">
                                Date of Birth:
                            </span>
                            <?php echo $aRes[1]["ic_birthday"] ?>
                        </div>
                    <?php } ?>
                    <?php if ($aRes[1]["homeplanet"]) { ?>
                        <div class="check-faction">
                            <span class="check-subtitle">
                                Date of Birth:
                            </span>
                            <?php echo $aRes[1]["homeplanet"] ?>
                        </div>
                    <?php } ?>
                    <?php if ($aRes[1]["card_id"]) { ?>
                        <div class="check-faction">
                            <span class="check-subtitle">
                                ICC ID:
                            </span>
                            <?php echo $aRes[1]["card_id"] ?>
                        </div>
                    <?php } ?>
                    <?php if ($aRes[1]["douane_notes"]) { ?>
                        <div class="check-faction check-doublecolumn">
                            <span class="check-subtitle">
                                Notes:
                            </span>
                            <?php echo nl2br($aRes[1]["douane_notes"]) ?>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($travels)) {
                        ?>
                        <div class="check-faction check-doublecolumn">
                            <span class="check-subtitle">
                                Travel logs:
                            </span>
                            <table class="checking-table" width="100%">
                                <thead>
                                    <td>
                                        <strong>Date</strong>
                                    </td>
                                    <td>
                                        <strong>Time</strong>
                                    </td>
                                    <td>
                                        <strong>Access</strong>
                                    </td>
                                    <td>
                                        <strong>Reason</strong>
                                    </td>
                                    <td>
                                        <strong>Note</strong>
                                    </td>
                                </thead>

                                <?php
                                foreach ($travels as $travel) {
                                    ?>
                                    <tr class="travel-line">
                                        <td class="travel-line-date">
                                            <?php echo $travel["date"]; ?>
                                        </td>
                                        <td class="travel-line-time">
                                            <?php echo $travel["time"]; ?>
                                        </td>
                                        <td class="travel-line-access">
                                            <?php
                                            if ($travel["access"] == 1) {
                                                echo "Checked in";
                                            } else {
                                                echo "Checked out";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($travel["reason"])) { ?>

                                                <i class="fas fa-clipboard">
                                                    <div class="tooltip">
                                                        <?php echo nl2br($travel["reason"]); ?>
                                                    </div>
                                                </i>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($travel["note"])) { ?>
                                                <i class="fas fa-sticky-note">
                                                    <div class="tooltip">
                                                        <?php echo nl2br($travel["note"]); ?>
                                                    </div>
                                                </i>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clear">

    </div>
</div>
</div>
<?php
include ('includes/inc.footer.php');
?>
<?php if ($post == 1) { ?>
    <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            h = checkTime(h);
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').value = h + ":" + m + ":" + s;
            var t = setTimeout(function () { startTime() }, 1000);
        }

        function checkTime(i) {
            if (i < 10) { i = "0" + i } // add zero in front of numbers < 10
            return i;
        }

        startTime();
    <?php } ?>
</script>
</body>

</html>