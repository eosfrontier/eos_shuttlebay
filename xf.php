<?php
    include('includes/include.php');

    // switch($_POST["xf"]){
    //     case "checkout":
            $result = $cShuttles->checkInOut($_POST);
            echo $result;
            // echo "<pre>". print_r($result) . "</pre>";
    //         break;
    //     case "checkin":
    //         $result = $cShuttles->checkInOut($_POST);
    //         echo $result;
    //         //var_dump($result);
    //         break;
    // }

