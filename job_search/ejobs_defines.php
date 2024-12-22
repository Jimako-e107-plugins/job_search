<?php


define("JOBS_FOLDER", "job_search");


define("JOBS_DEF_PLUGIN_FOLDER", "job_search");
define('JOBS_DEF_CATEGORY_TABLE', 'jobsch_cats');  //from sql file, DEF is used for easier founding and replace 
define('JOBS_DEF_CATEGORY_CACHE_STRING', 'jobsch_cats');  //see categories menu
define('JOBS_DEF_CATEGORY_MODEL_FILE', 'ejobs_category.php');  //see categories menu, handlers
define('JOBS_DEF_CATEGORY_MODEL_TREE', 'ejobs_plugin_category_tree');  //see categories menu, handlers
define('JOBS_DEF_CATEGORY_MODEL_ITEM', 'ejobs_plugin_category_item');  //see categories menu, handlers


define('JOBS_DEF_ITEM_FIELD_ID', 'jobsch_cid');
define('JOBS_DEF_ITEM_FIELD_CAT', 'jobsch_category');
define('JOBS_DEF_ITEM_TABLE', 'jobsch_ads');
define('JOBS_DEF_ITEM_FIELD_START', 'jobsch_postdate');
define('JOBS_DEF_ITEM_FIELD_END', 'jobsch_closedate');

define('JOBS_DEF_CATEGORY_FIELD_ID', 'jobsch_catid');
define('JOBS_DEF_CATEGORY_FIELD_ORDER', 'jobsch_catid');
define('JOBS_DEF_CATEGORY_FIELD_CLASS', 'jobsch_catclass');

define("JOBS_IMAGES_PATH", e_PLUGIN_ABS . JOBS_FOLDER . "/images/");   //to replace e_IMAGE ,  e_PLUGIN_ABS is needed for SEF-URL site !!!

if (!defined("USER_WIDTH"))
{
	define("USER_WIDTH", "width:100%");
}
