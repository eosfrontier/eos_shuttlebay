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
                <form action="./check.php" method="post">
                    <input name="id" type="text" class="badge-scan" autofocus />
                </form>
            </div>
        <?php } ?>
        <?php if ($post == 1) { ?>
            <?php if ($aRes[1]["douane_disposition"] == "DETAIN") { ?>
                <div class="check-warning">
                    WARNING -- DETAIN -- WARNING
                </div>
            <?php } ?>
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

                <img class="faction-logo" src="./images/logos/<?php echo $aRes[1]["faction"] ?>.png" />
            </div>
            <div class="check-right">
                <div class="check-name check-doublecolumn">
                    <?php echo $aRes[1]["character_name"] ?> <a
                        href="edit_character.php?id=<?php echo $aRes[1]["characterID"]; ?>"><i
                            class="fas fa-wrench"></i></a>
                </div>
                <table>
                    <tr>
                        <td>
                            <div class="check-faction">
                                <span class="check-subtitle">
                                    Faction:
                                </span>
                                <?php echo $aRes[1]["faction"] ?>
                            </div>
                            <?php if ($aRes[1]["rank"]) { ?>
                                <div class="check-faction">
                                    <span class="check-subtitle">
                                        Rank / Job:
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
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>
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
                                        Home Planet:
                                    </span>
                                    <?php echo $aRes[1]["homeplanet"] ?>
                                </div>
                            <?php } ?>
                            <?php if ($aRes[1]["ICC_number"]) { ?>
                                <div class="check-faction">
                                    <span class="check-subtitle">
                                        ICC ID:
                                    </span>
                                    <?php echo $aRes[1]["ICC_number"] ?>
                                </div>
                            <?php } ?>
                            <?php if ($aRes[1]["card_id"]) { ?>
                    <div class="check-faction">
                        <span class="check-subtitle">
                            Card ID:
                        </span>
                        <?php echo $aRes[1]["card_id"] ?>
                    </div>
                    <?php } ?>
                        </td>
                    </tr>
                <tr>
                <?php if ($aRes[1]["douane_notes"]) { ?>
                    <div class="check-faction check-doublecolumn">
                        <span class="check-subtitle">
                            Notes:
                        </span>
                        <?php echo nl2br($aRes[1]["douane_notes"]) ?>
                    </div>
                <?php } ?>
                </tr></table>
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
        <?php } ?>
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