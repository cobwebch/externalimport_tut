#
# Table structure for table 'tx_externalimporttut_departments'
#
CREATE TABLE tx_externalimporttut_departments (
	code varchar(4) default '' not null,
	name varchar(255) default '' not null
);


#
# Table structure for table 'tx_externalimporttut_teams'
#
CREATE TABLE tx_externalimporttut_teams (
	code varchar(5) default '' not null,
	name varchar(255) default '' not null,
	members text
);


#
# Table structure for extending table 'fe_users'
#
CREATE TABLE fe_users (
	tx_externalimporttut_code varchar(10) default '' not null,
	tx_externalimporttut_department text,
	tx_externalimporttut_holidays int(11) default 0 not null
);


#
# Table structure for extending table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (
	tx_externalimporttut_externalid varchar(255) default '' not null
);