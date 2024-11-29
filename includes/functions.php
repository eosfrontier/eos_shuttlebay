<?php

function displayShuttles($array, $disabled = NULL){
    
    $current_url = $_SERVER['REQUEST_URI'];
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
        <form action="<?php echo $current_url; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>" />
        <button name="selected_shuttle" value="<?php echo $shuttle['id']; ?>" class='button--shuttle <?php echo $buttonClass; ?>' <?php if ($disabled == "disabled"){ echo "disabled style='pointer-events: none;'";} ?>>
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
        echo $shuttle['status_name'] . "<br>";
        ?>
                </td>
            </tr>
        </table>
    </button>
</br>
<?php
        }
}