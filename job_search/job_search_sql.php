CREATE TABLE jobsch_ads (
jobsch_cid int(10) NOT NULL auto_increment,
jobsch_vacancy varchar(250) default NULL,
jobsch_companyinfoname varchar(250) default NULL,
jobsch_category int(10) unsigned NOT NULL default '0',
jobsch_document varchar(250) default NULL,
jobsch_vacancydetails text,
jobsch_approved int(10) unsigned NOT NULL default '0',
jobsch_submittedby varchar(250) default NULL,
jobsch_companyphone varchar(250) default NULL,
jobsch_email varchar(250) default NULL,
jobsch_postdate int(10) unsigned NOT NULL default '0',
jobsch_closedate int(10) unsigned NOT NULL default '0',
jobsch_last int(10) unsigned NOT NULL default '0',
jobsch_salary varchar(20) default NULL,
jobsch_views int(10) unsigned NOT NULL default '0',
jobsch_counter varchar(50) default '',
jobsch_companyinfo text,
jobsch_locality int(10) unsigned NOT NULL default '0',
jobsch_lastnews int(10) unsigned NOT NULL default '0',
jobsch_empref varchar(30) default NULL,
PRIMARY KEY  (jobsch_cid)
) ENGINE=InnoDB;
CREATE TABLE jobsch_cats (
jobsch_catid int(10) NOT NULL auto_increment,
jobsch_catname varchar(250) default NULL,
jobsch_catdesc varchar(250) default NULL,
jobsch_catclass int(10) unsigned NOT NULL default '0',
jobsch_caticon varchar(50) default '',
PRIMARY KEY  (jobsch_catid)
) ENGINE=InnoDB;
CREATE TABLE jobsch_subcats (
jobsch_subid int(10) NOT NULL auto_increment,
jobsch_categoryid int(10) unsigned NOT NULL default '0',
jobsch_subname varchar(250) default NULL,
jobsch_subicon varchar(50) default NULL,
PRIMARY KEY  (jobsch_subid)
) ENGINE=InnoDB;
CREATE TABLE jobsch_locals (
jobsch_localid int(10) NOT NULL auto_increment,
jobsch_localname varchar(250) default NULL,
jobsch_localflag varchar(50) default NULL,
PRIMARY KEY  (jobsch_localid)
) ENGINE=InnoDB;
CREATE TABLE jobsch_subs (
jobsch_subid int(10) NOT NULL auto_increment,
jobsch_subuserid int(10) unsigned NOT NULL default '0',
jobsch_subemail varchar(100) default NULL,
PRIMARY KEY  (jobsch_subid)
) ENGINE=InnoDB;
