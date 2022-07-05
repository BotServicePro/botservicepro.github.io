DROP DATABASE mmclub;
CREATE DATABASE mmclub DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE mmclub;

/*Таблица персонажей*/
CREATE TABLE `users` (
   USER_ID                            bigint(20) unsigned NOT NULL auto_increment,
   Nick_Name                     CHAR(32) UNIQUE,                                         /*ник игрока (уникальный, при регистрации)*/
   User_Pass                     CHAR(32),                                                /*пароль игрока (задается при регистрации)*/
   SessionID                     bigint,                                                  /*Идентификатор сессии*/
   User_EMail                    CHAR(64) UNIQUE,                                         /*почтовый ящик игрока*/
   Security_Question             SMALLINT(2) DEFAULT 1 REFERENCES secretquestions(`ID`),  /*секретный вопрос (из справочника)*/
   Security_Answer               CHAR(30),                                                /*ответ на секретный вопрос*/
   Full_Name                     CHAR(50),                                                /*реальное имя игрока*/
   User_Birth_Day                DATE NOT NULL,                                           /*дата рождения игрока*/
   Character_Birth_Day           DATE NOT NULL,                                           /*дата создания персонажа*/
   User_Gender                   SMALLINT(1),                                             /*пол игрока и перса*/
   User_City                     CHAR(32),                                                /*реальный город игрока*/
   ICQ_Number                    CHAR(16),                                                /*номер аськи*/
   Character_Money               FLOAT DEFAULT 200,                                           /*деньги (добавлено 2004.07.04)*/
   Character_Strength            INT DEFAULT 3,                                           /*сила персонажа*/
   Character_Strength_Total      INT DEFAULT 3,                                           /*сила персонажа c учетом вещей*/
   Character_Endurance           INT DEFAULT 3,                                           /*Выносливость (Здоровье=Выносливость*5)*/
   Character_Accuracy            INT DEFAULT 3,                                           /*Точность перса (влияет на крит.удар)*/
   Character_Accuracy_Total      INT DEFAULT 0,                                           /*Точность с уч. вещей перса*/
   Character_Dexterity           INT DEFAULT 3,                                           /*Ловкость перса (влияет на уворот)*/
   Character_Dexterity_Total     INT DEFAULT 0,                                           /*Ловкость перса с уч. вещей*/

   /* Добавлено в 9.4.*/
   Character_Intelligence        INT DEFAULT 0,                                           /*Интелект перса */
   Character_Intelligence_Total  INT DEFAULT 0,                                           /*Интелект перса  учетом вещей*/
   Character_CurMana             INT DEFAULT 0,                                           /* текущие очки маны */
   Character_MaxMana             INT DEFAULT 0,                                           /* максимальные очки маны */
   /* Добавлено в 9.5.*/
   Character_Magic_Protection    INT DEFAULT 0,                                           /*Защита от магии */

   Character_Sword               INT DEFAULT 0,                                           /*Мастерство владения мечом*/
   Character_Spear               INT DEFAULT 0,                                           /*Мастерство владения копьем*/
   Character_Axe                 INT DEFAULT 0,                                           /*Мастерство владения Топором*/
   Character_Mace                INT DEFAULT 0,                                           /*Мастерство владения Молот,Дубина*/
   Character_Dagger              INT DEFAULT 0,                                           /*Мастерство владения Ножом*/
   Character_CurHealth           INT DEFAULT 0,                                           /*тек здоровье во время боя*/
   Character_MaxHealth           INT DEFAULT 0,                                           /*Максимальное здоровье с учетом вещей*/
   Character_Level               INT DEFAULT 1,                                           /*УРОВЕНЬ ИГРОКА*/
   Character_Experience          INT DEFAULT 0,                                           /*ОПЫТ ИГРОКА*/
   Character_NextExperience      INT DEFAULT 10,                                          /*Следующая граничная точка опыта*/
   Character_UnUsed_Points       INT DEFAULT 3,
   /* добавлено */
   Character_Status              INT DEFAULT 1,                                           /* 1-обычное состояние,2-в бою, 3-бой окончен (смотрим результат), 4-в транспортном средстве */

   Town                          INT DEFAULT 1 REFERENCES Towns(`ID`),                    /*Текущий город перса*/
   Building                      INT DEFAULT 1 REFERENCES Buildings(`ID`),                /*текущее положение перса в городе (здание, площадь)*/
   EndMoving_Time                DATETIME DEFAULT 0 NOT NULL,                         /*время прибытия в Пункт Назначения*/
   Character_Disposition         INT DEFAULT 0 REFERENCES Dispositions(`ID`),              /*склонность перса*/
   Character_Clan                INT DEFAULT 0 REFERENCES Clans(`ID`),                    /*клан перса*/
   Character_Image               CHAR(30) DEFAULT 'standart1.gif',                        /*изображения перса*/
   Character_MaxWeigth           INT DEFAULT 20,                                          /*максимальный вес предметов в рюкзаке*/
   Helmet_Slot                   INT DEFAULT 0,                                           /*слот шлема*/
   Shield_Slot                   INT DEFAULT 0,                                           /*слот щита*/
   Weapon_Slot                   INT DEFAULT 0,                                           /*слот оружия*/
   Gloves_Slot                   INT DEFAULT 0,                                           /*слот перчаток*/
   Shoes_Slot                    INT DEFAULT 0,                                           /*слот обуви*/
   Armor_Slot                    INT DEFAULT 0,                                           /*слот брони*/
   Necklace_Slot                 INT DEFAULT 0,                                           /*слот ожерелья*/
   Ring1_Slot                    INT DEFAULT 0,                                           /*слот 1 кольца*/
   Ring2_Slot                    INT DEFAULT 0,                                           /*слот 2 кольца*/
   Ring3_Slot                    INT DEFAULT 0,                                           /*слот 3 кольца*/
   Ring4_Slot                    INT DEFAULT 0,                                           /*слот 4 кольца*/
   Ear_Slot                      INT DEFAULT 0,                                           /*слот серег*/
   Belt_Slot                     INT DEFAULT 0,                                           /*слот пояса*/
   -- добавили слот для свитка - 9 урок
   Scroll_Slot                     INT DEFAULT 0,                                           /*слот пояса*/
  PRIMARY KEY  (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day) 
                   VALUES('Создатель','1234','500','1','2008-03-11');
INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day,
                   Character_Intelligence)
                   VALUES('Defender','1234','200','1','2008-03-11','4');
INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day)
                   VALUES('Stranger','1234','200','1','2008-03-11');

                   

/* Справочник типов предметов и их свойств */
CREATE TABLE `Items_List` (
  `IL_ID` INT(4) unsigned NOT NULL AUTO_INCREMENT,     /*идентификатор предмета*/
  `ItemType`  INT DEFAULT 0,                        /*Тип предмета : напр. 1 = меч, 2-топор....*/
  `ItemNo`    INT DEFAULT 1,                        /*Номер предмета внутри типа : напр. 1-меч новичка,8-меч урагана....*/
  `ItemName`  CHAR(50) NOT NULL,                    /*Название предмета*/
  `ItemSlotName`  CHAR(15) NOT NULL DEFAULT '',     /*Слот передмета*/
  `Item_StateCost`  INT DEFAULT 0,                  /*гос цена предмета*/
  `Item_Image`  CHAR(32),                           /*путь к картинке предмета и ее имя*/
  `Item_Weight` INT DEFAULT 1,                      /*вес предмета*/
  `Item_FullLife`        INT DEFAULT 0,             /*Долговечность предмета напр. 0/50*/
  `Item_Strength`        INT DEFAULT 0,             /*требования к силе перса*/
  `Item_Intelligence`    INT DEFAULT 0,             /*требования к интеллекту перса*/
  `Item_Endurance`       INT DEFAULT 0,             /*требования к выносливости перса*/
  `Item_Accuracy`        INT DEFAULT 0,             /*требования к точность перса*/
  `Item_Dexterity`       INT DEFAULT 0,             /*требования к ловкости перса*/
  `Item_Sword`           INT DEFAULT 0,             /*требования к владению мечом перса*/
  `Item_Spear`           INT DEFAULT 0,             /*требования к владению копьем перса*/
  `Item_Axe`             INT DEFAULT 0,             /*требования к владению топором перса*/
  `Item_Club`            INT DEFAULT 0,             /*требования к владению булавой,дубиной перса*/
  `Item_Dagger`          INT DEFAULT 0,             /*требования к владению ножом перса*/
  `Item_Level`           INT DEFAULT 0,             /*требования к уровню перса*/
  `Item_Fire`            INT DEFAULT 0,             /*требования к владению магией огня перса*/
  `Item_Air`             INT DEFAULT 0,             /*требования к владению магией воздуха перса*/
  `Item_Water`           INT DEFAULT 0,             /*требования к владению магией воды перса*/
  `Item_Earth`           INT DEFAULT 0,             /*требования к владению магией земли перса*/
  `ManaCost`             INT DEFAULT 0,             /*сколько забирает маны, для свитков*/
  `Min_Damage`           INT DEFAULT 0,             /*минимальное повреждение предметом*/
  `Max_Damage`           INT DEFAULT 0,             /*максимальное повреждение предметом*/
  `MF_Deviation`         INT DEFAULT 0,             /*модификатор уклонения*/
  `MF_UnDeviation`       INT DEFAULT 0,             /*модификатор антиуклонения*/
  `MF_ShokingBlow`       INT DEFAULT 0,             /*модификатор критического удара*/
  `MF_UnShokingBlow`     INT DEFAULT 0,             /*модификатор антикритической защиты*/
   /*для 9.5.*/
  `Item_Use`             INT DEFAULT 0,             /*использование предмета 0-одеваем,1-в инвентаре*/
  PRIMARY KEY  (`IL_ID`),
  KEY(`ItemType`)
) TYPE=MyISAM;

