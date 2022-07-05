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
   time_up                       bigint DEFAULT 0,                            /*����� ���������� ������� ���� (���.7 ����)*/
   culture_points                bigint DEFAULT 0,                            /*������� �������� (���. 7 ����)*/  
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
   f_ore						             int default 700,								/* ���. ���-�� ���� */
   f_wood 						           int default 700,								/* ���. ���-�� ������ */
   f_clay						             int default 700,								/* ���. ���-�� ����� */
   fid_parent                    BIGINT(20),                    /*fid ������� ������������ ��� ����������� ���� (���.7 ����)*/
  
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*create function ftest (param float) returns float*/
/*return param*1.1;*/


/*------- ��������� �� ������������� �������� ����� ��������� ����� ----------*/
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

/*------ ��������� �� ���� ����� --------*/
CALL makefields(1,4);

-- ����������� ���� ��� ������ ��������� ���������
update fields set usr_id = 100 where fid = 49;
update fields set usr_id = 101 where fid = 52;

/*----------------  ���������� ����� ��������� ����� ---------------*/
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
 

/*----------------  ������� ��������� ����� ��� ������� ��������� ---------------*/
CREATE TABLE `res_fields` (
   rf_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID ���������� ����*/
   rf_xcoord                     int,
   rf_ycoord                     int,
   rft_id                        int,                                           /*��� ���.����: 1-�����,2-������,3-���,4-�����*/
   rf_level                      int default 0,                                 /* ������� ���������� ���� */
   fid                           int default 0,                                 /*������ � ������������� ������ ����� ����� �����*/
  PRIMARY KEY  (`rf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;



/*------- ��������� �� ������������� ��������� ����� ��� ������� ----------*/
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


/*------------  ���������� �������, ��������� ���������, ����������� ��������� ����� ---------------*/
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


/*������� ������� ��������� ��������� ����� � ������ �������*/
CREATE TABLE `job_upgrade` (
   jr_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID ������� �� �������*/
   rf_id                         bigint(20) unsigned NOT NULL,                  /*ID ���� �� ������� res_fields*/ 
   time_s                        bigint DEFAULT 0,                              /*����� ������ �������� � ���. �����. (php time) */
   time_e                        bigint DEFAULT 0,                              /*������������� ����� ���������� �������� � ���. �����. (php time) */
   jr_type                       int default 0,                                 /*��� ��������: 0-��������� ����, 1-������ � �������*/ 
  PRIMARY KEY  (`jr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


/* ���������� ������ ������� */
CREATE TABLE `building_types` (
   bt_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID*/
   bt_name                       char(50),                                      /*�������� ���������*/ 
   bt_image                      char(50),                                      /*�������� �������� ������*/
   bt_image_not_ready            char(50),                                      /*�������� ����������� ������*/   
   bt_description                char(255),                                     /*�������� ���������*/
   bt_ycoord_dif                 int,                                           /*��������� �� Y ���������� ��������*/ 
   bt_template                   char(20),                                      /*������ ������*/
  PRIMARY KEY  (`bt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (1,'�������������','img/vill/iso.gif','img/vill/iso.gif','',0,'tpl_iso'); 
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (2,'������� ������','img/vill/g15.gif','img/vill/g15b.gif','� ������� ������ ����� ��������� �������. ��� ���� ������� �������� �������� ������, ��� ������� ������� �������������.',20,'tpl_g15');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (3,'�����','img/vill/g11.gif','img/vill/g11b.gif','� ������ �������� ������� �����. � ��������� �������������� ������������� ��� �����������.',35,'tpl_g11');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (4,'�����','img/vill/g10.gif','img/vill/g10b.gif','�� ������ �������� �����: ���������, ����� � ������. � ��������� ����� ������ ������������� ��� �����������.',22,'tpl_g10');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (5,'�������','img/vill/g19.gif','img/vill/g19b.gif','� ������� ����� ���� ������� �������� ������. � ��������� ������� ����������� ����� �������� ������.',22,'tpl_g19');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (6,'�������','img/vill/g20.gif','img/vill/g20b.gif','� ������� ����� ���� ������� ��� ������ ���������. � ��������� ������� ����������� ����� �������� ������.',22,'tpl_g20');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (7,'��������','img/vill/g22.gif','img/vill/g22b.gif','� �������� ����� ���� ����������� ����� ���� �����. � ��������� �������� ������������� ���������� ��������� ��� ������������ ����� �����.',22,'tpl_g22');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (8,'������� ������','img/vill/g12.gif','img/vill/g12b.gif','� ���������� ���� ������� ����� �������� ������ ������. � ��������� ����� ������ ���������� ������������ ������� ��������� ������.',22,'tpl_g12');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (9,'������� ��������','img/vill/g13.gif','img/vill/g13b.gif','� ���������� ����� ������� ����� �������� �������������� �������� ������. � ��������� ����� ������ ���������� ������������ ������� ����������������� ��������.',22,'tpl_g13.php');
/*����� �����*/
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (99,'����� ��� ����� �����','img/vill/g16e.gif','img/vill/g16e.gif','',0,'tpl_g16e'); 
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (10,'����� �����','img/vill/g16.gif','img/vill/g16b.gif','',0,'tpl_g16'); 
/**/
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (11,'������','img/vill/g23.gif','img/vill/g23b.gif','��� ������ �� ���� ������� �� ������ ������ � ������ ����� ����� �� ��������. ��� ����� �� ����� ���� �������� ����������.',22,'tpl_g23');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (12,'�����','img/vill/g17.gif','img/vill/g17b.gif','�� ����� ����� ���������� � ������� �������� ������. � ��������� ����� ������������� ���������� ��������� ���������.',22,'tpl_g17');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (13,'����������','img/vill/g25.gif','img/vill/g25b.gif','���������� � ��� ��������� ������, � ������� ��������������� ������ ��� �������� �������, ����� �� ��� ��� ��������� � �������. ���������� ����� ������������� ������ �������.',32,'tpl_g25');
insert into building_types (bt_id,bt_name,bt_image,bt_image_not_ready,bt_description,bt_ycoord_dif,bt_template) 
                    values (14,'�������','img/vill/g37.gif','img/vill/g37b.gif','� ������� �� ������ ������ �����. ����� 10 ������ �������� ������ �� ������ ����������� ������ � ����������� ���� �������.',32,'tpl_g37');


/* ������� ������/������������� ������� ������ */ 
CREATE TABLE `buildings` (
   bid                         bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   bnum                        char(50),                                       /*����� ���������� ���������*/ 
   bt_id                       char(50),                                       /*����� � building_types (��� ������)*/
   b_xcoord                    int,                                          
   b_ycoord                    int,
   b_level                     int default 0,                                  /* ������� ������ */
   fid                         int default 0,                                  /*������ � ������������� ������ ����� ����� �����*/
  PRIMARY KEY  (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


/*------- ��������� �� ������������� ������������� ----------*/
create procedure makebuildplaces (p_fid int)
BEGIN
  /*����� ��������� ������� ������ � �������*/ 
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (1,2,255,139,1,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (2,5,210,89,1,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (4,6,345,94,1,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (9,7,172,303,1,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (17,8,235,260,1,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (20,9,176,161,1,p_fid);
  /*� ��� �������������*/  
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (3,1,269,83,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (5,1,125,115,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (6,1,89,154,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (7,1,75,224,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (8,1,93,263,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (10,1,151,340,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (11,1,282,344,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (12,1,298,314,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (13,1,369,276,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (14,1,417,242,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (15,1,408,186,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (16,1,402,145,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (18,1,164,214,0,p_fid);
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (19,1,214,193,0,p_fid);
  /* �������� �������� ��� ������ ����� */
  insert into `buildings` (bnum,bt_id,b_xcoord,b_ycoord,b_level,fid) VALUES (21,99,326,162,0,p_fid);
  


END;                 

CALL makebuildplaces(49);  /* ��� ������ ������ "test" */

/*------------  ���������� �������, ��������� ���������, ����������� ��������� ����� ---------------*/
CREATE TABLE `build_levels_cost` (
   blc_id                         bigint(20) unsigned NOT NULL auto_increment,   /*ID*/
   bt_id                          int,                                           /*����� � building_types (��� ������)*/
   blc_level                      int,                                           /*������� ���������� ����*/ 
   blc_grain                      int,                                           /* ������� ����� ��� �������� �� ���� ������� */   
   blc_ore                        int,                                           /* ������� ���� ��� �������� �� ���� ������� */   
   blc_wood                       int,                                           /* ������� ���� ��� �������� �� ���� ������� */   
   blc_clay                       int,                                           /* ������� ����� ��� �������� �� ���� ������� */ 
   blc_cons                       int,                                           /* ����������� */ 
   blc_space                      INT,                                           /* �����������, ��� ������,������*/ 
   blc_build_speed                INT,                                           /* �������� ������������� (��� ��. ������)*/
   blc_time_upgrade               CHAR(10),                                      /* ����� �������� �� ����. ������ */
  PRIMARY KEY  (`blc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*---------------------------  ������ 5 ������� �������� ��������� ������ ----------------------*/
/*�����*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (4,0,0,0,0,0,0,800,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (4,1,130,160,90,40,1,1200,'0:25:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (4,2,165,205,115,50,1,1700,'0:33:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (4,3,215,260,145,65,2,2300,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (4,4,275,335,190,85,2,3100,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (4,5,350,430,240,105,2,4000,'1:06:20');
/*�����*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (3,0,0,0,0,0,0,800,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (3,1,80,100,70,20,1,1200,'0:20:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (3,2,100,130,90,25,1,1700,'0:27:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (3,3,130,165,115,35,2,2300,'0:36:10');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (3,4,170,210,145,40,2,3100,'0:45:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (3,5,215,270,190,155,2,4000,'0:57:00');
/*������� ������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_build_speed, blc_time_upgrade) values (2,0,0,0,0,0,0,100,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_build_speed, blc_time_upgrade) values (2,1,70,40,160,20,2,100,'0:27:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_build_speed, blc_time_upgrade) values (2,2,90,50,75,25,1,96,'0:33:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_build_speed, blc_time_upgrade) values (2,3,115,65,100,35,1,93,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_build_speed, blc_time_upgrade) values (2,4,145,85,125,40,1,90,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_build_speed, blc_time_upgrade) values (2,5,190,105,160,55,1,86,'1:06:20');
/*�������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (5,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (5,1,70,40,160,20,2,'0:27:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (5,2,90,50,75,25,1,'0:35:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (5,3,115,65,100,35,1,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (5,4,145,85,125,40,1,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (5,5,190,105,160,55,1,'1:06:20');
/*�������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (6,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (6,1,260,140,220,100,5,'0:28:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (6,2,335,180,280,130,3,'0:36:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (6,3,425,230,360,165,3,'0:46:30');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (6,4,545,295,460,210,3,'0:57:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (6,5,700,375,590,270,3,'1:11:00');
/*��������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (7,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (7,1,220,10,90,40,4,'0:25:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (7,2,280,205,115,50,2,'0:33:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (7,3,360,260,145,65,2,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (7,4,460,335,190,85,2,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (7,5,590,430,240,105,2,'1:06:20');
/*������� ������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (8,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (8,1,170,200,380,130,4,'0:25:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (8,2,220,225,485,165,2,'0:33:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (8,3,280,330,625,215,2,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (8,4,355,420,795,275,2,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (8,5,455,535,1020,350,2,'1:06:20');
/*������� ��������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (9,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (9,1,130,210,410,130,4,'0:25:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (9,2,165,270,525,165,2,'0:33:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (9,3,215,345,670,215,2,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (9,4,275,440,860,275,2,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (9,5,350,565,1100,350,2,'1:06:20');
/*����� �����*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (10,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (10,1,110,160,90,70,1,'0:25:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (10,2,140,205,115,90,1,'0:33:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (10,3,180,260,145,115,1,'0:43:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (10,4,230,335,190,145,1,'0:53:50');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (10,5,295,430,240,190,1,'1:06:20');
/*������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (11,0,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (11,1,40,50,30,10,0,100,'0:09:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (11,2,50,65,40,15,0,130,'0:15:10');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (11,3,65,80,50,15,0,170,'0:21:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (11,4,85,105,65,20,0,220,'0:28:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_space, blc_time_upgrade) values (11,5,105,135,80,25,0,280,'0:37:10');
/*�����*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (12,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (12,1,80,70,120,70,4,'0:23:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (12,2,100,90,155,90,2,'0:30:10');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (12,3,130,115,195,115,2,'0:39:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (12,4,170,145,250,145,2,'0:49:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (12,5,215,190,320,190,2,'1:01:40');
/*����������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (13,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (13,1,580,460,350,180,1,'0:23:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (13,2,740,590,450,230,1,'0:30:10');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (13,3,950,755,575,295,1,'0:39:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (13,4,1215,965,735,375,1,'0:49:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (13,5,1555,1235,940,485,1,'1:01:40');
/*�������*/
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (14,0,0,0,0,0,0,'0:00:00');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (14,1,700,670,700,240,2,'0:29:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (14,2,930,890,930,320,1,'0:34:10');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (14,3,1240,1185,1240,425,1,'0:39:20');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (14,4,1645,1575,1645,565,1,'0:46:40');
insert into `build_levels_cost`(bt_id, blc_level, blc_wood, blc_clay, blc_ore, blc_grain, blc_cons, blc_time_upgrade) values (14,5,2190,2095,2190,750,1,'0:53:20');


/* ���������� ����� ����� */
CREATE TABLE `spr_army` (
   sa_id                          bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   sa_name                        char(50),                                       /*����� ���������� ���������*/ 
   sa_image                       CHAR(50) ,                                      
   sa_attack                      int, /* ����� */ 
   sa_inf_defence                 int, /* ������ �� ������*/                                          
   sa_cav_defence                 int, /* ������ �� �������*/
   sa_grain                       INT, /*�����*/
   sa_ore                         INT, /*����*/
   sa_wood                        INT, /*������*/
   sa_clay                        INT, /*�����*/
   sa_speed                       INT, /*�������� ����� � ���*/
   sa_capacity                    INT, /*����������������*/
   sa_cons                        INT, /*����������� �����*/          
   sa_training_time               CHAR(20), /*����� �������� (��� ������ 1 ������)*/
   sa_description                 CHAR(255), /*��������*/
   bt_id                          int,       /*�������������� ������*/

  PRIMARY KEY  (`sa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*��� �������*/
insert into spr_army(sa_id,sa_name,sa_image,sa_attack,sa_inf_defence,sa_cav_defence,sa_wood,sa_clay,sa_ore,sa_grain,sa_speed,sa_capacity,sa_cons,sa_training_time,bt_id,sa_description) 
             values (1,'��������','img/army/1.gif',40,35,50,120,100,150,30,6,50,1,'0:00:20',5,'��������� � ������� � ������������� ������ ������. ������ ������� ����� ���� ����� ������������� �������: ��� ������ ��������� ���� ��� � �����, ��� � � ������. ��, �� ��, �� �������� �������������� � ������ ��������� ������� ������� �� ������ ������� ����������.');
insert into spr_army(sa_id,sa_name,sa_image,sa_attack,sa_inf_defence,sa_cav_defence,sa_wood,sa_clay,sa_ore,sa_grain,sa_speed,sa_capacity,sa_cons,sa_training_time,bt_id,sa_description) 
             values (2,'�����������','img/army/2.gif',30,65,35,100,130,160,70,5,20,1,'0:29:20',5,'����������� �������� ��������������� �������� ������� ������� ������� ��� ���������� ������ ��� ������ � �������� ����-�������. ���� ����������� ����� ��� ��������� ��������� ��������� ������ ������� �������� ��� ������ ��������� ������. ������, ����������� �� ����� ������ � ������� � ������� ������ ���������, ��� �� ������ �� ������ � ���������.');
insert into spr_army(sa_id,sa_name,sa_image,sa_attack,sa_inf_defence,sa_cav_defence,sa_wood,sa_clay,sa_ore,sa_grain,sa_speed,sa_capacity,sa_cons,sa_training_time,bt_id,sa_description) 
             values (3,'����������','img/army/3.gif',70,40,25,150,160,210,80,7,50,1,'0:32:00',5,'���������� � ������� ��������� ����� ����. ��� ������ � ������ � �����, ��� ������� ���� �� �������� ������ ����������. ������, �� �� ����� ������� � �������� ����������� �������� ��������� � ��������� ������.');
/*��� �������*/
insert into spr_army(sa_id,sa_name,sa_image,sa_attack,sa_inf_defence,sa_cav_defence,sa_wood,sa_clay,sa_ore,sa_grain,sa_speed,sa_capacity,sa_cons,sa_training_time,bt_id,sa_description) 
             values (4,'������ ���������','img/army/4.gif',0,20,10,20,140,160,40,7,0,2,'0:22:40',6,'������ ���������� � ���������������� ������� ����. ����� ������� �������. ��� ��������� ��������� �� ��������� ������� � �������� ������ �������� � ��������� �������, ������� � ���������� ��������. ���� � ������� ���������� ��� �����������, �� ���������������� �������� �������� �� ���������.');
insert into spr_army(sa_id,sa_name,sa_image,sa_attack,sa_inf_defence,sa_cav_defence,sa_wood,sa_clay,sa_ore,sa_grain,sa_speed,sa_capacity,sa_cons,sa_training_time,bt_id,sa_description) 
             values (5,'������� ����������','img/army/5.gif',180,80,105,800,550,640,180,10,70,4,'0:58:40',6,'������� ������ � ��� ������� ������ ������. ������������� ������ ��� � �����, ��� � � ������, � ��� ��������� ������� ������ �� ��������� � ���� ������ ���������� ������. �� ��������, ��� � ����������, ����� ����� ������� ����.');



/* ���������� ����� ����� */
CREATE TABLE `army` (
   ar_id                          bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   sa_id                          bigint(20),                                     /*ID �� spr_army*/
   sr_qty                         int default 0,                                  /* ���-�� ����� */ 
   sr_enable                      int default 0,                                  /* ����������� */         
   sr_attack_upgrade              int default 0,                                  /* ������� � �����*/
   sr_defence_upgrade             int default 0,                                  /* ������� � ������*/ 
   fid                            int,                                            /*�������������� �������*/
  PRIMARY KEY  (`ar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*------- ��������� �� ������������� ����� ������ ----------*/
create procedure makearmy (p_fid int)
BEGIN
  insert into army (sa_id,sr_qty,sr_enable,fid) VALUES (1,0,1,p_fid);  /*��������� ��������*/
  insert into army (sa_id,sr_qty,sr_enable,fid) VALUES (2,0,0,p_fid);  /*����������� ����������*/
  insert into army (sa_id,sr_qty,sr_enable,fid) VALUES (3,0,0,p_fid);  /*���������� ����������*/
  insert into army (sa_id,sr_qty,sr_enable,fid) VALUES (4,0,0,p_fid);  /*������ ��������� ����������*/
  insert into army (sa_id,sr_qty,sr_enable,fid) VALUES (5,0,0,p_fid);  /*������� ���������� ����������*/
END;

call makearmy( 49 );  /* ����� ��� ������ ������ "test", �.�. ��� ��� ������� � id=49 */

/* ������� ������� ���������� ������ */
CREATE TABLE `job_training_army` (
   jt_id                          bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   sa_id                          bigint(20),                                     /*ID �� spr_army*/
   fid                            int,                                            /*�������������� �������*/
   jt_start_time                  bigint DEFAULT 0,                               /*������ ����������*/ 
   jt_end_time                    bigint DEFAULT 0,                               /*��������� ������� ����������*/ 
   jt_qty                         int default 0,                                  /* ������� ������ � ������� */ 
  PRIMARY KEY  (`jt_id`) 
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/* ������� ������ �� ������������ */
CREATE TABLE `army_research_cost` (
   arc_id                         int unsigned NOT NULL auto_increment,           /*ID*/
   sa_id                          bigint(20),                                     /*ID �� spr_army*/
   arc_grain                      int DEFAULT 0,                                  
   arc_ore                        int DEFAULT 0,                                  
   arc_wood                       int DEFAULT 0,                                  
   arc_clay                       int DEFAULT 0,                                  
   arc_research_time              CHAR(20),                                  
  PRIMARY KEY  (`arc_id`) 
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
  
insert into army_research_cost (sa_id,arc_wood,arc_clay,arc_ore,arc_grain,arc_research_time)  values (2,700,620,670,580,'1:58:00');   /*����������*/
insert into army_research_cost (sa_id,arc_wood,arc_clay,arc_ore,arc_grain,arc_research_time)  values (3,1000,740,1880,640,'2:06:00');  /*����������*/
insert into army_research_cost (sa_id,arc_wood,arc_clay,arc_ore,arc_grain,arc_research_time)  values (4,940,740,360,400,'1:38:00');    /*���������*/
insert into army_research_cost (sa_id,arc_wood,arc_clay,arc_ore,arc_grain,arc_research_time)  values (5,3400,1860,2760,760,'2:42:00'); /*������� ����������*/

/* ������� ������� ������������ ����� ����� ����� */
CREATE TABLE `job_research_army` (
   jra_id                         bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   sa_id                          bigint(20),                                     /*ID �� spr_army*/
   fid                            int,                                            /*�������������� �������*/
   jra_start_time                  bigint DEFAULT 0,                               /*������ ������������*/ 
   jra_end_time                    bigint DEFAULT 0,                               /*��������� ������� ������������*/ 
  PRIMARY KEY  (`jra_id`) 
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*---------  ���������� ������� ��������� ������ � �������� � �������� ---------------*/
/* ��� �������� - ���� ������� � ��� �������� � ��� ������ */
CREATE TABLE `army_upgrade_cost` (
   auc_id                         bigint(20) unsigned NOT NULL auto_increment,   /* ID*/
   sa_id                          int,                                           /* ��� ������ */
   auc_level                      int,                                           /* �������*/ 
   auc_grain                      int,                                           /* ������ ����� ��� �������� �� ���� ������� */   
   auc_ore                        int,                                           /* ������ ���� ��� �������� �� ���� ������� */   
   auc_wood                       int,                                           /* ������ ���� ��� �������� �� ���� ������� */   
   auc_clay                       int,                                           /* ������ ����� ��� �������� �� ���� ������� */ 
   auc_time_upgrade               CHAR(10),                                      /* ����� �������� ������ ��� ����� �� ����. ������ */
  PRIMARY KEY  (`auc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

/*������� �� 2 ������ �������� ������� ���� �����*/
/*��������*/
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (1,1,560,620,680,370,'1:42:20');
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (1,2,670,730,800,450,'2:32:00');
/*�����������*/
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (2,1,580,640,690,350,'1:45:20');
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (2,2,560,620,680,370,'2:25:00');
/*����������*/
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (3,1,630,690,880,390,'1:42:20');
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (3,2,740,850,1020,450,'2:52:00');
/*���������*/
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (4,1,350,420,480,270,'1:22:20');
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (4,2,520,610,640,350,'1:45:50');
/*������� ����������*/
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (5,1,800,1200,1680,870,'1:50:20');
insert into army_upgrade_cost (sa_id,auc_level,auc_wood,auc_clay,auc_ore,auc_grain,auc_time_upgrade) values (5,2,980,1450,1830,950,'2:45:00');

/* ������� ������� ��������� ����� (������,�������) */
CREATE TABLE `job_upgrade_army` (
   jua_id                         bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   sa_id                          bigint(20),                                     /*ID �� spr_army*/
   fid                            int,                                            /*�������������� �������*/
   jua_start_time                 bigint DEFAULT 0,                               /*������ ������������*/ 
   jua_end_time                   bigint DEFAULT 0,                               /*��������� ������� ������������*/ 
   jua_type                       int DEFAULT 0,                                  /* 8-������, 9-������� */ 
  PRIMARY KEY  (`jua_id`) 
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


/* ������� ������ �������� */
CREATE TABLE `spr_tree` (
   st_id                          bigint(20) unsigned NOT NULL auto_increment,    /*ID*/
   bt_id                          bigint(20),                                     /*ID �� building_types, ��������� ���������*/
   bt_id_parent                   bigint(20),                                     /*ID �� building_types, ��������� (�� ������� �������)*/ 
   st_level                       int DEFAULT 0,                                  /*������� ���������*/ 
  PRIMARY KEY  (`st_id`) 
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


/*���������� ������� �������� ������ ������� 3*/
insert into spr_tree(bt_id,bt_id_parent,st_level) values (13,2,3);
/*����� ������� ������� ������ ������� 3, ����� ������� 1, ����� ������� 1*/
insert into spr_tree(bt_id,bt_id_parent,st_level) values (12,2,3);
insert into spr_tree(bt_id,bt_id_parent,st_level) values (12,3,1);
insert into spr_tree(bt_id,bt_id_parent,st_level) values (12,4,1);


  