<?php
namespace LeoGalleguillos\Question\Model\Entity;

use DateTime;
use LeoGalleguillos\Question\Model\Entity as QuestionEntity;

class Answer
{
    protected $answerId;
    protected $createdDateTime;
    protected $createdIp;
    protected $createdName;
    protected $createdUserId;
    protected $deletedDateTime;
    protected $deletedUserId;
    protected $deletedReason;
    protected $history;
    protected $message;
    protected $questionId;

    /**
     * @deprecated Use ::createdUserId property instead
     */
    protected $userId;

    protected $views;

    public function getAnswerId(): int
    {
        return $this->answerId;
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

    public function getCreatedUserId(): int
    {
        return $this->createdUserId;
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

    /**
     * @deprecated Use ::getCreatedUserId() instead
     */
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

    public function setCreatedDateTime(DateTime $createdDateTime): QuestionEntity\Answer
    {
        $this->createdDateTime = $createdDateTime;
        return $this;
    }

    public function setCreatedIp(string $createdIp): QuestionEntity\Answer
    {
        $this->createdIp = $createdIp;
        return $this;
    }

    public function setCreatedUserId(int $createdUserId): QuestionEntity\Answer
    {
        $this->createdUserId = $createdUserId;
        return $this;
    }

    public function setCreatedName(string $createdName): QuestionEntity\Answer
    {
        $this->createdName = $createdName;
        return $this;
    }

    public function setDeletedDateTime(DateTime $deletedDateTime): QuestionEntity\Answer
    {
        $this->deletedDateTime = $deletedDateTime;
        return $this;
    }

    public function setDeletedUserId(int $deletedUserId): QuestionEntity\Answer
    {
        $this->deletedUserId = $deletedUserId;
        return $this;
    }

    public function setDeletedReason(string $deletedReason): QuestionEntity\Answer
    {
        $this->deletedReason = $deletedReason;
        return $this;
    }

    public function setHistory(array $history): QuestionEntity\Answer
    {
        $this->history = $history;
        return $this;
    }

    public function setMessage(string $message): QuestionEntity\Answer
    {
        $this->message = $message;
        return $this;
    }

    public function setQuestionId(int $questionId): QuestionEntity\Answer
    {
        $this->questionId = $questionId;
        return $this;
    }

    /**
     * @deprecated Use ::setCreatedUserId() instead
     */
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
