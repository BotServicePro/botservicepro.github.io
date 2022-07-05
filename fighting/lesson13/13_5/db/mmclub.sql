DROP DATABASE mmclub;
CREATE DATABASE mmclub DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE mmclub;

/*������� ����������*/
CREATE TABLE `users` (
   USER_ID                            bigint(20) unsigned NOT NULL auto_increment,
   Nick_Name                     CHAR(32) UNIQUE,                                         /*��� ������ (����������, ��� �����������)*/
   User_Pass                     CHAR(32),                                                /*������ ������ (�������� ��� �����������)*/
   SessionID                     bigint,                                                  /*������������� ������*/
   User_EMail                    CHAR(64) UNIQUE,                                         /*�������� ���� ������*/
   Security_Question             SMALLINT(2) DEFAULT 1 REFERENCES secretquestions(`ID`),  /*��������� ������ (�� �����������)*/
   Security_Answer               CHAR(30),                                                /*����� �� ��������� ������*/
   Full_Name                     CHAR(50),                                                /*�������� ��� ������*/
   User_Birth_Day                DATE NOT NULL,                                           /*���� �������� ������*/
   Character_Birth_Day           DATE NOT NULL,                                           /*���� �������� ���������*/
   User_Gender                   SMALLINT(1),                                             /*��� ������ � �����*/
   User_City                     CHAR(32),                                                /*�������� ����� ������*/
   ICQ_Number                    CHAR(16),                                                /*����� �����*/
   Character_Money               FLOAT DEFAULT 200,                                           /*������ (��������� 2004.07.04)*/
   Character_Strength            INT DEFAULT 3,                                           /*���� ���������*/
   Character_Strength_Total      INT DEFAULT 3,                                           /*���� ��������� c ������ �����*/
   Character_Endurance           INT DEFAULT 3,                                           /*������������ (��������=������������*5)*/
   Character_Accuracy            INT DEFAULT 3,                                           /*�������� ����� (������ �� ����.����)*/
   Character_Accuracy_Total      INT DEFAULT 0,                                           /*�������� � ��. ����� �����*/
   Character_Dexterity           INT DEFAULT 3,                                           /*�������� ����� (������ �� ������)*/
   Character_Dexterity_Total     INT DEFAULT 0,                                           /*�������� ����� � ��. �����*/

   /* ��������� � 9.4.*/
   Character_Intelligence        INT DEFAULT 0,                                           /*�������� ����� */
   Character_Intelligence_Total  INT DEFAULT 0,                                           /*�������� �����  ������ �����*/
   Character_CurMana             INT DEFAULT 0,                                           /* ������� ���� ���� */
   Character_MaxMana             INT DEFAULT 0,                                           /* ������������ ���� ���� */
   /* ��������� � 9.5.*/
   Character_Magic_Protection    INT DEFAULT 0,                                           /*������ �� ����� */

   Character_Sword               INT DEFAULT 0,                                           /*���������� �������� �����*/
   Character_Spear               INT DEFAULT 0,                                           /*���������� �������� ������*/
   Character_Axe                 INT DEFAULT 0,                                           /*���������� �������� �������*/
   Character_Mace                INT DEFAULT 0,                                           /*���������� �������� �����,������*/
   Character_Dagger              INT DEFAULT 0,                                           /*���������� �������� �����*/
   Character_CurHealth           INT DEFAULT 0,                                           /*��� �������� �� ����� ���*/
   Character_MaxHealth           INT DEFAULT 0,                                           /*������������ �������� � ������ �����*/
   Character_Level               INT DEFAULT 1,                                           /*������� ������*/
   Character_Experience          INT DEFAULT 0,                                           /*���� ������*/
   Character_NextExperience      INT DEFAULT 10,                                          /*��������� ��������� ����� �����*/
   Character_UnUsed_Points       INT DEFAULT 3,
   /* ��������� */
   Character_Status              INT DEFAULT 1,                                           /* 1-������� ���������,2-� ���, 3-��� ������� (������� ���������), 4-� ������������ �������� */

   Town                          INT DEFAULT 1 REFERENCES Towns(`ID`),                    /*������� ����� �����*/
   Building                      INT DEFAULT 1 REFERENCES Buildings(`ID`),                /*������� ��������� ����� � ������ (������, �������)*/
   EndMoving_Time                DATETIME DEFAULT 0 NOT NULL,                         /*����� �������� � ����� ����������*/
   Character_Disposition         INT DEFAULT 0 REFERENCES Dispositions(`ID`),              /*���������� �����*/
   Character_Clan                INT DEFAULT 0 REFERENCES Clans(`ID`),                    /*���� �����*/
   Character_Image               CHAR(30) DEFAULT 'standart1.gif',                        /*����������� �����*/
   Character_MaxWeigth           INT DEFAULT 20,                                          /*������������ ��� ��������� � �������*/
   Helmet_Slot                   INT DEFAULT 0,                                           /*���� �����*/
   Shield_Slot                   INT DEFAULT 0,                                           /*���� ����*/
   Weapon_Slot                   INT DEFAULT 0,                                           /*���� ������*/
   Gloves_Slot                   INT DEFAULT 0,                                           /*���� ��������*/
   Shoes_Slot                    INT DEFAULT 0,                                           /*���� �����*/
   Armor_Slot                    INT DEFAULT 0,                                           /*���� �����*/
   Necklace_Slot                 INT DEFAULT 0,                                           /*���� ��������*/
   Ring1_Slot                    INT DEFAULT 0,                                           /*���� 1 ������*/
   Ring2_Slot                    INT DEFAULT 0,                                           /*���� 2 ������*/
   Ring3_Slot                    INT DEFAULT 0,                                           /*���� 3 ������*/
   Ring4_Slot                    INT DEFAULT 0,                                           /*���� 4 ������*/
   Ear_Slot                      INT DEFAULT 0,                                           /*���� �����*/
   Belt_Slot                     INT DEFAULT 0,                                           /*���� �����*/
   -- �������� ���� ��� ������ - 9 ����
   Scroll_Slot                     INT DEFAULT 0,                                           /*���� �����*/
  PRIMARY KEY  (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day) 
                   VALUES('���������','1234','500','1','2008-03-11');
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

                   

/* ���������� ����� ��������� � �� ������� */
CREATE TABLE `Items_List` (
  `IL_ID` INT(4) unsigned NOT NULL AUTO_INCREMENT,     /*������������� ��������*/
  `ItemType`  INT DEFAULT 0,                        /*��� �������� : ����. 1 = ���, 2-�����....*/
  `ItemNo`    INT DEFAULT 1,                        /*����� �������� ������ ���� : ����. 1-��� �������,8-��� �������....*/
  `ItemName`  CHAR(50) NOT NULL,                    /*�������� ��������*/
  `ItemSlotName`  CHAR(15) NOT NULL DEFAULT '',     /*���� ���������*/
  `Item_StateCost`  INT DEFAULT 0,                  /*��� ���� ��������*/
  `Item_Image`  CHAR(32),                           /*���� � �������� �������� � �� ���*/
  `Item_Weight` INT DEFAULT 1,                      /*��� ��������*/
  `Item_FullLife`        INT DEFAULT 0,             /*������������� �������� ����. 0/50*/
  `Item_Strength`        INT DEFAULT 0,             /*���������� � ���� �����*/
  `Item_Intelligence`    INT DEFAULT 0,             /*���������� � ���������� �����*/
  `Item_Endurance`       INT DEFAULT 0,             /*���������� � ������������ �����*/
  `Item_Accuracy`        INT DEFAULT 0,             /*���������� � �������� �����*/
  `Item_Dexterity`       INT DEFAULT 0,             /*���������� � �������� �����*/
  `Item_Sword`           INT DEFAULT 0,             /*���������� � �������� ����� �����*/
  `Item_Spear`           INT DEFAULT 0,             /*���������� � �������� ������ �����*/
  `Item_Axe`             INT DEFAULT 0,             /*���������� � �������� ������� �����*/
  `Item_Club`            INT DEFAULT 0,             /*���������� � �������� �������,������� �����*/
  `Item_Dagger`          INT DEFAULT 0,             /*���������� � �������� ����� �����*/
  `Item_Level`           INT DEFAULT 0,             /*���������� � ������ �����*/
  `Item_Fire`            INT DEFAULT 0,             /*���������� � �������� ������ ���� �����*/
  `Item_Air`             INT DEFAULT 0,             /*���������� � �������� ������ ������� �����*/
  `Item_Water`           INT DEFAULT 0,             /*���������� � �������� ������ ���� �����*/
  `Item_Earth`           INT DEFAULT 0,             /*���������� � �������� ������ ����� �����*/
  `ManaCost`             INT DEFAULT 0,             /*������� �������� ����, ��� �������*/
  `Min_Damage`           INT DEFAULT 0,             /*����������� ����������� ���������*/
  `Max_Damage`           INT DEFAULT 0,             /*������������ ����������� ���������*/
  `MF_Deviation`         INT DEFAULT 0,             /*����������� ���������*/
  `MF_UnDeviation`       INT DEFAULT 0,             /*����������� �������������*/
  `MF_ShokingBlow`       INT DEFAULT 0,             /*����������� ������������ �����*/
  `MF_UnShokingBlow`     INT DEFAULT 0,             /*����������� ��������������� ������*/
   /*��� 9.5.*/
  `Item_Use`             INT DEFAULT 0,             /*������������� �������� 0-�������,1-� ���������*/
  PRIMARY KEY  (`IL_ID`),
  KEY(`ItemType`)
) TYPE=MyISAM;

/*������� ��������� ��������� � ����������*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(1,1,1,'����� �������',20,'mace.jpg','Weapon',1,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(2,2,1,'��� �����������',25,'shield.jpg','Shield',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(3,3,1,'���� ������',20,'helmet.jpg','Helmet',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(4,3,2,'���� ��������',15,'helmet1.jpg','Helmet',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(5,4,1,'�������� �������',15,'gloves.jpg','Gloves',1,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(6,5,1,'������ ����������',22,'earrings.jpg','Ear',1,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(7,6,1,'����� �������',26,'necklace.jpg','Necklace',1,40);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(8,7,1,'�������� ������',10,'boots.jpg','Shoes',1,40);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(9,8,1,'���� ������',10,'belt.jpg','Belt',2,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(10,9,1,'������ �����������',15,'ring1.jpg','Ring',2,30);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(11,9,2,'������ ����������',24,'ring2.jpg','Ring',1,40);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(12,10,1,'�������',5,'skirt.jpg','Armor',1,20);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife) VALUES(13,10,2,'������� �����',14,'skirt1.jpg','Armor',1,30);

/*������� ���������� ������� - ��� ����� 9 ����� ��������� 9.4. ManaCost*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,ManaCost,Min_Damage) VALUES(14,11,1,'���� ����',14,'mscroll1.jpg','Scroll',1,30,3,5);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,ManaCost,Min_Damage) VALUES(15,12,1,'���� �������',14,'mscroll2.jpg','Scroll',1,30,3,5);
/*������� ���������� ��������� - ��� ����� 9.5. */
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,Item_Use) VALUES(16,15,1,'������������� ������',5,'vial1.jpg','Vial',1,1,1);
/*�����*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level,Item_FullLife,Item_Use) VALUES(17,16,1,'����� �� ������',0,'ticket.gif','Ticket',1,1,1);


/* ���������� ������� �������� */
CREATE Table `ItemPosition_List`(
  `IP_ID` INT(4)   unsigned NOT NULL AUTO_INCREMENT,     /*������������� �������*/
  `ItemPosName` CHAR(30),                             /*�������� �������*/
  PRIMARY KEY  (`IP_ID`)
) TYPE=MyISAM;

