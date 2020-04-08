CREATE TABLE `question_history` (
    `question_history_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned not null,
    `name` varchar(255) default null,
    `subject` varchar(255) not null,
    `message` text,
    `modified_reason` varchar(255) DEFAULT NULL,
    `created` datetime not null,
    PRIMARY KEY (`question_history_id`),
    KEY `question_id_created` (`question_id`, `created`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
