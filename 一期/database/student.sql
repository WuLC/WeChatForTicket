drop table if exists student;

create table student
(
 sid  BIGINT unsigned,
 name  Varchar(20) not null,
 wid Varchar(30) not null unique
 )ENGINE=MyISAM DEFAULT CHARSET=utf8;
