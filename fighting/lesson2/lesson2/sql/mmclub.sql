DROP DATABASE mmclub;
CREATE DATABASE mmclub DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE mmclub;

/*Таблица персонажей*/
CREATE TABLE `users` (
   USER_ID                       bigint(20) unsigned NOT NULL auto_increment,
   Nick_Name                     CHAR(32) UNIQUE,                                         /*ник игрока (уникальный, при регистрации)*/
   User_Pass                     CHAR(32),                                                /*пароль игрока (задается при регистрации)*/
   SessionID                     bigint,                                                  /*Идентификатор сессии*/
   User_EMail                    CHAR(64) UNIQUE,                                         /*почтовый ящик игрока*/
   Security_Answer               CHAR(30),                                                /*ответ на секретный вопрос*/
   Full_Name                     CHAR(50),                                                /*реальное имя игрока*/
   User_Birth_Day                DATE NOT NULL,                                           /*дата рождения игрока*/
   Character_Birth_Day           DATE NOT NULL,                                           /*дата создания персонажа*/
   User_Gender                   SMALLINT(1),                                             /*пол игрока и перса*/
   User_City                     CHAR(32),                                                /*реальный город игрока*/
   ICQ_Number                    CHAR(16),                                                /*номер аськи*/
  PRIMARY KEY  (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

