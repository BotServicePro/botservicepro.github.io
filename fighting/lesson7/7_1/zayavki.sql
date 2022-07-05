/*Таблица Заявок для физического боя 1 х 1 */
CREATE TABLE `zayavki` (
  `ID` BIGINT unsigned NOT NULL DEFAULT 1,     /*номер заявки - ID игрока ее подавшего*/
  `CHAR1_NAME` Char(32) NOT NULL,              /*Ник 1 игрока*/
  `level1` INT NOT NULL,                       /*level 1 игрока*/
  `CHAR2_NAME` Char(32),                       /*Ник 2 игрока*/
  `level2` INT,                                /*level 2 игрока*/
  `ZDATA` DATE,                                /*дата заявки*/
  `ZTIME` TIME,                                /*время заявки*/
  `ZTYPE` SMALLINT(2) unsigned,                /*Тип заявки*/
  `ZTIMEOUT` SMALLINT(2),                      /*Таймаут заявки*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;
