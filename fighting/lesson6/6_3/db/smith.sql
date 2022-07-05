/*������� ��������� ��� ������� � ������� (����������)*/
CREATE TABLE `smith`(
   `SM_ID`             BIGINT(20) unsigned NOT NULL auto_increment,   /*����. ������������� �������� � ��������*/
   `IL_ID`          INT(4) unsigned NOT NULL,                         /* ID �������� � ����������� ���������*/
   `Town`           INT(2) unsigned NOT NULL,                         /*�����, ��� ����������� ������*/
   `QTY`            INT NOT NULL,                                     /*���������� ���������*/
  PRIMARY KEY  (`SM_ID`),
  KEY (`Town`)
) TYPE=MyISAM;

INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,2,100);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,5,50);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,8,300);
INSERT INTO smith (Town,IL_ID,QTY) VALUES(1,13,300);

