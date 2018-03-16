<?php
namespace LeoGalleguillos\Question\Model\Entity;

use DateTime;
use LeoGalleguillos\Entity\Model\Entity as EntityEntity;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Answer
{
    protected $created;
    protected $answerId;
    protected $message;
    protected $questionId;
    protected $userId;
    protected $views;

    public function getCreated() : DateTime
    {
        return $this->created;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getQuestionId() : int
    {
        return $this->questionId;
    }

    public function getUserId() : int
    {
        return $this->userId;
    }

    public function getViews() : int
    {
        return $this->views;
    }

    public function setCreated(DateTime $created) : QuestionEntity\Answer
    {
        $this->created = $created;
        return $this;
    }

    public function setMessage(string $message) : QuestionEntity\Answer
    {
        $this->message = $message;
        return $this;
    }

    public function setQuestionId(int $questionId) : QuestionEntity\Answer
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setUserId(int $userId) : QuestionEntity\Answer
    {
        $this->userId = $userId;
        return $this;
    }

    public function setViews(int $views) : QuestionEntity\Answer
    {
        $this->views = $views;
        return $this;
    }
}
