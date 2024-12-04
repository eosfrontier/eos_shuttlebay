<?php
require 'vendor/autoload.php';
include('includes/include.php');

$shuttles = $cShuttles->getAllShuttles();

if (isset($_POST["selected_shuttle"])) {
    $selectedShuttle = $cShuttles->getShuttle($_POST['selected_shuttle']);
    $sImage = "./images/shuttles/" . $selectedShuttle[0]['class_id'] . ".jpg";
}
$post = 0;
if (isset($_POST["id"])) {
    $aRes = $cShuttles->getCharacter($_POST["id"]);
    if ($aRes != "empty") {
        $post = 1;
        $pilotLicense = $cShuttles->checkPilotLicense($aRes["characterID"]);
        $combatRated = $cShuttles->checkCombatPilot($aRes["characterID"]);
    }
}

include('includes/inc.header.php');
?>
<div id="main">
    <div class="container">
        <?php if ($post == 0) {
            if (isset($_GET["operation"])) {
                include('partials/checkout-badgescanner.php');
            } else {
                ?>
                <h1>Choose an operation</h1>
                <a href="checkinout.php?operation=checkout"><button name="operation" value="checkout"
                        class='button--shuttle good' style="min-height:80px;">
                        <h2>Check Out</h2>
                    </button></a>
                <a href="checkinout.php?operation=checkin"><button name="operation" value="checkin" class='button--shuttle warn'
                        style="min-height:80px;">
                        <h2>Check In</h2>
                    </button></a>
                <?php
            }
        }
        if ($post == 1) {
            include('partials/checkout-left.php');
            echo '<div class="checkinout-right">';
            include('partials/check-image.php');
            include('partials/check-right.php');
            echo "</div>";
        } ?>
    </div>
</div>
</div>
<?php if (isset($_POST)) { ?>
    <script src="scripts/scripts.js"></script>
<?php } ?>
</body>

</html>
<?php include('includes/inc.footer.php'); ?>