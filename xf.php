<?php
    include('includes/include.php');

    switch($_POST["xf"]){
        case "checkout":
            $result = $cShuttles->checkOut($_POST);
            echo $result;
            // echo "<pre>". print_r($result) . "</pre>";
            break;
        // case "editCharacter":
        //     $result = $cShuttles->editCharacter($_POST);
        //     echo $result;
        //     //var_dump($result);
        //     break;
    }

?>
