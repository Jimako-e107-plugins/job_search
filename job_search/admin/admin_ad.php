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
$e_wysiwyg = "jobsch_vacancydetails";
if ($pref['wysiwyg'])
{
    $WYSIWYG = true;
}
// Calendar bits (uses the one from e107 calendar
require_once(e_PLUGIN . "job_search/handlers/calendar/calendar_class.php");
$jobsch_cal = new DHTML_Calendar(true);

$jobsch_text .= $jobsch_cal->load_files();
$pluginPrefs = e107::pref('job_search');


require_once(e_HANDLER . "userclass_class.php");
require_once(e_HANDLER . "ren_help.php");

require_once(e_ADMIN . "auth.php");

$actvar = $_POST["actvar"];
$action = $_POST['action'];
$catname2 = $_POST["catname2"];
$catid = $_POST["catid"];
$jobsch_action = $_POST['jobsch_action'];
if (e_QUERY) {
	$actvar="edit";
	$action="godo";
	$catid=e_QUERY;
}
if (empty($pluginPrefs['jobsch_dform']))
{
	//$xprefs['jobsch_dform'] = "d-m-Y";
    //save_xprefs();
	e107::getPref()->set('jobsch', 'jobsch_dform', "d-m-Y");
}
if ($actvar == "delete")
{
    if ($_POST['confirm'])
    {
        $sql->db_Delete("jobsch_ads", "jobsch_cid=$catid");
        $jobsch_msg = JOBSCH_A79;
    }
    else
    {
        $jobsch_msg = JOBSCH_A78;
    }
    $action = "";
}

