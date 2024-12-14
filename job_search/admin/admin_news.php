<?php

require_once("../../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms("P"))
{
    header("location:" . e_BASE . "index.php");
    exit;
}
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/admin/English.php");
}
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/English.php");
}
require_once(e_ADMIN . "auth.php");
$jobsch_conv = new convert;

if (isset($_REQUEST['jobsch_donews']))
{
    // get the list of subscribers
    // step through each one and get the vacancies they are allowed to see
    // send them the newsletter
    require_once(e_HANDLER . "mail.php");
    // Create message
    require_once("jobsearch_shortcodes.php");
    require_once("./newsletter/newsletter_template.php");
    $month = date("m");
    $day = date("j");
    $year = date("Y");
    $jobsch_today = mktime(0, 0, 0, $month, $day, $year);
    $jobsch_arg = "select j.*,u.user_loginname,u.user_email from #jobsch_subs as j
	left join #user as u
	on jobsch_subuserid=user_id";
    if ($sql->db_Select_gen($jobsch_arg, false))
    {
        $jobsch_yescount = 0;
        $jobsch_nocount = 0;
        while ($jobsch_row = $sql->db_Fetch())
        {
            extract($jobsch_row);
            // print $user_email;
            $jobsch_arg2 = "select * from #jobsch_ads as r
                left join #jobsch_subcats as s on r.jobsch_category=s.jobsch_subid
                left join #jobsch_cats as c on s.jobsch_categoryid=c.jobsch_catid
                left join #jobsch_locals as l on r.jobsch_locality=l.jobsch_localid
                where
				(jobsch_lastnews = 0 or  jobsch_lastnews < '" . $pref['jobsch_lastnews'] . "')
				and find_in_set(jobsch_catclass, '" . USERCLASS_LIST . "')" .
            ($pref['jobsch_approval'] == 1?" and jobsch_approved > 0":"") . " and (jobsch_closedate = 0 or jobsch_closedate = '' or jobsch_closedate is null or jobsch_closedate > $jobsch_today)
                order by jobsch_postdate " . $tp->toFORM($pref['jobsch_sort']) ;
            $jobsch_counter = $sql2->db_Select_gen($jobsch_arg2, false);
            if ($jobsch_counter)
            {
                $message = $tp->parsetemplate($JOBSCH_NEWS_HEADER, false, $jobsearch_shortcodes);
                while ($jobsch_mrow = $sql2->db_Fetch())
                {
                    extract($jobsch_mrow);
                    $message .= $tp->parsetemplate($JOBSCH_NEWS_DETAIL, false, $jobsearch_shortcodes);
                } // while
                $message .= $tp->parsetemplate($JOBSCH_NEWS_FOOTER, false, $jobsearch_shortcodes);
                $jobsch_emalok = sendemail($user_email, "Newsletter", $message, $user_loginname, $pref['jobsch_sysemail'], $pref['jobsch_sysfrom']);
                if ($jobsch_emalok)
                {
                    $jobsch_yescount++;
                }
                else
                {
                    $jobsch_nocount++;
                }
            }

            // print "do mail $user_loginname<br>";
        }
        $jobsch_now = time();
        if ($sql->db_Update("jobsch_ads", "jobsch_lastnews='{$jobsch_now}'", false))
        {
            $jobsch_upok = JOBSCH_A149;
        }
        else
        {
            $jobsch_upok = JOBSCH_A150;
        }
        $pref['jobsch_lastnews'] = $jobsch_now;
        save_prefs();
        // Send Emails
        $jobsch_text .= "<table class='fborder' style='width:97%'>
        <tr><td class='fcaption'>" . JOBSCH_A133 . "</td></tr>
        <tr><td class='forumheader3'>" . JOBSCH_A145 . " $jobsch_yescount " . JOBSCH_A146 . "<br />
        " . JOBSCH_A147 . " $jobsch_nocount " . JOBSCH_A148 . "<br /></td></tr>
        <tr><td class='forumheader3'>" . $jobsch_upok . "</td></tr>
        </table>";
    } // ;
}
else
{
    $jobsch_count = $sql->db_Count("jobsch_subs", "(*)");
    $jobsch_vacancies = $sql->db_Count("jobsch_ads", "(*)", "where jobsch_lastnews = 0 or jobsch_lastnews <'" . $pref['jobsch_lastnews'] . "'",false);
    $jobsch_text .= "<form id=jobsch_news' method='post' action='" . e_SELF . "' >
<table class='fborder' style='width:97%'>
<tr><td class='fcaption'>" . JOBSCH_A133 . "</td></tr>
<tr><td class='forumheader3'>" . JOBSCH_A136 . " " . ($pref['jobsch_lastnews'] > 0?$jobsch_conv->convert_date($pref['jobsch_lastnews']):JOBSCH_A137) . "</td></tr>
<tr><td class='forumheader3'>" . JOBSCH_A134 . " $jobsch_count " . JOBSCH_A138 . " " .
    JOBSCH_A139 . " " . $jobsch_vacancies . " " . JOBSCH_A140 . " </td></tr>
<tr><td class='fcaption'><input class='tbox' type='submit' name='jobsch_donews' value='" . JOBSCH_A135 . "' /></td></tr>

</table>
</form>";
}
$ns->tablerender(JOBSCH_A1, $jobsch_text);
require_once(e_ADMIN . "footer.php");

?>
