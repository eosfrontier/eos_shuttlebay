<?php
function displayShuttles($array){
    foreach ($array as $shuttle){
        if ($shuttle['operable'] = 1){
            $buttonClass="good";
        }
        elseif ($shuttle['operable'] = 0){
            $buttonClass="warn";
        }
        elseif ($shuttle['operable'] = -1){
            $buttonClass = "error";
        }
        ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>" />
        <button name="selected_shuttle" value="<?php echo $shuttle['id']; ?>" class='button--shuttle <?php echo $buttonClass; ?>'>
        <table>
            <tr>
        <?php
        echo "<h3>". $shuttle['serial_number'] . ": " . $shuttle['name'] . "</h3>";
        echo "<td><strong>Class:<br>
        Type:<br>
        Cap:<br>
        Home Base:<br>
        Status:</strong></td>
        <td>";
        echo $shuttle['class'] . "<br>";
        echo $shuttle['type'] . "<br>";
        echo $shuttle['capacity'] . "👤<br>";
        echo $shuttle['base'] . "<br>";
        echo $shuttle['status'] . "<br>";
        ?>
                </td>
            </tr>
        </table>
    </button>
</br>
<?php
        }
}