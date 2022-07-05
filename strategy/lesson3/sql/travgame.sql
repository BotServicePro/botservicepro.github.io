DROP DATABASE travgame;
CREATE DATABASE travgame DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE travgame;

/*������� ����������*/
CREATE TABLE `users` (
   usr_id                        bigint(20) unsigned NOT NULL auto_increment, /*ID ������*/
   nick                          CHAR(32) UNIQUE,                             /*��� ������ (����������, ��� �����������)*/
   pass                          CHAR(32),                                    /*������ ������ (�������� ��� �����������)*/
   uniq_id                       varchar(50) NOT NULL default '',             /*���������� ������������� ������*/
   stat                          int(1) not null default 0,                   /*������������ ����������� 0/1*/
   email                         CHAR(64),                                    /*�������� ���� ������*/
   full_name                     CHAR(50),                                    /*�������� ��� ������*/
   regdate                       timestamp,                                   /*���� �����������*/
   user_gender                   SMALLINT(1),                                 /*��� ������ � �����*/
   gold                          FLOAT DEFAULT 0,                             /*������� �����*/
  PRIMARY KEY  (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

ALTER TABLE users auto_increment = 100;

insert into users (nick,pass,email,stat ) values ('test','1234','sp@te.net.ua',1);
insert into users (nick,pass,email,stat ) values ('����������','1234','sp@te.net.ua',1);

/*������� ��������� ����� ����� ����� � ����� ������� ������, ���� ���� usr_id*/
CREATE TABLE `fields` (
   fid                           bigint(20) unsigned NOT NULL auto_increment,   /*ID ����*/
   xcoord                        int,
   ycoord                        int,
   fid_type                      int,                                           /*��� ����: 1,2,3*/
   usr_id                        int default 0,                                 /*������ � �������?*/
   -- ������� ��������?
   f_grain                       int default 700,								/* ���. ���-�� ����� */
   f_ore						 int default 700,								/* ���. ���-�� ���� */
   f_wood 						 int default 700,								/* ���. ���-�� ������ */
   f_clay						 int default 700,								/* ���. ���-�� ����� */
  
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- ��������� �� ������������� �������� ����� ��������� ����� --
create procedure makefields (param1 int, param2 int)
BEGIN
  declare x int default 1;
  declare y int default 1;
  declare st int default 0;
WHILE y <= 15 DO
  WHILE x <= 15 DO
     SET st = RAND()*10 / (10 + 1) * ((param2 - param1) + param1)+0.5;
     insert into fields (xcoord,ycoord,fid_type) values (x,y,st);
     SET x = x+1;
  END WHILE;
  SET x = 1;
  SET y = y+1;
END WHILE;
END;

-- ��������� �� ���� ����� --------
CALL makefields(1,4);

-- ����������� ���� ��� ������ ��������� ���������
update fields set usr_id = 100 where fid = 49;
update fields set usr_id = 101 where fid = 52;

