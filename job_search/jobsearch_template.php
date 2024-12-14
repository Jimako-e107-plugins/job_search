<?php

if (!defined('e107_INIT'))
{
    exit;
}
if (!defined("USER_WIDTH"))
{
    define("USER_WIDTH", "100%");
}
global $jobsearch_shortcodes;
if ($pref['jobsch_icons'] > 0)
{
    // template if using icons
    if (!isset($JOBSCH_CAT_HEADER))
    {
        $JOBSCH_CAT_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='forumheader2'  colspan='4' style='width:30%;text-align:left;' ><img src='./images/blank.png' alt='' />&nbsp;</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='4' ><div style='text-align:center;'>{JOBLOGO}</div></td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='4' ><div style='text-align:left;'>" . JOBSCH_100 . " {JOBLOCALSELECTOR}</div></td>
		</tr>

		<tr>
			<td class='forumheader2' style='width:10%;'>&nbsp;</td>
			<td class='forumheader2' style='width:60%;'><strong>" . JOBSCH_2 . "</strong></td>
			<td class='forumheader2' style='width:30%;'><strong>" . JOBSCH_5 . "</strong></td>
		</tr>";
    }
    if (!isset($JOBSCH_CAT_DETAIL))
    {
        $JOBSCH_CAT_DETAIL = "
		<tr>
			<td class='forumheader3' style='width:10%;text-align:center;vertical-align:top;'>{JOBCATICON}</td>
			<td class='forumheader3' style='width:60%;text-align:left;vertical-align:top;'>{JOBCATNAME}<br /><em>{JOBCATDESC}</em></td>
			<td class='forumheader3' style='width:30%;text-align:left;vertical-align:top;'>{JOBSUBLIST}</td>
		</tr>";
    }
    if (!isset($JOBSCH_CAT_FOOTER))
    {
        $JOBSCH_CAT_FOOTER = "
    	<tr>
    		<td class='forumheader' colspan='3'>{JOB_NEXTPREV}&nbsp;{JOBMANAGE=button}&nbsp;{JOBTC=button}&nbsp;{JOBSUBSCRIBE=button}</td>
    	</tr>

	</table>
	</div>";
    }
}
else
{
    // not using icons
    if (!isset($JOBSCH_CAT_HEADER))
    {
        $JOBSCH_CAT_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='forumheader2'  colspan='3' style='width:30%;text-align:left;' ><img src='./images/blank.png' alt='' />&nbsp;</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='3' ><div style='text-align:center;'>{JOBLOGO}</div></td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='3' ><div style='text-align:left;'>" . JOBSCH_100 . " {JOBLOCALSELECTOR}</div></td>
		</tr>

		<tr>
			<td class='forumheader2' style='width:60%;'><strong>" . JOBSCH_2 . "</strong></td>
			<td class='forumheader2' style='width:30%;'><strong>" . JOBSCH_5 . "</strong></td>
		</tr>";
    }
    if (!isset($JOBSCH_CAT_DETAIL))
    {
        $JOBSCH_CAT_DETAIL = "
		<tr>
			<td class='forumheader3' style='width:60%;text-align:left;vertical-align:top;'>{JOBCATNAME}<br /><em>{JOBCATDESC}</em></td>
			<td class='forumheader3' style='width:30%;text-align:left;vertical-align:top;'>{JOBSUBLIST}</td>
		</tr>";
    }
    if (!isset($JOBSCH_CAT_FOOTER))
    {
        $JOBSCH_CAT_FOOTER = "
    	<tr>
    		<td class='forumheader3' colspan='3'>{JOB_NEXTPREV}&nbsp;{JOBMANAGE=button}&nbsp;{JOBTC=button}&nbsp;{JOBSUBSCRIBE=button}</td>
    	</tr>

	</table>
	</div>";
    }
}
// Sub Category Display
if ($pref['jobsch_icons'] > 0)
{
    // template if using icons
    if (!isset($JOBSCH_SUB_HEADER))
    {
        $JOBSCH_SUB_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='forumheader2'  colspan='4' style='width:30%;text-align:left;' >{JOBUPPAGE=icon}&nbsp;&nbsp;{JOBCATNAME=nolink}</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='4' ><div style='text-align:center;'>{JOBLOGO}</div></td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='4' ><div style='text-align:left;'>" . JOBSCH_100 . " {JOBLOCALSELECTOR}</div></td>
		</tr>

		<tr>
			<td class='forumheader2' style='width:10%;'>&nbsp;</td>
			<td class='forumheader2' style='width:60%;'><strong>" . JOBSCH_5 . "</strong></td>
			<td class='forumheader2' style='width:30%;'><strong>" . JOBSCH_6 . "</strong></td>
		</tr>";
    }
    if (!isset($JOBSCH_SUB_DETAIL))
    {
        $JOBSCH_SUB_DETAIL = "
		<tr>
			<td class='forumheader3' style='width:10%;text-align:left;'>{JOBSUBICON}</td>
			<td class='forumheader3' style='width:60%;text-align:left;'>{JOBSUBNAME}</td>
			<td class='forumheader3' style='width:30%;text-align:left;'>{JOBSUBJOBCOUNT}</td>
		</tr>";
    }
    if (!isset($JOBSCH_SUB_FOOTER))
    {
        $JOBSCH_SUB_FOOTER = "
		<tr>
			<td class='forumheader3' colspan='3'>{JOBMANAGE=button}&nbsp;{JOBTC=button}&nbsp;&nbsp;{JOBSUBSCRIBE=button}</td>
		</tr>
    	<tr>
    		<td class='forumheader' colspan='3'>{JOB_NEXTPREV}&nbsp;</td>
    	</tr>
		</table>
	</div>";
    }
}
else
{
    if (!isset($JOBSCH_SUB_HEADER))
    {
        $JOBSCH_SUB_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='forumheader2'  colspan='3' style='width:30%;text-align:left;' >{JOBUPPAGE=icon}&nbsp;&nbsp;{JOBCATNAME=nolink}</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='3' ><div style='text-align:center;'>{JOBLOGO}</div></td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='3' ><div style='text-align:left;'>" . JOBSCH_100 . " {JOBLOCALSELECTOR}</div></td>
		</tr>

		<tr>

			<td class='forumheader2' style='width:60%;'><strong>" . JOBSCH_5 . "</strong></td>
			<td class='forumheader2' style='width:30%;'><strong>" . JOBSCH_6 . "</strong></td>
		</tr>";
    }
    if (!isset($JOBSCH_SUB_DETAIL))
    {
        $JOBSCH_SUB_DETAIL = "
		<tr>
			<td class='forumheader3' style='width:60%;text-align:left;'>{JOBSUBNAME}</td>
			<td class='forumheader3' style='width:30%;text-align:left;'>{JOBSUBJOBCOUNT}</td>
		</tr>";
    }
    if (!isset($JOBSCH_SUB_FOOTER))
    {
        $JOBSCH_SUB_FOOTER = "
		<tr>
			<td class='forumheader3' colspan='3'>{JOBMANAGE=button}&nbsp;{JOBTC=button}&nbsp;&nbsp;{JOBSUBSCRIBE=button}</td>
		</tr>
    	<tr>
    		<td class='forumheader' colspan='3'>{JOB_NEXTPREV}&nbsp;</td>
    	</tr>
		</table>
	</div>";
    }
}
if (!isset($JOBSCH_LIST_HEADER))
{
    $JOBSCH_LIST_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='forumheader2'  colspan='5' style='width:30%;text-align:left;' >{JOBUPPAGE=icon}&nbsp;&nbsp;{JOBCATNAME=nolink}&nbsp;-&nbsp;{JOBSUBNAME=nolink}</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='5' ><div style='text-align:center;'>{JOBLOGO}</div></td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='5' ><div style='text-align:left;'>" . JOBSCH_100 . " {JOBLOCALSELECTOR}</div></td>
		</tr>

		<tr>
			<td class='forumheader2' style='width:40%;'><strong>" . JOBSCH_15 . "</strong></td>
			<td class='forumheader2' style='width:10%;text-align:right;'><strong>" . JOBSCH_60 . " {CURRENCY_SYMBOL}</strong></td>
			<td class='forumheader2' style='width:30%;text-align:left;'><strong>" . JOBSCH_28 . "</strong></td>
			<td class='forumheader2' style='width:10%;'><strong>" . JOBSCH_116 . "</strong></td>
			<td class='forumheader2' style='width:10%;'><strong>" . JOBSCH_16 . "</strong></td>
		</tr>";
}
if (!isset($JOBSCH_LIST_DETAIL))
{
    $JOBSCH_LIST_DETAIL = "
		<tr>
			<td class='forumheader3' style='width:40%;text-align:left;'>{JOBTITLE=item}</td>
			<td class='forumheader3' style='width:10%;text-align:right;'>{JOBSALARY}</td>
			<td class='forumheader3' style='width:30%;text-align:left;'>{JOBCOMPANY}</td>
			<td class='forumheader3' style='width:10%;text-align:left;'><span class='smallblacktext'>{JOBPOSTDATE=j M Y}</span></td>
			<td class='forumheader3' style='width:10%;text-align:left;'><span class='smallblacktext'>{JOBEXPIRES=j M Y}</span></td>
		</tr>";
}
if (!isset($JOBSCH_LIST_FOOTER))
{
    $JOBSCH_LIST_FOOTER = "
		<tr>
			<td class='forumheader3' colspan='5'>{JOBMANAGE=button}&nbsp;{JOBTC=button}&nbsp;{JOBSUBSCRIBE=button}</td>
		</tr>
    	<tr>
    		<td class='forumheader' colspan='5'>{JOB_NEXTPREV}&nbsp;</td>
    	</tr>
	</table>
	</div>";
}

