<?php

class shuttlebay
{
    public function runQuery($sql)
    {
        $stmt = db::$conn->prepare("$sql");
        $res = $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    public function get_characters_upcoming_event()
    {
        $sql = <<<SQL
        SELECT * FROM ecc_characters WHERE characterID IN (
        SELECT SUBSTRING_INDEX(v1.field_value,' - ',-1)  as characterID from jml_eb_registrants r
                    join joomla.jml_eb_field_values v1 on (v1.registrant_id = r.id and v1.field_id = 21)
                    join jml_eb_field_values v5 on (v5.registrant_id = r.id and v5.field_id = 14)
                    where v5.field_value = 'Speler' AND 
                    r.event_id = (SELECT e.id from jml_eb_events e
                            JOIN jml_eb_event_categories c ON (c.event_id = e.id)
                            WHERE SUBSTRING_INDEX(event_end_date,' ',1) >= CURDATE() AND c.category_id = 1 ORDER BY SUBSTRING_INDEX(event_date,' ',1) ASC LIMIT 1) and ((r.published = 1 AND (r.payment_method = 'os_bancontact' OR r.payment_method = 'os_ideal' OR r.payment_method = 'os_paypal')) OR 
                    (r.published in (0,1) AND r.payment_method = 'os_offline'))) ORDER by character_name
        SQL;
        $res = $this->runQuery($sql);
        return $res;
    }

    public function getMissions()
    {
        $request = new HTTP_Request2();
        $request->setUrl('https://api.eosfrontier.space/watchtower/missions/');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                return $response->getBody();
            } else {
                return 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function getICDate()
    {
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
                $ICDateString = $ICDateArray->iDay . '-' . $ICDateArray->iMonth . '-' . $ICDateArray->iYear . $ICDateArray->iYearAfter;
            } else {
                echo 'Unexpected HTTP status: ' . $ICDate->getStatus() . ' ' .
                    $ICDate->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $ICDateString;
    }
    public function getAllShuttles()
    {
        $sql = <<<SQL
                SELECT s.id, s.name, s.serial_number, c.name AS class, c.id as class_id, c.`type` as type, c.capacity, b.name AS base, 
        cond.name AS state, cond.operable AS operable, stat.`status` AS status_name, s.status AS status, chars.character_name AS assigned_to_name, chars.characterID AS assigned_to_id, skill.label AS required_skill, c.required_skill AS required_skill_id
        FROM esb_shuttles s
        JOIN esb_shuttle_classes c ON s.class = c.id
        JOIN esb_shuttle_bases b ON b.id = s.base_location
        JOIN esb_shuttle_conditions cond ON cond.id = s.condition
        JOIN esb_shuttle_status stat ON stat.id = s.status
        LEFT JOIN ecc_characters chars ON chars.characterID = s.assigned_to
        JOIN ecc_skills_allskills skill ON ((skill.skill_id = c.required_skill) AND (c.id = s.class))
        ORDER by s.status, s.name;
        SQL;

        $res = $this->runQuery($sql);
        return $res;
    }

    public function getShuttle($id)
    {
        $sql = <<<SQL
        SELECT s.id, s.name, s.serial_number, c.name AS class, c.id as class_id, c.`type` as type, c.capacity, b.name AS base, 
        cond.name AS state, cond.operable AS operable, stat.`status` AS status_name, s.status AS status, chars.character_name AS assigned_to_name, chars.characterID AS assigned_to_id, skill.label AS required_skill, c.required_skill AS required_skill_id
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

    public function getCurrentShuttleMission($id)
    {
        $sql = "SELECT * FROM esb_shuttle_log WHERE shuttleID = $id AND STATUS = 2 LIMIT 1;";
        $res = $this->runQuery($sql);
        return $res;
    }

    public function getCharacterByID($id)
    {
        $sql = "SELECT * FROM ecc_characters WHERE characterID = $id;";
        $res = $this->runQuery($sql);
        return $res;
    }

    public function getShuttleLogs()
    {
        $sql = <<<SQL
        SELECT s.name as shuttle_name, stat.`status`, l.comment, l.ic_date, l.ic_time, cs.character_name as status_updated_by, l.mission_name, cl.character_name as mission_leader FROM esb_shuttle_log l
        JOIN esb_shuttles s ON s.id = l.shuttleID
        JOIN esb_shuttle_status stat ON stat.id = l.`status`
        JOIN ecc_characters cs ON cs.characterID = l.status_updated_by
        JOIN ecc_characters cl ON cl.characterID = l.mission_leader
        ORDER BY status_date_oc DESC;
        SQL;
        $res = $this->runQuery($sql);
        return $res;
    }

    public function checkPilotLicense($charID)
    {
        $stmt = <<<SQL
        SELECT * FROM ecc_char_skills s
        WHERE s.charID = $charID AND (s.skill_id = 31152)
        SQL;
        $stm2 = <<<SQL
        SELECT * FROM ecc_char_implants i
        WHERE STATUS = 'active' AND
        charID = $charID AND
        skillgroup_siteindex = 'dex' AND
        skillgroup_level = 1
        SQL;

        $license = $this->runQuery($stmt);
        $implant = $this->runQuery($stm2);
        if ($license != null) {
            return true;
        } else if ($implant != null) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCombatPilot($charID)
    {
        $stmt = <<<SQL
        SELECT * FROM ecc_char_skills s
        WHERE s.charID = $charID AND (s.skill_id = 31162)
        SQL;
        $stm2 = <<<SQL
        SELECT * FROM ecc_char_implants i
        WHERE STATUS = 'active' AND
        charID = $charID AND
        skillgroup_siteindex = 'dex' AND
        skillgroup_level = 6
        SQL;

        $license = $this->runQuery($stmt);
        $implant = $this->runQuery($stm2);
        if ($license != null) {
            return true;
        } else if ($implant != null) {
            return true;
        } else {
            return false;
        }
    }

    public function getCharacter($post)
    {
        if (empty($post)) {
            return "empty";
        } else {
            $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE ICC_number = ?");
            $res = $stmt->execute(array($post));
            $res = $stmt->fetch();
            if ($res == null) {
                $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id = ?");
                $res = $stmt->execute(array($post));
                $res = $stmt->fetch();
                if ($res == null) {
                    if (is_numeric($post)) {
                        $sHex = dechex($post);
                        $aDec = str_split($sHex, 2);
                        $sDec = "%" . $aDec[3] . $aDec[2] . $aDec[1] . $aDec[0] . "%";

                        $stmt = db::$conn->prepare("SELECT * FROM ecc_characters WHERE card_id LIKE ?");
                        $res = $stmt->execute(array($sDec));
                        $res = $stmt->fetch();
                    } else {
                        $res = null;
                    }
                }
            }
            if ($res == null) {
                return "empty";
            } else {
                return $res;
            }
        }
    }

    public function checkInOut($post)
    {
        //return $post;
        $shuttleID = $post["shuttleID"];
        $status = $post["status"];
        $status_updated_by = $post["status_updated_by"];
        $ic_time = $post["ic_time"];
        $ic_date = $post["ic_date"];
        $comment = $post["comment"];
        $mission_name = $post["mission_name"];
        $mission_leader = $post["mission_leader"];

        $stmt = db::$conn->prepare("INSERT INTO esb_shuttle_log (shuttleID, status, status_updated_by, ic_time, ic_date, comment, mission_name, mission_leader) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->execute(array($shuttleID, $status, $status_updated_by, $ic_time, $ic_date, $comment, $mission_name, $mission_leader));

        $stmt2 = db::$conn->prepare("UPDATE esb_shuttles SET status=$status WHERE id=$shuttleID;");
        $stmt2->execute();


        return "success";
    }

    public function displayShuttles($array, $disabled = NULL)
    {

        $current_url = $_SERVER['REQUEST_URI'];
        foreach ($array as $shuttle) {
            if ($shuttle['operable'] = 1) {
                $buttonClass = "good";
            } elseif ($shuttle['operable'] = 0) {
                $buttonClass = "warn";
            } elseif ($shuttle['operable'] = -1) {
                $buttonClass = "error";
            }
            if ($disabled == NULL) {
                ?>
                <form action="<?php echo $current_url; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>" />
                <?php } ?>
                <button name="selected_shuttle" value="<?php echo $shuttle['id']; ?>"
                    class='button--shuttle <?php echo $buttonClass; ?>' <?php if ($disabled == "disabled") {
                           echo "disabled style='pointer-events: none;'";
                       } ?>>

                    <table>
                        <tr>
                            <?php
                            echo "<h3>" . $shuttle['serial_number'] . ": " . $shuttle['name'] . "</h3>";
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

}


