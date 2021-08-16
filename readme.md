## Install

```shell
composer require  PilulkaDistribuce/profisms-php-sender 
```

## Usage

 - Extend `SmsMessage` class for building your own unique sms message.
 - Use `ProfiSms->send(SmsMessage)` method for sending that message.
 - Evaluate returned `ProfiSmsResonse->hasError()` for result. 
