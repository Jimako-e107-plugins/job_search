<?php
/*
 * e107 Bootstrap CMS
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * 
 * IMPORTANT: Make sure the redirect script uses the following code to load class2.php: 
 * 
 * 	if (!defined('e107_INIT'))
 * 	{
 * 		require_once(__DIR__.'/../../class2.php');
 * 	}
 * 
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

class job_search_url // plugin-folder + '_url'
{
	function config() 
	{
		$config = array();

		$alias = 'jobs';
 
		$config['category'] = array(
			'alias'         => "{$alias}/category",
			'regex'			=> '^{alias}-(\d*)-([\w-]*)\/?\??(.*)',
			'sef'			=> '{alias}-{jobsch_catid}-{jobsch_catsef}/',
			'redirect'		=> '{e_PLUGIN}'.JOBS_FOLDER.'/jobs_category.php?id=$1&sef=$2'
		);


		// $config['index'] = array(
		// 	'alias'         => "{$alias}/",
		// 	'regex'			=> '^{alias}/$',
		// 	'sef'			=> '{alias}/',
		// 	'redirect'		=> '{e_PLUGIN}jobs/jobs.php'
		// );
 
		return $config;
	}
	

}