INSERT INTO ItemPosition_List (ItemPosName) VALUES('����� ������������� ��������');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('������ ������');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('���� ������');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('������� ��������');
INSERT INTO ItemPosition_List (ItemPosName) VALUES('������� ��������� ������ � ����������');

/* ������� ���� ��������� � ����� */
CREATE TABLE `Items`(
   `IT_ID`                BIGINT(20) unsigned NOT NULL auto_increment,     /*����. ������������� ��������*/
   `IL_ID`                INT(4) unsigned NOT NULL,                        /* ID �������� � ����������� ���������*/
   `Item_ComissionCost`   FLOAT DEFAULT 0,                                 /*������������ ��������� (���� �� 0 - ������� ���� ��� �������)*/
   `Item_Owner`           BIGINT(20) DEFAULT 0 NOT NULL,                   /*�������� �������� (ID ������ ��� ����� ���������� �������)*/
   `Item_Position`        INT REFERENCES ItemPosition_List(`ID`),          /*������� ��������*/
   `Item_CurrentLife`     INT DEFAULT 0,                                   /*����� ��������*/
   `Item_TID`             INT DEFAULT 0,             /*��� ������� - ID ������ �� tickets � ������� � �������,������ �������� � �.�.*/
   `Item_DateTime`        TIMESTAMP,                 /*��� ������� - ���� � ����� �����������*/
    /*� 13 �����*/
   `Item_Receiver`        BIGINT(20) DEFAULT 0 NOT NULL,                   /*���� ������������ ������� (ID ������)*/
   `Item_SellPrice`       INT DEFAULT 0,                                   /*���� �����������*/


  PRIMARY KEY  (`IT_ID`),
  KEY (`Item_Owner`)
) TYPE=MyISAM;

