<?php

/**
 * Copyright (C) 2008-2011 e107 Inc (e107.org), Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 * $Id$
 * 
 * News categories menu
 */

if (!defined('e107_INIT'))
{
	exit;
}

// $cacheString = 'nq_' .  JOBS_DEF_CATEGORY_CACHE_STRING . '_menu_' . md5(serialize($parm) . USERCLASS_LIST . e_LANGUAGE);
// $cached = e107::getCache()->retrieve($cacheString);
// $cached = false;

// if (false === $cached)
// {
// 	e107::plugLan(JOBS_DEF_PLUGIN_FOLDER);

// 	if (is_string($parm))
// 	{
// 		parse_str($parm, $parms);
// 	}
// 	else
// 	{
// 		$parms = $parm;
// 	}

// 	e107::getCache()->set($cacheString, $cached);
// }

// echo $cached;

$caption = JOBSCH_1;

if (isset($parm['categories_title']))
{
	if (isset($parm['categories_title'][e_LANGUAGE]))
	{
		$caption = $parm['categories_title'][e_LANGUAGE];
	}
	else $caption = $parm['categories_title'];
}

if (!isset($parm['categories_hide_empty'])) $parm['categories_hide_empty'] = 0;
if (!isset($parm['categories_count'])) $parm['categories_count'] = 0;
if (!isset($parm['categories_template'])) $parm['categories_template'] = "default";


$ns = e107::getRender();
$tp = e107::getParser();


$template = e107::getTemplate(JOBS_FOLDER, 'jobs_category_menu', $parm['categories_template']);
$wrapperKey =  'jobs_category_menu/' . $parm['categories_template'] . '/item';

$jobsch_sc = e107::getScBatch('category', JOBS_FOLDER)->wrapper($wrapperKey);;  //category data


$jobsearch_shortcodes = e107::getScBatch(JOBS_FOLDER, true, 'job_search');  //for header and footer, common for more templates

$JOBSCH_CAT_HEADER = $template['header'];
$JOBSCH_CAT_START = $template['start'];
$JOBSCH_CAT_DETAIL = $template['item'];
$JOBSCH_CAT_END = $template['end'];
$JOBSCH_CAT_FOOTER = $template['footer'];

$jobsch_header = $tp->parsetemplate($JOBSCH_CAT_HEADER, false, $jobsearch_shortcodes);

$jobsch_rows = ejobs::getCategories();

$jobsch_text = $JOBSCH_CAT_START;
foreach ($jobsch_rows as $jobsch_row)
{
	if ($parm['categories_hide_empty']  && $jobsch_row['jobsch_count'] == 0) continue;

	$jobsch_row['jobsch_today'] = $this->jobsch_today;
	$jobsch_sc->setVars($jobsch_row);

	$jobsch_text .= $tp->parsetemplate($JOBSCH_CAT_DETAIL, false, $jobsch_sc);
}
$jobsch_text .= $JOBSCH_CAT_FOOTER;

$jobsch_footer = $tp->parsetemplate($JOBSCH_CAT_FOOTER, false, $jobsearch_shortcodes);

$jobsch_page = JOBSCH_128;

$ns->tablerender($caption, $jobsch_header . $jobsch_text . $jobsch_footer);
