CREATE TABLE `{sms}`
(
    `id`          INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `number`      VARCHAR(16)         NOT NULL DEFAULT '',
    `content`     TEXT,
    `delivery`    TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    `send`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    `uid`         INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    `time_create` INT(10) UNSIGNED    NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `number` (`number`),
    KEY `uid` (`uid`),
    KEY `delivery` (`delivery`),
    KEY `time_create` (`time_create`)
);