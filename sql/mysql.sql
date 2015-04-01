CREATE TABLE `{sms}` (
    `id` int(10) unsigned NOT NULL auto_increment,
    `number` varchar(16) NOT NULL default '',
    `content` text,
    `delivery` tinyint(1) unsigned NOT NULL default '0',
    `uid` int(10) unsigned NOT NULL default '0',
    `time_create` int(10) unsigned NOT NULL default '0',
    PRIMARY KEY (`id`),
    KEY `number` (`number`),
    KEY `uid` (`uid`),
    KEY `delivery` (`delivery`),
    KEY `time_create` (`time_create`)
);