<?php
namespace LeoGalleguillos\Question\Model\Entity;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Answer
{
    protected $answerId;
    protected $created;
    protected $deleted;
    protected $history;
    protected $ip;
    protected $message;
    protected $questionId;
    protected $userId;
    protected $views;

    public function getAnswerId(): int
    {
        return $this->answerId;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getDeleted(): DateTime
    {
        return $this->deleted;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setAnswerId(int $answerId): QuestionEntity\Answer
    {
        $this->answerId = $answerId;
        return $this;
    }

    public function setCreated(DateTime $created): QuestionEntity\Answer
    {
        $this->created = $created;
        return $this;
    }

    public function setDeleted(DateTime $deleted): QuestionEntity\Answer
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function setHistory(array $history): QuestionEntity\Answer
    {
        $this->history = $history;
        return $this;
    }

    public function setIp(string $ip): QuestionEntity\Answer
    {
        $this->ip = $ip;
        return $this;
    }

    public function setMessage(string $message): QuestionEntity\Answer
    {
        $this->message = $message;
        return $this;
    }

    public function setName(string $name): QuestionEntity\Answer
    {
        $this->name = $name;
        return $this;
    }

    public function setQuestionId(int $questionId): QuestionEntity\Answer
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setUserId(int $userId): QuestionEntity\Answer
    {
        $this->userId = $userId;
        return $this;
    }

    public function setViews(int $views): QuestionEntity\Answer
    {
        $this->views = $views;
        return $this;
    }
}
