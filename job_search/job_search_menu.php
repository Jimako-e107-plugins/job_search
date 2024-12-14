<?php
// **************************************************************************
// *  Job Search Menu
// *
// **************************************************************************
if (!defined('e107_INIT'))
{
    exit;
}
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/English.php");
}
global $tp,$prefs,$sql;
// print $jobsch_uc;

$arg = "select a.jobsch_cid,a.jobsch_vacancy,c.jobsch_catname,a.jobsch_document,a.jobsch_salary,s.jobsch_subname,s.jobsch_categoryid,s.jobsch_subid from #jobsch_ads as a
		left join #jobsch_subcats as s
		on s.jobsch_subid = a.jobsch_category
		left join #jobsch_cats as c
		on s.jobsch_categoryid = c.jobsch_catid
		where find_in_set(jobsch_catclass,'" . USERCLASS_LIST . "')
		and jobsch_approved > 0
		and (jobsch_closedate>'" . time() . "' or jobsch_closedate =0) order by rand() limit 1";
if ($dsel = $sql->db_Select_gen($arg))
{

 $jobsch_item = $sql->db_Fetch();
    $jobsch_text .= "<div style='text-align:center;'>"; ;
    $jobsch_text .= $tp-> toHTML(JOBSCH_MENU_3,false,"no_make_clickable emotes_off") . " &gt; " . $tp-> html_truncate($tp-> toHTML($jobsch_item['jobsch_catname'],false,"no_make_clickable emotes_off"),30) . "<br />";
    $jobsch_text .= $tp-> toHTML(JOBSCH_MENU_5,false,"no_make_clickable emotes_off") . " &gt; " . $tp-> html_truncate($tp-> toHTML($jobsch_item['jobsch_subname'],false,"no_make_clickable emotes_off"),30) . "<br />";


    $jobsch_text .= "<strong><a href='" . e_PLUGIN . "job_search/jobshack.php?0.item." . $jobsch_item['jobsch_categoryid'] . "." . $jobsch_item['jobsch_subid'] . "." . $jobsch_item['jobsch_cid'] . "' >" . $tp->html_truncate($jobsch_item['jobsch_vacancy'], 30, JOBSCH_MENU_4) . "</a></strong><br />";

        $jobsch_text .= $tp-> html_truncate($tp-> toHTML($pluginPref['jobsch_currency'].$jobsch_item['jobsch_salary'],false,"no_make_clickable emotes_off"),30) . "&nbsp;<br />";
}
$jobsch_text .= "</div>";
$ns->tablerender(JOBSCH_MENU_1, $jobsch_text);

?>
