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

ALTER TABLE users auto_increment = 100;

insert into users (nick,pass,email,stat ) values ('test','1234','sp@te.net.ua',1);
insert into users (nick,pass,email,stat ) values ('Суперигрок','1234','sp@te.net.ua',1);

/*Таблица незанятых полей общей карты и также деревни игрока, если есть usr_id*/
CREATE TABLE `fields` (
   fid                           bigint(20) unsigned NOT NULL auto_increment,   /*ID поля*/
   xcoord                        int,
   ycoord                        int,
   fid_type                      int,                                           /*тип поля: 1,2,3*/
   usr_id                        int default 0,                                 /*связан с игроком?*/
   -- сколько ресурсов?
   f_grain                       int default 700,								/* нач. кол-во зерна */
   f_ore						 int default 700,								/* нач. кол-во руды */
   f_wood 						 int default 700,								/* нач. кол-во дерева */
   f_clay						 int default 700,								/* нач. кол-во глины */
  
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- процедура по генерированию случаных типов незанятых полей --
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

-- пройдемся по всем полям --------
CALL makefields(1,4);

-- резервируем поле для нашего тестового персонажа
update fields set usr_id = 100 where fid = 49;
update fields set usr_id = 101 where fid = 52;

