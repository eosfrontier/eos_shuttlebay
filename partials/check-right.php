<div class="check-right">
                    <div class="check-doublecolumn">
                        <div class="check-name">
                            <?php echo $aRes[1]["character_name"] ?>
                        </div>
                        <table border="1" padding="15px" align="center">
                        <thead>
                            <th min-width="20%"><span class="check-subtitle">Faction</span></th>
                            <th min-width="20%"><span class="check-subtitle">Rank</span></th>
                            <th min-width="60%"><span class="check-subtitle">ICC ID</span></th>

                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="check-faction"> 
                                        <?php echo $aRes[1]["faction"] ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($aRes[1]["rank"]) { ?>
                                        <div class="check-faction">
                                            <?php echo $aRes[1]["rank"] ?>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($aRes[1]["ICC_number"]) { ?>
                                        <div class="check-faction">
                                            <?php echo $aRes[1]["ICC_number"] ?>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h4>Pilot's License: <?php 
                    if ($cShuttles->checkPilotLicense($aRes[1]["characterID"])){
                        echo '<font style="color:green;">VALID</font>';
                    }
                    else {
                        echo '<font style="color:red;">NO LICENSE FOUND</font>';

                    }
                    ?>
                    </h4>
                    <h4>Combat Pilot Status: <?php 
                    if ($cShuttles->checkCombatPilot($aRes[1]["characterID"])){
                        echo '<font style="color:green;">CERTIFIED</font>';
                    }
                    else {
                        echo '<font style="color:red;">NOT CERTIFIED</font>';
                    }
                    ?>
                    </h4><br>
                    <h4 style="color:greenyellow;">User recognized. Please choose a shuttle.</h4>
                </div>

                    <?php if ($aRes[1]["douane_notes"]) { ?>
                        <div class="check-faction check-doublecolumn">
                            <span class="check-subtitle">
                                Notes:
                            </span>
                            <?php echo nl2br($aRes[1]["douane_notes"]) ?>
                        </div>
                    <?php } ?>
                    <!-- <?php
                    if (isset($travels)) {
                        ?>
                        <div class="check-faction check-doublecolumn">
                            <span class="check-subtitle">
                                Travel logs:
                            </span>
                            <table class="checking-table" width="100%">
                                <thead>
                                    <td>
                                        <strong>Date</strong>
                                    </td>
                                    <td>
                                        <strong>Time</strong>
                                    </td>
                                    <td>
                                        <strong>Access</strong>
                                    </td>
                                    <td>
                                        <strong>Reason</strong>
                                    </td>
                                    <td>
                                        <strong>Note</strong>
                                    </td>
                                </thead>

                                <?php
                                foreach ($travels as $travel) {
                                    ?>
                                    <tr class="travel-line">
                                        <td class="travel-line-date">
                                            <?php echo $travel["date"]; ?>
                                        </td>
                                        <td class="travel-line-time">
                                            <?php echo $travel["time"]; ?>
                                        </td>
                                        <td class="travel-line-access">
                                            <?php
                                            if ($travel["access"] == 1) {
                                                echo "Checked in";
                                            } else {
                                                echo "Checked out";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($travel["reason"])) { ?>

                                                <i class="fas fa-clipboard">
                                                    <div class="tooltip">
                                                        <?php echo nl2br($travel["reason"]); ?>
                                                    </div>
                                                </i>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($travel["note"])) { ?>
                                                <i class="fas fa-sticky-note">
                                                    <div class="tooltip">
                                                        <?php echo nl2br($travel["note"]); ?>
                                                    </div>
                                                </i>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?> -->
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>