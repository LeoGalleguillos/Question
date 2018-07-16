CREATE TABLE `question` (
    `question_id` int(10) unsigned auto_increment,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `subject` varchar(255) not null,
    `message` text,
    `views` int(10) unsigned NOT NULL DEFAULT '0',
    `created` datetime not null,
    PRIMARY KEY (`question_id`),
    KEY `user_id` (`user_id`)
) charset=utf8;
