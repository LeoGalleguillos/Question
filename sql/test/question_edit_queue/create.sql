CREATE TABLE `question_edit_queue` (
    `question_edit_queue_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned not null,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `subject` varchar(255) not null,
    `message` text,
    `ip` varchar(45) default null,
    `created_datetime` datetime NOT NULL,
    `reason` varchar(255) default null,
    `queue_status_id` tinyint(1) default 0,
    `modified` datetime default null,
    PRIMARY KEY (`question_edit_queue_id`),
    KEY `queue_status_id_created_datetime` (queue_status_id, created_datetime)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
