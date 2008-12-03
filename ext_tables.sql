#
# Table structure for table 'tx_externalimporttut_departments'
#
CREATE TABLE tx_externalimporttut_departments (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	code varchar(4) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for extending table 'fe_users'
#
CREATE TABLE fe_users (
	tx_externalimporttut_code varchar(10) DEFAULT '' NOT NULL,
	tx_externalimporttut_department text,
	tx_externalimporttut_holidays double(11,2) DEFAULT '0.0' NOT NULL,
);