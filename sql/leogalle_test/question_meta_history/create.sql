CREATE TABLE `question_meta_history` (
    `question_meta_history_id` int(10) unsigned auto_increment,
    `question_meta_id` int(10) unsigned not null,
    PRIMARY KEY (`question_meta_history_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
