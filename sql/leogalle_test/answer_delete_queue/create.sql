CREATE TABLE `answer_delete_queue` (
    `answer_delete_queue_id` int(10) unsigned auto_increment,
    `answer_id` int(10) unsigned not null,
    `user_id` int(10) unsigned default null,
    `reason` varchar(255) default null,
    `created` datetime not null,
    `queue_status_id` tinyint(1) signed default 0,
    `modified` datetime default null,
    PRIMARY KEY (`answer_delete_queue_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
