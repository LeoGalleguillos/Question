<?php
namespace LeoGalleguillos\Question\Model\Entity;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Question
{
    protected $answers;
    protected $createdDateTime;
    protected $createdIp;
    protected $createdName;
    protected $deletedDateTime;
    protected $deletedUserId;
    protected $deletedReason;
    protected $history;
    protected $message;
    protected $questionId;
    protected $subject;
    protected $userId;
    protected $views;

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function getCreatedDateTime(): DateTime
    {
        return $this->createdDateTime;
    }

    public function getCreatedIp(): string
    {
        return $this->createdIp;
    }

    public function getCreatedName(): string
    {
        return $this->createdName;
    }

    public function getDeletedDateTime(): DateTime
    {
        return $this->deletedDateTime;
    }

    public function getDeletedUserId(): int
    {
        return $this->deletedUserId;
    }

    public function getDeletedReason(): string
    {
        return $this->deletedReason;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setAnswers(array $answers): QuestionEntity\Question
    {
        $this->answers = $answers;
        return $this;
    }

    public function setCreatedDateTime(DateTime $createdDateTime): QuestionEntity\Question
    {
        $this->createdDateTime = $createdDateTime;
        return $this;
    }

    public function setCreatedIp(string $createdIp): QuestionEntity\Question
    {
        $this->createdIp = $createdIp;
        return $this;
    }

    public function setCreatedName(string $createdName): QuestionEntity\Question
    {
        $this->createdName = $createdName;
        return $this;
    }

    public function setDeletedDateTime(DateTime $deletedDateTime): QuestionEntity\Question
    {
        $this->deletedDateTime = $deletedDateTime;
        return $this;
    }

    public function setDeletedUserId(int $deletedUserId): QuestionEntity\Question
    {
        $this->deletedUserId = $deletedUserId;
        return $this;
    }

    public function setDeletedReason(string $deletedReason): QuestionEntity\Question
    {
        $this->deletedReason = $deletedReason;
        return $this;
    }

    public function setHistory(array $history): QuestionEntity\Question
    {
        $this->history = $history;
        return $this;
    }

    public function setMessage(string $message): QuestionEntity\Question
    {
        $this->message = $message;
        return $this;
    }

    public function setQuestionId(int $questionId): QuestionEntity\Question
    {
        $this->questionId = $questionId;
        return $this;
    }

    public function setSubject(string $subject): QuestionEntity\Question
    {
        $this->subject = $subject;
        return $this;
    }

    public function setUserId(int $userId): QuestionEntity\Question
    {
        $this->userId = $userId;
        return $this;
    }

    public function setViews(int $views): QuestionEntity\Question
    {
        $this->views = $views;
        return $this;
    }
}
