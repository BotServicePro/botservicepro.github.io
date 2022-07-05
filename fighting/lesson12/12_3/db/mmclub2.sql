/* билеты на вокзале */
CREATE TABLE `tickets`(
   `TK_ID`          BIGINT(20) unsigned NOT NULL auto_increment,      /* ID */
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID предмета в справочнике предметов */
   `Town`           INT(2) unsigned NOT NULL,                         /* ID Города, где расположен вокзал */
   `TownTo`         INT(2) unsigned NOT NULL,                         /* ID Города, куда отправляемся */
   `DateStart`      TIMESTAMP NOT NULL,                               /* дата и время отправления*/
   `Price`          INT NOT NULL,                                     /* цена билета */
   `MovingTime`     INT NOT NULL,                                     /* время переезда (минут) */
   `QTY`            INT NOT NULL,                                     /* количество предметов */
  PRIMARY KEY  (`TK_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,20,'2008-06-16 09:30',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,40,'2008-06-16 12:30',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,30,'2008-06-16 14:03',1,2,4,60);
