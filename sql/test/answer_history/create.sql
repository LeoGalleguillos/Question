CREATE TABLE `answer_history` (
    `answer_history_id` int(10) unsigned auto_increment,
    `answer_id` int(10) unsigned not null,
    `name` varchar(255) default null,
    `message` text,
    `modified_reason` varchar(255) DEFAULT NULL,
    `created` datetime not null,
    PRIMARY KEY (`answer_history_id`),
    KEY `answer_id_created` (`answer_id`, `created`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
