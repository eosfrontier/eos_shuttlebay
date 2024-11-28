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
                <?php
                if (!isset($_POST["selected_shuttle"])){
                    if ($cShuttles->checkPilotLicense($aRes[1]["characterID"])){
                    include('partials/shuttles-available.php'); }
                    else{
                        echo '<h3 style="color:red;">AUTHORIZATION DENIED:</h3>
                        <h4 style="color:red;">Only licensed pilots may access a shuttle.</h4>';
                    }
                }
                ?>
                </div>
                <?php if (isset($_POST["selected_shuttle"])){
                include("shuttle-checkout.php");
                } ?>
            </div>