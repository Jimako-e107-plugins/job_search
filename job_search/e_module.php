<?php
if (!defined('e107_INIT'))
{
    exit;
}
$e_event->register("postuserset", "job_search_postuserset");

function job_search_postuserset($data)
{
    global $tp, $sql;
    $sql->db_Select("user","user_id","where user_name = '".$tp->toDB($data['username'])."'","nowhere",false);
    $row=$sql->db_Fetch();
    $newname = $row['user_id'] . "." . $data['username'];
    $sql->db_Update("jobsch_ads", "jobsch_submittedby ='" . $tp->toDB($newname) . "' where SUBSTRING_INDEX(jobsch_submittedby,'.',1)='" . $row['user_id'] . "'", false);
}

?>