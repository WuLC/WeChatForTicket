drop table if exists e1;

create table e1
(
 name  Varchar(20) not null,
 wid   Varchar(30) not null,
 sid   Varchar(30) not null,
 flag  Varchar(5)  not null
 )ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `app_lcscut`.`e1` (`name`, `wid`, `sid`,`flag`) VALUES ('3', '33333333', '952795279527',''), ('4', '44444444', '952795279527',''),('5','555555','952795279527',''),('6','6666666666','952795279527','');