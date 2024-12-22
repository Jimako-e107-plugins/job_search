<?php


// job_search Shortcodes file

if (!defined('e107_INIT'))
{
	exit;
}

class plugin_job_search_job_search_shortcodes extends e_shortcode
{
	/* JOBLOGO */
	function sc_joblogo()
	{

		return "<img src='" . e_PLUGIN_ABS . "job_search/images/logo.png' alt='logo' style='border:0;'/>";
	}

	/* JOBLOCALSELECTOR */
	function sc_joblocalselector($jobsch_local = false)
	{
		$sql = e107::getDb();
		$retval = "<select class='tbox' name='jobsch_local' onchange='this.form.submit()'>";
		$retval .= "<option value='0' selected='selected'>" . JOBSCH_101 . "</option>";
		if ($sql->db_Select("jobsch_locals", "*", "order by jobsch_localname", "nowhere"))
		{
			while ($jbsrch_row = $sql->db_Fetch())
			{
				$retval .= "<option value='" . $jbsrch_row['jobsch_localid'] . "' " . ($jbsrch_row['jobsch_localid'] == $jobsch_local ? "selected='selected'" : "") . ">" . $jbsrch_row['jobsch_localname'] . "</option>";
			} // while
		}

		$retval .= "</select>&nbsp;<input type='button' onclick='this.form.submit()' class='tbox' name='jobsel' value='" . JOBSCH_97 . "' />";
		return $retval;
	}

	/* JOB_NEXTPREV */
	function sc_job_nextprev()
	{

		global $jobsch_catid, $jobsch_subid, $mycId, $jobsch_count, $pluginPref, $jobsch_from, $jobsch_local;

		$tp = e107::getParser();
		$jobsch_npaction = "list.$jobsch_catid.$jobsch_subid.$mycId.0.$jobsch_local";

		$jobsch_npparms = $jobsch_count . "," . $pluginPref['jobsch_perpage'] . "," . $jobsch_from . "," . e_SELF . '?' . "[FROM]." . $jobsch_npaction;
		$jobsch_nextprev = $tp->parseTemplate("{NEXTPREV={$jobsch_npparms}}") . "";
		return $jobsch_nextprev;
	}


	/* JOBMANAGE */
	function sc_jobmanage($parm = NULL)
	{
		global $pluginPref, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_local;
		if (USER && check_class($pluginPref['jobsch_create']))
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
	}

	/* JOBTC */
	function sc_jobtc($parm = NULL)
	{
		global $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_action, $jobsch_local;
		if ($parm == "button")
		{
			return "<input type='button' onclick='location.href=\"" . e_SELF . "?$jobsch_from.tnc.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_action.0.$jobsch_local\"' class='tbox' name='tcbutton' value='" . JOBSCH_41 . "' />";
		}
		else
		{
			return "<a href='" . e_SELF . "?$jobsch_from.tnc.$jobsch_catid.$jobsch_subid.$jobsch_itemid.$jobsch_action'>" . JOBSCH_41 . "</a>";
		}
	}

	/*  JOBSUBSCRIBE */
	function sc_jobsubscribe($parm = NULL)
	{

		global $pluginPref, $jobsch_from, $jobsch_catid, $jobsch_subid, $jobsch_itemid, $jobsch_local;
		if ($pluginPref['jobsch_subscribe'] > 0 && USER)
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
	}
}
