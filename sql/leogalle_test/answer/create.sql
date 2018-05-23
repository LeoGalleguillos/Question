CREATE TABLE `answer` (
    `answer_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned not null,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `message` text,
    `created` datetime not null,
    PRIMARY KEY (`answer_id`),
    KEY `question_id` (`question_id`),
    KEY `user_id` (`user_id`)
) charset=utf8;
