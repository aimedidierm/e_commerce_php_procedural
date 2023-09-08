<?php

use Aimedidierm\IntouchSms\SmsAbstract;

class SendSms
{
    public function sendsms()
    {
        $phone = "";
        $message = "Sample sms";
        $sms = new Sms();
        $sms->recipients([$phone])
            ->message($message)
            ->sender(getenv('SMS_SENDERID'))
            ->username(getenv('SMS_USERNAME'))
            ->password(getenv('SMS_PASSWORD'))
            ->apiUrl("www.intouchsms.co.rw/api/sendsms/.json")
            ->callBackUrl("");
        $sms->send();
    }
}
class Sms extends SmsAbstract
{
    public function __construct()
    {
        parent::__construct();

        //
    }

    public function configSender(): string
    {
        return "intouchSenderId";
    }

    public function configUsername(): string
    {
        return "intouchUsername";
    }

    public function configPassword(): string
    {
        return "intouchPassword";
    }

    public function configApiUrl(): string
    {
        return "www.intouchsms.co.rw/api/sendsms/.json";
    }

    public function configCallBackUrl(): string
    {
        return "";
    }


    public static function QuickSend($recipients, String $message, String $senderId = null)
    {
        $sms = new Sms();
        $sms->requiredData($recipients, $message, $senderId);
        return $sms->send();
    }
}
