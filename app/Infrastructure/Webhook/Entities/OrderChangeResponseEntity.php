<?php

namespace App\Infrastructure\Webhook\Entities;

class OrderChangeResponseEntity
{
    public function __construct(
        private readonly bool $status,
        private readonly string $message,
        private readonly ?array $data = null,
        private readonly ?\Throwable $error = null
    )
    {
    }

    public function isSuccess(): bool
    {
        return $this->status;
    }

    public function isFailed(): bool
    {
        return !$this->status;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getError(): ?\Throwable
    {
        return $this->error;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

}
