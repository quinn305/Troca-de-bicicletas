<?php

namespace Bikeshare\Exceptions;

use GuzzleHttp\Exception\ClientException;

class CouldNotSendLogSmsNotification extends \Exception
{

    public static function phoneNotProvided()
    {
        return new static('Service notification phone number was not provided. Please refer usage docs.');
    }
}
