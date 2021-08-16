<?php

declare(strict_types=1);

namespace ProfiSmsPhpSender;

class ProfiSmsResponse
{
    /** @var bool */
    private $isSuccess;

    /** @var array<mixed> */
    private $json;

    /** @var array<mixed> */
    private $info;

    /**
     * @param bool $isSuccess
     * @param array<mixed> $json
     * @param array<mixed> $info
     */
    public function __construct(bool $isSuccess, array $json, array $info)
    {
        $this->isSuccess = $isSuccess;
        $this->json = $json;
        $this->info = $info;
    }

    public function hasError(): bool
    {
        return !$this->isSuccess;
    }

    public function getHttpCode(): int
    {
        return (int)$this->info['http_code'];
    }

    public function getErrorCode(): int
    {
        return (int)$this->json['error']['code'];
    }

    public function getErrorMessage(): string
    {
        return $this->json['error']['message'] ?? '';
    }

    /**
     * @return array<mixed>
     */
    public function getDebugJson(): array
    {
        return $this->json;
    }

    /**
     * @return array<mixed>
     */
    public function getDebugInfo(): array
    {
        return $this->info;
    }
}
