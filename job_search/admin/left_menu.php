<?php

class job_search_adminArea extends e_admin_dispatcher
{

	protected $modes = array(

		'main'	=> array(
			'controller' 	=> 'job_search_ui',
			'path' 			=> null,
			'ui' 			=> 'job_search_form_ui',
			'uipath' 		=> null
		),

		'cat'	=> array(
			'controller' 	=> 'jobsch_cats_ui',
			'path' 			=> null,
			'ui' 			=> 'jobsch_cats_form_ui',
			'uipath' 		=> null
		),


	);


	protected $adminMenu = array(

		'main/prefs' 		=> array('caption' => JOBSCH_A2, 'perm' => 'P'),

		'cat/list'			=> array('caption' => LAN_MANAGE, 'perm' => 'P'),
		'cat/create'		=> array('caption' => LAN_CREATE, 'perm' => 'P'),

	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = JOBSCH_A1;

	/**
	 * Generic Admin Menu Generator
	 * @return string
	 */
	public function renderMenu()
	{

		$action = basename($_SERVER['PHP_SELF'], ".php");

		$var['admin_config']['text'] = JOBSCH_A2;
		$var['admin_config']['link'] = "admin_config.php";

		$var['admin_cat']['text'] = JOBSCH_A3;
		$var['admin_cat']['link'] = "admin_cat.php?mode=cat&action=list";

		$var['admin_sub']['text'] = JOBSCH_A4;
		$var['admin_sub']['link'] = "admin_sub.php";

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

		//return e107::getNav()->admin($this->menuTitle, $selected, $var);
	}
}
