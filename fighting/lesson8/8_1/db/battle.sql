/* Таблица поединка 1 х 1 */
CREATE TABLE `battle` (
  `BAT_ID` BIGINT unsigned NOT NULL auto_increment,  /*ID поединка*/
  `USER1_ID` bigint(20),                        /*ID 1 игрока*/
  `USER2_ID` bigint(20),                        /*ID 2 игрока*/
  `TIMEOUT` SMALLINT(2),                        /*Таймаут в секундах*/
  `STARTTIME` DATETIME,                         /*время начала поединка*/
  `M1` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*Ход первого*/
  `M2` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*Ход второго*/
  `LASTMOVE` DATETIME,                          /*время последнего хода*/
  `STATUS` SMALLINT(1),                         /*статус поединка 1-идет,2-завершен*/
  PRIMARY KEY  (`BAT_ID`)
) TYPE=MyISAM;

/* Таблица детализации поединка 1 х 1 */
CREATE TABLE `battledetails` (
  `BATDET_ID` BIGINT unsigned NOT NULL auto_increment,   /*номер заявки - ID игрока ее подавшего*/
  `BAT_ID` BIGINT unsigned NOT NULL DEFAULT 1,      /*ID поединка*/
  `USERID` bigint(20),                              /*ID игрока сделавшего ход*/
  `ATTACK` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*Зона атаки*/
  `DEFEND` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*Зона защиты*/
  `MESSAGE` CHAR(255) NOT NULL DEFAULT '',           /*Описание действия....куда нанес удар и т.д.*/
  PRIMARY KEY  (`BATDET_ID`)
) TYPE=MyISAM;

/*Справочник зон*/
CREATE TABLE `body_zones` (
   `BZ_ID` SMALLINT(1) unsigned NOT NULL DEFAULT 0,
   `BZ_NAME` CHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY  (`BZ_ID`)
) TYPE=MyISAM;
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(1,'Голова');
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(2,'Грудь');
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(3,'Живот');
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(4,'Ноги');


