<?php
/*
 * Copyright e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 *
 *
*/

if (!defined('e107_INIT'))
{
	exit;
}

/*
Array
(
    [jobsch_catid] => 2
    [jobsch_catname] => eeew
    [jobsch_catdesc] =>  dd
    [jobsch_catclass] => 0
    [jobsch_caticon] => 
    [jobsch_catsef] => eeew
)
*/

class plugin_job_search_category_shortcodes extends e_shortcode
{
	private $tp;
	private $jobsPref;


	function __construct()
	{
		$this->tp = e107::getParser();
		$this->jobsPref = e107::pref('jobs_search');
	}
	/* {JOBCATDESC} */
	function sc_jobcatdesc()
	{
		$jobsch_catdesc = $this->var['jobsch_catdesc'];
		$retval = $this->tp->toHTML($jobsch_catdesc);
		return $retval;
	}

	/* {JOBCATNAMELINK} */
	function sc_jobcatnamelink($parm = NULL)
	{

		$jobsch_catname = $this->tp->toHTML($this->var['jobsch_catname']);

		$link = $this->sc_jobcatlink();
		//$retval = "<a href='" . e_SELF . "?$jobsch_from.sub.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local' >" . $tp->toHTML($jobsch_catname) . "</a>";
		$retval = "<a href='" . $link . "'>" . $jobsch_catname . "</a>";

		return $retval;
	}


	/* {JOBCATNAME} */
	function sc_jobcatname($parm = NULL)
	{

		$jobsch_catname = $this->tp->toHTML($this->var['jobsch_catname']);

		return $jobsch_catname;
	}

	/* {JOBCATLINK} */
	function sc_jobcatlink($parm = NULL)
	{
		$jobsch_catlink = e107::url('job_search', 'category', $this->var);

		return 	$jobsch_catlink;
	}

	/* {JOBCATCOUNT} */
	function sc_jobcatcount($parm = NULL)
	{
		if (isset($this->var['jobsch_count'])) return $this->var['jobsch_count'];
		else return "";
	}


	/*{JOBSUBLIST} */
	function sc_jobsublist()
	{
		global  $jobsch_local,   $jobsch_from,   $jobsch_subid, $jobsch_itemid, $jobsch_tmp, $jobsch_local;

		$jobsch_catid = $this->var['jobsch_catid'];
		$jobsch_today = $this->var['jobsch_today'];

		$jobsch_subss = e107::getDb()->retrieve("jobsch_subcats", "*", "jobsch_categoryid=$jobsch_catid  order by jobsch_subname", true);

		if ($jobsch_subss)
		{
			$jobsch_selector = "<select class='tbox' name='jobsch_subid[]' onchange='this.form.submit()' >";
			$jobsch_selector .= "<option value='0' selected='selected'>" . JOBSCH_98 . "</option>";
			$jobsch_where = ($jobsch_local > 0 ? " and (jobsch_locality='{$jobsch_local}' or jobsch_locality=0)" : "");
			foreach ($jobsch_subss as $jobsch_subs)

			{
				extract($jobsch_subs);
				// $jobsch_count = e107::getDb()->select("jobsch_ads", "jobsch_cid", " jobsch_category=$jobsch_subid $jobsch_where " .
				// 	($this->jobsPref['jobsch_approval'] == 1 ? " and jobsch_approved > 0" : "") . " 
				// 	and (jobsch_closedate = 0 or jobsch_closedate='' or jobsch_closedate is null or jobsch_closedate>$jobsch_today)", "nowhere", false);

				$jobsch_count = e107::getDb()->select(
					"jobsch_ads",
					"jobsch_cid",
					" jobsch_category=$jobsch_subid $jobsch_where" .
						($this->jobsPref['jobsch_approval'] == 1 ? " AND jobsch_approved > 0" : "") .
						" AND (jobsch_closedate = 0 OR jobsch_closedate = '' OR jobsch_closedate IS NULL OR jobsch_closedate > $jobsch_today)",
					false,
					false
				);


				if ($this->jobsPref['jobsch_subdrop'] == 1)
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
						$catsubs .= "<a href='" . e_SELF . "?$jobsch_from.list.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_tmp.$jobsch_local' >" . $this->tp->toHTML($jobsch_subname, false) . " ($jobsch_count)</a><br />";
					}
					else
					{
						$catsubs .= $this->tp->toHTML($jobsch_subname, false) . " ($jobsch_count)<br />";
					}
				}
			}
			$jobsch_selector .= "</select>&nbsp;&nbsp;<input type='button' class='tbox' onclick='this.form.submit()' name='submitit[]' value='" . JOBSCH_97 . "' />";
		}
		else
		{
			$catsubs = JOBSCH_81;
		}
		return ($this->jobsPref['jobsch_subdrop'] == 1 ? $jobsch_selector : $catsubs);
	}
}
