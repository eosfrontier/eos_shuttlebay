<div class="checkinout-left">
                <?php
                if (isset($selectedShuttle)){
                    if ($selectedShuttle[0]['status'] == 0) {
                        $value = "Check out";
                        $status = "2";
                        $success = "checked out shuttle succcessfully";
                    }
                else if ($selectedShuttle[0]['status'] == 2) {
                    $value = "Check in";
                    $status = "2";
                    $success = "Checked in";
                } elseif ($selectedShuttle[0]['status'] == 3) {
                    $value = "Mark Post-Flight Checks as complete";
                    $status = "3";
                    $success = "completed post-flight checks";
                }
            }
                ?>
                <div class = "shuttle-list">
                <?php
                if (!isset($_POST["selected_shuttle"])){
                    if ($pilotLicense){
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