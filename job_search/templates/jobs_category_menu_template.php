<?php

/**
 * Copyright (C) e107 Inc (e107.org), Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 * $Id$
 */

if (!defined('e107_INIT'))  exit;

$JOBS_CATEGORY_MENU_TEMPLATE = array();

$JOBS_CATEGORY_MENU_WRAPPER['default']['item']['JOBCATCOUNT'] = '<span class="badge text-bg-primary rounded-pill">{---}</span>';

// category menu
$JOBS_CATEGORY_MENU_TEMPLATE['default']['header']      = "";
$JOBS_CATEGORY_MENU_TEMPLATE['default']['start']       = '<ul class="list-group jobs-menu-category">';
$JOBS_CATEGORY_MENU_TEMPLATE['default']['end']         = '</ul>';
$JOBS_CATEGORY_MENU_TEMPLATE['default']['item']        = '
	<li class="list-group-item d-flex justify-content-between align-items-start">
		<a class="e-menu-link" href="{JOBCATLINK}">{JOBCATNAME}</a>{JOBCATCOUNT}
	</li>
';
$JOBS_CATEGORY_MENU_TEMPLATE['default']['footer']      = "";



$JOBS_CATEGORY_MENU_WRAPPER['test']['item']['JOBCATCOUNT'] = '<span class="badge text-bg-primary rounded-pill">{---}</span>';

// category menu
$JOBS_CATEGORY_MENU_TEMPLATE['test']['header']      = "";
$JOBS_CATEGORY_MENU_TEMPLATE['test']['start']       = '<ul class="list-group jobs-menu-category">';
$JOBS_CATEGORY_MENU_TEMPLATE['test']['end']         = '</ul>';
$JOBS_CATEGORY_MENU_TEMPLATE['test']['item']        = '
	<li class="list-group-item d-flex justify-content-between align-items-start">
		<a class="e-menu-link" href="{JOBCATLINK}">{JOBCATNAME}</a>{JOBCATCOUNT}
	</li>
';
$JOBS_CATEGORY_MENU_TEMPLATE['test']['footer']      = "";
