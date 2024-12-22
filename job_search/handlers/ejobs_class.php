<?php

// Check if the class 'ejobs' already exists before declaring it
if (!class_exists('ejobs'))
{

	class ejobs
	{

		static $categories =  array();
		static $jobs =  array();

		static $jobsch_today;  //midnight

		function __construct()
		{

			$jobsch_today = self::$jobsch_today = mktime(0, 0, 0, date("n", time()), date("j", time()), date("Y", time()));

			$qry = "
			SELECT 
				COUNT(n." . JOBS_DEF_ITEM_FIELD_ID . ") AS jobsch_count, 
				nc.* FROM #" . JOBS_DEF_CATEGORY_TABLE . " AS nc
			LEFT JOIN #" . JOBS_DEF_ITEM_TABLE . " AS n ON n." . JOBS_DEF_ITEM_FIELD_CAT . "=nc." . JOBS_DEF_CATEGORY_FIELD_ID . "
			WHERE 
				find_in_set(" . JOBS_DEF_CATEGORY_FIELD_CLASS . ",'" . USERCLASS_LIST . "')
				AND   n." . JOBS_DEF_ITEM_FIELD_START . " < " . $jobsch_today  . " 
				AND  (n." . JOBS_DEF_ITEM_FIELD_END . "=0 || n." . JOBS_DEF_ITEM_FIELD_END . ">" . $jobsch_today  . ")
			GROUP BY nc." . JOBS_DEF_CATEGORY_FIELD_ID . "
			ORDER BY nc." . JOBS_DEF_CATEGORY_FIELD_ORDER . " ASC
			";

			self::$categories = e107::getDb()->retrieve($qry, true);
			//self::$categories = e107::getDb()->retrieve("jobsch_cats", "*", "find_in_set(jobsch_catclass,'" . USERCLASS_LIST . "')  order by jobsch_catname", true);

			$jobsch_today = self::$jobsch_today = mktime(0, 0, 0, date("n", time()), date("j", time()), date("Y", time()));


			// $where = " WHERE jobsch_approved > 0 AND (jobsch_closedate = 0 OR jobsch_closedate > $jobsch_today ) GROUP BY jobsch_category";

			// $jobs = e107::getDb()->retrieve("jobsch_ads", "jobsch_category, COUNT(jobsch_category) AS xy", $where , true ); 


		}

		public static function getCategories()
		{

			return self::$categories;
		}
	}
}
