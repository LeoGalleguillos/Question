CREATE TABLE `answer` (
    `answer_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned not null,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `message` text,
    `ip` varchar(45) default null,
    `created` datetime not null,
    `deleted` datetime default null,
    PRIMARY KEY (`answer_id`),
    KEY `question_id` (`question_id`),
    KEY `user_id` (`user_id`),
    KEY `ip` (`ip`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
