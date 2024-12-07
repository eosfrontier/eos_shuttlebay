<?php
include('includes/include.php');

$shuttleLogs = $cShuttles->getShuttleLogs();

?>

<?php
include('includes/inc.header.php');
?>
<div id="main">
    <div class="container">
        <table width="100%" class="shuttle-logs">
            <thead>
                <th>
                    <strong>Date</strong>
                </th>
                <th>
                    <strong>Time</strong>
                </th>
                <th>
                    <strong>Shuttle</strong>
                </th>
                <th>
                    <strong>New Status</strong>
                </th>
                <th>
                    <strong>Mission Name</strong>
                </th>
                <th>
                    <strong>Mission Leader</strong>
                </th>
                <th>
                    <strong>Status Updated By</strong>
                </th>
                <th>
                    <strong>Comment</strong>
                </th>
            </thead>
            <?php
            foreach ($shuttleLogs as $shuttleLog) {
                ?>
                <tr>
                    <td>
                        <?php echo $shuttleLog["ic_date"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["ic_time"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["shuttle_name"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["status"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["mission_name"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["mission_leader"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["status_updated_by"]; ?>
                    </td>
                    <td>
                        <?php echo $shuttleLog["comment"]; ?>
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