/*Добавим несколько предметов в справочник*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(1,1,1,'Молот Новичка',20,'mace.jpg','Weapon',1,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(2,2,1,'Щит Пророчества',25,'shield.jpg','Shield',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(3,3,1,'Шлем Рыцаря',20,'helmet.jpg','Helmet',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(4,3,2,'Шлем Всадника',15,'helmet1.jpg','Helmet',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(5,4,1,'Перчатки кузнеца',15,'gloves.jpg','Gloves',1,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(6,5,1,'Серьги обновления',22,'earrings.jpg','Ear',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(7,6,1,'Кулон знахаря',26,'necklace.jpg','Necklace',1,40);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(8,7,1,'Болотные Сапоги',10,'boots.jpg','Shoes',1,40);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(9,8,1,'Пояс отваги',10,'belt.jpg','Belt',2,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(10,9,1,'Кольцо повелевания',15,'ring1.jpg','Ring',2,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(11,9,2,'Кольцо Разрушения',24,'ring2.jpg','Ring',1,40);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(12,10,1,'Рубашка',5,'skirt.jpg','Armor',1,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(13,10,2,'Рубашка воина',14,'skirt1.jpg','Armor',1,30);

/*немного магических свитков - для урока 9 также доюавлено 9.4. ManaCost*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,ManaCost,Min_Damage) VALUES(14,11,1,'Удар огня',14,'mscroll1.jpg','Scroll',1,30,3,5);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,ManaCost,Min_Damage) VALUES(15,12,1,'Удар воздуха',14,'mscroll2.jpg','Scroll',1,30,3,5);
/*немного магических пузырьков - для урока 9.5. */
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,Item_Use) VALUES(16,15,1,'Универсальная защита',5,'vial1.jpg','Vial',1,1,1);
/*Билет*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,Item_Use) VALUES(17,16,1,'Билет на карету',0,'ticket.gif','Ticket',1,1,1);


/* Справочник позиций предмета */
CREATE Table `ItemPosition_List`(
  `IP_ID` INT(4)   unsigned NOT NULL AUTO_INCREMENT,     /*идентификатор позиции*/
  `ItemPosName` CHAR(30),                             /*Название позиции*/
  PRIMARY KEY  (`IP_ID`)
) TYPE=MyISAM;

INSERT INTO ItemPosition_List (ItemPosName) VALUES('Полка комиссионного магазина');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Рюкзак игрока');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Слот игрока');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Предмет выброшен');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('Предмет полностью пришел в негодность');