if (!isset($JOBSCH_ITEM_HEADER))
{
    // global $jobsch_catid,$jobsch_subid,$jobsch_itemid,$jobsch_tmp,$jobsch_local;
    $JOBSCH_ITEM_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
		<tr>
			<td class='forumheader2'  colspan='2' style='width:30%;text-align:left;' >{JOBUPPAGE=icon}&nbsp;&nbsp;{JOBEMAILLINK=icon}&nbsp;&nbsp;{JOBPRINT=icon}</td>
		</tr>
		<tr>
			<td class='fcaption' colspan='2'>" . JOBSCH_45 . " - <strong>{JOBCATNAME=nolink}</strong>: " . JOBSCH_91 . "<strong>{JOBSUBNAME=nolink}</strong></td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' ><div style='text-align:center;'>{JOBLOGO}</div></td>
		</tr>";
}
if (!isset($JOBSCH_ITEM_DETAIL))
{
    $JOBSCH_ITEM_DETAIL .= "
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_7 . "</td>
			<td class='forumheader3'>{JOBTITLE}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_118 . "</td>
			<td class='forumheader3'>{JOBREFERENCE}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_8 . "</td>
			<td class='forumheader3'>{JOBCOMPANY}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_119 . "</td>
			<td class='forumheader3'>{JOBEMPREF}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_10 . "</td>
			<td class='forumheader3'>{JOBDETAILS}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_103 . "</td>
			<td class='forumheader3'>{JOBLOCALITY}</td>
		</tr>

		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_60 . "</td>
			<td class='forumheader3'>{JOBSALARY}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:30%;'>" . JOBSCH_12 . "</td>
			<td class='forumheader3'>{JOBPHONE}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:30%;'>" . JOBSCH_13 . "</td>
			<td class='forumheader3'>{JOBEMAIL}</td>
		</tr>

		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_102 . "</td>
			<td class='forumheader3'>{JOBEMPLOYERDETAILS}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_9 . "</td>
			<td class='forumheader3'>{JOBDOWNLOAD}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_120 . "</td>
			<td class='forumheader3'>{JOBEXPIRES=D jS F Y}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_115 . "</td>
			<td class='forumheader3'>{JOBPOSTDATE=D jS F Y}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_132 . "</td>
			<td class='forumheader3'>{JOBPOSTER}</td>
		</tr>
		<tr>
			<td class='forumheader3' style='width:20%;'>" . JOBSCH_86 . "</td>
			<td class='forumheader3'>{JOBVIEWS}</td>
		</tr>
		";
}