if ($jobsch_action == "save")
{
    require_once("upload_pic.php");
    if ($_POST['jobsch_delpic'] == "1")
    {
        unlink(e_PLUGIN . "job_search/documents/" . $_POST['jobsch_document']);
        $_POST['jobsch_document'] = "";
    }
    $cpic = "";
    $file = "";
    if (!empty($_FILES['file_userfile']['name']) && $pref['jobsch_pictype'] == 1)
    {
        $userid = USERID . "_";
        $jobsch_up = jobshack_fileup("file_userfile", e_PLUGIN . "job_search/documents/", $userid);
        switch ($jobsch_up['result'])
        {
            case "0":
            default:
                $jobsch_upmess = JOBSCH_92;
                $cpic = "";
                $file = "";
                break;
            case "1":
                $jobsch_upmess = "";
                $cpic = $jobsch_up['filename'];
                $file = $jobsch_up['filename'];
                chmod(e_PLUGIN . "job_search/documents/" . $file, 777);
                break;
            case "2":
                $jobsch_upmess = JOBSCH_93;
                $cpic = "";
                $file = "";
                break;
            case "3":
                $jobsch_upmess = JOBSCH_94;
                $cpic = "";
                $file = "";
                break;
        }
    }
    else
    {
        $cpic = $_POST['jobsch_document'];
    }
    if (isset($_POST['jobsch_closedate']))
    {
        $jobsch_tmp = explode("-", $_POST['jobsch_closedate']);
        switch ($pref['jobsch_dform'])
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
    else
    {
        $ptime = 0;
    }
    # print $_POST['jobsch_closedate']." -- ".time()." -- ".$ptime."<br>";
    if (!empty($_FILES['file_userfile']['name']) && $pref['jobsch_pictype'] == 1)
    {
        $userid = $_POST['jobsch_submittedbyid'] . "_";

        require_once("upload_pic.php");
$jobsch_up = jobshack_fileup("file_userfile", e_PLUGIN . "job_search/documents/", $userid);
        switch ($jobsch_up['result'])
        {
            case "0":
            default:
                $jobsch_upmess = JOBSCH_92;
                $cpic = "";
                $file = "";
                break;
            case "1":
                $jobsch_upmess = "";
                $cpic = $jobsch_up['filename'];
                $file = $jobsch_up['filename'];
                chmod( e_PLUGIN . "job_search/documents/".$cpic,0777);
                break;
            case "2":
                $jobsch_upmess = JOBSCH_93;
                $cpic = "";
                $file = "";
                break;
            case "3":
                $jobsch_upmess = JOBSCH_94;
                $cpic = "";
                $file = "";
                break;
        }
    }
    else
    {
        $cpic = $_POST['jobsch_document'];
    }
    // get user name from db
    $sql->db_Select("user", "user_name", "user_id='" . $_POST['jobsch_submittedbyid'] . "'");
    $jobsch_row = $sql->db_Fetch();
    $jobsch_uname = $_POST['jobsch_submittedbyid'] . "." . $jobsch_row['user_name'];
    if ($actvar == "edit")
    {
        $jobsch_ok = $sql->db_Update("jobsch_ads", "
		jobsch_vacancy='" . $tp->toDB($_POST['jobsch_vacancy']) . "',
		jobsch_companyinfoname='" . $tp->toDB($_POST['jobsch_companyinfoname']) . "',
		jobsch_category='" . $tp->toDB($_POST['catname']) . "',
		jobsch_document='$cpic',
		jobsch_vacancydetails='" . $tp->toDB($_POST['jobsch_vacancydetails']) . "',
		jobsch_approved='$jobsch_approved',
		jobsch_submittedby='" . $tp->toDB($jobsch_uname) . "',
		jobsch_companyphone='" . $tp->toDB($_POST['jobsch_companyphone']) . "',
		jobsch_email='" . $tp->toDB($_POST['jobsch_email']) . "',
		jobsch_approved='" . $tp->toDB($_POST['jobsch_approved']) . "',
		jobsch_salary='" . $tp->toDB($_POST['jobsch_salary']) . "',
		jobsch_counter='" . $tp->toDB($_POST['jobsch_counter']) . "',
		jobsch_last='" . time() . "',
		jobsch_closedate='" . $tp->toDB($ptime) . "',
		jobsch_companyinfo='" . $tp->toDB($_POST['jobsch_companyinfo']) . "',
		jobsch_empref='" . $tp->toDB($_POST['jobsch_empref']) . "',
		jobsch_locality='" . $tp->toDB($_POST['jobsch_locality']) . "'
		WHERE jobsch_cid='$catid'") ;
        if ($jobsch_ok)
        {
            $jobsch_msg = JOBSCH_A75;
        }
        else
        {
            $jobsch_msg = JOBSCH_A81;
        }
    }

    if ($actvar == "new")
    {
        $jobsch_adid = $sql->db_Insert("jobsch_ads", "
		0, '" . $tp->toDB($_POST['jobsch_vacancy']) . "',
		'" . $tp->toDB($_POST['jobsch_companyinfoname']) . "',
		'" . $tp->toDB($_POST['catname']) . "',
		'$cpic',
		'" . $tp->toDB($_POST['jobsch_vacancydetails']) . "',
		'" . $tp->toDB($_POST['jobsch_approved']) . "',
		'" . $tp->toDB($jobsch_uname) . "',
		'" . $tp->toDB($_POST['jobsch_companyphone']) . "',
		'" . $tp->toDB($_POST['jobsch_email']) . "',
		'" . time() . "',
		'$ptime','0',
		'" . $tp->toDB($_POST['jobsch_salary']) . "','0',
		'" . $tp->toDB($_POST['jobsch_counter']) . "',
		'" . $tp->toDB($_POST['jobsch_companyinfo']) . "',
		'" . $tp->toDB($_POST['jobsch_locality']) . "',
		'0',
		'" . $tp->toDB($_POST['jobsch_empref']) . "'") ;
        if ($jobsch_adid)
        {
            $jobsch_msg = JOBSCH_A75;
        }
        else
        {
            $jobsch_msg = JOBSCH_A81;
        }
    }
    $action = "";
}
// -----------------------------------------
if ($action <> "godo")
{
    $jobsch_text .= "
	<form id=\"config\"  method=\"post\" action=\"" . e_SELF . "\">
            <table class=\"fborder\" style='width:97%' >";
    $jobsch_text .= "<tr><td class=\"fcaption\" colspan='2'>" . JOBSCH_A54 . "</td></tr>";
    $jobsch_text .= "<tr><td class=\"forumheader2\" colspan='2'>" . $jobsch_msg . "&nbsp;";
    if (!empty($jobsch_upmess))
    {
        $jobsch_text .= "<br />" . $jobsch_upmess;
    }
    $jobsch_text .= "</td></tr>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='width:20%;text-align:left;'>" . JOBSCH_A19 . "</td><td class=\"forumheader3\" style='width:80%;text-align:left;'>
		<select class='tbox' name='catid'>";
    $jobsch_ok = $sql->db_Select("jobsch_ads", "jobsch_cid,jobsch_vacancy,jobsch_empref", " order by jobsch_vacancy", "nowhere");
    $jobsch_yes = false;
    if ($jobsch_ok)
    {
        $jobsch_yes = true;
        while ($row = $sql->db_Fetch())
        {
            $eyetom = $row['jobsch_cid'];
            $eyename = $row['jobsch_vacancy'];
            $eyeref = (!empty($row['jobsch_empref'])?"(" . $tp->toFORM($row['jobsch_empref']) . ")":"");

            $jobsch_text .= "<option value='$eyetom' " .
            ($catid == $eyetom?"selected='selected'":"") . ">$eyename ($eyetom) " . $eyeref . "</option>";
        }
    }
    else
    {
        $jobsch_text .= "<option value='0' >" . JOBSCH_A92 . "</option>";
    }

    $jobsch_text .= "</select><br />";
    $jobsch_text .= "
	<input type='radio' checked='checked' name='actvar' value='edit' " . ($jobsch_yes?"checked='checked'":"disabled='disabled'") . " />" . JOBSCH_A20 . " <br />
	<input type='radio' name='actvar' value='new' " . (!$jobsch_yes?"checked='checked'":"") . " /> " . JOBSCH_A21 . "<br />
	<input type='radio' name='actvar' value='delete' /> " . JOBSCH_A22 . " &nbsp;
	<input type='checkbox' name='confirm' class='tbox' />" . JOBSCH_A23 . "
	<input type='hidden' name='action' value='godo' />
	</td></tr>
	<tr><td class='fcaption' colspan='2'><input class='tbox' type='submit' value='" . JOBSCH_A24 . "' name='doaction' />
	</td></tr></table></form>";
    $ns->tablerender(JOBSCH_A1, $jobsch_text);
}
if ($action == "godo")
{
    if ($actvar == "edit")
    {
        $sql->db_Select("jobsch_ads", "*", "jobsch_cid = $catid");
        $row = $sql->db_Fetch();
        extract($row);
        $actvar = "edit";
        $caption = JOBSCH_A61;
    }
    else
    {
        $caption = JOBSCH_A60;
        $actvar = "new";
    }

    $jobsch_text .= "
	<script type='text/javascript'>
	<!-- Begin
	function checkok(thisform)
	{

		if (thisform.catname.value=='0'
			|| thisform.jobsch_vacancy.value=='0'
			|| thisform.jobsch_companyinfoname.value=='')
		{
			alert('" . JOBSCH_A57 . "');
			return false;
		}
		else
		{
			thisform.submit();
		}
	}
	//-->
	</script>
	<form enctype='multipart/form-data' onsubmit='return checkok(this);' id=\"jobsched\" method=\"post\" action=\"" . e_SELF . "\">
	<table class=\"fborder\" style='width:97%'>";
    $jobsch_text .= "<tr><td class='fcaption' colspan='2' style='text-align:left;' >" . $caption . "</td></tr>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A62 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<input type='text' name='jobsch_vacancy' class='tbox' style='width:60%' value='" . $tp->toFORM($jobsch_vacancy) . "' /><i>" . JOBSCH_A59 . "</i></td></tr>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A63 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<input type='text' name='jobsch_companyinfoname' class='tbox' style='width:60%' value='$jobsch_companyinfoname' />&nbsp;<i>" . JOBSCH_A59 . "</i></td></tr>";

    $jobsch_catlist = "<select class='tbox' name='catname'>";
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

    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A76 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	$jobsch_catlist</td></tr>";
    switch ($pref['jobsch_pictype'])
    {
        // Upload to server
        case 1:
            // If there is no file specified or the image is missing allow an upload
            // Otherwise just display the name of the picture
            print $jobsch_document;
            if (empty($jobsch_document) || !file_exists("./documents/" . $jobsch_document))
            {
                $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A160 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
				<input class='tbox' name='file_userfile' type='file' size='47' />&nbsp;<br /><i>" . JOBSCH_A161 . "</i></td></tr>";
            }
            else
            {
                $jobsch_text .= "<tr>
				<td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A160 . ":</td>
				<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>" . $jobsch_document . "<br /><i>" . JOBSCH_A162 . "</i>
				<br />" . JOBSCH_A163 . "<input type='checkbox' name='jobsch_delpic' value='1' />
				<input type='hidden' name='jobsch_document' value='$jobsch_document' /></td>
				</tr>";
            }
            break;
        // Use remote picture by URL
        case 2:
            $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A164 . ":</td>
		<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input class='tbox' name='jobsch_document' type='text' style='width:80%;' value='" . $jobsch_document . "'/><br /><i>" . JOBSCH_A163 . "</i></td></tr>";
            break;
        // No pictures in use
        case 0:
        default: ;
    } // switch
    $jobsch_text .= "<tr>
	<td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A65 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<input type='text' name='jobsch_companyphone' class='tbox' style='width:150px' value='" . $jobsch_companyphone . "' />&nbsp;</td>
	</tr>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A155 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_empref' class='tbox' style='width:250px;text-align:left;' value='" . $tp->toFORM($jobsch_empref) . "' /></td></tr>";

    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A67 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_email' class='tbox' style='width:70%' value='$jobsch_email' /></td></tr>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A68 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='input' name='jobsch_salary' class='tbox' style='width:150px;text-align:left;' value='$jobsch_salary' /></td></tr>";
    $jobsch_sel = "<select name='jobsch_submittedbyid' class='tbox' >";
    $sql->db_Select("user", "user_id,user_name", "order by user_name", "nowhere");
    $jobsch_tmp=explode(".", $jobsch_submittedby,2);
    $jobsch_nid = $jobsch_tmp[0];
    while ($row = $sql->db_Fetch())
    {
        extract($row);
        // print $jobsch_submittedby.$user_name;
        $jobsch_sel .= "<option value='$user_id' " .
        ($jobsch_nid == $user_id?"selected='selected'":"") . ">$user_name</option>";
    }
    $jobsch_sel .= "</select>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A72 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		$jobsch_sel&nbsp;<i>" . JOBSCH_A59 . "</i></td></tr>";
    // calendar options
    $jobsch_cal_options['firstDay'] = 1;
    $jobsch_cal_options['showsTime'] = false;
    $jobsch_cal_options['showOthers'] = false;
    $jobsch_cal_options['weekNumbers'] = false;
    $jobsch_cal_df = "%" . str_replace("-", "-%", $pref['jobsch_dform']);
    # print $jobsch_cal_df."<br>".$pref['jobsch_dform']."<br>";
    $jobsch_cal_options['ifFormat'] = $jobsch_cal_df;

    $jobsch_cal_attrib['class'] = "tbox";
    $jobsch_cal_attrib['name'] = "jobsch_closedate";
    $jobsch_cal_attrib['value'] = ($jobsch_closedate > 0?date($pref['jobsch_dform'], $jobsch_closedate):"");
    $jobsch_desc = $jobsch_cal->make_input_field($jobsch_cal_options, $jobsch_cal_attrib);
    // $jobsch_desdate = date("l d F Y", $itrq_decisiondate);
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A73 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		$jobsch_desc </td></tr>";
    // end cal
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A74 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<input type='checkbox' name='jobsch_approved' class='tbox' style='' value='1'" .
    ($jobsch_approved == 1?"checked='checked'":"") . " /></td></tr>";
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A69 . ":</td><td class='forumheader3'>
	";
    // HTML AREA CODE
    $insertjs = (!$pref['wysiwyg'])?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'":
    "rows='20' style='width:100%' ";
    $jobsch_vacancydetails = $tp->toForm($jobsch_vacancydetails);
    $jobsch_text .= "<textarea class='tbox' id='jobsch_vacancydetails' name='jobsch_vacancydetails' cols='80'  style='width:95%' $insertjs>" . (strstr($jobsch_vacancydetails, "[img]http") ? $jobsch_vacancydetails : str_replace("[img]../", "[img]", $jobsch_vacancydetails)) . "</textarea>";
    if (!$pref['wysiwyg'])
    {
        $jobsch_text .= "<input id='helpb' class='helpbox' type='text' name='helpb' size='100' style='width:95%'/>
			<br />" . display_help("helpb");
    }
    // END HTML AREA CODE
    $jobsch_text .= "<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A158 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
		<textarea class='tbox' id='jobsch_companyinfo' name='jobsch_companyinfo' rows = '7' cols='80'  style='width:70%'>" . $tp->toFORM($jobsch_companyinfo) . "</textarea>
		</td></tr>";
    // Location
    $jobsch_text .= "
	<tr>
		<td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A128 . ":</td>
		<td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
			<select name='jobsch_locality' class='tbox'>";
    $jobsch_text .= "<option value='0' " . ($jobsch_locality == 0?"selected='selected'":"") . ">" . $tp->toFORM(JOBSCH_A157) . "</option>";
    if ($sql->db_Select("jobsch_locals", "*", "order by jobsch_localname", "nowhere"))
    {
        while ($jobsch_row = $sql->db_Fetch())
        {
            $jobsch_text .= "<option value='" . $jobsch_row['jobsch_localid'] . "' " . ($jobsch_row['jobsch_localid'] == $jobsch_locality?"selected='selected'":"") . ">" . $jobsch_row['jobsch_localname'] . "</option>";
        }
    }
    else
    {
        $jobsch_text .= "<option value='0'>" . JOBSCH_A122 . "</option>";
    }
    $jobsch_text .= "</select></td></tr>";
    // Counter
    $jobsch_text .= "</td></tr>
	<tr><td class=\"forumheader3\" style='vertical-align:top;' >" . JOBSCH_A107 . ":</td><td class=\"forumheader3\" style='width:80%;text-align:left;vertical-align:top;'>
	<select class='tbox' name='jobsch_counter'>
	<option value='' " . ($jobsch_counter == ''?"selected='selected'":"") . ">" . JOBSCH_A108 . "</option>
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
    // -------------------->
    $jobsch_text .= "<tr><td colspan=\"2\" class=\"fcaption\" style='text-align:left'>
	<input class='button' type='submit' value='" . JOBSCH_A70 . "' onclick='this.form.jobsch_action.value=\"save\";'name='merc' />";
    if ($actvar == "edit")
    {
        $jobsch_text .= "<input type='hidden' name='jobsch_category' value='$jobsch_category'>";
        $jobsch_text .= "<input type='hidden' name='catid' value='$catid'>";
    }
    else
    {
        $jobsch_text .= "<input type='hidden' name='catid' value='0'>";
    }
    $jobsch_text .= "<input type='hidden' name='actvar' value='$actvar' />
			<input type='hidden' name='action' value='godo' />
			<input type='hidden' name='jobsch_action' value='' />
			</td></tr></table></form>";
    $ns->tablerender(JOBSCH_A1, $jobsch_text);
}

require_once(e_ADMIN . "footer.php");

?>
