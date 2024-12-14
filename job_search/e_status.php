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
$jobsch_posts = $sql->db_Count("jobsch_ads", "(*)");
if (empty($jobsch_posts))
{
    $jobsch_posts = 0;
}
$text .= "<div style='padding-bottom: 2px;'><img src='" . e_PLUGIN . "job_search/images/icon_16.png' style='width: 16px; height: 16px; vertical-align: bottom;border:0;' alt='' /> " . JOBSCH_A159 . ": " . $jobsch_posts . "</div>";

?>