DROP DATABASE mmclub;
CREATE DATABASE mmclub DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE mmclub;

/*������� ����������*/
CREATE TABLE `users` (
   USER_ID                       bigint(20) unsigned NOT NULL auto_increment,
   Nick_Name                     CHAR(32) UNIQUE,                                         /*��� ������ (����������, ��� �����������)*/
   User_Pass                     CHAR(32),                                                /*������ ������ (�������� ��� �����������)*/
   SessionID                     bigint,                                                  /*������������� ������*/
   User_EMail                    CHAR(64) UNIQUE,                                         /*�������� ���� ������*/
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
   Character_Level               INT DEFAULT 0,                                           /*������� ������*/
   Character_Experience          INT DEFAULT 0,                                           /*���� ������*/
   Character_NextExperience      INT DEFAULT 10,                                          /*��������� ��������� ����� �����*/
   Character_UnUsed_Points       INT DEFAULT 3,                                           /*���������������� ���� ��� ������������� � ����� (����, ��������....)*/
   Town                          INT DEFAULT 0 REFERENCES Towns(`ID`),                    /*������� ����� �����*/
   Building                      INT DEFAULT 0 REFERENCES Buildings(`ID`),                /*������� ��������� ����� � ������ (������, �������)*/
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
                   User_Birth_Day, Building)
                   VALUES('���������','1234','500','1','2008-03-11',1);
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


/*������� ��������,������ � ������� � �������� ������*/
CREATE TABLE `Buildings` (
  `ID` INT(3) unsigned NOT NULL AUTO_INCREMENT,
  `BuildingName` CHAR(50) NOT NULL,                    /*�������� ��������*/
  `BuildingType` INT(3) NOT NULL,                      /*��� ��������*/
  `Town` SMALLINT(2) NOT NULL REFERENCES Towns(`ID`),  /*�����, ��� ����������� ��������*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;

INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(1,'�����',1,1);
INSERT INTO Buildings (ID, BuildingName, BuildingType, Town) VALUES(2,'����������� �������',2,1);


