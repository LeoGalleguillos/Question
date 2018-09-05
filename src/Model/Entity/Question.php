<?php
namespace LeoGalleguillos\Question\Model\Entity;

use DateTime;
use LeoGalleguillos\Entity\Model\Entity as EntityEntity;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Question
{
    protected $questionId;
    protected $userId;
    protected $created;
    protected $subject;
    protected $message;
    protected $meta;
    protected $views;

    public function getCreated() : DateTime
    {
        return $this->created;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getQuestionId() : int
    {
        return $this->questionId;
    }

    public function getSubject() : string
    {
        return $this->subject;
    }

    public function getUserId() : int
    {
        return $this->userId;
    }

    public function getViews() : int
    {
        return $this->views;
    }

    public function setCreated(DateTime $created) : QuestionEntity\Question
    {
        $this->created = $created;
        return $this;
    }

    public function setSubject(string $subject) : QuestionEntity\Question
    {
        $this->subject = $subject;
        return $this;
    }

    public function setMessage(string $message) : QuestionEntity\Question
    {
        $this->message = $message;
        return $this;
    }

    public function setMeta(array $meta): QuestionEntity\Question
    {
        $this->meta = $meta;
        return $this;
    }

    public function setQuestionId(int $questionId) : QuestionEntity\Question
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setUserId(int $userId) : QuestionEntity\Question
    {
        $this->userId = $userId;
        return $this;
    }

    public function setViews(int $views) : QuestionEntity\Question
    {
        $this->views = $views;
        return $this;
    }
}