/* таблица всех предметов в КЛУБЕ */
CREATE TABLE `Items`(
   `IT_ID`                BIGINT(20) unsigned NOT NULL auto_increment,     /*уник. идентификатор предмета*/
   `IL_ID`                INT(4) unsigned NOT NULL,                        /* ID предмета в справочнике предметов*/
   `Item_ComissionCost`   FLOAT DEFAULT 0,                                 /*комиссионная стоимость (если не 0 - предмет сдан для продажи)*/
   `Item_Owner`           BIGINT(20) DEFAULT 0 NOT NULL,                   /*владелец предмета (ID игрока или номер системного объекта)*/
   `Item_Position`        INT REFERENCES ItemPosition_List(`ID`),          /*позиция предмета*/
   `Item_CurrentLife`     INT DEFAULT 0,                                   /*Износ предмета*/
   `Item_TID`             INT DEFAULT 0,             /*для билетов - ID строки из tickets с записью о времени,пункте отправки и т.д.*/
   `Item_DateTime`        TIMESTAMP,                 /*для билетов - дата и время отправления*/
    /*в 13 уроке*/
   `Item_Receiver`        BIGINT(20) DEFAULT 0 NOT NULL,                   /*кому предлагается предмет (ID игрока)*/
   `Item_SellPrice`       INT DEFAULT 0,                                   /*Цена предложения*/


  PRIMARY KEY  (`IT_ID`),
  KEY (`Item_Owner`)
) TYPE=MyISAM;

