<?php
require 'vendor/autoload.php';
include ('includes/include.php');
$post = 0;
if (isset($_POST["id"])) {
    $cShuttlebay = new shuttlebay();
    $sId = $_POST["id"];
    $aRes = $cShuttlebay->getChecking($sId);
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
                    <?php
                    if (isset($aRes) && $aRes == "empty") {
                    echo "<h5 style='color:red;'>ACCESS DENIED: Invalid Card ID or ICC Number. Please try again...</h5>";
                    }

                    ?>
                </form>
            </div>
        <?php } ?>
        <?php if ($post == 1) { ?>
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
                <div class = "shuttle-list">
                <?php include('partials/shuttles.php'); ?>
                </div>
                <?php if (isset($_POST["chosen_shuttle"])){ ?>
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
                <?php } ?>
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

                    <img class="faction-logo" src="./images/logos/<?php echo $aRes[1]["faction"] ?>.png" />
                </div>
                <?php include('partials/check-right.php'); ?>
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