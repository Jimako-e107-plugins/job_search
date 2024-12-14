<?php

require_once("../../class2.php");
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
$e_wysiwyg = "jobsch_terms";
if ($pref['wysiwyg'])
{
    $WYSIWYG = true;
}
require_once(e_HANDLER . "ren_help.php");
require_once(e_HANDLER . "userclass_class.php");
require_once(e_ADMIN . "auth.php");

if (e_QUERY == "update")
{
    // Update rest
    if ($pref['jobsch_thumbheight'] <> $_POST['jobsch_thumbheight'])
    {
        require_once("upload_pic.php");
        // Resize thumbnails
        if ($handle = opendir("./images/classifieds"))
        {
            while (false !== ($file = readdir($handle)))
            {
                // go through each file in the directory and create a thumbnail image
                // Do not try on index.htm or on existing thumbnails
                // All thumbnails are generated as type .jpg
                if ($file <> "." && $file <> ".." && $file <> "index.htm" && substr($file, 0, 6) <> "thumb_")
                {
                    makeThumbnail($file, $t_ht = $_POST['jobsch_thumbheight']);
                }
            }

            closedir($handle);
            $jobsch_msgtext .= JOBSCH_A116 . "<br />";
        }
    }
    $pref['jobsch_email'] = $tp->toDB($_POST['jobsch_email']);
 
    $pref['jobsch_valid'] = $tp->toDB($_POST['jobsch_valid']);
    $pref['jobsch_read'] = $tp->toDB($_POST['jobsch_read']);
    $pref['jobsch_create'] = $tp->toDB($_POST['jobsch_create']);
    $pref['jobsch_admin'] = $tp->toDB($_POST['jobsch_admin']);
    $pref['jobsch_useremail'] = $tp->toDB($_POST['jobsch_useremail']);
    $pref['jobsch_pictype'] = $tp->toDB($_POST['jobsch_pictype']);
    $pref['jobsch_terms'] = $tp->toDB($_POST['jobsch_terms']);
    $pref['jobsch_perpage'] = $tp->toDB($_POST['jobsch_perpage']);
    $pref['jobsch_pich'] = $tp->toDB($_POST['jobsch_pich']);
    $pref['jobsch_picw'] = $tp->toDB($_POST['jobsch_picw']);
    $pref['jobsch_currency'] = $tp->toDB($_POST['jobsch_currency']);
    $pref['jobsch_metad'] = $tp->toDB($_POST['jobsch_metad']);
    $pref['jobsch_metak'] = $tp->toDB($_POST['jobsch_metak']);
    $pref['jobsch_leadz'] = $tp->toDB($_POST['jobsch_leadz']);
    $pref['jobsch_icons'] = $tp->toDB($_POST['jobsch_icons']);
    $pref['jobsch_counter'] = $tp->toDB($_POST['jobsch_counter']);
    $pref['jobsch_thumbheight'] = $tp->toDB($_POST['jobsch_thumbheight']);
    $pref['jobsch_subdrop'] = $tp->toDB($_POST['jobsch_subdrop']);
    $pref['jobsch_subscribe'] = $tp->toDB($_POST['jobsch_subscribe']);
    $pref['jobsch_sysemail'] = $tp->toDB($_POST['jobsch_sysemail']);
    $pref['jobsch_sysfrom'] = $tp->toDB($_POST['jobsch_sysfrom']);
    $pref['jobsch_sort'] = $tp->toDB($_POST['jobsch_sort']);
    $pref['jobsch_usexp'] = $tp->toDB($_POST['jobsch_usexp']);
    $pref['jobsch_dform'] = $tp->toDB($_POST['jobsch_dform']);
    save_prefs();

    $jobsch_msgtext .= JOBSCH_A14 ;
}
$jobsch_chmod = fopen("./documents/test.php", "w");
if ($jobsch_chmod)
{
    // we can write the document
    fclose($jobsch_chmod);
    if (!unlink("./documents/test.php"))
    {
        $jobsch_msgtext .= "<br />" . JOBSCH_A165;
    }
}
else
{
    $jobsch_msgtext .= "<br />" . JOBSCH_A165;
}
$jobsch_text = "<form id=\"config\" method=\"post\" action=\"" . e_SELF . "?update\">
		<table class=\"fborder\" width='97%'>";
$jobsch_text .= "<tr><td class='fcaption' colspan='2' style='text-align:left'>" . JOBSCH_A2 . "</td></tr>";

$jobsch_text .= "<tr><td class='forumheader3' colspan='2' style='text-align:left'><strong>$jobsch_msgtext</strong>&nbsp;</td></tr>";
// $jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A6 . "</td><td class='forumheader3'>
// <input class='tbox' style='width:190px' type='text' name='jobsch_email' value='" . $pref['jobsch_email'] . "' /></td></tr>";
 
  

$jobsch_text .= "
<tr><td class='forumheader3'>" . JOBSCH_A156 . "</td><td class='forumheader3'>
	<select class='tbox' name='jobsch_dform'>
		<option value='d-m-Y' " . ($pref['jobsch_dform'] == "d-m-Y" ?"selected='selected'":"") . ">d-m-Y</option>
		<option value='m-d-Y' " . ($pref['jobsch_dform'] == "m-d-Y" ?"selected='selected'":"") . ">m-d-Y</option>
		<option value='Y-m-d' " . ($pref['jobsch_dform'] == "Y-m-d" ?"selected='selected'":"") . ">Y-m-d</option>

		</select>
