CREATE TABLE `answer_edit_queue` (
    `answer_edit_queue_id` int(10) unsigned auto_increment,
    `answer_id` int(10) unsigned not null,
    `user_id` int(10) unsigned default null,
    `name` varchar(255) default null,
    `message` text,
    `ip` varchar(45) default null,
    `created` datetime not null,
    `reason` varchar(255) default null,
    `queue_status_id` tinyint(1) default 0,
    `modified` datetime default null,
    PRIMARY KEY (`answer_edit_queue_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
