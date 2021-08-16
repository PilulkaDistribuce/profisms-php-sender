<?php

declare(strict_types=1);

namespace ProfiSmsPhpSender;

interface SmsMessage
{
    public function getReceiverPhoneNumber(): string;
    public function getText(): string;
}
