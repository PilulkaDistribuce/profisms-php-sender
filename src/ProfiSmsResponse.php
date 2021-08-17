<?php

declare(strict_types=1);

namespace ProfiSmsPhpSender;

class ProfiSmsResponse
{
    /** @var bool */
    private $isSuccess;

    /** @var string */
    private $message;

    /** @var array<mixed> */
    private $json;

    /** @var array<mixed> */
    private $info;

    /**
     * @param bool $isSuccess
     * @param string $message
     * @param array<mixed> $json
     * @param array<mixed> $info
     */
    public function __construct(
        bool $isSuccess,
        string $message = '',
        array $json = [],
        array $info = []
    ) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->json = $json;
        $this->info = $info;
    }

    public function hasError(): bool
    {
        return !$this->isSuccess;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrorMessage(): string
    {
        return $this->json['error']['message'] ?? '';
    }

    /**
     * @return array<mixed>
     */
    public function getResponseDebugJson(): array
    {
        return $this->json;
    }

    /**
     * @return array<mixed>
     */
    public function getResponseDebugConnectionInfo(): array
    {
        return $this->info;
    }
}
