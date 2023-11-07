<?php

namespace App\Core\Service;

class BaseService
{
    protected array $data = [];
    protected string $message = '';

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function response(): array
    {
        return [
            'data' => $this->getData(),
            'message' => $this->getMessage(),
        ];
    }
}
