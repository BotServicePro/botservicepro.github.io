/*������� �������*/
CREATE TABLE `Towns` (
  `ID` SMALLINT(2) unsigned NOT NULL auto_increment,
  `TownName` char(40) default NULL,
  `TownStatus` SMALLINT(2) unsigned NOT NULL DEFAULT 1, /*1-�������,2-�������,3-���������*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO towns (TownName, TownStatus) VALUES('��������',2);
INSERT INTO towns (TownName, TownStatus) VALUES('���������',1);

