<?php
if (!defined('e107_INIT')) { exit; }
if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php"))
{
    include_once(e_PLUGIN . "job_search/languages/admin/" . e_LANGUAGE . ".php");
}
else
{
    include_once(e_PLUGIN . "job_search/languages/admin/English.php");
}
$config_category = JOBSCH_A43;
$config_events = array('jobshack' => JOBSCH_A44);

if (!function_exists('notify_jobshack'))
{
    function notify_jobshack($data)
    {
        global $nt;

        if ($data['action'] = "update")
        {
            $message = "<strong>" . JOBSCH_A49 . ': </strong>' . $data['user'] . '<br />';
        }
        else
        {
            $message = "<strong>" . JOBSCH_A45 . ': </strong>' . $data['user'] . '<br />';
        }
        $message .= "<strong>" . JOBSCH_A46 . ':</strong> ' . $data['itemtitle'] . "<br /><br />" . JOBSCH_A48 ;
        $message .= " " . JOBSCH_A47 . " " . $data['catid'] . "<br /><br />";
        $nt->send('jobshack', JOBSCH_A44, $message);
    }
}

?>