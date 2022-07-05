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
  PRIMARY KEY  (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

