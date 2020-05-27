CREATE TABLE `question_view_not_bot_log` (
    `question_view_not_bot_log_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned NOT NULL,
    `ip` varchar(45) NOT NULL,
    `created` datetime NOT NULL,
    PRIMARY KEY (`question_view_not_bot_log_id`),
    KEY `created_question_id_ip` (`created`, `question_id`, `ip`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
