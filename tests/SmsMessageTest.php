<?php

declare(strict_types=1);

namespace ProfiSmsPhpSender\Tests;

use ProfiSmsPhpSender\SmsMessage;

class SmsMessageTest implements SmsMessage
{
    /** @var string */
    private $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getReceiverPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getText(): string
    {
        return 'test text for SMS';
    }
}
