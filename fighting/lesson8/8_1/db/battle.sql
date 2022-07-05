/* ������� �������� 1 � 1 */
CREATE TABLE `battle` (
  `BAT_ID` BIGINT unsigned NOT NULL auto_increment,  /*ID ��������*/
  `USER1_ID` bigint(20),                        /*ID 1 ������*/
  `USER2_ID` bigint(20),                        /*ID 2 ������*/
  `TIMEOUT` SMALLINT(2),                        /*������� � ��������*/
  `STARTTIME` DATETIME,                         /*����� ������ ��������*/
  `M1` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*��� �������*/
  `M2` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*��� �������*/
  `LASTMOVE` DATETIME,                          /*����� ���������� ����*/
  `STATUS` SMALLINT(1),                         /*������ �������� 1-����,2-��������*/
  PRIMARY KEY  (`BAT_ID`)
) TYPE=MyISAM;

/* ������� ����������� �������� 1 � 1 */
CREATE TABLE `battledetails` (
  `BATDET_ID` BIGINT unsigned NOT NULL auto_increment,   /*����� ������ - ID ������ �� ���������*/
  `BAT_ID` BIGINT unsigned NOT NULL DEFAULT 1,      /*ID ��������*/
  `USERID` bigint(20),                              /*ID ������ ���������� ���*/
  `ATTACK` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*���� �����*/
  `DEFEND` SMALLINT(1) unsigned NOT NULL DEFAULT 0, /*���� ������*/
  `MESSAGE` CHAR(255) NOT NULL DEFAULT '',           /*�������� ��������....���� ����� ���� � �.�.*/
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


