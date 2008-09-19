
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `username` char(255) default NULL,
  `userpass` char(255) default NULL,
  `userid` int(11) default NULL,
  `useremail` char(255) default NULL,
  `userface` varchar(255) default 'default.gif',
  `usersign` char(255) default 'Nothing',
  `userstatus` int(11) default '7',
  `lastonlinetime` datetime default NULL,
  `usergender` int(11) default '1',
  `userpower` int(11) default '2',
  `syscode` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `syscode` (`syscode`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user` VALUES (340,'admin','e10adc3949ba59abbe56e057f20f883e',10000,'admin@admin.com','default.gif','Admin',7,'2008-08-27 15:41:20',1,0,17643);
INSERT INTO `user` VALUES (348,'test','e10adc3949ba59abbe56e057f20f883e',10001,'test@test.com','default.gif','test',7,'2008-08-27 15:40:33',1,2,0);
CREATE TABLE `userconfig` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `distype` int(11) default '1',
  `ordertype` int(11) default '1',
  `chatside` int(11) default '1',
  `msgsendkey` int(11) default '1',
  `showfocus` int(11) default '2',
  `msgshowtime` int(11) default '1',
  PRIMARY KEY  (`id`),
  KEY `msgsendkey` (`msgsendkey`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `userconfig` VALUES (334,10000,1,1,1,1,2,1);
INSERT INTO `userconfig` VALUES (342,10001,1,1,1,1,2,1);
CREATE TABLE `userfriend` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `friendid` int(11) default NULL,
  `groupid` int(11) default '1',
  `customname` char(255) default NULL,
  `isblocked` int(11) default '2',
  PRIMARY KEY  (`id`),
  KEY `friendid` (`friendid`),
  KEY `groupid` (`groupid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `userfriend` VALUES (37,10001,10000,1,NULL,2);
INSERT INTO `userfriend` VALUES (38,10000,10001,1,NULL,2);
CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL auto_increment,
  `groupname` char(255) default NULL,
  `userid` int(11) default '-1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `usergroup` VALUES (1,'Default',-1);
CREATE TABLE `usermsg` (
  `id` int(11) NOT NULL auto_increment,
  `fromid` int(11) default NULL,
  `toid` int(11) default NULL,
  `msgcontent` longtext,
  `isconfirm` int(11) default '2',
  `typeid` int(11) default '1',
  `msgaddtime` datetime default NULL,
  `isread` int(11) default '2',
  PRIMARY KEY  (`id`),
  KEY `typeid` (`fromid`),
  KEY `typeid1` (`typeid`),
  KEY `userid` (`toid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `usermsg` VALUES (13,10000,10000,'Welcome To FleaIM. :)',2,1,'2008-08-20 09:38:55',1);
INSERT INTO `usermsg` VALUES (133,10000,10001,'Welcome To FleaIM. :)',2,1,'2008-08-27 15:40:33',2);
CREATE TABLE `usernum` (
  `id` int(11) NOT NULL auto_increment,
  `num` int(11) default NULL,
  `isok` int(11) default '1',
  PRIMARY KEY  (`id`),
  KEY `number` (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `usernum` VALUES (2,10000,2);
INSERT INTO `usernum` VALUES (3,10001,2);
INSERT INTO `usernum` VALUES (4,10002,1);
INSERT INTO `usernum` VALUES (5,10003,1);
INSERT INTO `usernum` VALUES (6,10004,1);
INSERT INTO `usernum` VALUES (7,10005,1);
INSERT INTO `usernum` VALUES (8,10006,1);
INSERT INTO `usernum` VALUES (9,10007,1);
INSERT INTO `usernum` VALUES (10,10008,1);
INSERT INTO `usernum` VALUES (11,10009,1);
INSERT INTO `usernum` VALUES (12,10010,1);
INSERT INTO `usernum` VALUES (13,10011,1);
INSERT INTO `usernum` VALUES (14,10012,1);
INSERT INTO `usernum` VALUES (15,10013,1);
INSERT INTO `usernum` VALUES (16,10014,1);
INSERT INTO `usernum` VALUES (17,10015,1);
INSERT INTO `usernum` VALUES (18,10016,1);
INSERT INTO `usernum` VALUES (19,10017,1);
INSERT INTO `usernum` VALUES (20,10018,1);
INSERT INTO `usernum` VALUES (21,10019,1);
INSERT INTO `usernum` VALUES (22,10020,1);
INSERT INTO `usernum` VALUES (23,10021,1);
INSERT INTO `usernum` VALUES (24,10022,1);
INSERT INTO `usernum` VALUES (25,10023,1);
INSERT INTO `usernum` VALUES (26,10024,1);
INSERT INTO `usernum` VALUES (27,10025,1);
INSERT INTO `usernum` VALUES (28,10026,1);
INSERT INTO `usernum` VALUES (29,10027,1);
INSERT INTO `usernum` VALUES (30,10028,1);
INSERT INTO `usernum` VALUES (31,10029,1);
INSERT INTO `usernum` VALUES (32,10030,1);
INSERT INTO `usernum` VALUES (33,10031,1);
INSERT INTO `usernum` VALUES (34,10032,1);
INSERT INTO `usernum` VALUES (35,10033,1);
INSERT INTO `usernum` VALUES (36,10034,1);
INSERT INTO `usernum` VALUES (37,10035,1);
INSERT INTO `usernum` VALUES (38,10036,1);
INSERT INTO `usernum` VALUES (39,10037,1);
INSERT INTO `usernum` VALUES (40,10038,1);
INSERT INTO `usernum` VALUES (41,10039,1);
INSERT INTO `usernum` VALUES (42,10040,1);
INSERT INTO `usernum` VALUES (43,10041,1);
INSERT INTO `usernum` VALUES (44,10042,1);
INSERT INTO `usernum` VALUES (45,10043,1);
INSERT INTO `usernum` VALUES (46,10044,1);
INSERT INTO `usernum` VALUES (47,10045,1);
INSERT INTO `usernum` VALUES (48,10046,1);
INSERT INTO `usernum` VALUES (49,10047,1);
INSERT INTO `usernum` VALUES (50,10048,1);
INSERT INTO `usernum` VALUES (51,10049,1);
CREATE TABLE `usersysmsg` (
  `id` int(11) NOT NULL auto_increment,
  `fromid` int(11) default NULL,
  `toid` int(11) default NULL,
  `msgcontent` longtext,
  `isconfirm` int(11) default '2',
  `typeid` int(11) default '1',
  `msgaddtime` datetime default NULL,
  `isread` int(11) default '2',
  PRIMARY KEY  (`id`),
  KEY `typeid` (`fromid`),
  KEY `typeid1` (`typeid`),
  KEY `userid` (`toid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