/*������ ���������� ����*/
--INSERT INTO Items (IL_ID,Item_No,Item_Owner,Item_Position) VALUES(1,1,1,3);
/*� � ��������*/
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



                   
/*������� ��������� ��� ������� � ������� (����������)*/
CREATE TABLE `smith`(
   `SM_ID`             BIGINT(20) unsigned NOT NULL auto_increment,   /* ����. ������������� �������� � �������� */
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID �������� � ����������� ��������� */
   `Town`           INT(2) unsigned NOT NULL,                         /* �����, ��� ����������� ������ */
   `QTY`            INT NOT NULL,                                     /* ���������� ��������� */
  PRIMARY KEY  (`SM_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,1,30);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,2,100);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,5,50);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,8,300);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,12,300);  -- �������
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,13,100);  -- ������� �����


/*������� ��������� ��� ������� � ���������� �����*/
CREATE TABLE `magicshop`(
   `SM_ID`             BIGINT(20) unsigned NOT NULL auto_increment,   /* ����. ������������� �������� � �������� */
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID �������� � ����������� ��������� */
   `Town`           INT(2) unsigned NOT NULL,                         /* �����, ��� ����������� ������ */
   `QTY`            INT NOT NULL,                                     /* ���������� ��������� */
  PRIMARY KEY  (`SM_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO magicshop (Town,IL_ID,QTY) VALUES(1,14,40);  -- ������ ����
INSERT INTO magicshop (Town,IL_ID,QTY) VALUES(1,15,50);  -- ������ �������
INSERT INTO magicshop (Town,IL_ID,QTY) VALUES(1,16,20);  -- ������� ������������� ������


/*������� ������ ��� ����������� ��� 1 � 1 */
CREATE TABLE `zayavki` (
  `ZV_ID` BIGINT unsigned NOT NULL auto_increment,  /*����� ������*/
  `CHAR1_NAME` Char(32) NOT NULL,              /*��� 1 ������*/
  `level1` INT NOT NULL,                       /*level 1 ������*/
  `CHAR2_NAME` Char(32),                       /*��� 2 ������*/
  `level2` INT,                                /*level 2 ������*/
  `ZDATA` DATE,                                /*���� ������*/
  `ZTIME` TIME,                                /*����� ������*/
  `ZTYPE` SMALLINT(2) unsigned,                /*��� ������*/
  `ZTIMEOUT` SMALLINT(2),                      /*������� ������*/
  PRIMARY KEY  (`ZV_ID`)
) TYPE=MyISAM;

--INSERT INTO zayavki (ZV_ID, CHAR1_NAME, ZDATA, ZTIME, ZTYPE, ZTIMEOUT) VALUES(150,'Defender','2008-03-11','10:30',1,3);

/* ������� �������� 1 � 1 */
CREATE TABLE `battle` (
  `BAT_ID` BIGINT unsigned NOT NULL auto_increment,  /*ID ��������*/
  `CHAR1_NAME` Char(32) NOT NULL,               /*ID 1 ������*/
  `CHAR2_NAME` Char(32) NOT NULL,               /*ID 2 ������*/
  `TIMEOUT` SMALLINT(2),                        /*������� � ��������*/
  `STARTTIME` DATETIME,                         /*����� ������ ��������*/
  `M1` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*��� �������*/
  `M2` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*��� �������*/
  `LASTMOVE` DATETIME,                          /*����� ���������� ����*/
  `STATUS` SMALLINT(1),                         /*������ �������� 1-����,2-��������*/
  `R1` SMALLINT(1) unsigned NOT NULL DEFAULT 1, /*������ 1-�� ����� ��� 0-����, >0 - ���*/
  `R2` SMALLINT(1) unsigned NOT NULL DEFAULT 1, /*������ 2-�� ����� ��� 0-����, >0 - ���*/
  PRIMARY KEY  (`BAT_ID`)
) TYPE=MyISAM;

/* ������� ����������� �������� 1 � 1 */
CREATE TABLE `battledetails` (
  `BATDET_ID` BIGINT unsigned NOT NULL auto_increment, /*ID*/
  `BAT_ID` BIGINT unsigned NOT NULL DEFAULT 1,         /*����� ������ - ID ������ �� ���������*/
  `CHAR_NAME` Char(32) NOT NULL,                       /*ID ������ ���������� ���*/
  `ATTACK` SMALLINT(1) unsigned NOT NULL DEFAULT 0,    /*���� �����*/
  `DEFEND` SMALLINT(1) unsigned NOT NULL DEFAULT 0,    /*���� ������*/
  `MESSAGE` CHAR(255) NOT NULL DEFAULT '',             /*�������� ��������....���� ����� ���� � �.�.*/
  PRIMARY KEY  (`BATDET_ID`)
) TYPE=MyISAM;

/*���������� ���*/
CREATE TABLE `body_zones` (
   `BZ_ID` SMALLINT(1) unsigned NOT NULL DEFAULT 0,
   `BZ_NAME` CHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY  (`BZ_ID`)
) TYPE=MyISAM;
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(1,'������');
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(2,'�����');
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(3,'�����');
INSERT INTO body_zones(BZ_ID,BZ_NAME) values(4,'����');


/*������� ����*/
CREATE TABLE `chat` (
   `CH_ID` BIGINT unsigned NOT NULL auto_increment,
   `CH_ROOM` INT unsigned NOT NULL,                     -- ������� �������
   `USER_ID`  bigint(20) unsigned NOT NULL,             -- ��� ������� ���������
   `USER_ID_TO`  bigint(20) unsigned default 0,         -- ���� ���������  0 - ����
   `IS_PRIVATE` SMALLINT DEFAULT 0,                     -- 1 - ��������� (����� �����)
   `CH_MSG` CHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`CH_ID`)
) TYPE=MyISAM;

INSERT INTO chat(CH_ID,CH_ROOM,USER_ID,CH_MSG) values(1,1,1,'��� ���������������!');


/*������� ��������,������ � ������� � �������� ������*/
CREATE TABLE `Buildings` (
  `ID` INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `BuildingName` CHAR(50) NOT NULL,                    /*�������� ��������*/
  `BuildingType` INT(3) NOT NULL,                      /*��� ��������*/
  `Town` SMALLINT(2) NOT NULL REFERENCES Towns(`ID`),  /*�����, ��� ����������� ��������*/
  `PHP_File` CHAR(50) NOT NULL,  /*���� ������� �� PHP ������������ ������ - ����� ��� ����� � ����*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(1,'�����',1,1,'char.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(2,'����������� �������',2,1,'map.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(3,'�������',3,1,'smith.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(4,'������������ �������',4,1,'comission.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(5,'���������� �����',5,1,'magicshop.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(6,'����������� ������� 2',6,1,'map2.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(7,'������',7,1,'station.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(8,'�����',8,1,'market.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(9,'�����������',9,1,'euroshop.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(10,'����',10,1,'bank.phtml');
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town,PHP_File) VALUES(11,'������',11,1,'karet.phtml');






/*������� �������*/
CREATE TABLE `Towns` (
  `ID` SMALLINT(2) unsigned NOT NULL auto_increment,
  `TownName` char(40) default NULL,
  `TownStatus` SMALLINT(2) unsigned NOT NULL DEFAULT 1, /*1-�������,2-�������,3-���������*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO towns (TownName, TownStatus) VALUES('��������',2);
INSERT INTO towns (TownName, TownStatus) VALUES('���������',1);

/* ������ �� ������� */
CREATE TABLE `tickets`(
   `TK_ID`          BIGINT(20) unsigned NOT NULL auto_increment,      /* ID */
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID �������� � ����������� ��������� */
   `Town`           INT(2) unsigned NOT NULL,                         /* ID ������, ��� ���������� ������ */
   `TownTo`         INT(2) unsigned NOT NULL,                         /* ID ������, ���� ������������ */
   `DateStart`      TIMESTAMP NOT NULL,                               /* ���� � ����� �����������*/
   `Price`          INT NOT NULL,                                     /* ���� ������ */
   `MovingTime`     INT NOT NULL,                                     /* ����� �������� (�����) */
   `QTY`            INT NOT NULL,                                     /* ���������� ��������� */
  PRIMARY KEY  (`TK_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,20,'2008-08-06 11:00',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,40,'2008-08-06 12:28',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,30,'2008-08-06 14:03',1,2,4,60);