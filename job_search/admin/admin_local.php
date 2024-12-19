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


class jobsch_locals_ui extends e_admin_ui
{

	protected $pluginTitle		= 'Job Search';
	protected $pluginName		= 'job_search';
	//	protected $eventName		= 'job_search-'; // remove comment to enable event triggers in admin. 		
	protected $table			= 'jobsch_locals';
	protected $pid				= 'jobsch_localid';
	protected $perPage			= 10;
	protected $batchDelete		= true;
	protected $batchExport     = true;
	protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('tab1'=>'Tab 1', 'tab2'=>'Tab 2'); // Use 'tab'=>'tab1'  OR 'tab'=>'tab2' in the $fields below to enable. 

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'jobsch_localid DESC';

	protected $fields 		= array(
		'checkboxes'              => array('title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => 'value', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' => [], 'writeParms' => [],),
		'jobsch_localid'          => array('title' => LAN_ID, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_localname'        => array('title' => JOBSCH_A123, 'type' => 'text', 'data' => 'safestr', 'width' => 'auto', 'validate' => true, 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_localflag'        => array('title' => JOBSCH_95, 'type' => 'icon', 'data' => 'safestr', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'options'                 => array('title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => 'value', 'readParms' => [], 'writeParms' => [],),
	);

	protected $fieldpref = array('jobsch_localid', 'jobsch_localname', 'jobsch_localflag');


	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array();


	function AddButton()
	{
		$text = "</fieldset></form><div class='e-container'>
      <table  style='" . ADMIN_WIDTH . "' class='table adminlist table-striped'>";
		$text .=
			'<a href="admin_local.php?mode=local&action=create"  
      class="btn batch e-hide-if-js btn-success"><span>' . JOBSCH_A21 . '</span></a>';
		$text .= "</td></tr></table></div><form><fieldset>";
		return $text;
	}


	public function init()
	{

		$this->postFilterMarkup = $this->AddButton();
	}

	// ------- Customize Create --------

    // function beforeDelete() {
	// 	define("JOBSCH_A124","Locality in use - can not delete");
 

	// }


	public function beforeCreate($new_data, $old_data)
	{
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onCreateError($new_data, $old_data)
	{
		// do something		
	}


	// ------- Customize Update --------

	public function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
		// do something	
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something		
	}

	// left-panel help menu area. (replaces e_help.php used in old plugins)
	public function renderHelp()
	{
		$caption = LAN_HELP;
		$text = 'Some help text';

		return array('caption' => $caption, 'text' => $text);
	}

 
}



class jobsch_locals_form_ui extends e_admin_form_ui
{
}

new job_search_adminArea();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN . "footer.php");
exit;
