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
   Character_Money               INT DEFAULT 200,                                           /*������ (��������� 2004.07.04)*/
   Character_Strength            INT DEFAULT 3,                                           /*���� ���������*/
   Character_Strength_Total      INT DEFAULT 3,                                           /*���� ��������� c ������ �����*/
   Character_Endurance           INT DEFAULT 3,                                           /*������������ (��������=������������*5)*/
   Character_Accuracy            INT DEFAULT 3,                                           /*�������� ����� (������ �� ����.����)*/
   Character_Accuracy_Total      INT DEFAULT 0,                                           /*�������� � ��. ����� �����*/
   Character_Dexterity           INT DEFAULT 3,                                           /*�������� ����� (������ �� ������)*/
   Character_Dexterity_Total     INT DEFAULT 0,                                           /*�������� ����� � ��. �����*/
   Character_Sword               INT DEFAULT 0,                                           /*���������� �������� �����*/
   Character_Spear               INT DEFAULT 0,                                           /*���������� �������� ������*/
   Character_Axe                 INT DEFAULT 0,                                           /*���������� �������� �������*/
   Character_Mace                INT DEFAULT 0,                                           /*���������� �������� �����,������*/
   Character_Dagger              INT DEFAULT 0,                                           /*���������� �������� �����*/
   Character_CurHealth           INT DEFAULT 0,                                           /*��� �������� �� ����� ���*/
   Character_MaxHealth           INT DEFAULT 20,                                          /*������������ �������� � ������ �����*/
   Character_Level               INT DEFAULT 1,                                           /*������� ������*/
   Character_Experience          INT DEFAULT 0,                                           /*���� ������*/
   Character_NextExperience      INT DEFAULT 10,                                          /*��������� ��������� ����� �����*/
   Character_UnUsed_Points       INT DEFAULT 3,                                           /*���������������� ���� ��� ������������� � ����� (����, ��������....)*/
   Town                          INT DEFAULT 0 REFERENCES Towns(`ID`),                    /*������� ����� �����*/
   Building                      INT DEFAULT 1 REFERENCES Buildings(`ID`),                /*������� ��������� ����� � ������ (������, �������)*/
   Moving_Type                   INT DEFAULT 0 REFERENCES MovingTypes(`ID`),               /*������� ������������ �������� (�������, ������)*/
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
  PRIMARY KEY  (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

INSERT INTO users (Nick_Name,
                   User_Pass,
                   Character_Money,
                   Character_Level,
                   User_Birth_Day) 
                   VALUES('���������','1234','500','1','2004-10-22');
                   
                   
/*������� ��������,������ � ������� � �������� ������*/
CREATE TABLE `Buildings` (
  `ID` INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `BuildingName` CHAR(50) NOT NULL,                    /*�������� ��������*/
  `BuildingType` INT(3) NOT NULL,                      /*��� ��������*/
  `Town` SMALLINT(2) NOT NULL REFERENCES Towns(`ID`),  /*�����, ��� ����������� ��������*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(1,'������� ��������',1,1);
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(2,'������� �������',1,1);


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
  `Item_Mind`            INT DEFAULT 0,             /*���������� � �������� ������ ������ �����*/
  `Item_Body`            INT DEFAULT 0,             /*���������� � �������� ������ ���� �����*/
  `Item_Spirit`          INT DEFAULT 0,             /*���������� � �������� ������ ���� �����*/
  `Min_Damage`           INT DEFAULT 0,             /*����������� ����������� ���������*/
  `Max_Damage`           INT DEFAULT 0,             /*����������� ����������� ���������*/
  `Fire_Damage`          INT DEFAULT 0,             /*����������� ����������� �����*/
  `Water_Damage`         INT DEFAULT 0,             /*����������� ����������� ��������*/
  `Air_Damage`           INT DEFAULT 0,             /*����������� ����������� �����*/
  `Earth_Damage`         INT DEFAULT 0,             /*����������� ����������� ������*/
  `Mind_Damage`          INT DEFAULT 0,             /*����������� ����������� �������*/
  `MF_Deviation`         INT DEFAULT 0,             /*����������� ���������*/
  `MF_UnDeviation`       INT DEFAULT 0,             /*����������� �������������*/
  `MF_ShokingBlow`       INT DEFAULT 0,             /*����������� ������������ �����*/
  `MF_UnShokingBlow`     INT DEFAULT 0,             /*����������� ��������������� ������*/
  PRIMARY KEY  (`IL_ID`),
  KEY(`ItemType`)
) TYPE=MyISAM;

/*������� ��������� ��������� � ����������*/
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(1,1,1,'����� �������',20,'mace.jpg','Weapon',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(2,2,1,'��� �����������',25,'shield.jpg','Shield',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(3,3,1,'���� ������',20,'helmet.jpg','Helmet',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(4,3,2,'���� ��������',15,'helmet1.jpg','Helmet',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(5,4,1,'�������� �������',15,'gloves.jpg','Gloves',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(6,5,1,'������ ����������',22,'earrings.jpg','Ear',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(7,6,1,'����� �������',26,'necklace.jpg','Necklace',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(8,7,1,'�������� ������',10,'boots.jpg','Shoes',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(9,8,1,'���� ������',10,'belt.jpg','Belt',2);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(10,9,1,'������ �����������',15,'ring1.jpg','Ring',2);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(11,9,2,'������ ����������',24,'ring2.jpg','Ring',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(12,10,1,'�������',5,'skirt.jpg','Armor',1);
INSERT INTO Items_List (IL_ID,ItemType,ItemNo,ItemName,Item_StateCost,Item_Image,ItemSlotName,Item_Level) VALUES(13,10,2,'������� �����',14,'skirt1.jpg','Armor',1);


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
   `Item_FullLife`        INT DEFAULT 0,                                   /*������������� ��������*/
   `Item_CurrentLife`     INT DEFAULT 0,                                   /*����� ��������*/
  PRIMARY KEY  (`IT_ID`),
  KEY (`Item_Owner`)
) TYPE=MyISAM;

/*������ ���������� ����*/
--INSERT INTO Items (IL_ID,Item_No,Item_Owner,Item_Position) VALUES(1,1,1,3);
/*� � ��������*/
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position) VALUES(1,9,1,2);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position) VALUES(2,10,1,2);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position) VALUES(3,3,1,2);

                   

