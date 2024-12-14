<?php
if (!defined('e107_INIT')) { exit; }
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/English.php");
}
$myclass_title = JOBSCH_1;
$search_info[]=array( 'sfile' => e_PLUGIN.'job_search/search.php', 'qtype' => $myclass_title, 'refpage' => 'jobshack.php');
?>