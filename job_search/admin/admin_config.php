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




class job_search_adminArea extends e_admin_dispatcher
{

	protected $modes = array(

		'main'	=> array(
			'controller' 	=> 'job_search_ui',
			'path' 			=> null,
			'ui' 			=> 'job_search_form_ui',
			'uipath' 		=> null
		),


	);


	protected $adminMenu = array(

		'main/prefs' 		=> array('caption' => LAN_PREFS, 'perm' => 'P'),

		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),

	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = 'Job Search';

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
		$var['admin_cat']['link'] = "admin_cat.php";

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





class job_search_ui extends e_admin_ui
{

	protected $pluginTitle		= 'Job Search';
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

	//	protected $tabs				= array('tab1'=>'Tab 1', 'tab2'=>'Tab 2'); // Use 'tab'=>'tab1'  OR 'tab'=>'tab2' in the $fields below to enable. 

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= ' DESC';

	protected $fields 		= array();

	protected $fieldpref = array();


	//	protected $preftabs        = array('General', 'Other' );
	protected $prefs = array(
		'jobsch_approval'		=> array('title' => JOBSCH_A7, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_valid'		=> array('title' => JOBSCH_A10, 'tab' => 0, 'type' => 'number', 'data' => 'str', 'help' => JOBSCH_A11, 'writeParms' => []),
		'jobsch_read'		=> array('title' => JOBSCH_A37, 'tab' => 0, 'type' => 'userclass', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_admin'		=> array('title' => JOBSCH_A38, 'tab' => 0, 'type' => 'userclass', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_create'		=> array('title' => JOBSCH_A53, 'tab' => 0, 'type' => 'userclass', 'data' => 'str', 'help' => 'nobody, member, admin, classes', 'writeParms' => []),
		'jobsch_subscribe'		=> array('title' => JOBSCH_A131, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_usexp'		=> array('title' => JOBSCH_A154, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_icons'		=> array('title' => JOBSCH_A39, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_subdrop'		=> array('title' => JOBSCH_A113, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_icons'		=> array('title' => JOBSCH_A120, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_subdrop'		=> array('title' => JOBSCH_A120, 'tab' => 0, 'type' => 'checkbox', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_pictype'		=> array('title' => JOBSCH_A40, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_sort'		=> array('title' => JOBSCH_A153, 'tab' => 0, 'type' => 'radio', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_currency'		=> array('title' =>JOBSCH_A95, 'tab' => 0, 'type' => 'text', 'data' => 'str', 'help' => '', 'writeParms' => []),
		'jobsch_perpage'		=> array('title' => JOBSCH_A42, 'tab' => 0, 'type' => 'number', 'data' => 'str',   'writeParms' => []),
		'jobsch_leadz'		=> array('title' => JOBSCH_A109, 'tab' => 0, 'type' => 'number', 'data' => 'str',   'writeParms' => []),
		'jobsch_sysemail'		=> array('title' => JOBSCH_A144, 'tab' => 0, 'type' => 'text', 'data' => 'str',   'writeParms' => []),
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
		
		$this->prefs['jobsch_approval']['writeParms']['optArray'] = $jobsch_approval_options;
		$this->prefs['jobsch_approval']['writeParms']['default'] = "0";
		$this->prefs['jobsch_read']['writeParms']['classlist'] = "public,guest, nobody, member, admin, classes";
		$this->prefs['jobsch_admin']['writeParms']['classlist'] = "nobody, member, admin, classes";
		$this->prefs['jobsch_create']['writeParms']['classlist'] = "nobody, member, admin, classes";
		$this->prefs['jobsch_pictype']['writeParms']['optArray'] = $jobsch_pictype_options;
		$this->prefs['jobsch_pictype']['writeParms']['default'] = "0";
		$this->prefs['jobsch_sort']['writeParms']['optArray'] = $jobsch_sort_options;
		$this->prefs['jobsch_sort']['writeParms']['default'] = "0";
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

// render the header (everything before the main content area)
$hpslovnikFront = new job_search_adminArea();  //standard admin UI in admin area 

$text = $hpslovnikFront->runPage('raw'); // way how to render it directly 

$caption = $text[0];
$html = $text[1];

$html = str_replace('table adminlist table-striped', 'table-job-bx', $html);
$html = str_replace('admin-ui-list-search', '', $html);


require_once(e_ADMIN . "header.php");

e107::getRender()->tablerender($caption, $html);
require_once(e_ADMIN . "footer.php");




// $e_wysiwyg = "jobsch_terms";
// if ($pref['wysiwyg'])
// {
//     $WYSIWYG = true;
// }
// require_once(e_HANDLER . "ren_help.php");
// require_once(e_HANDLER . "userclass_class.php");
// require_once(e_ADMIN . "auth.php");

// if (e_QUERY == "update")
// {
//     // Update rest
//     if ($pref['jobsch_thumbheight'] <> $_POST['jobsch_thumbheight'])
//     {
//         require_once("upload_pic.php");
//         // Resize thumbnails
//         if ($handle = opendir("./images/classifieds"))
//         {
//             while (false !== ($file = readdir($handle)))
//             {
//                 // go through each file in the directory and create a thumbnail image
//                 // Do not try on index.htm or on existing thumbnails
//                 // All thumbnails are generated as type .jpg
//                 if ($file <> "." && $file <> ".." && $file <> "index.htm" && substr($file, 0, 6) <> "thumb_")
//                 {
//                     makeThumbnail($file, $t_ht = $_POST['jobsch_thumbheight']);
//                 }
//             }

//             closedir($handle);
//             $jobsch_msgtext .= JOBSCH_A116 . "<br />";
//         }
//     }
//     $pref['jobsch_email'] = $tp->toDB($_POST['jobsch_email']);
//     $pref['jobsch_approval'] = $tp->toDB($_POST['jobsch_approval']);
//     $pref['jobsch_valid'] = $tp->toDB($_POST['jobsch_valid']);
//     $pref['jobsch_read'] = $tp->toDB($_POST['jobsch_read']);
//     $pref['jobsch_create'] = $tp->toDB($_POST['jobsch_create']);
//     $pref['jobsch_admin'] = $tp->toDB($_POST['jobsch_admin']);
//     $pref['jobsch_useremail'] = $tp->toDB($_POST['jobsch_useremail']);
//     $pref['jobsch_pictype'] = $tp->toDB($_POST['jobsch_pictype']);
//     $pref['jobsch_terms'] = $tp->toDB($_POST['jobsch_terms']);
//     $pref['jobsch_perpage'] = $tp->toDB($_POST['jobsch_perpage']);
//     $pref['jobsch_pich'] = $tp->toDB($_POST['jobsch_pich']);
//     $pref['jobsch_picw'] = $tp->toDB($_POST['jobsch_picw']);
//     $pref['jobsch_currency'] = $tp->toDB($_POST['jobsch_currency']);
//     $pref['jobsch_metad'] = $tp->toDB($_POST['jobsch_metad']);
//     $pref['jobsch_metak'] = $tp->toDB($_POST['jobsch_metak']);
//     $pref['jobsch_leadz'] = $tp->toDB($_POST['jobsch_leadz']);
//     $pref['jobsch_icons'] = $tp->toDB($_POST['jobsch_icons']);
//     $pref['jobsch_counter'] = $tp->toDB($_POST['jobsch_counter']);
//     $pref['jobsch_thumbheight'] = $tp->toDB($_POST['jobsch_thumbheight']);
//     $pref['jobsch_subdrop'] = $tp->toDB($_POST['jobsch_subdrop']);
//     $pref['jobsch_subscribe'] = $tp->toDB($_POST['jobsch_subscribe']);
//     $pref['jobsch_sysemail'] = $tp->toDB($_POST['jobsch_sysemail']);
//     $pref['jobsch_sysfrom'] = $tp->toDB($_POST['jobsch_sysfrom']);
//     $pref['jobsch_sort'] = $tp->toDB($_POST['jobsch_sort']);
//     $pref['jobsch_usexp'] = $tp->toDB($_POST['jobsch_usexp']);
//     $pref['jobsch_dform'] = $tp->toDB($_POST['jobsch_dform']);
//     save_prefs();

//     $jobsch_msgtext .= JOBSCH_A14 ;
// }
// $jobsch_chmod = fopen("./documents/test.php", "w");
// if ($jobsch_chmod)
// {
//     // we can write the document
//     fclose($jobsch_chmod);
//     if (!unlink("./documents/test.php"))
//     {
//         $jobsch_msgtext .= "<br />" . JOBSCH_A165;
//     }
// }
// else
// {
//     $jobsch_msgtext .= "<br />" . JOBSCH_A165;
// }
// $jobsch_text = "<form id=\"config\" method=\"post\" action=\"" . e_SELF . "?update\">
// 		<table class=\"fborder\" width='97%'>";
// $jobsch_text .= "<tr><td class='fcaption' colspan='2' style='text-align:left'>" . JOBSCH_A2 . "</td></tr>";

// $jobsch_text .= "<tr><td class='forumheader3' colspan='2' style='text-align:left'><strong>$jobsch_msgtext</strong>&nbsp;</td></tr>";
// // $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A6 . "</td><td class='forumheader3'>
// // <input class='tbox' style='width:190px' type='text' name='jobsch_email' value='" . $pref['jobsch_email'] . "' /></td></tr>";
// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A7 . "</td><td class='forumheader3'>
// 		<select class='tbox' name='jobsch_approval'>
// 			<option value='1' " . ($pref['jobsch_approval'] == "1" || empty($apreq)?"selected='selected'":"") . ">" . JOBSCH_A8 . "</option>
// 			<option value='0' " . ($pref['jobsch_approval'] <> "1"?"selected='selected'":"") . ">" . JOBSCH_A9 . "</option>
// 		</select>
// 	</td></tr>";
// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A10 . "</td><td class='forumheader3'>
// 	<input type='text' name='jobsch_valid' class='tbox' value='" . $pref['jobsch_valid'] . "' /><br /><i>" . JOBSCH_A11 . "</i></td></tr>";
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A37 . "</td>
// <td style='width:70%' class='forumheader3'>" . r_userclass("jobsch_read", $pref['jobsch_read'], "off", 'public,guest, nobody, member, admin, classes') . "
// </td></tr>";

// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A38 . "</td>
// <td style='width:70%' class='forumheader3'>" . r_userclass("jobsch_admin", $pref['jobsch_admin'], "off", 'nobody, member, admin, classes') . "
// </td></tr>";
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A53 . "</td>
// <td style='width:70%' class='forumheader3'>" . r_userclass("jobsch_create", $pref['jobsch_create'], "off", 'nobody, member, admin, classes') . "
// </td></tr>";
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A131 . "</td>
// <td style='width:70%' class='forumheader3'>
// 	<input type='checkbox' class='tbox' name='jobsch_subscribe' value='1'" .
// ($pref['jobsch_subscribe'] > 0?"checked='checked'":"") . " />
// </td></tr>";

// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A154 . "</td>
// <td style='width:70%' class='forumheader3'>
// 	<input type='checkbox' class='tbox' name='jobsch_usexp' value='1'" .
// ($pref['jobsch_usexp'] > 0?"checked='checked'":"") . " />
// </td></tr>";

// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A39 . "</td>
// <td style='width:70%' class='forumheader3'>
// 	<input type='checkbox' class='tbox' name='jobsch_useremail' value='1'" .
// ($pref['jobsch_useremail'] > 0?"checked='checked'":"") . " />
// </td></tr>";
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A113 . "</td>
// <td style='width:70%' class='forumheader3'>
// 	<input type='checkbox' class='tbox' name='jobsch_icons' value='1'" .
// ($pref['jobsch_icons'] > 0?"checked='checked'":"") . " />
// </td></tr>";
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A120 . "</td>
// <td style='width:70%' class='forumheader3'>
// 	<input type='checkbox' class='tbox' name='jobsch_subdrop' value='1'" .
// ($pref['jobsch_subdrop'] > 0?"checked='checked'":"") . " />
// </td></tr>";
// # $jobsch_text .= "
// # <tr>
// # <td style='width:30%' class='forumheader3'>" . JOBSCH_A114 . "</td>
// # <td style='width:70%' class='forumheader3'>
// # <input type='checkbox' class='tbox' name='jobsch_thumbs' value='1'" .
// # ($pref['jobsch_thumbs'] > 0?"checked='checked'":"") . " />
// # </td></tr>";
// # $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A115 . "</td><td class='forumheader3'>
// # <input class='tbox' style='width:10%;' type='text' name='jobsch_thumbheight' value='" . $pref['jobsch_thumbheight'] . "' /></td></tr>";
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A40 . "</td>
// <td style='width:70%' class='forumheader3'>
// <select name='jobsch_pictype' class='tbox'>
// <option value='0' " .
// ($pref['jobsch_pictype'] == 0?"selected='selected'":"") . ">" . JOBSCH_A98 . "</option>
// <option value='1' " .
// ($pref['jobsch_pictype'] == 1?"selected='selected'":"") . ">" . JOBSCH_A99 . "</option>
// <option value='2' " .
// ($pref['jobsch_pictype'] == 2?"selected='selected'":"") . ">" . JOBSCH_A100 . "</option>
// </select>
// </td></tr>";
// // default sort order
// $jobsch_text .= "
// <tr>
// <td style='width:30%' class='forumheader3'>" . JOBSCH_A153 . "</td>
// <td style='width:70%' class='forumheader3'>
// <select name='jobsch_sort' class='tbox'>
// <option value='ASC' " .
// ($pref['jobsch_sort'] == "ASC"?"selected='selected'":"") . ">" . JOBSCH_A151 . "</option>
// <option value='DESC' " .
// ($pref['jobsch_sort'] == "DESC"?"selected='selected'":"") . ">" . JOBSCH_A152 . "</option>
// </select>
// </td></tr>";
// # $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A94 . "</td><td class='forumheader3'>
// # <input class='tbox' style='width:10%;' type='text' name='jobsch_pich' value='" . $pref['jobsch_pich'] . "' /></td></tr>";
// # $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A93 . "</td><td class='forumheader3'>
// # <input class='tbox' style='width:10%;' type='text' name='jobsch_picw' value='" . $pref['jobsch_picw'] . "' /></td></tr>";
// $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A95 . "</td><td class='forumheader3'>
// <input class='tbox' style='width:10%;' type='text' name='jobsch_currency' value='" . $pref['jobsch_currency'] . "' /></td></tr>";

// $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A42 . "</td><td class='forumheader3'>
// <input class='tbox' style='width:10%;' type='text' name='jobsch_perpage' value='" . $pref['jobsch_perpage'] . "' /></td></tr>";
// $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A109 . "</td><td class='forumheader3'>
// <input class='tbox' style='width:10%;' type='text' name='jobsch_leadz' value='" . $pref['jobsch_leadz'] . "' /></td></tr>";

// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A144 . "</td><td class='forumheader3'>
// 	<input type='text' name='jobsch_sysemail' style='width:80%' class='tbox' value='" . $pref['jobsch_sysemail'] . "' /></td></tr>";

// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A156 . "</td><td class='forumheader3'>
// 	<select class='tbox' name='jobsch_dform'>
// 		<option value='d-m-Y' " . ($pref['jobsch_dform'] == "d-m-Y" ?"selected='selected'":"") . ">d-m-Y</option>
// 		<option value='m-d-Y' " . ($pref['jobsch_dform'] == "m-d-Y" ?"selected='selected'":"") . ">m-d-Y</option>
// 		<option value='Y-m-d' " . ($pref['jobsch_dform'] == "Y-m-d" ?"selected='selected'":"") . ">Y-m-d</option>

// 		</select>
// </td></tr>";

// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A143 . "</td><td class='forumheader3'>
// 	<input type='text' name='jobsch_sysfrom' style='width:80%' class='tbox' value='" . $pref['jobsch_sysfrom'] . "' /></td></tr>";

// $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A117 . "</td><td class='forumheader3'>
// 	<select class='tbox' name='jobsch_counter'>
// 	<option value='NONE' " . ($pref['jobsch_counter'] == 'NONE'?"selected='selected'":"") . ">" . JOBSCH_A118 . "</option>
// 	<option value='ALL' " . ($pref['jobsch_counter'] == 'ALL'?"selected='selected'":"") . ">" . JOBSCH_A119 . "</option>
// 	<option value='cb' " . ($pref['jobsch_counter'] == 'cb'?"selected='selected'":"") . ">Coloured Blocks</option>
// 	<option value='crt' " . ($pref['jobsch_counter'] == 'crt'?"selected='selected'":"") . ">CRTs</option>
// 	<option value='flame' " . ($pref['jobsch_counter'] == 'flame'?"selected='selected'":"") . ">Flames</option>
// 	<option value='floppy' " . ($pref['jobsch_counter'] == 'floppy'?"selected='selected'":"") . ">Floppy Disks</option>
// 	<option value='heart' " . ($pref['jobsch_counter'] == 'heart'?"selected='selected'":"") . ">Hearts</option>
// 	<option value='jelly' " . ($pref['jobsch_counter'] == 'jelly'?"selected='selected'":"") . ">Jelly</option>
// 	<option value='lcd' " . ($pref['jobsch_counter'] == 'lcd'?"selected='selected'":"") . ">LCD HP Calculator</option>
// 	<option value='lcdg' " . ($pref['jobsch_counter'] == 'lcdg'?"selected='selected'":"") . ">LED Green</option>
// 	<option value='purple' " . ($pref['jobsch_counter'] == 'purple'?"selected='selected'":"") . ">Purple</option>
// 	<option value='slant' " . ($pref['jobsch_counter'] == 'slant'?"selected='selected'":"") . ">Slant</option>
// 	<option value='snowm' " . ($pref['jobsch_counter'] == 'snowm'?"selected='selected'":"") . ">Snowman</option>
// 	<option value='text' " . ($pref['jobsch_counter'] == 'text'?"selected='selected'":"") . ">Text</option>
// 	<option value='tree' " . ($pref['jobsch_counter'] == 'tree'?"selected='selected'":"") . ">Christmas Tree</option>
// 	<option value='turf' " . ($pref['jobsch_counter'] == 'turf'?"selected='selected'":"") . ">Turf</option>
// 	</select>
// </td></tr>";
// # # html area for t&CC
// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A41 . "</td><td class='forumheader3'>";
// # <textarea name='jobsch_terms' style='width:85%;vertical-align:top;' cols = '100' rows='6' class='tbox' >" . $pref['jobsch_terms'] . "</textarea></td></tr>";
// $insertjs = (!$pref['wysiwyg'])?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'":
// "rows='20' style='width:100%' ";
// $jobsch_terms = $tp->toForm($pref['jobsch_terms']);
// $jobsch_text .= "<textarea class='tbox' id='jobsch_terms' name='jobsch_terms' cols='80'  style='width:95%' $insertjs>" . (strstr($jobsch_terms, "[img]http") ? $jobsch_terms : str_replace("[img]../", "[img]", $jobsch_terms)) . "</textarea>";

// if (!$pref['wysiwyg'])
// {
//     $jobsch_text .= "<input id='helpb' class='helpbox' type='text' name='helpb' size='100' style='width:95%'/>
// 			<br />" . display_help("helpb");
// }
// # #end html
// $jobsch_text .= "</td></tr>
// <tr><td class='forumheader3'>" . JOBSCH_A96 . "</td><td class='forumheader3'>
// 	<textarea name='jobsch_metad' style='width:85%;vertical-align:top;' cols = '100' rows='6' class='tbox' >" . $pref['jobsch_metad'] . "</textarea></td></tr>";

// $jobsch_text .= "
// <tr><td class='forumheader3'>" . JOBSCH_A97 . "</td><td class='forumheader3'>
// 	<textarea name='jobsch_metak' style='width:85%;vertical-align:top;' cols = '100' rows='6' class='tbox' >" . $pref['jobsch_metak'] . "</textarea></td></tr>";

// $jobsch_text .= "<tr><td class='forumheader' colspan='2' style='text-align:left;vertical-align:top;'>
// <input class='button' name='savesettings' type='submit' value='" . JOBSCH_A15 . "' /></td></tr>";

// $jobsch_text .= "</table></form>";
// $ns->tablerender(JOBSCH_A12, $jobsch_text);
require_once(e_ADMIN . "footer.php");

?>
