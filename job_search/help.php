<?php

if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/help/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/help/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/help/English.php");
}


$jobsch_action = basename($_SERVER['PHP_SELF'], ".php");

$jobsch_text = "<table width='100%' class='fborder'>";
if ($jobsch_action=="admin_config?delparent") {
      $jobsch_text .= "<tr><td class='forumheader3'><b>" . FAQ_H17 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . FAQ_H72 . "</b><br />" . FAQ_H73 . "</td></tr>";

}
if ($jobsch_action == "admin_config")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H2 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H3 . "</b><br />" . JOBSCH_H4 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H5 . "</b><br />" . JOBSCH_H6 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H7 . "</b><br />" . JOBSCH_H8 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H9 . "</b><br />" . JOBSCH_H10 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H11 . "</b><br />" . JOBSCH_H12 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H13 . "</b><br />" . JOBSCH_H14 . "</td></tr>";
$jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H29 . "</b><br />" . JOBSCH_H29a . "</td></tr>";
$jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H29b . "</b><br />" . JOBSCH_H29c . "</td></tr>";

    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H15 . "</b><br />" . JOBSCH_H16 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H17 . "</b><br />" . JOBSCH_H18 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H19 . "</b><br />" . JOBSCH_H20 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H21 . "</b><br />" . JOBSCH_H22 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H27 . "</b><br />" . JOBSCH_H28 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H25 . "</b><br />" . JOBSCH_H26 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H23 . "</b><br />" . JOBSCH_H24 . "</td></tr>";

    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H81 . "</b><br />" . JOBSCH_H82 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H83 . "</b><br />" . JOBSCH_H84 . "</td></tr>";

}

if ($jobsch_action == "admincat")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H30 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H31 . "</b><br />" . JOBSCH_H32 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H33 . "</b><br />" . JOBSCH_H34 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H35 . "</b><br />" . JOBSCH_H36 . "</td></tr>";
}

if ($jobsch_action == "adminsub")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H40 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H41 . "</b><br />" . JOBSCH_H42 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H43 . "</b><br />" . JOBSCH_H44 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H45 . "</b><br />" . JOBSCH_H46 . "</td></tr>";
}

if ($jobsch_action == "admin_ad")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H50 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H51 . "</b><br />" . JOBSCH_H52 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H53 . "</b><br />" . JOBSCH_H54 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H55 . "</b><br />" . JOBSCH_H56 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H57 . "</b><br />" . JOBSCH_H58 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H59 . "</b><br />" . JOBSCH_H60 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H61 . "</b><br />" . JOBSCH_H62 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H63 . "</b><br />" . JOBSCH_H64 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H65 . "</b><br />" . JOBSCH_H66 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H67 . "</b><br />" . JOBSCH_H68 . "</td></tr>";

}
if ($jobsch_action == "admin_submit")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H70 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H71 . "</b><br />" . JOBSCH_H72 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H73 . "</b><br />" . JOBSCH_H74 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H75 . "</b><br />" . JOBSCH_H76 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H77 . "</b><br />" . JOBSCH_H78 . "</td></tr>";

}
if ($jobsch_action == "admin_purge")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H90 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H91 . "</b><br />" . JOBSCH_H92 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H93 . "</b><br />" . JOBSCH_H94 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H95 . "</b><br />" . JOBSCH_H96 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H97 . "</b><br />" . JOBSCH_H98 . "</td></tr>";

}
if ($jobsch_action == "admin_imag")
{
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H100 . "</b></td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H101 . "</b><br />" . JOBSCH_H102 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H103 . "</b><br />" . JOBSCH_H104 . "</td></tr>";
    $jobsch_text .= "<tr><td class='forumheader3'><b>" . JOBSCH_H105 . "</b><br />" . JOBSCH_H106 . "</td></tr>";

}
$jobsch_text .= "</table>";
$ns->tablerender(JOBSCH_H1, $jobsch_text);

?>