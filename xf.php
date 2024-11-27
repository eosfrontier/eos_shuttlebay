<?php
    include('includes/include.php');
    $cShuttlebay = new shuttlebay();

    switch($_POST["xf"]){
        case "checkin":
            $result = $cShuttlebay->checkIn($_POST);
            echo $result;
            //var_dump($result);
            break;
        case "editCharacter":
            $result = $cShuttlebay->editCharacter($_POST);
            echo $result;
            //var_dump($result);
            break;
    }

?>
