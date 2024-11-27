<?php
    include('includes/include.php');

    $cShuttlebay = new shuttlebay();
    $aPersonals = $cShuttlebay->getAllPersonal();

?>

    <?php
        include('includes/inc.header.php');
    ?>
    <div id="main">
        <div class="container">
            <div class="welcome">
                All personnel currently on the Bastion.<br />
            </div>
            <table width="100%">
                <thead>
                    <td>
                        <strong>Name</strong>
                    </td>
                    <td>
                        <strong>Faction</strong>
                    </td>
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
                    foreach($aPersonals as $aPersonal){
                ?>
                <tr class="travel-line">
                    <td>
                        <form action="./check.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $aPersonal["ICC_number"] ?>" />
                            <input class="name-submit" type="submit" value="<?php echo $aPersonal["character_name"] ?>" />
                        </form>
                    </td>
                    <td class="travel-line-faction">
                        <?php echo $aPersonal["faction"] ?>
                    </td>
                    <td>
                        <?php echo $aPersonal["date"] ?>
                    </td>
                    <td>
                        <?php echo $aPersonal["time"] ?>
                    </td>
                    <td class="travel-line-access">
                        <?php
                            if($aPersonal["access"] == 1){
                                echo "Checked in";
                            }else{
                                echo "Checked out";
                            }
                         ?>
                    </td>
                    <td>
                    <?php if(!empty($aPersonal["reason"])){ ?>

                        <i class="fas fa-clipboard">
                            <div class="tooltip">
                                <?php echo nl2br($aPersonal["reason"]); ?>
                            </div>
                        </i>
                    <?php } ?>
                    </td>
                    <td>
                    <?php if(!empty($aPersonal["note"])){ ?>
                        <i class="fas fa-sticky-note">
                            <div class="tooltip">
                                <?php echo nl2br($aPersonal["note"]); ?>
                            </div>
                        </i>
                    <?php } ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
    <?php
        include('includes/inc.footer.php');
    ?>
</body>
</html>
