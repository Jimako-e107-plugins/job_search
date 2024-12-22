<?php
require_once("../../../class2.php");
if (!defined('e107_INIT'))
{
	exit;
}

if (!getperms("P"))
{
	header("location:" . e_BASE . "index.php");
	exit;
}

if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php"))
{
	include_once(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php");
}
else
{
	include_once(e_PLUGIN . "job_search/languages/admin/English.php");
}

include_once(e_PLUGIN . "job_search/admin/left_menu.php");

class jobsch_subs_ui extends e_admin_ui
{

	protected $pluginTitle		= 'Job Search';
	protected $pluginName		= 'job_search';
	//	protected $eventName		= 'job_search-jobsch_subs'; // remove comment to enable event triggers in admin. 		
	protected $table			= 'jobsch_subs';
	protected $pid				= 'jobsch_subid';
	protected $perPage			= 10;
	protected $batchDelete		= true;
	protected $batchExport     = true;
	protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('tab1'=>'Tab 1', 'tab2'=>'Tab 2'); // Use 'tab'=>'tab1'  OR 'tab'=>'tab2' in the $fields below to enable. 

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'jobsch_subid DESC';

	protected $fields 		= array(
		'checkboxes'              => array('title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => 'value', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' => [], 'writeParms' => [],),
		'jobsch_subid'            => array('title' => 'Subid', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_subuserid'        => array('title' => 'Subuserid', 'type' => 'user', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_subemail'         => array('title' => 'Subemail', 'type' => 'email', 'data' => 'safestr', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'options'                 => array('title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => 'value', 'readParms' => [], 'writeParms' => [],),
	);

	protected $fieldpref = array('jobsch_subid', 'jobsch_subuserid', 'jobsch_subemail');

	//	protected $filterSort = ['field_key_5', 'field_key_7']; // Display these fields first in the filter drop-down. 

	//	protected $batchSort = ['field_key_5', 'field_key_7'];; // Display these fields first in the batch drop-down.


	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array();


	public function init()
	{

		$this->getRequest()->setMode('subs');
	}

	// left-panel help menu area. (replaces e_help.php used in old plugins)
	public function renderHelp()
	{
		$caption = LAN_HELP;
		$text = 'Just trying to understood how this should work. jobsch_subemail is not used at all, actual user email is used. This is really very simple and outdated solution.';

		return array('caption' => $caption, 'text' => $text);
	}

 
}



class jobsch_subs_form_ui extends e_admin_form_ui
{
}


new job_search_adminArea();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN . "footer.php");
exit;
