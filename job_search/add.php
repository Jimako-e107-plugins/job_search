<?php

require_once("../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}

require_once(e_HANDLER . "userclass_class.php");
require_once(e_HANDLER . "ren_help.php");
// check class for creating editing ads
if (!check_class($pluginPref['jobsch_create']))
{
    require_once(HEADERF);
    $ns->tablerender(JOBSCH_54, JOBSCH_53);
    require_once(FOOTERF) ;
    exit;
}
require_once(e_PLUGIN . "job_search/handlers/calendar/calendar_class.php");
$jobsch_cal = new DHTML_Calendar(true);
$jobsch_text .= $jobsch_cal->load_files();

require_once(HEADERF);
// Calendar bits (uses the one from e107 calendar
require_once("upload_pic.php");
$actvar = $_POST["actvar"];
$action = $_POST['action'];
$catname2 = $_POST["catname2"];
$catid = $_POST["catid"];
$jobsch_action = $_POST['jobsch_action'];
if (empty($pluginPref['jobsch_dform']))
{
    $pluginPref['jobsch_dform'] = "d-m-Y";
}
if ($actvar == "delete")
{
if ($_POST['confirm'])
{
    $sql->db_Delete("jobsch_ads", "jobsch_cid=$catid");
    $jobsch_msg = JOBSCH_66;
}
else
{
    $jobsch_msg = JOBSCH_65;
}
$action = "";
}
// ----------------NEW INSERT---------------
if ($jobsch_action == "save")
{
if ($_POST['jobsch_delpic'] == "1")
{
    unlink(e_PLUGIN . "job_search/documents/" . $_POST['jobsch_document']);
    $_POST['jobsch_document'] = "";
}
$cpic = "";
$file = "";
if (!empty($_FILES['file_userfile']['name']) && $pluginPref['jobsch_pictype'] == 1)
{
    $userid = USERID . "_";
    $evrsn_up = jobshack_fileup("file_userfile", e_PLUGIN . "job_search/documents/", $userid);
    switch ($evrsn_up['result'])
    {
        case "0":
        default:
            $evrsn_upmess = JOBSCH_92;
            $cpic = "";
            $file = "";
            break;
        case "1":
            $evrsn_upmess = "";
            $cpic = $evrsn_up['filename'];
            $file = $evrsn_up['filename'];
            chmod(e_PLUGIN . "job_search/documents/" . $file, 0777);
            break;
        case "2":
            $evrsn_upmess = JOBSCH_93;
            $cpic = "";
            $file = "";
            break;
        case "3":
            $evrsn_upmess = JOBSCH_94;
            $cpic = "";
            $file = "";
            break;
    }
}
else
{
    $cpic = $_POST['jobsch_document'];
}
// $jobsch_action = "submit";
if ($pluginPref['jobsch_approval'] == 1)
{
    $jobsch_approved = 0;
    $jobsch_msg = JOBSCH_48;
}
else
{
    $jobsch_approved = 1;
    $jobsch_msg = JOBSCH_68;
}
if ($pluginPref['jobsch_valid'] > 0 && empty($_POST['jobsch_closedate']))
{
    // we use default period and no date set by user
    $month = date("n");
    $day = date("j");
    $year = date("Y");
    $ptime = mktime(0, 0, 0, $month, $day, $year);
    $adlength = $pluginPref['jobsch_valid'] * 86400;
    $ptime = $ptime + $adlength;
}
else
{
    $ptime = 0;
}
if (isset($_POST['jobsch_closedate']))
{
    // a date has been entered by the user
    $jobsch_tmp = explode("-", $_POST['jobsch_closedate']);
    switch ($pluginPref['jobsch_dform'])
    {
        case "Y-m-d":
            $ptime = mktime(0, 0, 1, $jobsch_tmp[1], $jobsch_tmp[2], $jobsch_tmp[0]);
            break;
        case "m-d-Y":
            $ptime = mktime(0, 0, 1, $jobsch_tmp[0], $jobsch_tmp[1], $jobsch_tmp[2]);
            break;
        default :
            $ptime = mktime(0, 0, 1, $jobsch_tmp[1], $jobsch_tmp[0], $jobsch_tmp[2]);
    }
}
if ($actvar == "edit")
{

    $jobsch_res = $sql->db_Update("jobsch_ads", "
		jobsch_vacancy='" . $tp->toDB($_POST['jobsch_vacancy']) . "',
		jobsch_companyinfoname='" . $tp->toDB($_POST['jobsch_companyinfoname']) . "',
		jobsch_category='" . $tp->toDB($_POST['jobsch_category']) . "',
		jobsch_document='$cpic',
		jobsch_vacancydetails='" . $tp->toDB($_POST['jobsch_vacancydetails']) . "',
		jobsch_approved='$jobsch_approved',
		jobsch_submittedby='" . USERID . "." . $tp->toDB(USERNAME) . "',
		jobsch_companyphone='" . $tp->toDB($_POST['jobsch_companyphone']) . "',
		jobsch_salary='" . $tp->toDB($_POST['jobsch_salary']) . "',
		jobsch_last='" . time() . "',
		jobsch_closedate='" . $ptime . "',
		jobsch_counter='" . $tp->toDB($_POST['jobsch_counter']) . "',
		jobsch_email='" . $tp->toDB($_POST['jobsch_email']) . "',
		jobsch_companyinfo='" . $tp->toDB($_POST['jobsch_companyinfo']) . "',
		jobsch_empref='" . $tp->toDB($_POST['jobsch_empref']) . "',
		jobsch_locality='" . $tp->toDB($_POST['jobsch_locality']) . "'
		WHERE jobsch_cid='$catid'");
    if ($jobsch_res)
    {
        $edata_sn = array("action" => "update", "user" => USERNAME, "itemtitle" => $_POST['jobsch_companyinfoname'], "catid" => intval($catid));
        $e_event->trigger("jobshack", $edata_sn);
        $jobsch_msg = $jobsch_msg;
    }
    else
    {
        $jobsch_msg = JOBSCH_67;
    }
}

if ($actvar == "new")
{
    // if ($pluginPref['jobsch_pictype'] == 1)
    // {
    // makeThumbnail($cpic, $t_ht = 100);
    // }
    $jobsch_adid = $sql->db_Insert("jobsch_ads", "
		0, '" . $tp->toDB($_POST['jobsch_vacancy']) . "',
		'" . $tp->toDB($_POST['jobsch_companyinfoname']) . "',
		'" . $tp->toDB($_POST['jobsch_category']) . "',
		'$cpic',
		'" . $tp->toDB($_POST['jobsch_vacancydetails']) . "',
		'$jobsch_approved',
		'" . USERID . "." . $tp->toDB(USERNAME) . "',
		'" . $tp->toDB($_POST['jobsch_companyphone']) . "',
		'" . $tp->toDB($_POST['jobsch_email']) . "',
		'" . time() . "',
		'$ptime',
		'" . time() . "',
		'" . $tp->toDB($_POST['jobsch_salary']) . "','0',
		'" . $_POST['jobsch_counter'] . "',
		'" . $tp->toDB($_POST['jobsch_companyinfo']) . "',
		'" . $tp->toDB($_POST['jobsch_locality']) . "',
		'0',
		'" . $tp->toDB($_POST['jobsch_empref']) . "'") ;
    if ($jobsch_adid)
    {
        $edata_sn = array("action" => "new", "user" => USERNAME, "itemtitle" => $_POST['jobsch_companyinfoname'], "catid" => intval($jobsch_adid));
        $e_event->trigger("jobshack", $edata_sn);
        $jobsch_msg = $jobsch_msg;
    }
    else
    {
        $jobsch_msg = JOBSCH_67;
    }
}
$action = "";
}
if ($action <> "godo")
{
$jobsch_text = "
    <form id=\"config\"  method=\"post\" action=\"" . e_SELF . "?0.mge.\">
            <table class=\"border\" style='width:97%' >";
$jobsch_text .= "<tr><td class='fcaption' colspan='2'>" . JOBSCH_20 . "</td></tr>";
$jobsch_text .= "<tr><td class='forumheader2' colspan='2' style='text-align:left' >
            <a href='" . e_SELF . "?$jobsch_from.cat.$jobsch_catid.$jobsch_subid.$jobsch_itemid'><img src='./images/updir.png' alt='logo' style='border:0'/></a></td></tr>";
if (!empty($jobsch_msg))
{
    $jobsch_text .= "<tr><td class=\"forumheader2\" colspan='2'>" . $jobsch_msg . " </td></tr>";
}
$jobsch_text .= "<tr><td class=\"forumheader3\">" . JOBSCH_20 . "</td><td class=\"forumheader3\" style='width:70%text-align:left'>
        <select class='tbox' name='catid'>";
$sql->db_Select("jobsch_ads", "*", "jobsch_submittedby regexp '^" . USERID . "[.]' order by jobsch_vacancy");
while ($row = $sql->db_Fetch())
{
    $eyetom = $row['jobsch_cid'];
    $eyename = $tp->toFORM($row['jobsch_vacancy']);
    $eyeref = (!empty($row['jobsch_empref'])?"(" . $tp->toFORM($row['jobsch_empref']) . ")":"");
    $jobsch_text .= "<option value='$eyetom' " .
    ($catid == $eyetom?"selected='selected'":"") . ">$eyename ($eyetom) " . $eyeref . "</option>";
    $some = true;
}

if (!$some)
{
    $jobsch_text .= "<option value='0' " . ($catid == none?"selected='selected'":"") . ">" . $tp->toHTML(JOBSCH_76) . "</option>";
}

$jobsch_text .= "</select><br />";
if ($some)
{
    $jobsch_text .= "<input type='radio' checked='checked' name='actvar' value='edit' />" . $tp->toHTML(JOBSCH_21) . "<br />
		<input type='radio' name='actvar' value='new' /> " . $tp->toHTML(JOBSCH_57) . "<br />";
}
else
{
    $jobsch_text .= "<input type='radio' disabled='disabled' name='actvar' value='edit' />" . $tp->toHTML(JOBSCH_21) . "<br />
		<input type='radio' checked='checked' name='actvar' value='new' /> " . $tp->toHTML(JOBSCH_57) . "<br />";
}

$jobsch_text .= "<input type='radio' name='actvar' value='delete' /> " . $tp->toHTML(JOBSCH_22) . "
    <input type='checkbox' name='confirm' style='border:0' class='tbox' />" . $tp->toHTML(JOBSCH_58) . "
    <input type='hidden' name='action' value='godo' />
    </td></tr>
    <tr><td class='fcaption' colspan='2'><input class='tbox' type='submit' value='" . JOBSCH_39 . "' name='doaction' /></td></tr></table></form>";
$ns->tablerender(JOBSCH_23, $jobsch_text);
}

if ($action == "godo")
{
if ($actvar == "edit")
{
    $sql->db_Select("jobsch_ads", "*", "jobsch_cid = $catid");
    $row = $sql->db_Fetch();
    extract($row);
    $actvar = "edit";
}
else
{
    $actvar = "new";
}

$jobsch_text .= "
	<script type='text/javascript'>
	<!-- Begin
	var doneit;
	function checkok(thisform)
	{

		if (doneit=='yes')
		{
			alert('" . JOBSCH_38 . "');
			return false;
		}

		if (thisform.catname2.value=='0'
			|| thisform.jobsch_vacancy.value=='0'
			|| thisform.jobsch_companyinfoname.value=='')
		{
			alert('" . JOBSCH_37 . "');
			return false;
		}
		else
		{
			doneit='yes';
			thisform.submit();
		}
	}
	//-->
	</script>
	<form enctype='multipart/form-data' onsubmit='return checkok(this);' id=\"jobsched\" method=\"post\" action=\"" . e_SELF . "?0.mge.\">
	<table class=\"border\" style='width:97%'>";
$jobsch_text .= "<tr><td class='fcaption' colspan='2' style='text-align:left;' >" . JOBSCH_99 . "&nbsp;</td></tr>";
$jobsch_text .= "<tr><td class='forumheader2' colspan='2' style='text-align:left;' >
			<a href='" . e_SELF . "?$jobsch_from.mge.$jobsch_catid.$jobsch_subid.$jobsch_itemid'><img src='./images/updir.png' alt='logo' style='border:0;'/></a></td></tr>";
    $jobsch_catlist = "<select class='tbox' name='jobsch_category'>";
    $jobsch_arg = "select * from #jobsch_subcats as s
		left join #jobsch_cats as c
		on s.jobsch_categoryid = c.jobsch_catid order by jobsch_catname,jobsch_subname";
    if ($sql->db_Select_gen($jobsch_arg, false))
    {
        $jobsch_current = "";
        while ($jobsch_row = $sql->db_Fetch())
        {
            if ($jobsch_current != $jobsch_row['jobsch_catname'])
            {
                $jobsch_current = $jobsch_row['jobsch_catname'];
                $jobsch_catlist .= "<option value='0' disabled='disabled'>" . $tp->toFORM($jobsch_row['jobsch_catname']) . "</option>";
            }
            $jobsch_catlist .= "<option value='" . $jobsch_row['jobsch_subid'] . "'";
            if ($jobsch_row['jobsch_subid'] == $jobsch_category)
            {
                $jobsch_catlist .= " selected='selected'";
            }

            $jobsch_catlist .= "> &nbsp;&raquo;&nbsp;" . $tp->toFORM($jobsch_row['jobsch_subname']) . "</option>";
        } // while
        $jobsch_catlist .= "</select>";
    }

    else
    {
        $jobsch_text .= "</select>&nbsp;<i>" . JOBSCH_A18 . "</i></td></tr>";
    }


// -------------------------
// $jobsch_text .= "</select></td></tr>";
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_26 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<input type='text' name='jobsch_vacancy' class='tbox' style='width:60%' value='$jobsch_vacancy' />&nbsp;<i>" . JOBSCH_27 . "</i></td></tr>";
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_28 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<input type='text' name='jobsch_companyinfoname' class='tbox' style='width:60%' value='$jobsch_companyinfoname' />&nbsp;<i>" . JOBSCH_27 . "</i></td></tr>";
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_25 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	$jobsch_catlist</td></tr>";

switch ($pluginPref['jobsch_pictype'])
{
    // Upload to server
    case 1:
        // If there is no file specified or the image is missing allow an upload
        // Otherwise just display the name of the picture
        if (empty($jobsch_document) || !file_exists("./documents/" . $jobsch_document))
        {
            $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_29 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
				<input class='tbox' name='file_userfile' type='file' size='47' />&nbsp;<br /><i>" . JOBSCH_55 . "</i></td></tr>";
        }
        else
        {
            $jobsch_text .= "<tr>
				<td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_29 . ":</td>
				<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>" . $jobsch_document . "<br /><i>" . JOBSCH_62 . "</i>
<br />" . JOBSCH_89 . "<input type='checkbox' name='jobsch_delpic' value='1' />
				<input type='hidden' name='jobsch_document' value='$jobsch_document' /></td>
				</tr>";
        }
        break;
    // Use remote picture by URL
    case 2:
        $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_30 . ":</td>
		<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input class='tbox' name='jobsch_document' type='text' style='width:80%;' value='" . $jobsch_document . "'/><br /><i>" . JOBSCH_63 . "</i></td></tr>";
        break;
    // No pictures in use
    case 0:
    default: ;
} // switch
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_12 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_companyphone' class='tbox' style='width:150px;text-align:left;' value='" . $tp->toFORM($jobsch_companyphone) . "' /></td></tr>";
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_119 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_empref' class='tbox' style='width:250px;text-align:left;' value='" . $tp->toFORM($jobsch_empref) . "' /></td></tr>";
if ($pluginPref['jobsch_usexp'] > 0)
{
    // calendar options
    $jobsch_cal_options['firstDay'] = 1;
    $jobsch_cal_options['showsTime'] = false;
    $jobsch_cal_options['showOthers'] = false;
    $jobsch_cal_options['weekNumbers'] = false;
    $jobsch_cal_df = "%" . str_replace("-", "-%", $pluginPref['jobsch_dform']);
    # print $jobsch_cal_df."<br>".$pluginPref['jobsch_dform']."<br>";
    $jobsch_cal_options['ifFormat'] = $jobsch_cal_df;
    $jobsch_cal_attrib['class'] = "tbox";
    $jobsch_cal_attrib['name'] = "jobsch_closedate";
    $jobsch_cal_attrib['value'] = ($jobsch_closedate > 0?date($pluginPref['jobsch_dform'], $jobsch_closedate):"");
    $jobsch_desc = $jobsch_cal->make_input_field($jobsch_cal_options, $jobsch_cal_attrib);
    // $jobsch_desdate = date("l d F Y", $itrq_decisiondate);
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_117 . ":</td>
	<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		$jobsch_desc </td></tr>";
    // end cal
}
if ($pluginPref['jobsch_useremail'] == 1)
{
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_32 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_email' class='tbox' style='width:75%' value='" . $tp->toFORM($jobsch_email) . "' /></td></tr>";
}
else
{
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_32 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='hidden' name='jobsch_email' class='tbox' value='" . USEREMAIL . "' />" . JOBSCH_56 . " " . USEREMAIL . "</td></tr>";
}
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_60 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_salary' class='tbox' style='width:150px;text-align:left;' value='" . $tp->toFORM($jobsch_salary) . "' /></td></tr>";
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_33 . ":</td><td class='forumheader3'>";
// HTML Area code
// <tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_33 . ":</td><td class='forumheader3'>
// <textarea class='tbox' style='width:80%;vertical-align:top;' rows='8' name='jobsch_vacancydetails'  onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'>" . $jobsch_vacancydetails . "</textarea><br />" . ren_help(2) . "
$insertjs = (!$pluginPref['wysiwyg'])?"rows='15' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'":
"rows='25' style='width:100%' ";
$jobsch_vacancydetails = $tp->toForm($jobsch_vacancydetails);
$jobsch_text .= "<textarea class='tbox' id='jobsch_vacancydetails' name='jobsch_vacancydetails' cols='80'  style='width:95%' $insertjs>" . (strstr($jobsch_vacancydetails, "[img]http") ? $jobsch_vacancydetails : str_replace("[img]../", "[img]", $jobsch_vacancydetails)) . "</textarea>";
if (!$pluginPref['wysiwyg'])
{
    $jobsch_text .= "<input id='helpb' class='helpbox' type='text' name='helpb' size='100' style='width:95%'/>
			<br />" . display_help("helpb");
}
// End HTML Area Code
$jobsch_text .= "</td></tr>";
$jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_102 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<textarea class='tbox' id='jobsch_companyinfo' name='jobsch_companyinfo' rows = '7' cols='80'  style='width:70%'>" . $tp->toFORM($jobsch_companyinfo) . "</textarea>
		</td></tr>";
// Location
$jobsch_text .= "
	<tr>
		<td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_103 . ":</td>
		<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
			<select name='jobsch_locality' class='tbox'>";
$jobsch_text .= "<option value='0' " . ($jobsch_locality == 0?"selected='selected'":"") . ">" . $tp->toFORM(JOBSCH_101) . "</option>";
if ($sql->db_Select("jobsch_locals", "*", "order by jobsch_localname", "nowhere"))
{
    while ($jobsch_row = $sql->db_Fetch())
    {
        // print $jobsch_row['jobsch_localid']." - ". $jobsch_locality."<br>";
        $jobsch_text .= "<option value='" . $jobsch_row['jobsch_localid'] . "' " . ($jobsch_row['jobsch_localid'] == $jobsch_locality?"selected='selected'":"") . ">" . $tp->toFORM($jobsch_row['jobsch_localname']) . "</option>";
    }
}
else
{
    $jobsch_text .= "<option value='0'>" . JOBSCH_A122 . "</option>";
}
$jobsch_text .= "</select></td></tr>";
if ($jobsch_approved != 1 && $pluginPref['jobsch_approval'] == 1)
{
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_84 . "</td><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_83 . "</td></tr>";
}
// Counter
if ($pluginPref['jobsch_counter'] == "ALL")
{
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_87 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<select class='tbox' name='jobsch_counter'>
	<option value='' " . ($jobsch_counter == ''?"selected='selected'":"") . ">" . JOBSCH_88 . "</option>
	<option value='cb' " . ($jobsch_counter == 'cb'?"selected='selected'":"") . ">Coloured Blocks</option>
	<option value='crt' " . ($jobsch_counter == 'crt'?"selected='selected'":"") . ">CRTs</option>
	<option value='flame' " . ($jobsch_counter == 'flame'?"selected='selected'":"") . ">Flames</option>
	<option value='floppy' " . ($jobsch_counter == 'floppy'?"selected='selected'":"") . ">Floppy Disks</option>
	<option value='heart' " . ($jobsch_counter == 'heart'?"selected='selected'":"") . ">Hearts</option>
	<option value='jelly' " . ($jobsch_counter == 'jelly'?"selected='selected'":"") . ">Jelly</option>
	<option value='lcd' " . ($jobsch_counter == 'lcd'?"selected='selected'":"") . ">LCD HP Calculator</option>
	<option value='lcdg' " . ($jobsch_counter == 'lcdg'?"selected='selected'":"") . ">LED Green</option>
	<option value='purple' " . ($jobsch_counter == 'purple'?"selected='selected'":"") . ">Purple</option>
	<option value='slant' " . ($jobsch_counter == 'slant'?"selected='selected'":"") . ">Slant</option>
	<option value='snowm' " . ($jobsch_counter == 'snowm'?"selected='selected'":"") . ">Snowman</option>
	<option value='text' " . ($jobsch_counter == 'text'?"selected='selected'":"") . ">Text</option>
	<option value='tree' " . ($jobsch_counter == 'tree'?"selected='selected'":"") . ">Christmas Tree</option>
	<option value='turf' " . ($jobsch_counter == 'turf'?"selected='selected'":"") . ">Turf</option>
	</select>
	</td></tr>";
}
// -------------------->
$jobsch_text .= "<tr><td colspan=\"2\" class=\"fcaption\" style='text-align:left'>
	<input class='button' type='submit' value='" . JOBSCH_64 . "' onclick='this.form.jobsch_action.value=\"save\";'name='merc' />";
if ($actvar == "edit")
{
    if ($pluginPref['jobsch_approval'] == 1 && $jobsch_approved == 1)
    {
        $jobsch_text .= "<br /><em>" . JOBSCH_85 . "</em>";
    }
    #$jobsch_text .= "<input type='hidden' name='jobsch_category' value='$jobsch_category'>";
    $jobsch_text .= "<input type='hidden' name='catid' value='$catid'>";
    $caption = JOBSCH_36;
}
else
{
    $jobsch_text .= "<input type='hidden' name='catid' value='0'>";
    $caption = JOBSCH_35;
}
$jobsch_text .= "<input type='hidden' name='actvar' value='$actvar' />
			<input type='hidden' name='action' value='godo' />
			<input type='hidden' name='jobsch_action' value='' />
			</td></tr></table></form>";
$ns->tablerender($caption, $jobsch_text);
}

require_once(FOOTERF);

?>
