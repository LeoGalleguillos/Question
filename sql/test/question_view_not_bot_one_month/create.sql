CREATE TABLE `question_view_not_bot_one_month` (
    `question_view_not_bot_one_month_id` int(10) unsigned auto_increment,
    `question_id` int(10) unsigned NOT NULL,
    `views` int(10) unsigned NOT NULL,
    PRIMARY KEY (`question_view_not_bot_one_month_id`),
    KEY `question_id_views` (`question_id`, `views`),
    KEY `views_question_id` (`views`, `question_id`),
    CONSTRAINT FOREIGN KEY (`question_id`)
        REFERENCES `question` (`question_id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
