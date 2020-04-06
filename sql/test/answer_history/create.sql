CREATE TABLE `answer_history` (
    `answer_history_id` int(10) unsigned auto_increment,
    `answer_id` int(10) unsigned not null,
    `name` varchar(255) default null,
    `message` text,
    `created` datetime not null,
    `reason` varchar(255) default null,
    PRIMARY KEY (`answer_history_id`),
    KEY `question_id` (`answer_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
