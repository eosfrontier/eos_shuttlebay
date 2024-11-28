<?php

class shuttlebay{
    public function runQuery($sql) {
        $stmt = db::$conn->prepare("$sql");
		$res = $stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }
    public function getICDate(){
        $request = new HTTP_Request2();
        $request->setUrl('https://api.eosfrontier.space/watchtower/time/');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
        'follow_redirects' => TRUE
        ));
        try {
        $ICDate = $request->send();
        if ($ICDate->getStatus() == 200) {
            $ICDateJSON = $ICDate->getBody();
            $ICDateArray = json_decode($ICDateJSON);
            $ICDateString =  $ICDateArray->iDay . '-' . $ICDateArray->iMonth . '-' . $ICDateArray->iYear . $ICDateArray->iYearAfter;
        }
        else {
            echo 'Unexpected HTTP status: ' . $ICDate->getStatus() . ' ' .
            $ICDate->getReasonPhrase();
        }
        }
        catch(HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
        }
        return $ICDateString;
    }
    public function getAllShuttles(){
        $sql=<<<SQL
        SELECT s.id, s.name, s.serial_number, c.name AS class, c.`type` as type, c.capacity, b.name AS base, 
        cond.name AS state, cond.operable AS operable, stat.`status`, chars.character_name AS assigned_to_name, chars.characterID AS assigned_to_id, skill.label AS required_skill, c.required_skill AS required_skill_id
        FROM esb_shuttles s
        JOIN esb_shuttle_classes c ON s.class = c.id
        JOIN esb_shuttle_bases b ON b.id = s.base_location
        JOIN esb_shuttle_conditions cond ON cond.id = s.condition
        JOIN esb_shuttle_status stat ON stat.id = s.status
        LEFT JOIN ecc_characters chars ON chars.characterID = s.assigned_to
        JOIN ecc_skills_allskills skill ON ((skill.skill_id = c.required_skill) AND (c.id = s.class))
        ORDER by s.name;
        SQL;

        $res = $this->runQuery($sql);
        return $res;
    }

    public function getShuttle($id){
        $sql=<<<SQL
        SELECT s.id, s.name, s.serial_number, c.name AS class, c.id as class_id, c.`type` as type, c.capacity, b.name AS base, 
        cond.name AS state, cond.operable AS operable, stat.`status`, chars.character_name AS assigned_to_name, chars.characterID AS assigned_to_id, skill.label AS required_skill, c.required_skill AS required_skill_id
        FROM esb_shuttles s
        JOIN esb_shuttle_classes c ON s.class = c.id
        JOIN esb_shuttle_bases b ON b.id = s.base_location
        JOIN esb_shuttle_conditions cond ON cond.id = s.condition
        JOIN esb_shuttle_status stat ON stat.id = s.status
        LEFT JOIN ecc_characters chars ON chars.characterID = s.assigned_to
        JOIN ecc_skills_allskills skill ON ((skill.skill_id = c.required_skill) AND (c.id = s.class))
        WHERE s.id = $id
        ORDER by s.name;
        SQL;

        $res = $this->runQuery($sql);
        return $res;
    }

    public function checkPilotLicense($charID){
        $stmt=<<<SQL
        SELECT * FROM ecc_char_skills s
        WHERE s.charID = $charID AND (s.skill_id = 31152)
        SQL;
        $stm2=<<<SQL
        SELECT * FROM ecc_char_implants i
        WHERE STATUS = 'active' AND
        charID = $charID AND
        skillgroup_siteindex = 'dex' AND
        skillgroup_level = 1
        SQL;

        $license = $this->runQuery($stmt);
        $implant = $this->runQuery($stm2);
            if ($license != null){
                return true;
            }
            else if ($implant != null ){
                return true;
            }
            else {
                return false;
            }
    }

    public function checkCombatPilot($charID){
        $stmt=<<<SQL
        SELECT * FROM ecc_char_skills s
        WHERE s.charID = $charID AND (s.skill_id = 31162)
        SQL;
        $stm2=<<<SQL
        SELECT * FROM ecc_char_implants i
        WHERE STATUS = 'active' AND
        charID = $charID AND
        skillgroup_siteindex = 'dex' AND
        skillgroup_level = 6
        SQL;

        $license = $this->runQuery($stmt);
        $implant = $this->runQuery($stm2);
            if ($license != null){
                return true;
            }
            // else if ($implant != null ){
            //     return true;
            // }
            else {
                return false;
            }
    }

    // public function getById($post){
    //     $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE characterID = ?");
	// 	$res = $stmt->execute(array($post));
	// 	$res = $stmt->fetch();

    //     return $res;
    // }

    // public function getByScan($post){
    //     $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE ICC_number = ?");
	// 	$res = $stmt->execute(array($post));
	// 	$res = $stmt->fetch();

    //     if($res == null){
    //         $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id = ?");
    //         $res = $stmt->execute(array($post));
    // 		$res = $stmt->fetch();
    //     }

    //     if($res == null){
    //         $sHex = dechex($post);
    //         $aDec = str_split($sHex, 2);
    //         $sDec = "%".$aDec[3].$aDec[2].$aDec[1].$aDec[0]."%";

    //         $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id LIKE ?");
    //         $res = $stmt->execute(array($sDec));
    // 		$res = $stmt->fetch();

    //         //return $sDec;
    //     }

    //     if($res == null){
    //         return "false";
    //     }

    //     return $res;
    // }

    public function getChecking($post){
        if(empty($post)){
            return "empty";
        }
        else{
            $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE ICC_number = ?");
            $res = $stmt->execute(array($post));
            $res = $stmt->fetch();
            if($res == null){
                $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id = ?");
                $res = $stmt->execute(array($post));
                $res = $stmt->fetch();
                if($res == null){
                    if(is_numeric($post)){
                    $sHex = dechex($post);
                    $aDec = str_split($sHex, 2);
                    $sDec = "%".$aDec[3].$aDec[2].$aDec[1].$aDec[0]."%";

                    $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id LIKE ?");
                    $res = $stmt->execute(array($sDec));
                    $res = $stmt->fetch();
                    }
                    else {
                        $res = null;
                    }
                    if($res == null){
                        return "empty";
                    }
                }
            }

            $char = $res;

            $id = $res["characterID"];

            $stmt = db::$conn->prepare("SELECT * FROM douane_logging WHERE character_id = ? ORDER BY id DESC");
            $res = $stmt->execute(array($id));
            $res = $stmt->fetchAll();

            if($res == false){
                $return = array(
                    array(
                        "returning" => "empty",
                        "access" => 0)
                    , $char);
                return $return;
            }

            $first = $res[0];
            $lastAccess = $first["access"];

            return array(
                array(
                    "returning" => "exist",
                    "access" => $lastAccess)
                , $char, $res);
                }
    }

    // public function getEditById($post){
    //     $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE characterID = ?");
	// 	$res = $stmt->execute(array($post));
	// 	$res = $stmt->fetch();

    //     $char = $res;

    //     $id = $res["characterID"];

    //     $stmt = db::$conn->prepare("SELECT * FROM douane_logging WHERE character_id = ? ORDER BY id DESC");
    //     $res = $stmt->execute(array($id));
    //     $res = $stmt->fetchAll();

    //     if($res == false){
    //         $return = array(
    //             array(
    //                 "returning" => "empty",
    //                 "access" => 0)
    //             , $char);
    //         return $return;
    //     }

    //     $first = $res[0];
    //     $lastAccess = $first["access"];

    //     return array(
    //         array(
    //             "returning" => "exist",
    //             "access" => $lastAccess)
    //         , $char, $res);
    // }

    // public function checkIn($post){
    //     //return $post;
    //     $character_id   = $post["character_id"];
    //     $time           = $post["time"];
    //     $date           = $post["date"];
    //     $reason         = $post["reason"];
    //     $access         = $post["access"];
    //     $note           = $post["note"];

    //     $stmt = db::$conn->prepare("INSERT INTO douane_logging (character_id, time, date, reason, access, note) VALUES (?, ?, ?, ?, ?, ?)");
    //     $stmt->execute(array($character_id, $time, $date, $reason, $access, $note));

    //     return "success";
    // }

    // public function getAllPersonal(){
    //     $stmt = db::$conn->prepare("SELECT * FROM douane_logging LEFT JOIN ecc_characters ON douane_logging.character_id = ecc_characters.characterID WHERE id IN ( SELECT MAX(id) FROM douane_logging GROUP BY character_id ) AND access = 1 ORDER BY ecc_characters.faction ASC, ecc_characters.character_name");
    //     $res = $stmt->execute();
    //     $res = $stmt->fetchAll();
    //     return $res;
    // }

    // public function editCharacter($post){
    //     $douane_notes = $_POST["douane_notes"];
    //     $douane_disposition = $_POST["douane_disposition"];
    //     $threat_assessment = $_POST["threat_assessment"];
    //     $bastion_clearance = $_POST["bastion_clearance"];
    //     $rank = $_POST["rank"];
    //     $characterID = $_POST["characterID"];

    //     $sql = "update ecc_characters SET douane_disposition=?, douane_notes=?, threat_assessment=?, bastion_clearance=?, rank=? WHERE characterID=?";
    //     $stmt = db::$conn->prepare($sql);
    //     $result = $stmt->execute([$douane_disposition, $douane_notes, $threat_assessment, $bastion_clearance, $rank, $characterID]);

    //     if($result != false){
    //         return "success";
    //     }
    // }

}


