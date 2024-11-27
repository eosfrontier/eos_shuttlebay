<?php
    require 'vendor/autoload.php';
    include('includes/include.php');
?>
    <?php
        include('includes/inc.header.php');
    ?>
        <div id="main">
            <div class="container">
                <div class="welcome">
                    Welcome to Shuttlebay Launch Control.<br / />
                    <span class="red">If you have not been authorized by the CiC, please log off and report to CiC to request launch authorization.</span><br  />
                </div>
            </div>
            <?php echo "<strong>Date:</strong> " . $ICDateString; ?>
        </div>
    </div>
    <?php
    include('includes/inc.footer.php');
    ?>

</body>
</html>
