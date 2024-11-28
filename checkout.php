<?php
require 'vendor/autoload.php';
include ('includes/include.php');
include('includes/functions.php');

$shuttles = $cShuttles->getAllShuttles();

$post = 0;
$cShuttlebay = new shuttlebay();
if (isset($_POST["id"])) {
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
        <?php if ($post == 0) {
            include('partials/checkout-badgescanner.php');
         }
         if ($post == 1) {
            include('partials/checkout-left.php');
        ?>
        <div class="checkinout-right">
            <?php
            include('partials/check-image.php');
            include('partials/check-right.php');
            ?>
        </div>
        <?php } ?>
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
    </script>
    <?php } ?>
</body>

</html>