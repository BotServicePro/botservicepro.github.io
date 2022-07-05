/*таблица предметов для продажи у КУЗНЕЦА (ОРУЖЕЙНИКА)*/
CREATE TABLE `smith`(
   `SM_ID`             BIGINT(20) unsigned NOT NULL auto_increment,   /*уник. идентификатор предмета в магазине*/
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID предмета в справочнике предметов*/
   `Town`           INT(2) unsigned NOT NULL,                         /*Город, где расположено здание*/
   `QTY`            INT NOT NULL,                                     /*количество предметов*/
  PRIMARY KEY  (`SM_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,2,100);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,5,50);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,8,300);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,13,300);