</td></tr>";

$jobsch_text .= "
<tr><td class='forumheader3'>" . JOBSCH_A143 . "</td><td class='forumheader3'>
	<input type='text' name='jobsch_sysfrom' style='width:80%' class='tbox' value='" . $pref['jobsch_sysfrom'] . "' /></td></tr>";

$jobsch_text .= "<tr><td class='forumheader3' style='width:30%;'>" . JOBSCH_A117 . "</td><td class='forumheader3'>
	<select class='tbox' name='jobsch_counter'>
	<option value='NONE' " . ($pref['jobsch_counter'] == 'NONE'?"selected='selected'":"") . ">" . JOBSCH_A118 . "</option>
	<option value='ALL' " . ($pref['jobsch_counter'] == 'ALL'?"selected='selected'":"") . ">" . JOBSCH_A119 . "</option>
	<option value='cb' " . ($pref['jobsch_counter'] == 'cb'?"selected='selected'":"") . ">Coloured Blocks</option>
	<option value='crt' " . ($pref['jobsch_counter'] == 'crt'?"selected='selected'":"") . ">CRTs</option>
	<option value='flame' " . ($pref['jobsch_counter'] == 'flame'?"selected='selected'":"") . ">Flames</option>
	<option value='floppy' " . ($pref['jobsch_counter'] == 'floppy'?"selected='selected'":"") . ">Floppy Disks</option>
	<option value='heart' " . ($pref['jobsch_counter'] == 'heart'?"selected='selected'":"") . ">Hearts</option>
	<option value='jelly' " . ($pref['jobsch_counter'] == 'jelly'?"selected='selected'":"") . ">Jelly</option>
	<option value='lcd' " . ($pref['jobsch_counter'] == 'lcd'?"selected='selected'":"") . ">LCD HP Calculator</option>
	<option value='lcdg' " . ($pref['jobsch_counter'] == 'lcdg'?"selected='selected'":"") . ">LED Green</option>
	<option value='purple' " . ($pref['jobsch_counter'] == 'purple'?"selected='selected'":"") . ">Purple</option>
	<option value='slant' " . ($pref['jobsch_counter'] == 'slant'?"selected='selected'":"") . ">Slant</option>
	<option value='snowm' " . ($pref['jobsch_counter'] == 'snowm'?"selected='selected'":"") . ">Snowman</option>
	<option value='text' " . ($pref['jobsch_counter'] == 'text'?"selected='selected'":"") . ">Text</option>
	<option value='tree' " . ($pref['jobsch_counter'] == 'tree'?"selected='selected'":"") . ">Christmas Tree</option>
	<option value='turf' " . ($pref['jobsch_counter'] == 'turf'?"selected='selected'":"") . ">Turf</option>
	</select>
</td></tr>";
# # html area for t&CC
$jobsch_text .= "
<tr><td class='forumheader3'>" . JOBSCH_A41 . "</td><td class='forumheader3'>";
# <textarea name='jobsch_terms' style='width:85%;vertical-align:top;' cols = '100' rows='6' class='tbox' >" . $pref['jobsch_terms'] . "</textarea></td></tr>";
$insertjs = (!$pref['wysiwyg'])?"rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'":
"rows='20' style='width:100%' ";
$jobsch_terms = $tp->toForm($pref['jobsch_terms']);
$jobsch_text .= "<textarea class='tbox' id='jobsch_terms' name='jobsch_terms' cols='80'  style='width:95%' $insertjs>" . (strstr($jobsch_terms, "[img]http") ? $jobsch_terms : str_replace("[img]../", "[img]", $jobsch_terms)) . "</textarea>";

if (!$pref['wysiwyg'])
{
    $jobsch_text .= "<input id='helpb' class='helpbox' type='text' name='helpb' size='100' style='width:95%'/>
			<br />" . display_help("helpb");
}
# #end html
$jobsch_text .= "</td></tr>
<tr><td class='forumheader3'>" . JOBSCH_A96 . "</td><td class='forumheader3'>
	<textarea name='jobsch_metad' style='width:85%;vertical-align:top;' cols = '100' rows='6' class='tbox' >" . $pref['jobsch_metad'] . "</textarea></td></tr>";

$jobsch_text .= "
<tr><td class='forumheader3'>" . JOBSCH_A97 . "</td><td class='forumheader3'>
	<textarea name='jobsch_metak' style='width:85%;vertical-align:top;' cols = '100' rows='6' class='tbox' >" . $pref['jobsch_metak'] . "</textarea></td></tr>";

$jobsch_text .= "<tr><td class='forumheader' colspan='2' style='text-align:left;vertical-align:top;'>
<input class='button' name='savesettings' type='submit' value='" . JOBSCH_A15 . "' /></td></tr>";

$jobsch_text .= "</table></form>";
$ns->tablerender(JOBSCH_A12, $jobsch_text);
require_once(e_ADMIN . "footer.php");

?>
