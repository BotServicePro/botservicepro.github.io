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



