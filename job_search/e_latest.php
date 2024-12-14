<?php
if (!defined('e107_INIT')) { exit; }
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php");
} 
else
{
    include_once(e_PLUGIN . "job_search/languages/admin/English.php");
} 
$jobsch_approve = $sql->db_Count('jobsch_ads', '(*)', "WHERE jobsch_approved='0'");
$text .= "<div style='padding-bottom: 2px;'>
<img src='" . e_PLUGIN . "job_search/images/icon_16.png' style='width: 16px; height: 16px; vertical-align: bottom;border:0;' alt='' /> ";
if (empty($jobsch_approve))
{
    $jobsch_approve = 0;
} 
if ($jobsch_approve)
{
    $text .= "<a href='" . e_PLUGIN . "job_search/admin_submit.php'>" . JOBSCH_A51 . ": " . $jobsch_approve . "</a>";
} 
else
{
    $text .= JOBSCH_A51 . ': ' . $jobsch_approve;
} 

$text .= '</div>';

?>