if (!isset($JOBSCH_ITEM_FOOTER))
{
    $JOBSCH_ITEM_FOOTER = "
    	<tr>
			<td class='forumheader3' colspan='5'>{JOBMANAGE=button}&nbsp;{JOBTC=button}&nbsp;{JOBSUBSCRIBE=button}</td>
		</tr>
		<tr>
				<td class='forumheader3' colspan='2'>&nbsp;</td>
		</tr>
		</table>
	</div>";
}

if (!isset($JOBSCH_TC_HEADER))
{
    $JOBSCH_TC_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
	<tr>
		<td class='fcaption'>" . JOBSCH_41 . "</td>
	</tr>
	<tr>
		<td class='forumheader2' style='width:30%;text-align:left;' >{JOBUPPAGE=icon}</td>
	</tr>
	<tr>
		<td class='forumheader2'><div style='text-align:center;'>{JOBLOGO}</div></td>
	</tr>";
}
if (!isset($JOBSCH_TC_DETAIL))
{
    $JOBSCH_TC_DETAIL = "
	<tr>
		<td class='forumheader2' style='width:70%;'><strong>" . JOBSCH_41 . "</strong></td>
	</tr>
	<tr>
		<td class='forumheader3'>{JOBTERMS}</td>
	</tr>";
}
if (!isset($JOBSCH_TC_FOOTER))
{
    $JOBSCH_TC_FOOTER = "
	</table>
	</div>";
}

if (!isset($JOBSCH_SUBS_HEADER))
{
    $JOBSCH_SUBS_HEADER = "
	<div class='fborder' style='width:" . USER_WIDTH . "' >
	<table style='width:" . USER_WIDTH . "'>
	<tr>
		<td class='fcaption'>" . JOBSCH_106 . "</td>
	</tr>
	<tr>
		<td class='forumheader2' style='width:30%;text-align:left;' >{JOBUPPAGE=icon}</td>
	</tr>
	<tr>
		<td class='forumheader2' ><div style='text-align:center;'>{JOBLOGO}</div></td>
	</tr>
	<tr>
		<td class='forumheader3'><div style='text-align:left;'>{JOBSUBNOTE}</div></td>
	</tr>
	";
}
if (!isset($JOBSCH_SUBS_DETAIL))
{
    $JOBSCH_SUBS_DETAIL = "
	<tr>
		<td class='forumheader3'>{JOBSUBME}</td>
	</tr>";
}
if (!isset($JOBSCH_SUBS_FOOTER))
{
    $JOBSCH_SUBS_FOOTER = "
    <tr>
		<td class='forumheader2' style='width:30%;text-align:left;' >{JUBSUBOK}</td>
	</tr>
	</table>
	</div>";
}

?>