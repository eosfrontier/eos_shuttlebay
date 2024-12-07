<?php
require 'vendor/autoload.php';
include ('includes/include.php');
include ('includes/inc.header.php');

$page = $_SERVER['PHP_SELF'];
$sec = "5";
header("Refresh: $sec; url=$page");
?>
<div id="main">
    <div class="container">
    <?php include("partials/shuttles-all.php"); ?>
    </div>
    <div class="clear">

    </div>
 <?php echo "This page will autorefresh every $sec seconds!"; ?>
   
</div>
</div>
<?php
include ('includes/inc.footer.php');
?>
</body>

</html>