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



class job_search_ui extends e_admin_ui
{

	protected $pluginTitle		= JOBSCH_A1;
	protected $pluginName		= 'job_search';
	//	protected $eventName		= 'job_search-'; // remove comment to enable event triggers in admin. 		
	protected $table			= '';
	protected $pid				= '';
	protected $perPage			= 10;
	protected $batchDelete		= true;
	protected $batchExport     = true;
	protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	protected $tabs				= array('0'=> JOBSCH_A2,  ); // Use 'tab'=>'tab1'  OR 'tab'=>'tab2' in the $fields below to enable. 

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= ' DESC';

	protected $fields 		= array();

	protected $fieldpref = array();


	protected $preftabs        = array(0 => JOBSCH_A2 );
	protected $prefs = array(
		'jobsch_approval'		=> array('title' => JOBSCH_A7, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_valid'		=> array('title' => JOBSCH_A10, 'tab' => 0, 'type' => 'number', 'data' => 'str', 'help' => JOBSCH_A11, 'writeParms' => []),
		'jobsch_read'		=> array('title' => JOBSCH_A37, 'tab' => 0, 'type' => 'userclass', 'data' => 'str', 'help' => 'public,guest, nobody, member, admin, classes', 'writeParms' => []),
		'jobsch_admin'		=> array('title' => JOBSCH_A38, 'tab' => 0, 'type' => 'userclass', 'data' => 'str', 'help' => 'nobody, member, admin, classes', 'writeParms' => []),
		'jobsch_create'		=> array('title' => JOBSCH_A53, 'tab' => 0, 'type' => 'userclass', 'data' => 'str', 'help' => 'nobody, member, admin, classes', 'writeParms' => []),
		'jobsch_subscribe'		=> array('title' => JOBSCH_A131, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_usexp'		=> array('title' => JOBSCH_A154, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_useremail'		=> array('title' => JOBSCH_A39, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
 		'jobsch_icons'		=> array('title' =>JOBSCH_A113, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_subdrop'		=> array('title' => JOBSCH_A120, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_pictype'		=> array('title' => JOBSCH_A40, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_sort'		=> array('title' => JOBSCH_A153, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_currency'		=> array('title' =>JOBSCH_A95, 'tab' => 0, 'type' => 'text', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_perpage'		=> array('title' => JOBSCH_A42, 'tab' => 0, 'type' => 'number', 'data' => 'str',   'writeParms' => []),
		'jobsch_leadz'		=> array('title' => JOBSCH_A109, 'tab' => 0, 'type' => 'number', 'data' => 'str',   'writeParms' => []),
		'jobsch_sysemail'		=> array('title' => JOBSCH_A144, 'tab' => 0, 'type' => 'text', 'data' => 'str',   'writeParms' => []),
		'jobsch_dform'		=> array('title' => JOBSCH_A156, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_counter'		=> array('title' => JOBSCH_A117, 'tab' => 0, 'type' => 'dropdown', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_terms'		=> array('title' => JOBSCH_A41, 'tab' => 0, 'type' => 'bbarea', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_metad'		=> array('title' => JOBSCH_A96, 'tab' => 0, 'type' => 'textarea', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_metak'		=> array('title' => JOBSCH_A97, 'tab' => 0, 'type' => 'textarea', 'data' => 'str', 'help' => '', 'writeParms' => []),
	);


	public function init()
	{

		 
		$jobsch_approval_options = array(
			'1' => JOBSCH_A8,
			'0' => JOBSCH_A9
		);

		$jobsch_pictype_options = array(
			'0' => JOBSCH_A98,
			'1' => JOBSCH_A99,
			'2' => JOBSCH_A100
		);

		$jobsch_sort_options = array(
			'ASC' => JOBSCH_A151,
			'DESC' => JOBSCH_A152
		);

		$jobsch_dform_options = [
			'd-m-Y' => 'd-m-Y',
			'm-d-Y' => 'm-d-Y',
			'Y-m-d' => 'Y-m-d',
		];

		$jobsch_counter_options = [
			'NONE' => JOBSCH_A118,
			'ALL' => JOBSCH_A119,
			'cb' => 'Coloured Blocks',
			'crt' => 'CRTs',
			'flame' => 'Flames',
			'floppy' => 'Floppy Disks',
			'heart' => 'Hearts',
			'jelly' => 'Jelly',
			'lcd' => 'LCD HP Calculator',
			'lcdg' => 'LED Green',
			'purple' => 'Purple',
			'slant' => 'Slant',
			'snowm' => 'Snowman',
			'text' => 'Text',
			'tree' => 'Christmas Tree',
			'turf' => 'Turf',
		];


		$this->prefs['jobsch_approval']['writeParms']['optArray'] = $jobsch_approval_options;
		$this->prefs['jobsch_approval']['writeParms']['default'] = "0";
		$this->prefs['jobsch_read']['writeParms']['classlist'] = "public,guest, nobody, member, admin, classes";
		$this->prefs['jobsch_admin']['writeParms']['classlist'] = "nobody, member, admin, classes";
		$this->prefs['jobsch_create']['writeParms']['classlist'] = "nobody, member, admin, classes";
		$this->prefs['jobsch_pictype']['writeParms']['optArray'] = $jobsch_pictype_options;
		$this->prefs['jobsch_pictype']['writeParms']['default'] = "0";
		$this->prefs['jobsch_sort']['writeParms']['optArray'] = $jobsch_sort_options;
		$this->prefs['jobsch_sort']['writeParms']['default'] = "0";
		$this->prefs['jobsch_dform']['writeParms']['optArray'] = $jobsch_dform_options;
		$this->prefs['jobsch_dform']['writeParms']['default'] = "0";

		$this->prefs['jobsch_counter']['writeParms']['optArray'] = $jobsch_counter_options;
		$this->prefs['jobsch_counter']['writeParms']['default'] = "NONE";

		$this->prefs['jobsch_metak']['writeParms']['size'] = "block-level";
		$this->prefs['jobsch_metad']['writeParms']['size'] = "block-level";

		
	}

	// ------- Customize Create --------

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

	/*	
		// optional - a custom page.  
		public function customPage()
		{
			if($this->getPosted('custom-submit')) // after form is submitted. 
			{
				e107::getMessage()->addSuccess('Changes made: '. $this->getPosted('example'));
			}

			$this->addTitle('My Custom Title');


			$frm = $this->getUI();
			$text = $frm->open('my-form', 'post');

				$tab1 = "<table class='table table-bordered adminform'>
					<colgroup>
						<col class='col-label'>
						<col class='col-control'>
					</colgroup>
					<tr>
						<td>Label ".$frm->help('A help tip')."</td>
						<td>".$frm->text('example', $this->getPosted('example'), 80, ['size'=>'xlarge'])."</td>
					</tr>
					</table>";

			// Display Tab
			$text .= $frm->tabs([
				'general'   => ['caption'=>LAN_GENERAL, 'text' => $tab1],
			]);

			$text .= "<div class='buttons-bar text-center'>".$frm->button('custom-submit', 'submit', 'submit', LAN_CREATE)."</div>";
			$text .= $frm->close();

			return $text;
			
		}
			
		
		
	*/
}



class job_search_form_ui extends e_admin_form_ui
{
}

new job_search_adminArea();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN . "footer.php");
exit;

 

?>
