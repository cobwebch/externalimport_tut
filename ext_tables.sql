#
# Table structure for table 'tx_externalimporttut_departments'
#
CREATE TABLE tx_externalimporttut_departments (
	code varchar(4) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL
);


#
# Table structure for table 'tx_externalimporttut_teams'
#
CREATE TABLE tx_externalimporttut_teams (
	code varchar(5) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	members text
);


#
# Table structure for extending table 'fe_users'
#
CREATE TABLE fe_users (
	tx_externalimporttut_code varchar(10) DEFAULT '' NOT NULL,
	tx_externalimporttut_department text,
	tx_externalimporttut_holidays int(11) DEFAULT '0' NOT NULL
);


#
# Table structure for extending table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
	tx_externalimporttut_externalid varchar(255) DEFAULT '' NOT NULL
);