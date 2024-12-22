<?php
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* e107 JM Menus Plugin
*
* #######################################
* #     e107 website system plugin      #
* #     by Jimako                    	 #
* #     https://www.e107sk.com          #
* #######################################
*/

if (!defined('e107_INIT'))
{
	exit;
}

//v2.x Standard for extending menu configuration within Menu Manager. (replacement for v1.x config.php)

class job_search_menu
{
	function __construct()
	{
		// e107::lan('jm_shortcode','menu',true); // English_menu.php or {LANGUAGE}_menu.php
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu = '')
	{

		$fields = array();

		switch ($menu)
		{
			case "ejobs_categories":

				$templates = e107::getLayouts(JOBS_FOLDER, 'jobs_category_menu', 'front', null, false, false);

				$fields['categories_title']      = array('title' => "Caption", 'type' => 'text', 'multilan' => true, 'writeParms' => array('size' => 'xxlarge'));
				$fields['categories_hide_empty']      = array('title' => "Hide Empty", 'type' => 'boolean', 'multilan' => false);
				$fields['categories_count']      = array('title' => "Display count", 'type' => 'boolean', 'multilan' => false);
				$fields['categories_template']      = array('title' => LAN_TEMPLATE, 'type' => 'dropdown', 'tab' => 0, 'writeParms' => array('optArray' => $templates));
				return $fields;



				return $fields;

				// case "block_code":

				// 	$fields['block_title']        = array('title'=> "Caption", 'type'=>'text', 'multilan'=>true, 'writeParms'=>array('size'=>'xxlarge'));
				// 	$fields['block_content']      = array('title'=> "HTML code", 'type'=>'textarea', 'writeParms'=>array('size'=>'xxlarge'));
				// 	$fields['block_style']        = array('title'=> "Style code [theme support]", 'type'=>'text', 'writeParms'=>array('size'=>'xxlarge' ));              
				// 	$fields['block_tablestyle']   = array('title'=> "ID/Mode for tablestyle [theme support]", 'type'=>'text', 'writeParms'=>array('size'=>'xxlarge' ));  
				// return $fields;
		}
	}
}
