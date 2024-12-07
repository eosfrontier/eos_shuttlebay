<?php
include('includes/include.php');


switch ($_POST["xf"]) {
    case "checkout":
        $result = $cShuttles->checkInOut($_POST);
        echo $result;
        break;
    case "checkin":
        $result = $cShuttles->checkInOut($_POST);
        echo $result;
        break;
}

