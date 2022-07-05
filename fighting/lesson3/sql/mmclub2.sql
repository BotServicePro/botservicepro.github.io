DROP DATABASE mmclub;
CREATE DATABASE mmclub DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE mmclub;

/*Таблица персонажей*/
CREATE TABLE `users` (
   USER_ID                       bigint(20) unsigned NOT NULL auto_increment,
   Nick_Name                     CHAR(32) UNIQUE,                                         /*ник игрока (уникальный, при регистрации)*/
   User_Pass                     CHAR(32),                                                /*пароль игрока (задается при регистрации)*/
   SessionID                     bigint,                                                  /*Идентификатор сессии*/
   User_EMail                    CHAR(64) UNIQUE,                                         /*почтовый ящик игрока*/
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
   Character_Level               INT DEFAULT 0,                                           /*УРОВЕНЬ ИГРОКА*/
   Character_Experience          INT DEFAULT 0,                                           /*ОПЫТ ИГРОКА*/
   Character_NextExperience      INT DEFAULT 10,                                          /*Следующая граничная точка опыта*/
   Character_UnUsed_Points       INT DEFAULT 3,                                           /*Неиспользованные очки для распределения в статы (сила, ловкость....)*/
   Town                          INT DEFAULT 0 REFERENCES Towns(`ID`),                    /*Текущий город перса*/
   Building                      INT DEFAULT 0 REFERENCES Buildings(`ID`),                /*текущее положение перса в городе (здание, площадь)*/
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
                   User_Birth_Day, Building)
                   VALUES('Создатель','1234','500','1','2008-03-11',1);
INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day, Building)
                   VALUES('Defender','1234','200','1','2008-03-11',1);
INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day, Building)
                   VALUES('Stranger','1234','200','1','2008-03-11',1);


/*Таблица строений,комнат и локаций в пределах города*/
CREATE TABLE `Buildings` (
  `ID` INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `BuildingName` CHAR(50) NOT NULL,                    /*Название строения*/
  `BuildingType` INT(3) NOT NULL,                      /*Тип строения*/
  `Town` SMALLINT(2) NOT NULL REFERENCES Towns(`ID`),  /*Город, где расположено строение*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(1,'Арена',1,1);
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(2,'Центральная площадь',2,1);


