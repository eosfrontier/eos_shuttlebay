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