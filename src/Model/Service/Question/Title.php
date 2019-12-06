<?php
namespace LeoGalleguillos\Question\Model\Service\Question;

use LeoGalleguillos\Question\Model\Entity as QuestionEntity;
use LeoGalleguillos\Question\Model\Service as QuestionService;
use LeoGalleguillos\String\Model\Service as StringService;

class Title
{
    /**
     * Get title.
     *
     * @param QuestionEntity\Question $questionEntity
     * @return string
     */
    public function getTitle(
        QuestionEntity\Question $questionEntity
    ): string {
        $message = $questionEntity->getMessage();

        # Replace any HTML tags with one space.
        $pattern = '/<[^>]*>/';
        $replacement = ' ';
        $message = preg_replace($pattern, $replacement, $message);

        # Replace all one-or-more spaces with one space.
        $pattern = '/\s+/s';
        $replacement = ' ';
        $message = preg_replace($pattern, $replacement, $message);

        # Remove any space at beginning or end of message.
        $message = trim($message);

        # Keep only first characters, truncating at the last possible word.
        $pattern = '/^(.{80}[^\s]*).*/s';
        $replacement = '$1';
        $message = preg_replace($pattern, $replacement, $message);

        return $message;

        /*
        # If there is a question mark after the 20th character,
        # then truncate the message at the question mark.
        $questionMarkPosition = strpos($message, '?', 20);
        if ($questionMarkPosition > 20) {
            $message = substr($message, 0, $questionMarkPosition + 1);
        }
         */
    }
}
