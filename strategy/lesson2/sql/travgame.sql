DROP DATABASE travgame;
CREATE DATABASE travgame DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE travgame;

/*Таблица персонажей*/
CREATE TABLE `users` (
   usr_id                        bigint(20) unsigned NOT NULL auto_increment, /*ID игрока*/
   nick                          CHAR(32) UNIQUE,                             /*ник игрока (уникальный, при регистрации)*/
   pass                          CHAR(32),                                    /*пароль игрока (задается при регистрации)*/
   uniq_id                       varchar(50) NOT NULL default '',             /*уникальный идентификатор сессии*/
   stat                          int(1) not null default 0,                   /*подтверждена регистрация 0/1*/
   email                         CHAR(64),                                    /*почтовый ящик игрока*/
   full_name                     CHAR(50),                                    /*реальное имя игрока*/
   regdate                       timestamp,                                   /*дата регистрации*/
   user_gender                   SMALLINT(1),                                 /*пол игрока и перса*/
   gold                          FLOAT DEFAULT 0,                             /*золотых монет*/
  PRIMARY KEY  (`usr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



