<?php
if (!defined('e107_INIT'))
{
    exit;
}
include_once(e_HANDLER . 'shortcode_handler.php');
$jobsearch_shortcodes = $tp->e_sc->parse_scbatch(__FILE__);
/*

SC_BEGIN JOBPOSTER
global $tp,$jobsch_submittedby;
return $jobsch_submittedby;
SC_END
SC_BEGIN JOBRSS
global $PLUGINS_DIRECTORY;

$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?job_search.1'><img src='images/rss1.png' alt='RSS 1' title='RSS 1' style='border:0;' /></a>&nbsp;&nbsp;";
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?job_search.2'><img src='images/rss2.png' alt='RSS 2' title='RSS 2' style='border:0;' /></a>&nbsp;&nbsp;";
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?job_search.3'><img src='images/rss3.png' alt='RSS RDF' title='RSS RDF' style='border:0;' /></a>&nbsp;&nbsp;";
$retval .= "<a href='".e_BASE.$PLUGINS_DIRECTORY."rss_menu/rss.php?job_search.4'><img src='images/rss4.png' alt='RSS ATOM' title='RSS ATOM' style='border:0;' /></a>";
return $retval;

SC_END
SC_BEGIN JOBLOCALITY
global $pref, $tp, $jobsch_localname;
if (empty($jobsch_localname))
{
    $retval = JOBSCH_101;
}
else
{
    $retval = $tp->toHTML($jobsch_localname);
}
return $retval;
SC_END
SC_BEGIN JOBVIEWS
global $pref, $tp, $jobsch_counter, $jobsch_views;
if ($pref['jobsch_counter'] != "NONE")
{
    // counter is available for all ads
    if ($pref['jobsch_counter'] == "ALL" && !empty($jobsch_counter))
    {
        // user defined counter and one is set
        $retval .= jobsch_makeimg($jobsch_views, $jobsch_counter);
    }
    if ($pref['jobsch_counter'] != "ALL" && !empty($jobsch_counter))
    {
        // admin defined setting for counter and ignore the set chosen by the user
        $retval .= jobsch_makeimg($jobsch_views, $pref['jobsch_counter']);
    }
}
else
{
    $retval .= JOBSCH_121;
}
return $retval;
SC_END

SC_BEGIN JOBREFERENCE
global $tp,$jobsch_cid;
	return $tp->toHTML($jobsch_cid);
SC_END

SC_BEGIN JOBEMPREF
global $tp,$jobsch_empref;
if (!empty($jobsch_empref))
{
	return $tp->toHTML($jobsch_empref);
}
else
{
	return JOBSCH_127;
}
SC_END

SC_BEGIN JOBPOSTDATE
global $tp, $jobsch_postdate, $jobsch_gen;
if (empty($parm))
{
	$parm="short";
}
if ($jobsch_postdate > 0)
{
	if ($parm=="long" || $parm=="short")
	{
	    return $jobsch_gen->convert_date($jobsch_postdate, $parm);
	}
	else
	{
		return date($parm ,$jobsch_postdate);
	}
}
else
{
   	return "&nbsp;";
}

SC_END

SC_BEGIN JOBSUBLIST
global $tp, $pref, $jobsch_today, $jobsch_local, $jobsch_catid, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_tmp, $jobsch_local;
$jobsch_db1 = new DB;
$jobsch_db2 = new DB;
if ($jobsch_db1->db_Select("jobsch_subcats", "*", "jobsch_categoryid=$jobsch_catid  order by jobsch_subname"))
{
    $jobsch_selector = "<select class='tbox' name='jobsch_subid[]' onchange='this.form.submit()' >";
    $jobsch_selector .= "<option value='0' selected='selected'>" . JOBSCH_98 . "</option>";
    $jobsch_where = ($jobsch_local > 0?" and (jobsch_locality='{$jobsch_local}' or jobsch_locality=0)":"");
    while ($jobsch_subs = $jobsch_db1->db_Fetch())
    {
        extract($jobsch_subs);
        $jobsch_count = $jobsch_db2->db_Select("jobsch_ads", "jobsch_cid", "where jobsch_category=$jobsch_subid $jobsch_where " .
            ($pref['jobsch_approval'] == 1?" and jobsch_approved > 0":"") . " and (jobsch_closedate = 0 or jobsch_closedate='' or jobsch_closedate is null or jobsch_closedate>$jobsch_today)", "nowhere", false);
        if ($pref['jobsch_subdrop'] == 1)
        {
            if ($jobsch_count > 0)
            {
                $jobsch_selector .= "<option value='{$jobsch_subid}'>" . $jobsch_subname . " ($jobsch_count)</option>";
            }
            else
            {
                $jobsch_selector .= "<option value='{$jobsch_subid}' disabled='disabled'>" . $jobsch_subname . " ($jobsch_count)</option>";
            }
        }
        else
        {
            if ($jobsch_count > 0)
            {
                $catsubs .= "<a href='" . e_SELF . "?$jobsch_from.list.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local' >" . $tp->toHTML($jobsch_subname, false) . " ($jobsch_count)</a><br />";
            }
            else
            {
                $catsubs .= $tp->toHTML($jobsch_subname, false) . " ($jobsch_count)<br />";
            }
        }
    }
    $jobsch_selector .= "</select>&nbsp;&nbsp;<input type='button' class='tbox' onclick='this.form.submit()' name='submitit[]' value='" . JOBSCH_97 . "' />";
}
else
{
    $catsubs = JOBSCH_81;
}
return ($pref['jobsch_subdrop'] == 1?$jobsch_selector: $catsubs);
SC_END

SC_BEGIN JOBCATNAME
global $tp, $jobsch_catname, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_tmp, $jobsch_local;
if ($parm == "nolink")
{
    $retval = $tp->toHTML($jobsch_catname);
}
else
{
    $retval = "<a href='" . e_SELF . "?$jobsch_from.sub.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local' >" . $tp->toHTML($jobsch_catname) . "</a>";
}
return $retval;
SC_END

SC_BEGIN JOBCATDESC
global $tp, $jobsch_catdesc;
$retval = $tp->toHTML($jobsch_catdesc);
return $retval;
SC_END

SC_BEGIN JOBCATICON
global $tp, $jobsch_caticon, $jobsch_catname, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_tmp, $jobsch_local;
if (!empty($jobsch_caticon) && file_exists("./images/icons/" . $jobsch_caticon))
{
    $retval = "<a href='" . e_SELF . "?$jobsch_from.sub.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local' ><img src='./images/icons/" . $jobsch_caticon . "' alt='" . $tp->toHTML($jobsch_catname) . " icon' title='" . $tp->toHTML($jobsch_catname) . "' style='border:0;'/></a>";
}
else
{
    $retval .= "<img src='./images/icons/blank.png' alt='category icon' title='' style='border:0;'/>";
}
return $retval;
SC_END

SC_BEGIN JOBSUBNAME
global $tp, $jobsch_count, $jobsch_subname, $jobsch_from, $jobsch_categoryid, $jobsch_subid, $jobsch_itemid, $jobsch_tmp, $jobsch_local;
if ($jobsch_count > 0)
{
    if ($parm == "nolink")
    {
        return $tp->toHTML($jobsch_subname);
    }
    else
    {
        return "<a href='" . e_SELF . "?$jobsch_from.list.$jobsch_categoryid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local'>" . $tp->toHTML($jobsch_subname) . "</a>";
    }
}
else
{
    return $tp->toHTML($jobsch_subname);
}
SC_END

SC_BEGIN JOBSUBJOBCOUNT
global $tp,$jobsch_count;
return $tp->toHTML($jobsch_count) . "&nbsp;";
SC_END

SC_BEGIN JOBSUBICON
global $jobsch_count, $jobsch_subicon, $jobsch_subname, $tp, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_tmp, $jobsch_local;
$retval = "&nbsp;";
if (!empty($jobsch_subicon) && file_exists("./images/icons/" . $jobsch_subicon))
{
    if ($jobsch_count > 0)
    {
        $retval .= "<a href='" . e_SELF . "?$jobsch_from.list.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local' ><img src='./images/icons/" . $jobsch_subicon . "'  alt='" . $tp->toHTML($jobsch_subname) . " icon' title='" . $tp->toHTML($jobsch_subname) . "'style='border:0;' /></a>";
    }
    else
    {
        $retval .= "<img src='./images/icons/" . $jobsch_subicon . "'  alt='" . $tp->toHTML($jobsch_subname) . " icon' title='" . $tp->toHTML($jobsch_subname) . "'style='border:0;' />";
    }
}
else
{
    $retval .= "<img src='./images/icons/blank.png'  alt='' title='' style='border:0;' />";
}
return $retval;
SC_END

SC_BEGIN JOBLOCALSELECTOR
global $tp, $sql, $jobsch_local;
$retval = "<select class='tbox' name='jobsch_local' onchange='this.form.submit()'>";
$retval .= "<option value='0' selected='selected'>" . JOBSCH_101 . "</option>";

if ($sql->db_Select("jobsch_locals", "*", "order by jobsch_localname", "nowhere"))
{
    while ($jbsrch_row = $sql->db_Fetch())
    {
        $retval .= "<option value='" . $jbsrch_row['jobsch_localid'] . "' " . ($jbsrch_row['jobsch_localid'] == $jobsch_local?"selected='selected'":"") . ">" . $jbsrch_row['jobsch_localname'] . "</option>";
    } // while
}

$retval .= "</select>&nbsp;<input type='button' onclick='this.form.submit()' class='tbox' name='jobsel' value='" . JOBSCH_97 . "' />";
return $retval;
SC_END

SC_BEGIN CURRENCY_SYMBOL
global $pref, $tp;
return $tp->toHTML($pref['jobsch_currency']);
SC_END

SC_BEGIN JOBTITLE
global $tp, $jobsch_vacancy, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_cid, $jobsch_local;
if ($parm == "item")
{
    $retval = "<a href='" . e_SELF . "?$jobsch_from.item.$jobsch_catid.$jobsch_subid.$jobsch_cid.0.$jobsch_local'>" . $tp->toHTML($jobsch_vacancy, false, "no_make_clickable") . "</a>";
}
else
{
    $retval = $tp->toHTML($jobsch_vacancy, false, "no_make_clickable");
}
return $retval;
SC_END

SC_BEGIN JOBSALARY
global $tp, $jobsch_salary;
if (!empty($jobsch_salary))
{
	return $tp->toHTML($jobsch_salary);
}
else
{
	return JOBSCH_123;
}
SC_END

SC_BEGIN JOBCOMPANY
global $tp, $jobsch_companyinfoname;
return $tp->toHTML($jobsch_companyinfoname);
SC_END

SC_BEGIN JOBEMPLOYERDETAILS
global $tp, $jobsch_companyinfo;
return $tp->toHTML($jobsch_companyinfo);
SC_END

SC_BEGIN JOBEXPIRES
global $tp, $jobsch_closedate, $jobsch_gen;
if (empty($parm))
{
	$parm="short";
}
if ($jobsch_closedate > 0)
{
	if ($parm=="long" || $parm=="short")
	{
	    return $jobsch_gen->convert_date($jobsch_closedate, $parm);
	}
	else
	{
		return date($parm ,$jobsch_closedate);
	}
}
else
{
   	return $tp->toHTML(JOBSCH_43);
}
SC_END

SC_BEGIN JOBDETAILS
global $tp, $jobsch_vacancydetails;
return $tp->toHTML($jobsch_vacancydetails, true);

SC_END
SC_BEGIN JOBPHONE
global $tp, $jobsch_companyphone,$jobsch_vacancydetails;
if (!empty($jobsch_companyphone))
{
	return $tp->toHTML($jobsch_companyphone);
}
else
{
	return JOBSCH_126;
}
SC_END

SC_BEGIN JOBEMAIL
global $jobsch_email;
if (!empty($jobsch_email))
{
    $jobsch_addr = explode("@", $jobsch_email);
    $retval = "<script type='text/javascript'>
		<!--
		var jobsch_contact='" . $jobsch_addr[0] . " at " . $jobsch_addr[1] . "'
		var jobsch_email='" . $jobsch_addr[0] . "'
		var jobsch_emailHost='" . $jobsch_addr[1] . $subject . "'
		document.write(\"<a href=\" + \"mail\" + \"to:\" + jobsch_email + \"@\" + jobsch_emailHost+ \">\" + jobsch_contact + \"</a>\" + \"\")
		//-->
		</script>
		&nbsp;";
}
else
{
    $retval = JOBSCH_125;
}
return $retval;
SC_END

SC_BEGIN JOBDOWNLOAD
global $pref, $tp, $jobsch_document;
if (!empty($jobsch_document))
{
	switch ($pref['jobsch_pictype'])
	{
	    case 1:
	        if (!empty($jobsch_document) && file_exists("./documents/$jobsch_document"))
	        {
	            $retval .= "<a href='./documents/$jobsch_document' rel='external' >" . JOBSCH_110 . "</a>";
	        }
	        break;
	    case 2:
	        if (!empty($jobsch_document))
	        {
	            $retval .= "<a href='$jobsch_document' rel='external' >" . JOBSCH_110 . "</a>";
	        }
	        break;
	    case 0:
	    default:
	        $retval = JOBSCH_124;
	} // switch
}
else
{
	$retval = JOBSCH_124;
}
return $retval;
SC_END

SC_BEGIN JOBTERMS
global $pref, $tp;
return $tp->toHTML($pref['jobsch_terms'], true) ;
SC_END

SC_BEGIN JOBLOGO

return "<img src='./images/logo.png' alt='logo' style='border:0;'/>";
SC_END

SC_BEGIN JOBUPPAGE
global $tp, $pref, $jobsch_from, $jobsch_action, $jobsch_catid, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_local;
switch ($jobsch_action)
{
    case "sub":
        $jobsch_action = "cat";
        break;
    case "list":
        $jobsch_action = "sub";
        break;
    case "item":
        $jobsch_action = "list";
        break;
    case "tnc":
    default:
        $jobsch_action = "cat";
        break;
}
if ($parm == "icon")
{
    return "<a href='" . e_SELF . "?$jobsch_from.$jobsch_action.$jobsch_catid.$jobsch_subid.$jobsch_itemid.0.$jobsch_local'><img src='./images/updir.png' alt='Go Up' style='border:0;'/></a>";
}
else
{
    return "<a href='" . e_SELF . "?$jobsch_from.$jobsch_action.$jobsch_catid.$jobsch_subid.$jobsch_itemid.0.$jobsch_local'>" . JOBSCH_112 . "</a>";
}
SC_END
SC_BEGIN JOBEMAILLINK
global $jobsch_itemid;
if ($parm == "icon")
{
    return "<a href='../../email.php?plugin:job_search." . $jobsch_itemid . "'><img src='" . e_IMAGE . "generic/" . IMODE . "/email.png' style='border:0' alt='" . JOBSCH_78 . "' title='" . JOBSCH_78 . "' /></a>";
}
else
{
    return "<a href='../../email.php?plugin:job_search." . $jobsch_itemid . "'>" . JOBSCH_113 . "</a>";
}
SC_END

SC_BEGIN JOBPRINT
global $jobsch_itemid;
if ($parm == "icon")
{
    return "<a href='../../print.php?plugin:job_search.$jobsch_itemid' ><img src='" . e_IMAGE . "generic/" . IMODE . "/printer.png' style='border:0;' title='" . JOBSCH_77 . "' alt='" . JOBSCH_77 . "' /></a>";
}
else
{
    return "<a href='../../print.php?plugin:job_search.$jobsch_itemid' >" . JOBSCH_114 . "</a>";
}
SC_END

SC_BEGIN JOBTC
global $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_action, $jobsch_local;
if ($parm == "button")
{
    return "<input type='button' onclick='location.href=\"" . e_SELF . "?$jobsch_from.tnc.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_action.0.$jobsch_local\"' class='tbox' name='tcbutton' value='" . JOBSCH_41 . "' />";
}
else
{
    return "<a href='" . e_SELF . "?$jobsch_from.tnc.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_action'>" . JOBSCH_41 . "</a>";
}
SC_END

SC_BEGIN JOBMANAGE
global $pref, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_local;
if (USER && check_class($pref['jobsch_create']))
{
    if ($parm == "button")
    {
        $retval = "<input type='button' class='tbox' name='tcbutton' onclick='location.href=\"" . e_SELF . "?$jobsch_from.mge.$jobsch_catid.$jobsch_subid.$jobsch_itemid.0.$jobsch_local\"' value='" . JOBSCH_17 . "' />";
    }
    else
    {
        $retval = "<a href='" . e_SELF . "?$jobsch_from.mge.$jobsch_catid.$jobsch_subid.$jobsch_itemid.0.$jobsch_local'>" . JOBSCH_17 . "</a>";
    }
}
else
{
    $retval = "";
}

return $retval;
SC_END
SC_BEGIN JOB_NEXTPREV
global $tp, $jobsch_catid, $jobsch_subid, $mycId, $jobsch_count, $pref, $jobsch_from, $jobsch_local;
$jobsch_npaction = "list.$jobsch_catid.$jobsch_subid.$mycId.0.$jobsch_local";
$jobsch_npparms = $jobsch_count . "," . $pref['jobsch_perpage'] . "," . $jobsch_from . "," . e_SELF . '?' . "[FROM]." . $jobsch_npaction;
$jobsch_nextprev = $tp->parseTemplate("{NEXTPREV={$jobsch_npparms}}") . "";
return $jobsch_nextprev;

SC_END
SC_BEGIN JOBSUBSCRIBE
global $pref, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_local;
if ($pref['jobsch_subscribe'] > 0 && USER)
{
    if ($parm == "button")
    {
        $retval = "<input type='button' class='tbox' name='tcbutton' onclick='location.href=\"" . e_SELF . "?$jobsch_from.subs.$jobsch_catid.$jobsch_subid.$jobsch_itemid.0.$jobsch_local\"' value='" . JOBSCH_104 . "' />";
    }
    else
    {
        $retval = "<a href='" . e_SELF . "?$jobsch_from.subs.$jobsch_catid.$jobsch_subid.$jobsch_itemid.0.$jobsch_local'>" . JOBSCH_104 . "</a>";
    }
}
else
{
    $retval = "";
}
return $retval;
SC_END

SC_BEGIN JOBSUBME
global $sql;
$jobsch_subbed = false;
if ($sql->db_Select("jobsch_subs", "jobsch_subid", "jobsch_subuserid='" . USERID . "'"))
{
    $jobsch_subbed = true;
}
return JOBSCH_107 . "&nbsp;&nbsp;<input type='checkbox' name='jobsch_subme' " . ($jobsch_subbed?"checked='checked'":"") . "value = '1' class='tbox' />";
SC_END

SC_BEGIN JUBSUBOK
return "<input type='submit' class='tbox' name='jobsch_subsub' value='" . JOBSCH_108 . "' />";
SC_END

SC_BEGIN JOBSUBNOTE
return JOBSCH_109;
SC_END

SC_BEGIN JOB_NUMBER
global $pref, $jobsch_counter;
return $jobsch_counter;

SC_END
SC_BEGIN JOB_MOREINFO
global $jobsch_cid, $PLUGINS_DIRECTORY;
$plugindir = substr(e_PLUGIN, strpos(e_PLUGIN, "/", -2));
return "<a href='" . SITEURL . $PLUGINS_DIRECTORY . "job_search/jobshack.php?0.item.0.0.$jobsch_cid' >" . JOBSCH_A141 . "</a>";
SC_END

SC_BEGIN JOB_JOBSEARCHURL
global $PLUGINS_DIRECTORY;
return "<a href='" . SITEURL . $PLUGINS_DIRECTORY . "job_search/jobshack.php' >" . SITENAME . "</a>";
SC_END

SC_BEGIN JOB_JOBSEARCHUNSUBURL
global $PLUGINS_DIRECTORY;
return "<a href='" . SITEURL . $PLUGINS_DIRECTORY . "job_search/jobshack.php?0.subs' >" . JOBSCH_A142 . "</a>";
SC_END

SC_BEGIN JOBTODAY
global $tp;
$jobsch_time = time();
$jobsch_gen = new convert;
if (empty($parm))
{
	$parm="short";
}
	if ($parm=="long" || $parm=="short")
	{
	    return $jobsch_gen->convert_date($jobsch_time, $parm);
	}
	else
	{
		return date($parm ,$jobsch_time);
	}

SC_END

SC_BEGIN JOB_JOBSENDER
global $pref;
return $pref['jobsch_sysfrom'];
SC_END
* /
?>