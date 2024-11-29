<div class="check-right">
                    <div class="check-doublecolumn">
                    <h4 style="color:greenyellow;">User authenticated.</h4>
                    <div class="check-name">
                            <?php echo $aRes["character_name"] ?>
                        </div>
                                    <div class="check-faction"> 
                                        <?php echo "<strong>Faction:</strong>". $aRes["faction"] . "</br>" ?>
                                    <?php if ($aRes["rank"]) { ?>
                                            <?php echo "<strong>Rank:</strong>". $aRes["rank"] ."</br>"?>
                                    <?php } ?>
                                    <?php if ($aRes["ICC_number"]) { ?>
                                            <?php echo "<strong>ICC Number:</strong>". $aRes["ICC_number"] ?>
                                        </div>
                                    <?php } ?>
                    <h4>Pilot's License: <?php 
                    if ($pilotLicense){
                        echo '<font style="color:green;">VALID</font>';
                    }
                    else {
                        echo '<font style="color:red;">NO LICENSE FOUND</font>';

                    }
                    ?>
                    </h4>
                    <h4>Combat Pilot Status: <?php 
                    if ($combatRated){
                        echo '<font style="color:green;">CERTIFIED</font>';
                    }
                    else {
                        echo '<font style="color:red;">NOT CERTIFIED</font>';
                    }
                    ?>
                    </h4>
                </div>

                    <?php if ($aRes["douane_notes"]) { ?>
                        <div class="check-faction check-doublecolumn">
                            <span class="check-subtitle">
                    </br><strong>Notes:</strong>
                            </span>
                            <?php echo nl2br($aRes["douane_notes"]) ?>
                        </div>
                    <?php } ?>
                </div>

<?php   if (isset($selectedShuttle)){ ?>
<h3>Selected Shuttle:</h3>
<table class="selected-shuttle">
    <tr>
        <td>
            <?php
            if (file_exists($sImage)) {
                echo '<img class="ship-image" src="' . $sImage . '" />';
            } else {
                echo '<img class="ship-image" src="./images/shuttles/0.jpg" />';
            }
            ?>
            </td>
            <td>
                <?php displayShuttles($selectedShuttle, 'disabled'); ?>
            </td>
        </tr>
    </table>
<?php } ?>