/*Оденем создателей игры*/
--INSERT INTO Items (IL_ID,Item_No,Item_Owner,Item_Position) VALUES(1,1,1,3);
/*и в рюкзачок*/
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(1,9,1,2,0);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(2,10,1,2,12);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(3,3,1,2,15);
/**/
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife,Item_ComissionCost) VALUES(4,12,1,1,10,23);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife,Item_ComissionCost) VALUES(5,12,1,1,10,25);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife,Item_ComissionCost) VALUES(6,13,1,1,12,36);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife,Item_ComissionCost) VALUES(7,13,1,1,9,43);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife,Item_ComissionCost) VALUES(8,13,1,1,10,40);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife,Item_ComissionCost) VALUES(9,1,1,1,10,16);



                   
/*таблица предметов для продажи у КУЗНЕЦА (ОРУЖЕЙНИКА)*/
CREATE TABLE `smith`(
   `SM_ID`             BIGINT(20) unsigned NOT NULL auto_increment,   /* уник. идентификатор предмета в магазине */
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID предмета в справочнике предметов */
   `Town`           INT(2) unsigned NOT NULL,                         /* Город, где расположено здание */
   `QTY`            INT NOT NULL,                                     /* количество предметов */
  PRIMARY KEY  (`SM_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,1,30);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,2,100);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,5,50);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,8,300);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,12,300);  -- Рубашка
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,13,100);  -- Рубашка воина


/*таблица предметов для продажи в магической лавке*/
CREATE TABLE `magicshop`(
   `SM_ID`             BIGINT(20) unsigned NOT NULL auto_increment,   /* уник. идентификатор предмета в магазине */
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID предмета в справочнике предметов */
   `Town`           INT(2) unsigned NOT NULL,                         /* Город, где расположено здание */
   `QTY`            INT NOT NULL,                                     /* количество предметов */
  PRIMARY KEY  (`SM_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO magicshop (Town,IL_ID,QTY) VALUES(1,14,40);  -- свиток огня
INSERT INTO magicshop (Town,IL_ID,QTY) VALUES(1,15,50);  -- свиток воздуха
INSERT INTO magicshop (Town,IL_ID,QTY) VALUES(1,16,20);  -- пузырек универсальной защиты


/*Таблица Заявок для физического боя 1 х 1 */
CREATE TABLE `zayavki` (
  `ZV_ID` BIGINT unsigned NOT NULL auto_increment,  /*номер заявки*/
  `CHAR1_NAME` Char(32) NOT NULL,              /*Ник 1 игрока*/
  `level1` INT NOT NULL,                       /*level 1 игрока*/
  `CHAR2_NAME` Char(32),                       /*Ник 2 игрока*/
  `level2` INT,                                /*level 2 игрока*/
  `ZDATA` DATE,                                /*дата заявки*/
  `ZTIME` TIME,                                /*время заявки*/
  `ZTYPE` SMALLINT(2) unsigned,                /*Тип заявки*/
  `ZTIMEOUT` SMALLINT(2),                      /*Таймаут заявки*/
  PRIMARY KEY  (`ZV_ID`)
) TYPE=MyISAM;

--INSERT INTO zayavki (ZV_ID, CHAR1_NAME, ZDATA, ZTIME, ZTYPE, ZTIMEOUT) VALUES(150,'Defender','2008-03-11','10:30',1,3);

/* Таблица поединка 1 х 1 */
CREATE TABLE `battle` (
  `BAT_ID` BIGINT unsigned NOT NULL auto_increment,  /*ID поединка*/
  `CHAR1_NAME` Char(32) NOT NULL,               /*ID 1 игрока*/
  `CHAR2_NAME` Char(32) NOT NULL,               /*ID 2 игрока*/
  `TIMEOUT` SMALLINT(2),                        /*Таймаут в секундах*/
  `STARTTIME` DATETIME,                         /*время начала поединка*/
  `M1` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*Ход первого*/
  `M2` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*Ход второго*/
  `LASTMOVE` DATETIME,                          /*время последнего хода*/
  `STATUS` SMALLINT(1),                         /*статус поединка 1-идет,2-завершен*/
  `R1` SMALLINT(1) unsigned NOT NULL DEFAULT 1, /*Статус 1-го после боя 0-убит, >0 - жив*/
  `R2` SMALLINT(1) unsigned NOT NULL DEFAULT 1, /*Статус 2-го после боя 0-убит, >0 - жив*/
  PRIMARY KEY  (`BAT_ID`)
) TYPE=MyISAM;

/* Таблица детализации поединка 1 х 1 */
CREATE TABLE `battledetails` (
  `BATDET_ID` BIGINT unsigned NOT NULL auto_increment, /*ID*/
  `BAT_ID` BIGINT unsigned NOT NULL DEFAULT 1,         /*номер заявки - ID игрока ее подавшего*/
  `CHAR_NAME` Char(32) NOT NULL,                       /*ID игрока сделавшего ход*/
  `ATTACK` SMALLINT(1) unsigned NOT NULL DEFAULT 0,    /*Зона атаки*/
  `DEFEND` SMALLINT(1) unsigned NOT NULL DEFAULT 0,    /*Зона защиты*/
  `MESSAGE` CHAR(255) NOT NULL DEFAULT '',             /*Описание действия....куда нанес удар и т.д.*/
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


/*Таблица чата*/
CREATE TABLE `chat` (
   `CH_ID` BIGINT unsigned NOT NULL auto_increment,
   `CH_ROOM` INT unsigned NOT NULL,                     -- игровая комната
   `USER_ID`  bigint(20) unsigned NOT NULL,             -- кто написал сообщение
   `USER_ID_TO`  bigint(20) unsigned default 0,         -- кому сообщение  0 - всем
   `IS_PRIVATE` SMALLINT DEFAULT 0,                     -- 1 - приватное (видно везде)
   `CH_MSG` CHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`CH_ID`)
) TYPE=MyISAM;

INSERT INTO chat(CH_ID,CH_ROOM,USER_ID,CH_MSG) values(1,1,1,'Чат инициализирован!');


/*Таблица строений,комнат и локаций в пределах города*/
CREATE TABLE `Buildings` (
  `ID` INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `BuildingName` CHAR(50) NOT NULL,                    /*Название строения*/
  `BuildingType` INT(3) NOT NULL,                      /*Тип строения*/
  `Town` SMALLINT(2) NOT NULL REFERENCES Towns(`ID`),  /*Город, где расположено строение*/
  `PHP_File` CHAR(50) NOT NULL,  /*Файл скрипта на PHP описывающего объект - нужно при входе в игру*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(1,'Арена',1,1,'char.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(2,'Центральная площадь',2,1,'map.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(3,'Кузница',3,1,'smith.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(4,'Комиссионный магазин',4,1,'comission.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(5,'Магическая лавка',5,1,'magicshop.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(6,'Центральная площадь 2',6,1,'map2.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(7,'Вокзал',7,1,'station.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(8,'Рынок',8,1,'market.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(9,'Евромагазин',9,1,'euroshop.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(10,'Банк',10,1,'bank.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(11,'Карета',11,1,'karet.phtml');






/*Таблица городов*/
CREATE TABLE `Towns` (
  `ID` SMALLINT(2) unsigned NOT NULL auto_increment,
  `TownName` char(40) default NULL,
  `TownStatus` SMALLINT(2) unsigned NOT NULL DEFAULT 1, /*1-обычный,2-столица,3-секретный*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO towns (TownName, TownStatus) VALUES('Силлурия',2);
INSERT INTO towns (TownName, TownStatus) VALUES('Гринсфилд',1);

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

INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,20,'2008-08-06 11:00',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,40,'2008-08-06 12:28',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,30,'2008-08-06 14:03',1,2,4,60);