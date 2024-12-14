<?php
/*
+---------------------------------------------------------------+
|	Job Search Plugin for e107
|
|	Barry
|	http://www.keal.me.uk
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
+---------------------------------------------------------------+
*/
// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = "Job Search";
$eplug_version = "1.5";
$eplug_author = "Father Barry";

$eplug_url = "http://www.keal.me.uk/";
$eplug_email = "";
$eplug_description = "A basic Job Search plugin";
$eplug_compatible = "e107v7";
$eplug_readme = "readme.pdf";	// leave blank if no readme file
$eplug_compliant=TRUE;
$eplug_status = TRUE;
$eplug_latest = TRUE;

// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "job_search";

// Mane of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = $eplug_folder."/images/icon_32.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_caption =  "Job Search Configuration";

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array(
"jobsch_email"=>"youremail@example.com",
"jobsch_approval"=>"yes",
"jobsch_valid"=>"14",
"jobsch_read"=>"0",
"jobsch_admin"=>"253",
"jobsch_useremail"=>"1",
"jobsch_pictype"=>"1",
"jobsch_perpage"=>"10",
"jobsch_create"=>"0",
"jobsch_picw"=>"100",
"jobsch_pich"=>"100",
"jobsch_currency"=>"£",
"jobsch_icons"=>"1",
"jobsch_thumbheight"=>"50",
"jobsch_counter"=>"text",
"jobsch_subscribe",1,
"jobsch_sysemail","Site Admin",
"jobsch_sysfrom","admin@example.com",
"jobsch_lastnews"=>0,
"jobsch_sort"=>"DESC",
"jobsch_usexp"=>1,
"jobsch_dform"=>"d-m-Y",
"jobsch_metak"=>"father barry,father,barry,job,search,shack,job search,job shack",
"jobsch_metad"=>"Father Barry e107 job shack plugin. You can get all the latest vacancy news from here. ",


"jobsch_terms"=>"Only suitable vacancies will be accepted. Job adverts will be checked. This site is not responsible for the goods or services");

// List of table names -----------------------------------------------------------------------------------------------
$eplug_table_names = array("jobsch_ads", "jobsch_cats",  "jobsch_subcats","jobsch_locals","jobsch_subs");

// List of sql requests to create tables -----------------------------------------------------------------------------
$eplug_tables = array(
"create table ".MPREFIX."jobsch_ads (
jobsch_cid int(10) auto_increment not null,
jobsch_vacancy varchar(250),
jobsch_companyinfoname varchar(250),
jobsch_category int(10) unsigned not null default 0,
jobsch_document varchar(250),
jobsch_vacancydetails text NULL,
jobsch_approved int(10) unsigned not null default 0,
jobsch_submittedby varchar(250),
jobsch_companyphone varchar(250),
jobsch_email varchar(250),
jobsch_postdate int(10) unsigned not null default 0,
jobsch_closedate int(10) unsigned not null default 0,
jobsch_last int(10) unsigned not null default 0,
jobsch_salary varchar(20)  default null,
jobsch_views int(10) unsigned not null default 0,
jobsch_counter varchar(50) null default '',
jobsch_companyinfo text,
jobsch_locality int(10) unsigned not null default 0,
jobsch_lastnews int(10) unsigned not null default 0,
jobsch_empref varchar(30),
primary key(jobsch_cid)
) TYPE=MyISAM;",
"create table ".MPREFIX."jobsch_cats (
jobsch_catid int(10) auto_increment not null,
jobsch_catname varchar(250)  default null,
jobsch_catdesc varchar(250)  default null,
jobsch_catclass int(10) unsigned not null default '0',
jobsch_caticon varchar(50) null default '',
primary key(jobsch_catid)
) TYPE=MyISAM;",
"create table ".MPREFIX."jobsch_subcats (
jobsch_subid int(10) auto_increment not null,
jobsch_categoryid int(10) unsigned not null default 0,
jobsch_subname varchar(250) default null,
jobsch_subicon varchar(50) default null,
primary key(jobsch_subid)
) TYPE=MyISAM;",
"create table ".MPREFIX."jobsch_locals (
jobsch_localid int(10) auto_increment not null,
jobsch_localname varchar(250) default null,
jobsch_localflag varchar(50) default null,
primary key(jobsch_localid)
) TYPE=MyISAM;",
"create table ".MPREFIX."jobsch_subs (
jobsch_subid int(10) auto_increment not null,
jobsch_subuserid int(10) unsigned not null default '0',
jobsch_subemail varchar(100) default null,
primary key(jobsch_subid)
) TYPE=MyISAM;");


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = True;
$eplug_link_name = "Job Shack";
$eplug_link_url = e_PLUGIN."job_search/jobshack.php";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = "Please add your categories, sub categories and items";

// upgrading ...

$upgrade_add_prefs = "";

$upgrade_remove_prefs = "";

$upgrade_alter_tables ="";

$eplug_upgrade_done = "";

?>