<?php

namespace Bikeshare\Exceptions;

use GuzzleHttp\Exception\ClientException;

class CouldNotSendEuroSmsNotification extends \Exception
{

    public static function serviceRespondedWithAnError(ClientException $exception)
    {
        $statusCode = $exception->getResponse()->getStatusCode();
        $description = 'no description given';
        if ($result = json_decode($exception->getResponse()->getBody())) {
            $description = $result->message ?: $description;
        }

        return new static("EuroSms responded with an error `{$statusCode} - {$description}`");
    }


    public static function serviceConfigNotProvided()
    {
        return new static('You must provide your Service id key and sender number to make any API requests.');
    }


    public static function couldNotCommunicateWithService()
    {
        return new static('The communication with Service failed.');
    }


    public static function phoneNotProvided()
    {
        return new static('Service notification phone number was not provided. Please refer usage docs.');
    }
}
