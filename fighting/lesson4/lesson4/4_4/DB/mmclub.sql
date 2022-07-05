/* ���������� ������� �������� */
CREATE Table `ItemPosition_List`(
  `IP_ID` INT(4)   unsigned NOT NULL AUTO_INCREMENT,     /*������������� �������*/
  `ItemPosName` CHAR(30),                             /*�������� �������*/
  PRIMARY KEY  (`IP_ID`)
) TYPE=MyISAM;

INSERT INTO ItemPosition_List (ItemPosName) VALUES('����� ������������� ��������');               --1
INSERT INTO ItemPosition_List (ItemPosName) VALUES('������ ������');                              --2
INSERT INTO ItemPosition_List (ItemPosName) VALUES('���� ������');                                --3
INSERT INTO ItemPosition_List (ItemPosName) VALUES('������� ��������');                           --4
INSERT INTO ItemPosition_List (ItemPosName) VALUES('������� ��������� ������ � ����������');      --5

/* ������� ���� ��������� � ����� */
CREATE TABLE `Items`(
   `IT_ID`                BIGINT(20) unsigned NOT NULL auto_increment,     /*����. ������������� ��������*/
   `IL_ID`                INT(4) unsigned NOT NULL,                        /* ID �������� � ����������� ���������*/
   `Item_ComissionCost`   FLOAT DEFAULT 0,                                 /*������������ ��������� (���� �� 0 - ������� ���� ��� �������)*/
   `Item_Owner`           BIGINT(20) DEFAULT 0 NOT NULL,                   /*�������� �������� (ID ������ ��� ����� ���������� �������)*/
   `Item_Position`        INT REFERENCES ItemPosition_List(`ID`),          /*������� ��������*/
   `Item_CurrentLife`     INT DEFAULT 0,                                   /*����� ��������*/

  PRIMARY KEY  (`IT_ID`),
  KEY (`Item_Owner`)
) TYPE=MyISAM;

/*� ��������*/
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(1,9,1,2,0);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(2,10,1,2,12);
INSERT INTO Items (IT_ID,IL_ID,Item_Owner,Item_Position,Item_CurrentLife) VALUES(3,3,1,2,15);
