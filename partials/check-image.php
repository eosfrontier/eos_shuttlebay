<div class="check-image">
                    <?php
                    $status = $aRes["status"];
                    if (str_contains($status, "figu")) {
                        $pImage = "./images/mugs/npc/" . $aRes["figu_accountID"] . ".jpg";
                    } else {
                        $pImage = "./images/mugs/" . $aRes["characterID"] . ".jpg";
                    }
                    if (file_exists($pImage)) {
                        echo '<img class="portrait" src="' . $pImage . '" />';
                    } else { ?>
                        <img class="portrait" src="./images/pending.png" />
                    <?php } ?>

                    <img class="faction-logo" src="./images/logos/<?php echo $aRes["faction"] ?>.png" />
                </div>