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

insert into users (nick,pass,email ) values ('test','1234','sp@te.net.ua');
insert into users (nick,pass,email ) values ('Суперигрок','1234','sp@te.net.ua');

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


-- процедура по генерированию случаных типов незанятых полей ----------
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

--  справочник типов ресурсных полей ---------------
CREATE TABLE `res_fields_types` (
   rft_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID*/
   rft_name                       char(30),
   rft_image                      char(30),
   rft_description                char(255),
  PRIMARY KEY  (`rft_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (1,'Ферма','img/res/r_grain.png','На фермах выращивают зерно для обеспечения продовольствием населения. С развитием фермы увеличивается ее производительность.');
 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (2,'Железный рудник','img/res/r_ore.png','На железных рудниках шахтеры добывают ценное сырье – железо. С развитием рудника увеличивается его производительность.');
 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (3,'Лесопилка','img/res/r_wood.png',' На лесопилке идет производство древесины. С увеличением уровня развития здания увеличивается его производительность.');
 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (4,'Глиняный карьер','img/res/r_clay.png','На глиняном карьере добывают сырье глину. С развитием глиняного карьера увеличивается его производительность.');
 

--  таблица ресурсных полей для каждого поселка ---------------
CREATE TABLE `res_fields` (
   rf_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID ресурсного поля*/
   rf_xcoord                     int,
   rf_ycoord                     int,
   rft_id                        int,                                           /*тип рес.поля: 1-ферма,2-рудник,3-лес,4-глина*/
   rf_level                      int default 0,                                 /* уровень ресурсного поля */
   fid                           int default 0,                                 /*связан с принадлежащим игроку полем общей карты*/
  PRIMARY KEY  (`rf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



-- процедура по генерированию ресурсных полей для поселка ----------
create procedure makeresfields (p_fid int)
BEGIN
 -- Фермы 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (253,280,1,p_fid);
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (304,273,1,p_fid);
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (262,332,1,p_fid);  
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (315,325,1,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (461,360,1,p_fid);
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (386,196,1,p_fid); 
 -- Рудники
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (269,228,2,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (434,305,2,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (490,306,2,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (483,249,2,p_fid); 
 -- Лес
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (323,195,3,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (446,210,3,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (362,391,3,p_fid);  
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (381,346,3,p_fid);  
 -- Глина
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (360,236,4,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (425,255,4,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (308,378,4,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (412,394,4,p_fid);
END;                 

CALL makeresfields(49);


--  справочник уровней, стоимости апгрейдов, потребления ресурсных полей ---------------
CREATE TABLE `res_levels_cost` (
   rlc_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID*/
   rft_id                         int,
   rlc_level                      int,                                           /*уровень ресурсного поля*/ 
   rlc_grain                      int,                                           /* колько зерна для перехода на этот уровень */   
   rlc_ore                        int,                                           /* колько руды для перехода на этот уровень */   
   rlc_wood                       int,                                           /* колько леса для перехода на этот уровень */   
   rlc_clay                       int,                                           /* колько глины для перехода на этот уровень */ 
   rlc_cons                       int,                                           /* потребление */ 
   rlc_prod                       int,                                           /* производство */
   rlc_time_upgrade               CHAR(10),                                      /* время апгрейда до след. уровня */
  PRIMARY KEY  (`rlc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*---------------------------  первые 5 уровней развития ресурсных полей ----------------------*/
/*ферма*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,0,0,0,0,0,0,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,1,70,90,70,20,0,5,'0:01:40');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,2,115,150,115,35,0,9,'0:04:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,3,195,250,195,55,0,15,'0:10:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,4,325,420,325,95,0,22,'0:18:20');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,5,545,700,545,155,0,33,'0:31:30');
/*рудник*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,0,0,0,0,0,1,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,1,100,80,30,60,2,5,'0:05:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,2,165,135,50,100,3,9,'0:10:10');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,3,280,225,85,165,4,15,'0:18:40');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,4,465,375,140,280,6,22,'0:32:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,5,780,620,235,465,8,33,'0:53:30');
/*лес*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,0,0,0,0,0,1,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,1,40,100,60,50,2,5,'0:02:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,2,65,165,85,100,3,9,'0:06:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,3,110,280,140,165,4,15,'0:13:10');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,4,185,465,235,280,6,22,'0:23:20');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,5,310,780,390,465,8,33,'0:39:40');
/*глина*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,0,0,0,0,0,1,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,1,80,40,80,50,2,5,'0:02:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,2,135,65,135,85,3,9,'0:07:10');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,3,225,110,225,140,4,15,'0:14:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,4,375,185,375,235,6,22,'0:25:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,5,620,310,620,390,8,33,'0:42:30');


/*Таблица очереди апгрейдов ресурсных полей */
CREATE TABLE `job_res_upgrade` (
   jr_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID задания на апгрейд*/
   rf_id                         bigint(20) unsigned NOT NULL,                  /*ID поля из таблицы res_fields*/ 
   time_s                        bigint DEFAULT 0,                              /*время начала апгрейда в сек. Эпохи. (php time) */
   time_e                        bigint DEFAULT 0,                              /*расссчитанное время завершения апгрейда в сек. Эпохи. (php time) */
  PRIMARY KEY  (`jr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



