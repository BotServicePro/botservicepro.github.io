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

INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,20,'2008-06-16 09:30',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,40,'2008-06-16 12:30',1,2,2,120);
INSERT INTO tickets (IL_ID,QTY,DateStart,Town,Townto,Price,MovingTime) VALUES(17,30,'2008-06-16 14:03',1,2,4,60);
