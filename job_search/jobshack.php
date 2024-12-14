<?php
require_once("../../class2.php");
// If not a valid call to the script then leave it
if (!defined('e107_INIT'))
{
    exit;
}

require_once(e_HANDLER . "userclass_class.php");
#require_once(e_HANDLER . "np_class.php");

if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/English.php");
}

// check if we use the wysiwyg for text areas
$e_wysiwyg = "jobsch_vacancydetails";
if ($pref['wysiwyg'])
{
    $WYSIWYG = true;
}
require_once("jobsearch_template.php");
require_once("jobsearch_shortcodes.php");

// Check that access is permitted to this plugin
$jobsch_access = check_class($pref['jobsch_read']) || check_class($pref['jobsch_admin']) || check_class($pref['jobsch_create']);
if (!$jobsch_access)
{
    $jobsch_text = $tp->toHTML(JOBSCH_40);
    $ns->tablerender(JOBSCH_1, $jobsch_text);
    require_once(FOOTERF);
    exit;
}

$jobsch_gen = new convert;

$jobsch_today = mktime(0, 0, 0, date("n", time()), date("j", time()), date("Y", time()));
// get the parameters passed into the script
// print e_QUERY;
if (e_QUERY)
{
    $jobsch_tmpy = explode(".", e_QUERY);
    $jobsch_from = intval($jobsch_tmpy[0]);
    $jobsch_action = $jobsch_tmpy[1];
    $jobsch_catid = intval($jobsch_tmpy[2]);
    $jobsch_subid = intval($jobsch_tmpy[3]);
    $jobsch_itemid = intval($jobsch_tmpy[4]);
    $jobsch_tmp = intval($jobsch_tmpy[5]);
    $jobsch_local = intval($jobsch_tmpy[6]);
}
else
{
    $jobsch_from = intval($_REQUEST['jobsch_from']);
    $jobsch_action = $_REQUEST['jobsch_action'];
    $jobsch_catid = intval($_REQUEST['jobsch_catid']);

    $jobsch_itemid = intval($_REQUEST['jobsch_itemid']);
    $jobsch_tmp = intval($_REQUEST['jobsch_tmp']);
    $jobsch_local = intval($_REQUEST['jobsch_local']);
    if (is_array($_REQUEST['jobsch_subid']))
    {
        foreach($_REQUEST['jobsch_subid'] as $row)
        {
            if ($row > 0)
            {
                $jobsch_subid = intval($row);
                $jobsch_action = "list";
            }
        }
    }
    else
    {
        $jobsch_subid = intval($_REQUEST['jobsch_subid']);
    }
}
// print $jobsch_local;
// this is used if drop downs are used for sub categories to get the one that was selected
// If from not defined then make it zero
$jobsch_from = ($jobsch_from > 0?$jobsch_from: 0);
// If no per page pref set then default to 10 per page
$pref['jobsch_perpage'] = ($pref['jobsch_perpage'] > 0?$pref['jobsch_perpage']:10);
// Check if subscriptions being done
if ($pref['jobsch_subscribe'] > 0 && isset($_REQUEST['jobsch_subsub']))
{
    if ($_REQUEST['jobsch_subme'] > 0)
    {
        // add to subscriptions list
        // check if they already are subscribed
        if (!$sql->db_Select("jobsch_subs", "jobsch_subid", "jobsch_subuserid='" . USERID . "'"))
        {
            // no they are not so add them
            $sql->db_Insert("jobsch_subs", "0,'" . USERID . "',''");
        }
    }
    else
    {
        // check if they already are subscribed
        if ($sql->db_Select("jobsch_subs", "jobsch_subid", "jobsch_subuserid='" . USERID . "'"))
        {
            // They are so delete them
            $sql->db_Delete("jobsch_subs", "jobsch_subuserid='" . USERID . "'");
        }
    }
}
// Do the action
if (!USER)
{
    #require_once(HEADERF);
   # $ns->tablerender(JOBSCH_54, JOBSCH_111);
   # require_once(FOOTERF) ;
   # exit;
}
// check class for creating editing ads
if (!$pref['jobsch_subscribe'])
{
 #   require_once(HEADERF);
 ##   $ns->tablerender(JOBSCH_54, JOBSCH_105);
 #   require_once(FOOTERF) ;
 #   exit;
}
switch ($jobsch_action)
{
    case "subs":
        $jobsch_text .= "<form method = 'post' action = '" . e_SELF . "' id = 'jobschsub' > ";
        $jobsch_text .= $tp->parsetemplate($JOBSCH_SUBS_HEADER, false, $jobsearch_shortcodes);
        $jobsch_text .= $tp->parsetemplate($JOBSCH_SUBS_DETAIL, false, $jobsearch_shortcodes);
        $jobsch_text .= $tp->parsetemplate($JOBSCH_SUBS_FOOTER, false, $jobsearch_shortcodes);
        $jobsch_text .= "</form > ";
        break;
    case "mge":
    case "new";
        require_once("add.php");
        exit;
        break;
    case "tnc":
        $jobsch_text .= $tp->parsetemplate($JOBSCH_TC_HEADER, false, $jobsearch_shortcodes);
        $jobsch_text .= $tp->parsetemplate($JOBSCH_TC_DETAIL, false, $jobsearch_shortcodes);
        $jobsch_text .= $tp->parsetemplate($JOBSCH_TC_FOOTER, false, $jobsearch_shortcodes);
        $jobsch_text .= jobsch_footer();
        $jobsch_page=JOBSCH_41;
        break;
    case "item":
        {
            $sql->db_Update("jobsch_ads", "jobsch_views = jobsch_views + 1 where jobsch_cid = $jobsch_itemid");
            // needs to be this complex for security reasons!
            // print " <br > item".$jobsch_itemid;
            $jobsch_arg = "select * from #jobsch_ads as r
                left join #jobsch_subcats as t on r.jobsch_category=jobsch_subid
                left join #jobsch_cats on jobsch_categoryid=jobsch_catid
                left join #jobsch_locals on jobsch_locality=jobsch_localid
                where r.jobsch_cid = $jobsch_itemid and find_in_set(jobsch_catclass, '" . USERCLASS_LIST . "') " .
            ($pref['jobsch_approval'] == 1?" and jobsch_approved > 0":"") . "
                and (jobsch_closedate = 0 or jobsch_closedate = '' or jobsch_closedate is null or jobsch_closedate > $jobsch_today) ";
            if ($sql->db_Select_gen($jobsch_arg, false))
            {
                $jobsch_row = $sql->db_Fetch();
                extract($jobsch_row);
            }
            $jobsch_tmp=explode(".",$jobsch_submittedby,2);
            $jobsch_submittedby=$jobsch_tmp[1];
            $jobsch_text .= $tp->parsetemplate($JOBSCH_ITEM_HEADER, false, $jobsearch_shortcodes);
            $jobsch_text .= $tp->parsetemplate($JOBSCH_ITEM_DETAIL, false, $jobsearch_shortcodes);
            $jobsch_text .= $tp->parsetemplate($JOBSCH_ITEM_FOOTER, false, $jobsearch_shortcodes);
            $jobsch_text .= jobsch_footer();
            $jobsch_page=JOBSCH_131." : ".substr($tp->toFORM($jobsch_vacancy),0,20);
            break;
        }

    case "list":
        {
            // $jobsch_text = jobsch_header();
            $jobsch_text .= " <form id = 'subform3' method = 'post' action = '" . e_SELF . "' >
		<div>
			<input type = 'hidden' name = 'jobsch_from' value = '" . $jobsch_from . "' />
			<input type = 'hidden' name = 'jobsch_action' value = 'list' />
			<input type = 'hidden' name = 'jobsch_catid' value = '" . $jobsch_catid . "' />
			<input type = 'hidden' name = 'jobsch_subid' value = '" . $jobsch_subid . "' />
			<input type = 'hidden' name = 'jobsch_itemid' value = '" . $jobsch_itemid . "' />
			<input type = 'hidden' name = 'jobsch_tmp' value = '" . $jobsch_tmp . "' / >
		</div>";
            // needs to be this complex for security reasons!
            // if there is a locality set then add the locality to the where clause
            $jobsch_where = ($jobsch_local > 0?" and (jobsch_locality = '{$jobsch_local}' or jobsch_locality=0)":"");
            // Get the data
            $jobsch_arg = "select * from #jobsch_ads as r
                left join #jobsch_subcats as t on r.jobsch_category=jobsch_subid
                left join #jobsch_cats on jobsch_categoryid=jobsch_catid
                where r.jobsch_category = $jobsch_subid $jobsch_where and find_in_set(jobsch_catclass, '" . USERCLASS_LIST . "')" .
            ($pref['jobsch_approval'] == 1?" and jobsch_approved > 0":"") . " and (jobsch_closedate = 0 or jobsch_closedate = '' or jobsch_closedate is null or jobsch_closedate > $jobsch_today)
                order by jobsch_postdate " . $tp->toFORM($pref['jobsch_sort']) . " limit $jobsch_from, " . $pref['jobsch_perpage'];
            // print $jobsch_arg ." <br > ". $jobsch_today;
            $jobsch_count = $sql2->db_Count("jobsch_ads", "(*)", "where jobsch_category = $jobsch_subid and jobsch_approved > 0 and (jobsch_closedate = 0 or jobsch_closedate = '' or jobsch_closedate is null or jobsch_closedate > $jobsch_today)");
            $sql2->db_Select_gen("select * from #jobsch_subcats left join #jobsch_cats on jobsch_categoryid=jobsch_catid where jobsch_subid=$jobsch_subid");
            $jobsch_scat = $sql2->db_Fetch();
            extract($jobsch_scat);
            $jobsch_text .= $tp->parsetemplate($JOBSCH_LIST_HEADER, false, $jobsearch_shortcodes);
            if ($sql->db_Select_gen($jobsch_arg, false))
            {
                while ($jobsch_row = $sql->db_Fetch())
                {
                    extract($jobsch_row);
                    $jobsch_tmp = explode(".", $jobsch_submittedby,2);
                    $jobsch_poster =$jobsch_tmp[1];
                    $jobsch_text .= $tp->parsetemplate($JOBSCH_LIST_DETAIL, false, $jobsearch_shortcodes);
                } // while
            }
            else
            {
                $jobsch_text .= " <tr > <td class = 'forumheader3' colspan = '5' > " . JOBSCH_52 . " </ td > </ tr > ";
            }

            $jobsch_text .= $tp->parsetemplate($JOBSCH_LIST_FOOTER, false, $jobsearch_shortcodes);
            $jobsch_text .= " </form > ";

            $jobsch_page=JOBSCH_129." ".$jobsch_catname." ".JOBSCH_130." ".$jobsch_subname;
            break;
        }
    case "sub":
        {
            # $jobsch_where = ($jobsch_local > 0?" and jobsch_locality = '{$jobsch_local}'":"");
            $jobsch_where = ($jobsch_local > 0?" and (jobsch_locality = '{$jobsch_local}' or jobsch_locality=0)":"");
            // $jobsch_text = jobsch_header();
            $jobsch_text .= " <form action = '" . e_SELF . "' method = 'post' id = jobschsub'>
			<div><input type='hidden' name='jobsch_from' value='" . $jobsch_from . "' />
                <input type='hidden' name='jobsch_action' value='sub' />
                <input type='hidden' name='jobsch_catid' value='" . $jobsch_catid . "' />
                <input type='hidden' name='jobsch_itemid' value='" . $jobsch_itemid . "' />
                <input type='hidden' name='jobsch_tmp' value='" . $jobsch_tmp . "' />
				</div>";
            $jobsch_colspan = ($pref['jobsch_icons'] > 0?3:2);
            $jobsch_from = 0;
            // get the sub and cat names
            $sql->db_Select("jobsch_cats", "jobsch_catname", "jobsch_catid=$jobsch_catid");
            $jobsch_row = $sql->db_Fetch();
            extract($jobsch_row);
            // display the header
            $jobsch_text .= $tp->parsetemplate($JOBSCH_SUB_HEADER, false, $jobsearch_shortcodes);
            $jobsch_text .= "";
            $jobsch_arg = "select * from #jobsch_subcats left join #jobsch_cats on jobsch_categoryid=jobsch_catid where jobsch_categoryid=$jobsch_catid and find_in_set(jobsch_catclass,'" . USERCLASS_LIST . "')  order by jobsch_subname";
            if ($sql->db_Select_gen($jobsch_arg))
            {
                while ($jobsch_row = $sql->db_Fetch())
                {
                    extract($jobsch_row);
                    $jobsch_count = $sql2->db_Count("jobsch_ads", "(*)", "where jobsch_category=$jobsch_subid and (jobsch_closedate = 0 or jobsch_closedate='' or jobsch_closedate is null or jobsch_closedate>$jobsch_today) $jobsch_where" .
                        ($pref['jobsch_approval'] == 1?" and jobsch_approved > 0":"") . " and (jobsch_closedate = 0 or jobsch_closedate='' or jobsch_closedate is null or jobsch_closedate>$jobsch_today) ");
                    $jobsch_text .= $tp->parsetemplate($JOBSCH_SUB_DETAIL, false, $jobsearch_shortcodes);
                } // while
            }
            else
            {
                $jobsch_text .= "<tr><td class='forumheader3' colspan='$jobsch_colspan'>" . JOBSCH_51 . "</td></tr>";
            }

            $jobsch_text .= $tp->parsetemplate($JOBSCH_SUB_FOOTER, false, $jobsearch_shortcodes);
            $jobsch_text .= "</form>";
            $jobsch_text .= jobsch_footer();
            $jobsch_page=JOBSCH_129." ".$jobsch_catname;
            break;
        }

    case "cat":
    default:
        {
            $jobsch_colspan = ($pref['jobsch_icons'] > 0?4:3);
            // $jobsch_text = jobsch_header();
            $jobsch_text .= "
            <form id='subform2' method='post' action='" . e_SELF . "' >
            <div><input type='hidden' name='jobsch_from' value='" . $jobsch_from . "' />
                <input type='hidden' name='jobsch_action' value='cat' />
                <input type='hidden' name='jobsch_catid' value='" . $jobsch_catid . "' />
                <input type='hidden' name='jobsch_itemid' value='" . $jobsch_itemid . "' />
                <input type='hidden' name='jobsch_tmp' value='" . $jobsch_tmp . "' />
				</div>";

            $jobsch_text .= $tp->parsetemplate($JOBSCH_CAT_HEADER, false, $jobsearch_shortcodes);
            if ($sql->db_Select("jobsch_cats", "*", "where find_in_set(jobsch_catclass,'" . USERCLASS_LIST . "')  order by jobsch_catname", "nowhere", false))
            {
                while ($jobsch_row = $sql->db_Fetch())
                {
                    extract($jobsch_row);
                    $jobsch_text .= $tp->parsetemplate($JOBSCH_CAT_DETAIL, false, $jobsearch_shortcodes);
                } // while
            }
            $jobsch_text .= $tp->parsetemplate($JOBSCH_CAT_FOOTER, false, $jobsearch_shortcodes);
            $jobsch_text .= "</form></div>";
            $jobsch_page=JOBSCH_128;
        }
        // $jobsch_text .= jobsch_footer();
        break;
}
// define the over ride meta tags
// define("PAGE_NAME", JOBSCH_1);
define("e_PAGETITLE", JOBSCH_1." : ".$jobsch_page);
if (!empty($pref['jobsch_metad']))
{
    define("META_DESCRIPTION", $pref['jobsch_metad']);
}
if (!empty($pref['jobsch_metak']))
{
    define("META_KEYWORDS", $pref['jobsch_metak']);
}
require_once(HEADERF);
$ns->tablerender(JOBSCH_1, $jobsch_text);
require_once(FOOTERF);
// .
// functions
// .
function jobsch_footer($jobsch_nextprev)
{
    global $pref, $jobsch_from, $jobsch_action, $jobsch_catid, $jobsch_subid, $jobsch_itemid;
    if (!empty($jobsch_nextprev))
    {
        $jobsch_retval .= JOBSCH_42;
    }
    $jobsch_retval .= "&nbsp;$jobsch_nextprev";
    return $jobsch_retval;
}
function jobsch_makeimg($number, $set)
{
    global $pref;

    $number = str_pad($number, ($pref['jobsch_leadz'] > 0?$pref['jobsch_leadz']:0), "0", STR_PAD_LEFT);
    $retval = "";
    $len = strlen($number);
    $url = "./images/counter/";
    for($pos = 0;$pos < $len;$pos++)
    {
        $retval .= "<img src='" . $url . substr($number, $pos, 1) . "$set.gif'  style='border:0;' alt='" . substr($number, $pos, 1) . "' />";
    }
    return $retval;
}


?>
