CREATE TABLE `question_search_message` (
    `question_id` int(10) unsigned NOT NULL,
    `message` text COLLATE utf8mb4_unicode_ci,
    PRIMARY KEY (`question_id`),
    FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
