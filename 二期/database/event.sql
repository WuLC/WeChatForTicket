drop table if exists event;

create table event
(
 ename  Varchar(20) not null,
 stime datetime not null,
 address varchar(20) not null,
 sqtime datetime not null,
 eqtime datetime  not null,
 url Varchar(255) not null
 )ENGINE=MyISAM DEFAULT CHARSET=utf8;

 insert into event(ename,stime,address,pnumber,sqtime,eqtime,url) 
 values('°®ÉÏÅ®Ö÷²¥',
 '2014-10-12 17:00','ÒôÀÖÌü','50','2014-10-11 17:00','2014-10-11 17:00:00','www.baidu.com');

  insert into event(ename,stime,address,pnumber,sqtime,eqtime,url) 
 values('ÐÂÉúdai',
 '2014-11-15 17:00','ÒôÀÖÌü','50','2014-11-13 17:00','2014-11-14 17:00:00','www.baidu.com');

 insert into event(ename,stime,address,pnumber,sqtime,eqtime,url) 
 values('ÊÀ¼ÍÄ¾ÃÞ',
 '2015-01-15 17:00','ÒôÀÖÌü','50','2014-11-13 17:00','2015-01-14 17:00:00',
 'www.baidu.com');