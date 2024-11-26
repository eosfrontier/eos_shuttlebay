<?php
    include('includes/include.php');
    $cDouane = new douane();

    switch($_POST["xf"]){
        case "checkin":
            $result = $cDouane->checkIn($_POST);
            echo $result;
            //var_dump($result);
            break;
        case "editCharacter":
            $result = $cDouane->editCharacter($_POST);
            echo $result;
            //var_dump($result);
            break;
    }

?>
