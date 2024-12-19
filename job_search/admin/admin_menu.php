<?php
/*
+---------------------------------------------------------------+
|	e107 website system
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }
if(e_LANGUAGE !="English" && file_exists(e_PLUGIN."job_search/languages/admin/".e_LANGUAGE.".php"))
{
	include_once(e_PLUGIN."job_search/languages/admin/".e_LANGUAGE.".php");
}
else
{
	include_once(e_PLUGIN."job_search/languages/admin/English.php");
}
$action = basename($_SERVER['PHP_SELF'], ".php");

$var['admin_config']['text'] = JOBSCH_A2;
$var['admin_config']['link'] = "admin_config.php";

$var['admin_cat']['text'] = JOBSCH_A3;
$var['admin_cat']['link'] = "admin_cat.php?mode=cat&action=list";

$var['admin_sub']['text'] = JOBSCH_A4;
$var['admin_sub']['link'] = "admin_sub.php?mode=sub&action=list";

$var['admin_local']['text'] = JOBSCH_A130;
$var['admin_local']['link'] = "admin_local.php";

$var['admin_ad']['text'] = JOBSCH_A54;
$var['admin_ad']['link'] = "admin_ad.php";

$var['admin_submit']['text'] = JOBSCH_A5;
$var['admin_submit']['link'] = "admin_submit.php";

$var['admin_purge']['text'] = JOBSCH_A101;
$var['admin_purge']['link'] = "admin_purge.php";

$var['admin_docs']['text'] = JOBSCH_A103;
$var['admin_docs']['link'] = "admin_docs.php";

$var['admin_news']['text'] = JOBSCH_A132;
$var['admin_news']['link'] = "admin_news.php";


show_admin_menu(JOBSCH_A1, $action, $var);
?>
