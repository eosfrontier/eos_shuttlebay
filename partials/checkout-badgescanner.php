<div class="welcome">
                Please scan the identity badge.
                <form action="./checkout.php" method="post">
                    <input name="id" type="text" class="badge-scan" autofocus />
                    <?php
                    if (isset($aRes) && $aRes == "empty") {
                    echo "<h5 style='color:red;'>ACCESS DENIED: Invalid Card ID or ICC Number. Please try again...</h5>";
                    }

                    ?>
                </form>
            </div>