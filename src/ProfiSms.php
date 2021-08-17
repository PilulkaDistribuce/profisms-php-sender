<?php

declare(strict_types=1);

namespace ProfiSmsPhpSender;

class ProfiSms
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $source;

    /** @var string */
    private $url;

    public function __construct(
        string $username = 'user',
        string $password = 'passwd',
        string $source = '',
        string $url = 'http://api.profimobilem.cz/index.php?'
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->source = $source;
        $this->url = $url;
    }

    public function send(SmsMessage $message): ProfiSmsResponse
    {
        $call = microtime(true);
        $params = [
            'CTRL' => 'sms',
            '_login' => $this->username,
            '_service' => 'sms',
            'source' => $this->source,
            '_call' => $call,
            '_password' => md5(md5($this->password) . $call),
            'text' => $message->getText(),
            'msisdn' => str_replace(' ', '', $message->getReceiverPhoneNumber()),
        ];

        $fullUrl = $this->url . http_build_query($params);

        $curl = curl_init($fullUrl);
        if ($curl === false) {
            return new ProfiSmsResponse(false, 'curl_init failed');
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /** @var string|false $response */
        $response = curl_exec($curl);
        if ($response === false) {
            return new ProfiSmsResponse(false, 'curl_exec failed');
        }

        $info = curl_getinfo($curl);
        curl_close($curl);

        $json = json_decode($response, true);
        if ($json === null) {
            return new ProfiSmsResponse(false, 'json_decode failed');
        }

        if ($info['http_code'] !== 200 || $json['error']['code'] !== 0) {
            return new ProfiSmsResponse(false, 'returned error code', $json, $info);
        }

        return new ProfiSmsResponse(true, 'success', $json, $info);
    }
}
