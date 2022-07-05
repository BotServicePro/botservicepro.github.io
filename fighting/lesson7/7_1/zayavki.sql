/*������� ������ ��� ����������� ��� 1 � 1 */
CREATE TABLE `zayavki` (
  `ID` BIGINT unsigned NOT NULL DEFAULT 1,     /*����� ������ - ID ������ �� ���������*/
  `CHAR1_NAME` Char(32) NOT NULL,              /*��� 1 ������*/
  `level1` INT NOT NULL,                       /*level 1 ������*/
  `CHAR2_NAME` Char(32),                       /*��� 2 ������*/
  `level2` INT,                                /*level 2 ������*/
  `ZDATA` DATE,                                /*���� ������*/
  `ZTIME` TIME,                                /*����� ������*/
  `ZTYPE` SMALLINT(2) unsigned,                /*��� ������*/
  `ZTIMEOUT` SMALLINT(2),                      /*������� ������*/
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM;
