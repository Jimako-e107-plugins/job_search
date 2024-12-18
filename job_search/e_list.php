<?php
if (!defined('e107_INIT')) { exit; }
if (!$eclassif_install = $sql->db_Select("plugin", "*", "plugin_path = 'job_search' AND plugin_installflag = '1' "))
{
    return;
}
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/English.php");
}
$LIST_CAPTION = $arr[0];
$LIST_DISPLAYSTYLE = ($arr[2] ? "" : "none");

$todayarray = getdate();
$current_day = $todayarray['mday'];
$current_month = $todayarray['mon'];
$current_year = $todayarray['year'];
$current = mktime(0, 0, 0, $current_month, $current_day, $current_year);

if ($mode == "new_page" || $mode == "new_menu")
{
    $lvisit = $this->getlvisit();
    $qry = " (jobsch_closedate = 0  or jobsch_closedate is null or jobsch_closedate>$current) ".
($pluginPref['jobsch_approval']==1?" and jobsch_approved > 0":"" )." and jobsch_postdate>" . $lvisit ;
}
else
{
    $qry = "(jobsch_closedate = 0  or jobsch_closedate is null or jobsch_closedate>$current) and jobsch_cid>0 ".
($pluginPref['jobsch_approval']==1?" and jobsch_approved > 0":"" )." ";
}

$bullet = $this->getBullet($arr[6], $mode);

$qry = "
	SELECT r.*, c.jobsch_subname,c.jobsch_subid,c.jobsch_subname,d.jobsch_catid,d.jobsch_catname
	FROM #jobsch_ads AS r
	LEFT JOIN #jobsch_subcats AS c ON r.jobsch_category = c.jobsch_subid
    LEFT JOIN #jobsch_cats as d on d.jobsch_catid=c.jobsch_categoryid
	WHERE " . $qry . "
	ORDER BY r.jobsch_last ASC LIMIT 0," . $arr[7];
if (!$jobsch_items = $sql->db_Select_gen($qry))
{
    $LIST_DATA = JOBSCH_76;
}
else
{
    while ($row = $sql->db_Fetch())
    {
        $tmp = explode(".", $row['jobsch_submittedby'],2);
        if ($tmp[0] == "0")
        {
            $AUTHOR = $tmp[1];
        } elseif (is_numeric($tmp[0]) && $tmp[0] != "0")
        {
            $AUTHOR = (USER ? "<a href='" . e_BASE . "user.php?id." . $tmp[0] . "'>" . $tmp[1] . "</a>" : $tmp[1]);
        }
        else
        {
            $AUTHOR = "";
        }

        $rowheading = $this->parse_heading($row['jobsch_vacancy'], $mode);
        $ICON = $bullet;
        $HEADING = "<a href='" . e_PLUGIN . "job_search/job_shack.php?0.item." . $row['jobsch_catid'] . "." . $row['jobsch_subid'] . "." . $row['jobsch_cid'] . "' title='" . $row['jobsch_vacancy'] . "'>" . $rowheading . "</a>";
        $CATEGORY = $row['jobsch_catname']." - ".$row['jobsch_subname'];
        $DATE = ($arr[5] ? ($row['jobsch_postdate'] ? $this->getListDate($row['jobsch_postdate'], $mode) : "") : "");
        $INFO = "";
        $LIST_DATA[$mode][] = array($ICON, $HEADING, $AUTHOR, $CATEGORY, $DATE, $INFO);
    }
}

?>
