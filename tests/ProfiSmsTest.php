<?php

declare(strict_types=1);

namespace ProfiSmsPhpSender\Tests;

use PHPUnit\Framework\TestCase;
use ProfiSmsPhpSender\ProfiSms;
use ProfiSmsPhpSender\ProfiSmsException;
use ProfiSmsPhpSender\ProfiSmsResponse;
use ProfiSmsPhpSender\SmsMessage;

class ProfiSmsTest extends TestCase
{
    private const TEST_PHONE_NUMBER = '600000000';

    /** @var ProfiSms */
    private $profiSms;

    /**
     * @return void
     */
    public function setUp()
    {
        // test access
        $this->profiSms = new ProfiSms(
            'user',
            'passwd'
        );
    }

    /**
     * @param SmsMessage $message
     * @param ProfiSmsResponse $wantedResponse
     *
     * @dataProvider provideSend
     * @throws ProfiSmsException
     */
    public function testSend(SmsMessage $message, ProfiSmsResponse $wantedResponse): void
    {
        $response = $this->profiSms->send($message);
        var_dump($response);
        $this->assertSame($wantedResponse->hasError(), $response->hasError());
    }

    /**
     * @return array<string, array<SmsMessageTest|ProfiSmsResponse>>
     */
    public function provideSend(): array
    {
        $successJson['error']['code'] = 0;
        $successInfo['http_code'] = 200;
        $successResponse = new ProfiSmsResponse(true, $successJson, $successInfo);

        $errorJson['error']['code'] = 202;
        $errorInfo['http_code'] = 200;
        $errorResponse = new ProfiSmsResponse(false, $errorJson, $errorInfo);

        return [
            'simple message' => [
                new SmsMessageTest(self::TEST_PHONE_NUMBER),
                $successResponse,
            ],
            'simple message with SK international code' => [
                new SmsMessageTest('+421940000000'),
                $successResponse,
            ],
            'unvalid phone number' => [
                new SmsMessageTest('987654321'),
                $errorResponse,
            ],
        ];
    }
}
