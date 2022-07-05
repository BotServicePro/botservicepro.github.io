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
   Character_Money               INT DEFAULT 200,                                           /*деньги (добавлено 2004.07.04)*/
   Character_Strength            INT DEFAULT 3,                                           /*сила персонажа*/
   Character_Strength_Total      INT DEFAULT 3,                                           /*сила персонажа c учетом вещей*/
   Character_Endurance           INT DEFAULT 3,                                           /*Выносливость (Здоровье=Выносливость*5)*/
   Character_Accuracy            INT DEFAULT 3,                                           /*Точность перса (влияет на крит.удар)*/
   Character_Accuracy_Total      INT DEFAULT 0,                                           /*Точность с уч. вещей перса*/
   Character_Dexterity           INT DEFAULT 3,                                           /*Ловкость перса (влияет на уворот)*/
   Character_Dexterity_Total     INT DEFAULT 0,                                           /*Ловкость перса с уч. вещей*/
   Character_Sword               INT DEFAULT 0,                                           /*Мастерство владения мечом*/
   Character_Spear               INT DEFAULT 0,                                           /*Мастерство владения копьем*/
   Character_Axe                 INT DEFAULT 0,                                           /*Мастерство владения Топором*/
   Character_Mace                INT DEFAULT 0,                                           /*Мастерство владения Молот,Дубина*/
   Character_Dagger              INT DEFAULT 0,                                           /*Мастерство владения Ножом*/
   Character_CurHealth           INT DEFAULT 0,                                           /*тек здоровье во время боя*/
   Character_MaxHealth           INT DEFAULT 20,                                          /*Максимальное здоровье с учетом вещей*/
   Character_Level               INT DEFAULT 1,                                           /*УРОВЕНЬ ИГРОКА*/
   Character_Experience          INT DEFAULT 0,                                           /*ОПЫТ ИГРОКА*/
   Character_NextExperience      INT DEFAULT 10,                                          /*Следующая граничная точка опыта*/
   Character_UnUsed_Points       INT DEFAULT 3,                                           /*Неиспользованные очки для распределения в статы (сила, ловкость....)*/
   Town                          INT DEFAULT 0 REFERENCES Towns(`ID`),                    /*Текущий город перса*/
   Building                      INT DEFAULT 1 REFERENCES Buildings(`ID`),                /*текущее положение перса в городе (здание, площадь)*/
   Moving_Type                   INT DEFAULT 0 REFERENCES MovingTypes(`ID`),               /*текущее транспортное средство (корабль, карета)*/
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
  PRIMARY KEY  (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day) 
                   VALUES('Создатель','1234','500','1','2004-10-22');
                   
                   
/*Таблица строений,комнат и локаций в пределах города*/
CREATE TABLE `Buildings` (
  `ID` INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `BuildingName` CHAR(50) NOT NULL,                    /*Название строения*/
  `BuildingType` INT(3) NOT NULL,                      /*Тип строения*/
  `Town` SMALLINT(2) NOT NULL REFERENCES Towns(`ID`),  /*Город, где расположено строение*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(1,'Комната новичков',1,1);
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(2,'Комната рыцарей',1,1);


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
  `Item_Mind`            INT DEFAULT 0,             /*требования к владению магией разума перса*/
  `Item_Body`            INT DEFAULT 0,             /*требования к владению магией тела перса*/
  `Item_Spirit`          INT DEFAULT 0,             /*требования к владению магией духа перса*/
  `Min_Damage`           INT DEFAULT 0,             /*минимальное повреждение предметом*/
  `Max_Damage`           INT DEFAULT 0,             /*макимальное повреждение предметом*/
  `Fire_Damage`          INT DEFAULT 0,             /*добавленное повреждение огнем*/
  `Water_Damage`         INT DEFAULT 0,             /*добавленное повреждение воздухом*/
  `Air_Damage`           INT DEFAULT 0,             /*добавленное повреждение водой*/
  `Earth_Damage`         INT DEFAULT 0,             /*добавленное повреждение землей*/
  `Mind_Damage`          INT DEFAULT 0,             /*добавленное повреждение разумом*/
  `MF_Deviation`         INT DEFAULT 0,             /*модификатор уклонения*/
  `MF_UnDeviation`       INT DEFAULT 0,             /*модификатор антиуклонения*/
  `MF_ShokingBlow`       INT DEFAULT 0,             /*модификатор критического удара*/
  `MF_UnShokingBlow`     INT DEFAULT 0,             /*модификатор антикритической защиты*/
  PRIMARY KEY  (`IL_ID`),
  KEY(`ItemType`)
) TYPE=MyISAM;

/*Добавим несколько предметов в справочник*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(1,1,1,'Молот Новичка',20,'mace.jpg','Weapon',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(2,2,1,'Щит Пророчества',25,'shield.jpg','Shield',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(3,3,1,'Шлем Рыцаря',20,'helmet.jpg','Helmet',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(4,3,2,'Шлем Всадника',15,'helmet1.jpg','Helmet',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(5,4,1,'Перчатки кузнеца',15,'gloves.jpg','Gloves',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(6,5,1,'Серьги обновления',22,'earrings.jpg','Ear',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(7,6,1,'Кулон знахаря',26,'necklace.jpg','Necklace',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(8,7,1,'Болотные Сапоги',10,'boots.jpg','Shoes',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(9,8,1,'Пояс отваги',10,'belt.jpg','Belt',2);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(10,9,1,'Кольцо повелевания',15,'ring1.jpg','Ring',2);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(11,9,2,'Кольцо Разрушения',24,'ring2.jpg','Ring',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(12,10,1,'Рубашка',5,'skirt.jpg','Armor',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(13,10,2,'Рубашка воина',14,'skirt1.jpg','Armor',1);


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
   `Item_FullLife`        INT DEFAULT 0,                                   /*Долговечность предмета*/
   `Item_CurrentLife`     INT DEFAULT 0,                                   /*Износ предмета*/
  PRIMARY KEY  (`IT_ID`),
  KEY (`Item_Owner`)
) TYPE=MyISAM;

/*Оденем создателей игры*/
--INSERT INTO Items (IL_ID,Item_No,Item_Owner,Item_Position) VALUES(1,1,1,3);
/*и в рюкзачок*/
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position) VALUES(1,9,1,2);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position) VALUES(2,10,1,2);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position) VALUES(3,3,1,2);

                   

