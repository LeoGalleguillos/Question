CREATE TABLE `question_view_not_bot_log` (
    `question_view_not_bot_log_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned NOT NULL,
    `ip` varchar(45) NOT NULL,
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`question_view_not_bot_log_id`),
    KEY `created_question_id_ip` (`created`, `question_id`, `ip`),
    KEY `question_id` (`question_id`),
    KEY `ip` (`ip`),
    CONSTRAINT FOREIGN KEY (`question_id`)
        REFERENCES `question` (`question_id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
