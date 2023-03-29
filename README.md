# GoSMS.GE Integration for Laravel

[![Packagist](https://img.shields.io/packagist/v/zgabievi/laravel-gosms.svg)](https://packagist.org/packages/zgabievi/laravel-gosms)
[![Packagist](https://img.shields.io/packagist/dt/zgabievi/laravel-gosms.svg)](https://packagist.org/packages/zgabievi/laravel-gosms)
[![license](https://img.shields.io/github/license/zgabievi/laravel-gosms.svg)](https://packagist.org/packages/zgabievi/laravel-gosms)

[![laravel-gosms](https://raw.githubusercontent.com/zgabievi/laravel-gosms/main/assets/gosms.png)](https://github.com/zgabievi/laravel-gosms)

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
    - [Send Message](#send-message)
    - [Check Status](#check-status)
    - [Send OTP](#send-otp)
    - [Verify OTP](#verify-otp)
    - [Check Balance](#check-balance)
    - [Sender Request](#sender-request)
- [Notification](#notification)
- [Configuration](#configuration)
- [License](#license)

## Installation

To get started, you need to install package:

```shell script
composer require zgabievi/laravel-gosms
```

If your laravel version is older than 5.5, then add this to your service providers in *config/app.php*:

```php
'providers' => [
    ...
    Zorb\GoSMS\GoSMSServiceProvider::class,
    ...
];
```

You can publish config file using this command:

```shell script
php artisan vendor:publish --provider="Zorb\GoSMS\GoSMSServiceProvider"
```

This command will copy config file in your config directory.

## Usage

- [Send Message](#send-message)
- [Check Status](#check-status)
- [Send OTP](#send-otp)
- [Verify OTP](#verify-otp)
- [Check Balance](#check-balance)
- [Sender Request](#sender-request)

### Send Message

```php
use Zorb\GoSMS\Facades\GoSMS;

class MessageController extends Controller
{
    //
    public function __invoke()
    {
        // recipient who should get sms
        $mobile_number = '9955XXXXXXXX';
    
        // content of the message
        $message = 'Welcome, you are getting this message from integration';

        // brand name, if empty, config value will be used
        $brand = 'MY_BRAND';                  

        $result = GoSMS::send($mobile_number, $message, $brand);
        
        if ($result->success) {
            // $result->success
            // $result->messageId
            // $result->from
            // $result->to
            // $result->text
            // $result->sendAt
            // $result->balance
            // $result->encode
            // $result->segment
            // $result->smsCharacters
        } else {
            // message was not sent
        }
    }
} 
```

### Check Status

```php
use Zorb\GoSMS\Facades\GoSMS;

class MessageController extends Controller
{
    //
    public function __invoke()
    {
        // message id provided by send method
        $message_id = 0000;

        $result = GoSMS::status($message_id);
        
        if ($result->success) {
            // $result->success
            // $result->messageId
            // $result->from
            // $result->to
            // $result->text
            // $result->sendAt
            // $result->encode
            // $result->segment
            // $result->smsCharacters
            // $result->status

            if ($result->status === 'DELIVERED') {
                // message has been delivered
            }
        } else {
            // message status check failed
        }
    }
} 
```

### Send OTP

```php
use Zorb\GoSMS\Facades\GoSMS;

class MessageController extends Controller
{
    //
    public function __invoke()
    {
        // recipient who should get sms
        $mobile_number = '9955XXXXXXXX';

        $result = GoSMS::sendOTP($mobile_number);
        
        if ($result->success) {
            // $result->success
            // $result->hash
            // $result->to
            // $result->sendAt
            // $result->encode
            // $result->segment
            // $result->smsCharacters
        } else {
            // message wasn't sent
        }
    }
} 
```

### Verify OTP

```php
use Zorb\GoSMS\Facades\GoSMS;

class MessageController extends Controller
{
    //
    public function __invoke()
    {
        // recipient who should get sms
        $mobile_number = '9955XXXXXXXX';

        // hash was received from otp send method
        $hash = 'asd987asd76fds6f5sd7fsdf';

        // otp code from user input
        $code = '1234';

        $result = GoSMS::verifyOTP($mobile_number, $hash, $code);
        
        if ($result->success) {
            // $result->success
            // $result->verify

            if ($result->verify) {
                // otp has been verified
            }
        } else {
            // otp couldn't be checked
        }
    }
} 
```

### Check Balance

```php
use Zorb\GoSMS\Facades\GoSMS;

class MessageController extends Controller
{
    //
    public function __invoke()
    {
        $result = GoSMS::balance();
        
        if ($result->success) {
            // $result->success
            // $result->balance
        } else {
            // balance couldn't be checked
        }
    }
} 
```

### Sender Request

```php
use Zorb\GoSMS\Facades\GoSMS;

class MessageController extends Controller
{
    //
    public function __invoke()
    {
        // sender name
        $brand = 'MY_BRAND';  

        $result = GoSMS::senderRequest($brand);
        
        if ($result->success) {
            // $result->success
        } else {
            // message sender name request failed
        }
    }
} 
```

## Notification

You can use this package as notification channel.

```php
use Illuminate\Notifications\Notification;
use Zorb\GoSMS\Notifications\SMSMessage;
use Zorb\GoSMS\Channels\GoSMSChannel;

class WelcomeNotification extends Notification
{
    //
    public function via($notifiable)
    {
        return [GoSMSChannel::class];
    }
    
    //
    public function toGoSMS($notifiable): SMSMessage
    {
        return (new SMSMessage())
            ->content('Your message goes here.')
            ->recipient($notifiable->phone);
    }
}
```

## Additional Information

### Errors

Errors has its own enum `Zorb\GoSMS\Enums\Errors`

| Key | Value |
| --- | :---: |
| INVALID_API_KEY | 100 |
| INVALID_BRAND_NAME | 101 |
| NOT_ENOUGH_BALANCE | 102 |
| MESSAGE_TOO_LONG | 103 |
| MESSAGE_ID_NOT_FOUND | 104 |
| INVALID_NUMBER_FORMAT | 105 |
| NUMBER_IS_IN_BLACK_LIST | 106 |
| BRAND_ALREADY_EXISTS | 107 |
| BRAND_NAME_ADD_IMPOSSIBLE | 108 |

## Configuration

You can configure environment file with following variables:

| Key | Type | Default | Meaning |
| --- | :---: | --- | --- |
| GOSMS_DEBUG | bool | false | This value decides to log or not to log requests. |
| GOSMS_API_KEY | string |  | This is the api key, which should be generated on gosms.ge. |
| GOSMS_API_URL | string | https://api.gosms.ge/api | This is the url provided gosms.ge api docs. |
| GOSMS_BRAND | string | | This is the brand name which you should have registered on gosms.ge. |

## License

[zgabievi/laravel-gosms](https://github.com/zgabievi/laravel-gosms) is licensed under a [MIT License](https://github.com/zgabievi/laravel-gosms/blob/master/LICENSE).

