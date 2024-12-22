<?php
if (!defined('e107_INIT'))
{
	exit;
}

require(e_PLUGIN . "job_search/ejobs_defines.php");
e107::getSingleton("ejobs", e_PLUGIN . JOBS_DEF_PLUGIN_FOLDER . '/handlers/ejobs_class.php');

$e_event->register("postuserset", "job_search_postuserset");

$pluginPref = e107::pref('job_search');

function job_search_postuserset($data)
{
	global $tp, $sql;
	$sql->db_Select("user", "user_id", "where user_name = '" . $tp->toDB($data['username']) . "'", "nowhere", false);
	$row = $sql->db_Fetch();
	$newname = $row['user_id'] . "." . $data['username'];
	$sql->db_Update("jobsch_ads", "jobsch_submittedby ='" . $tp->toDB($newname) . "' where SUBSTRING_INDEX(jobsch_submittedby,'.',1)='" . $row['user_id'] . "'", false);
}
