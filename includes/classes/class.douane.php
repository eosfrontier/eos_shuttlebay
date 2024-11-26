<?php

class douane{
    public function getAll(){
        $stmt = db::$conn->prepare("SELECT * FROM ecc_characters ORDER BY character_name ASC");
		$res = $stmt->execute();
		$res = $stmt->fetchAll();

        return $res;
    }

    public function getById($post){
        $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE characterID = ?");
		$res = $stmt->execute(array($post));
		$res = $stmt->fetch();

        return $res;
    }

    public function getByScan($post){
        $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE ICC_number = ?");
		$res = $stmt->execute(array($post));
		$res = $stmt->fetch();

        if($res == null){
            $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id = ?");
            $res = $stmt->execute(array($post));
    		$res = $stmt->fetch();
        }

        if($res == null){
            $sHex = dechex($post);
            $aDec = str_split($sHex, 2);
            $sDec = "%".$aDec[3].$aDec[2].$aDec[1].$aDec[0]."%";

            $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id LIKE ?");
            $res = $stmt->execute(array($sDec));
    		$res = $stmt->fetch();

            //return $sDec;
        }

        if($res == null){
            return "false";
        }

        return $res;
    }

    public function getChecking($post){
        if(empty($post)){
            return "empty";
        }

        $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE ICC_number = ?");
		$res = $stmt->execute(array($post));
		$res = $stmt->fetch();

        if($res == null){
            $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id = ?");
            $res = $stmt->execute(array($post));
    		$res = $stmt->fetch();
        }

        if($res == null){
            $sHex = dechex($post);
            $aDec = str_split($sHex, 2);
            $sDec = "%".$aDec[3].$aDec[2].$aDec[1].$aDec[0]."%";

            $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id LIKE ?");
            $res = $stmt->execute(array($sDec));
    		$res = $stmt->fetch();

            //return $sDec;
        }

        if($res == null){
            return "empty";
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

    public function getEditById($post){
        $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE characterID = ?");
		$res = $stmt->execute(array($post));
		$res = $stmt->fetch();

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

    public function checkIn($post){
        //return $post;
        $character_id   = $post["character_id"];
        $time           = $post["time"];
        $date           = $post["date"];
        $reason         = $post["reason"];
        $access         = $post["access"];
        $note           = $post["note"];

        $stmt = db::$conn->prepare("INSERT INTO douane_logging (character_id, time, date, reason, access, note) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($character_id, $time, $date, $reason, $access, $note));

        return "success";
    }

    public function getAllPersonal(){
        $stmt = db::$conn->prepare("SELECT * FROM douane_logging LEFT JOIN ecc_characters ON douane_logging.character_id = ecc_characters.characterID WHERE id IN ( SELECT MAX(id) FROM douane_logging GROUP BY character_id ) AND access = 1 ORDER BY ecc_characters.faction ASC, ecc_characters.character_name");
        $res = $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public function editCharacter($post){
        $douane_notes = $_POST["douane_notes"];
        $douane_disposition = $_POST["douane_disposition"];
        $threat_assessment = $_POST["threat_assessment"];
        $bastion_clearance = $_POST["bastion_clearance"];
        $rank = $_POST["rank"];
        $characterID = $_POST["characterID"];

        $sql = "update ecc_characters SET douane_disposition=?, douane_notes=?, threat_assessment=?, bastion_clearance=?, rank=? WHERE characterID=?";
        $stmt = db::$conn->prepare($sql);
        $result = $stmt->execute([$douane_disposition, $douane_notes, $threat_assessment, $bastion_clearance, $rank, $characterID]);

        if($result != false){
            return "success";
        }
    }

}


