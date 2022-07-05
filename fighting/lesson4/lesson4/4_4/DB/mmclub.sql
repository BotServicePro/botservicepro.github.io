/* Справочник позиций предмета */
CREATE Table `ItemPosition_List`(
  `IP_ID` INT(4)   unsigned NOT NULL AUTO_INCREMENT,     /*идентификатор позиции*/
  `ItemPosName` CHAR(30),                             /*Название позиции*/
  PRIMARY KEY  (`IP_ID`)
) TYPE=MyISAM;

INSERT INTO ItemPosition_List (ItemPosName) VALUES('Полка комиссионного магазина');               --1
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Рюкзак игрока');                              --2
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Слот игрока');                                --3
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Предмет выброшен');                           --4
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Предмет полностью пришел в негодность');      --5

/* таблица всех предметов в КЛУБЕ */
CREATE TABLE `Items`(
   `IT_ID`                BIGINT(20) unsigned NOT NULL auto_increment,     /*уник. идентификатор предмета*/
   `IL_ID`                INT(4) unsigned NOT NULL,                        /* ID предмета в справочнике предметов*/
   `Item_ComissionCost`   FLOAT DEFAULT 0,                                 /*комиссионная стоимость (если не 0 - предмет сдан для продажи)*/
   `Item_Owner`           BIGINT(20) DEFAULT 0 NOT NULL,                   /*владелец предмета (ID игрока или номер системного объекта)*/
   `Item_Position`        INT REFERENCES ItemPosition_List(`ID`),          /*позиция предмета*/
   `Item_CurrentLife`     INT DEFAULT 0,                                   /*Износ предмета*/

  PRIMARY KEY  (`IT_ID`),
  KEY (`Item_Owner`)
) TYPE=MyISAM;

/*в рюкзачок*/
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(1,9,1,2,0);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(2,10,1,2,12);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(3,3,1,2,15);
