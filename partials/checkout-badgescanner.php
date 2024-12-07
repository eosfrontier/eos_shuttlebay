<div class="welcome">
                Please scan the identity badge.
                <form action="./checkinout.php?operation=<?php echo $_GET["operation"]; ?>" method="post">
                    <input name="id" type="text" class="badge-scan" autofocus autocomplete="off" />
                    <?php
                    if (isset($aRes) && $aRes == "empty") {
                    echo "<h5 style='color:red;'>ACCESS DENIED: Invalid Card ID or ICC Number. Please try again...</h5>";
                    }
                    ?>
                </form>
            </div>