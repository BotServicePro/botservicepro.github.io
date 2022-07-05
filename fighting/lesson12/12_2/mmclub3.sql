/*Таблица городов*/
CREATE TABLE `Towns` (
  `ID` SMALLINT(2) unsigned NOT NULL auto_increment,
  `TownName` char(40) default NULL,
  `TownStatus` SMALLINT(2) unsigned NOT NULL DEFAULT 1, /*1-обычный,2-столица,3-секретный*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO towns (TownName, TownStatus) VALUES('Силлурия',2);
INSERT INTO towns (TownName, TownStatus) VALUES('Гринсфилд',1);

