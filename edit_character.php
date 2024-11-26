<?php
include ('includes/include.php');
$post = 0;
if (isset($_GET["id"])) {
    $cDouane = new douane();
    $sId = $_GET["id"];
    $aRes = $cDouane->getEditById($sId);
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
            <form class="character-edit-form">
                <div class="check-name">
                    <?php echo $aRes[1]["character_name"] ?>
                </div>
                <div class="check-faction">
                    <span class="check-subtitle">
                        Rank:
                    </span>
                    <input class="input-pretty" name="rank" value="<?php echo $aRes[1]["rank"] ?>" />
                </div>
                <div class="check-faction small">
                    <span class="check-subtitle">
                        Disposition:
                    </span>
                    <?php $sDisposition = $aRes[1]["douane_disposition"] ?>
                    <?php if ($sDisposition != "ICC VETTED" && $sDisposition != "DECEASED" && $sDisposition != "AWOL" && $sDisposition != "MIA") { ?>
                        <input type="radio" id="des-pending" name="douane_disposition" value="ACCESS PENDING" <?php if ($sDisposition == "ACCESS PENDING") { ?>checked<?php } ?> /> <label for="des-pending">Access
                            pending</label><br />
                        <input type="radio" id="des-granted" name="douane_disposition" value="ACCESS GRANTED" <?php if ($sDisposition == "ACCESS GRANTED") { ?>checked<?php } ?> /> <label for="des-granted">Access
                            granted</label><br />
                        <input type="radio" id="des-detain" name="douane_disposition" value="DETAIN" <?php if ($sDisposition == "DETAIN") { ?>checked<?php } ?> /> <label for="des-detain">Detain</label><br />
                        <input type="radio" id="des-awol" name="douane_disposition" value="AWOL" <?php if ($sDisposition == "AWOL") { ?>checked<?php } ?> /> <label for="des-awol">AWOL</label><br />
                        <input type="radio" id="des-mia" name="douane_disposition" value="MIA" <?php if ($sDisposition == "MIA") { ?>checked<?php } ?> /> <label for="des-mia">MIA</label><br />
                    <?php } ?>
                    <?php if ($sDisposition == "DECEASED") { ?>
                        <input type="radio" id="des-deceased" name="douane_disposition" value="DECEASED" <?php if ($sDisposition == "DECEASED") { ?>checked<?php } ?> /> <label
                            for="des-deceased">Deceased</label><br />
                    <?php } ?>
                    <?php if ($sDisposition == "ICC VETTED") { ?>
                        <input type="radio" id="des-vetted" name="douane_disposition" value="ICC VETTED" <?php if ($sDisposition == "ICC VETTED") { ?>checked<?php } ?> /> <label for="des-vetted">ICC
                            vetted</label><br />
                    <?php } ?>
                </div>
                <div class="check-faction small">
                    <span class="check-subtitle">
                        Threat level:
                    </span>
                    <?php
                    $sLevel = $aRes[1]["threat_assessment"];
                    ?>
                    <input type="radio" id="thr-0" name="threat_assessment" value="0" <?php if ($sLevel == "0") { ?>checked<?php } ?> /> <label for="thr-0">0</label><br />
                    <input type="radio" id="thr-1" name="threat_assessment" value="1" <?php if ($sLevel == "1") { ?>checked<?php } ?> /> <label for="thr-1">1</label><br />
                    <input type="radio" id="thr-2" name="threat_assessment" value="2" <?php if ($sLevel == "2") { ?>checked<?php } ?> /> <label for="thr-2">2</label><br />
                    <input type="radio" id="thr-3" name="threat_assessment" value="3" <?php if ($sLevel == "3") { ?>checked<?php } ?> /> <label for="thr-3">3</label><br />
                    <input type="radio" id="thr-4" name="threat_assessment" value="4" <?php if ($sLevel == "4") { ?>checked<?php } ?> /> <label for="thr-4">4</label><br />
                    <input type="radio" id="thr-5" name="threat_assessment" value="5" <?php if ($sLevel == "5") { ?>checked<?php } ?> /> <label for="thr-5">5</label><br />
                </div>
                <div class="check-faction small">
                    <span class="check-subtitle">
                        Clearance level:
                    </span>
                    <?php
                    $sClear = $aRes[1]["bastion_clearance"];
                    ?>
                    <input type="radio" id="clr-0" name="bastion_clearance" value="0" <?php if ($sClear == "0") { ?>checked<?php } ?> /> <label for="clr-0">0</label><br />
                    <input type="radio" id="clr-1" name="bastion_clearance" value="1" <?php if ($sClear == "1") { ?>checked<?php } ?> /> <label for="clr-1">1</label><br />
                    <input type="radio" id="clr-2" name="bastion_clearance" value="2" <?php if ($sClear == "2") { ?>checked<?php } ?> /> <label for="clr-2">2</label><br />
                    <input type="radio" id="clr-3" name="bastion_clearance" value="3" <?php if ($sClear == "3") { ?>checked<?php } ?> /> <label for="clr-3">3</label><br />
                </div>
                <div class="check-faction clear">
                    <span class="check-subtitle">
                        Notes:
                    </span>
                    <textarea class="textarea-pretty"
                        name="douane_notes"><?php echo nl2br($aRes[1]["douane_notes"]) ?></textarea>
                </div>
                <input class="edit-submit" type="submit" value="UPDATE" />
                <input name="characterID" type="hidden" value="<?php echo $aRes[1]["characterID"] ?>" />
                <input type="hidden" name="xf" value="editCharacter" />
        </div>
        </form>
        <div class="checking-success">
            <strong><?php echo $aRes[1]["character_name"] ?> has been updated.</strong><br />
            Returning to "Check Person" in 3 seconds.
        </div>
    </div>
    <div class="clear">

    </div>
</div>



</div>
<?php
include ('includes/inc.footer.php');
?>
</body>

</html>