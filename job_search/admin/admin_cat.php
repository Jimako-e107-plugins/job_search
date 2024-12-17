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


class jobsch_cats_ui extends e_admin_ui
{

	protected $pluginTitle		= 'Job Search';
	protected $pluginName		= 'job_search';
	//	protected $eventName		= 'job_search-'; // remove comment to enable event triggers in admin. 		
	protected $table			= 'jobsch_cats';
	protected $pid				= 'jobsch_catid';
	protected $perPage			= 10;
	protected $batchDelete		= true;
	protected $batchExport     = true;
	protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('tab1'=>'Tab 1', 'tab2'=>'Tab 2'); // Use 'tab'=>'tab1'  OR 'tab'=>'tab2' in the $fields below to enable. 

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'jobsch_catid DESC';

	protected $fields 		= array(
		'checkboxes'              => array('title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => 'value', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' => [], 'writeParms' => [],),
		'jobsch_catid'            => array('title' => 'Catid', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_caticon'          => array('title' => JOBSCH_95, 'type' => 'icon', 'data' => 'safestr', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_catname'          => array('title' => JOBSCH_A25, 'type' => 'text', 'data' => 'safestr', 'width' => 'auto', 'filter' => true, 'inline' => true, 'validate' => true, 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_catdesc'          => array('title' => JOBSCH_A26, 'type' => 'textarea', 'data' => 'safestr', 'width' => 'auto', 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'jobsch_catclass'         => array('title' => JOBSCH_A27, 'type' => 'userclass', 'data' => 'int', 'width' => 'auto', 'batch' => true, 'filter' => true, 'help' => '', 'readParms' => [], 'writeParms' => [], 'class' => 'left', 'thclass' => 'left',),
		'options'                 => array('title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => 'value', 'readParms' => [], 'writeParms' => [],),
	);

	protected $fieldpref = array('jobsch_catid', 'jobsch_caticon' , 'jobsch_catname', 'jobsch_catdesc', 'jobsch_catclass' );


	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array();


	public function init()
	{
		$this->fields['jobsch_catname']['writeParms']['size'] = 'block-level'  ;
		$this->fields['jobsch_catdesc']['writeParms']['size'] = 'block-level';
		$this->postFilterMarkup = $this->AddButton();
	}

	function AddButton()
	{
		$text = "</fieldset></form><div class='e-container'>
      <table  style='" . ADMIN_WIDTH . "' class='table adminlist table-striped'>";
		$text .=
			'<a href="admin_cat.php?mode=cat&action=create"  
      class="btn batch e-hide-if-js btn-success"><span>'. JOBSCH_A21.'</span></a>';
		$text .= "</td></tr></table></div><form><fieldset>";
		return $text;
	}
	
	// function beforeDelete() {
	// 	//define("JOBSCH_A29", "Category in use. Can not delete.");
	// 	//define("JOBSCH_A31","Unable to delete category");

	// }
}
class jobsch_cats_form_ui extends e_admin_form_ui
{
}


new job_search_adminArea();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN . "footer.php");
exit;
