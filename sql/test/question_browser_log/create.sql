CREATE TABLE `question_browser_log` (
    `question_browser_log_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned not null,
    `ip` varchar(45) not null,
    `http_user_agent` varchar(255) not null,
    `created` datetime not null,
    PRIMARY KEY (`question_browser_log_id`),
    KEY `question_id` (`question_id`),
    KEY `created` (`created`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
