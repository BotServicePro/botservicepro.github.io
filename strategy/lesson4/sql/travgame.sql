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

insert into users (nick,pass,email ) values ('test','1234','sp@te.net.ua');
insert into users (nick,pass,email ) values ('����������','1234','sp@te.net.ua');

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


-- ��������� �� ������������� �������� ����� ��������� ����� ----------
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

--  ���������� ����� ��������� ����� ---------------
CREATE TABLE `res_fields_types` (
   rft_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID*/
   rft_name                       char(30),
   rft_image                      char(30),
   rft_description                char(255),
  PRIMARY KEY  (`rft_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (1,'�����','img/res/r_grain.png','�� ������ ���������� ����� ��� ����������� ��������������� ���������. � ��������� ����� ������������� �� ������������������.');
 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (2,'�������� ������','img/res/r_ore.png','�� �������� �������� ������� �������� ������ ����� � ������. � ��������� ������� ������������� ��� ������������������.');
 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (3,'���������','img/res/r_wood.png',' �� ��������� ���� ������������ ���������. � ����������� ������ �������� ������ ������������� ��� ������������������.');
 insert into res_fields_types (rft_id, rft_name, rft_image, rft_description) values (4,'�������� ������','img/res/r_clay.png','�� �������� ������� �������� ����� �����. � ��������� ��������� ������� ������������� ��� ������������������.');
 

--  ������� ��������� ����� ��� ������� ������� ---------------
CREATE TABLE `res_fields` (
   rf_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID ���������� ����*/
   rf_xcoord                     int,
   rf_ycoord                     int,
   rft_id                        int,                                           /*��� ���.����: 1-�����,2-������,3-���,4-�����*/
   rf_level                      int default 0,                                 /* ������� ���������� ���� */
   fid                           int default 0,                                 /*������ � ������������� ������ ����� ����� �����*/
  PRIMARY KEY  (`rf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



-- ��������� �� ������������� ��������� ����� ��� ������� ----------
create procedure makeresfields (p_fid int)
BEGIN
 -- ����� 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (253,280,1,p_fid);
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (304,273,1,p_fid);
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (262,332,1,p_fid);  
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (315,325,1,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (461,360,1,p_fid);
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (386,196,1,p_fid); 
 -- �������
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (269,228,2,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (434,305,2,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (490,306,2,p_fid); 
 insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (483,249,2,p_fid); 
 -- ���
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (323,195,3,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (446,210,3,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (362,391,3,p_fid);  
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (381,346,3,p_fid);  
 -- �����
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (360,236,4,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (425,255,4,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (308,378,4,p_fid);
  insert into res_fields (rf_xcoord,rf_ycoord,rft_id,fid) values (412,394,4,p_fid);
END;                 

CALL makeresfields(49);


--  ���������� �������, ��������� ���������, ����������� ��������� ����� ---------------
CREATE TABLE `res_levels_cost` (
   rlc_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID*/
   rft_id                         int,
   rlc_level                      int,                                           /*������� ���������� ����*/ 
   rlc_grain                      int,                                           /* ������ ����� ��� �������� �� ���� ������� */   
   rlc_ore                        int,                                           /* ������ ���� ��� �������� �� ���� ������� */   
   rlc_wood                       int,                                           /* ������ ���� ��� �������� �� ���� ������� */   
   rlc_clay                       int,                                           /* ������ ����� ��� �������� �� ���� ������� */ 
   rlc_cons                       int,                                           /* ����������� */ 
   rlc_prod                       int,                                           /* ������������ */
   rlc_time_upgrade               CHAR(10),                                      /* ����� �������� �� ����. ������ */
  PRIMARY KEY  (`rlc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*---------------------------  ������ 5 ������� �������� ��������� ����� ----------------------*/
/*�����*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,0,0,0,0,0,0,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,1,70,90,70,20,0,5,'0:01:40');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,2,115,150,115,35,0,9,'0:04:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,3,195,250,195,55,0,15,'0:10:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,4,325,420,325,95,0,22,'0:18:20');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (1,5,545,700,545,155,0,33,'0:31:30');
/*������*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,0,0,0,0,0,1,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,1,100,80,30,60,2,5,'0:05:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,2,165,135,50,100,3,9,'0:10:10');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,3,280,225,85,165,4,15,'0:18:40');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,4,465,375,140,280,6,22,'0:32:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (2,5,780,620,235,465,8,33,'0:53:30');
/*���*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,0,0,0,0,0,1,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,1,40,100,60,50,2,5,'0:02:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,2,65,165,85,100,3,9,'0:06:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,3,110,280,140,165,4,15,'0:13:10');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,4,185,465,235,280,6,22,'0:23:20');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (3,5,310,780,390,465,8,33,'0:39:40');
/*�����*/
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,0,0,0,0,0,1,3,'0:00:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,1,80,40,80,50,2,5,'0:02:50');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,2,135,65,135,85,3,9,'0:07:10');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,3,225,110,225,140,4,15,'0:14:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,4,375,185,375,235,6,22,'0:25:00');
insert into res_levels_cost(rft_id,rlc_level,rlc_wood,rlc_clay,rlc_ore,rlc_grain,rlc_cons,rlc_prod,rlc_time_upgrade) values (4,5,620,310,620,390,8,33,'0:42:30');


/*������� ������� ��������� ��������� ����� */
CREATE TABLE `job_res_upgrade` (
   jr_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID ������� �� �������*/
   rf_id                         bigint(20) unsigned NOT NULL,                  /*ID ���� �� ������� res_fields*/ 
   time_s                        bigint DEFAULT 0,                              /*����� ������ �������� � ���. �����. (php time) */
   time_e                        bigint DEFAULT 0,                              /*������������� ����� ���������� �������� � ���. �����. (php time) */
  PRIMARY KEY  (`jr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



