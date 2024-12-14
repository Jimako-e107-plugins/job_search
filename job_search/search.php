<?php
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
$month = date("n");
$day = date("j");
$year = date("Y");
$today = mktime(0, 0, 0, $month, $day, $year);

$return_fields = 't.jobsch_vacancy,t.jobsch_companyinfoname,t.jobsch_vacancydetails,t.jobsch_salary,l.jobsch_localname,t.jobsch_closedate,t.jobsch_cid,t.jobsch_submittedby,u.jobsch_catname,v.jobsch_subname,v.jobsch_categoryid,v.jobsch_subid';
$search_fields = array('l.jobsch_localname','t.jobsch_vacancy', 't.jobsch_companyinfoname', 't.jobsch_vacancydetails', 't.jobsch_submittedby', 'u.jobsch_catname', 'v.jobsch_subname');
$weights = array('1','2', '2', '2', '0.5', '1', '1');
$no_results = LAN_198;

$where = "find_in_set(jobsch_catclass,'" . USERCLASS_LIST . "') " .
($pref['jobsch_approval'] == 1?" and jobsch_approved > 0":"") .
" and (jobsch_closedate > " . $today . " or jobsch_closedate=0 ) and ";
$order = array('t.jobsch_vacancy' => DESC);
$table = "jobsch_ads as t
left join #jobsch_locals as l on l.jobsch_localid = t.jobsch_locality
left join #jobsch_subcats as v on v.jobsch_subid = t.jobsch_category
left join #jobsch_cats as u on v.jobsch_categoryid = u.jobsch_catid
";

$ps = $sch->parsesearch($table, $return_fields, $search_fields, $weights, 'search_jobsch', $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_jobsch($row)
{
    global $con;
    if ($row['jobsch_closedate'] > 0)
    {
        $datestamp = $con->convert_date($row['jobsch_closedate'], "short");
    }
    else
    {
        $datestamp = JOBSCH_75;
    }
    $title = $row['jobsch_vacancy'];
    if (!empty($row['jobsch_localname']))
    {
        $jobloc = JOBSCH_122 . " ".substr($row['jobsch_localname'], 0, 60);
    }

    $link_id = $row['jobsch_cid'];
    if (!empty($row['jobsch_salary'])) {
    	$jobsch_salary = $row['jobsch_salary'];
    }
    else
    {
    $jobsch_salary =JOBSCH_123;
    }
    // $dept = $row['dept_id'];
    $res['link'] = e_PLUGIN . "job_search/jobshack.php?0.item." . $row['jobsch_categoryid'] . "." . $row['jobsch_subid'] . "." . $link_id . "";
    $res['pre_title'] = $title ?JOBSCH_69 . " " : "";
    $res['title'] = $title ? $title : LAN_SEARCH_9;
    $res['summary'] = JOBSCH_70 . ": " . substr($row['jobsch_catname'], 0, 30) . " &mdash; " . JOBSCH_73 . ": " . substr($row['jobsch_subname'], 0, 30) . "";
    $res['detail'] = JOBSCH_71 . ": " . substr($row['jobsch_companyinfoname'], 0, 60) . " " . $jobloc . " <br  />" .
    JOBSCH_74 . ": " . $jobsch_salary . "<br />" . JOBSCH_72 . ": " . $datestamp;
    return $res;
}

?>