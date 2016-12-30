<?php
namespace BikeShare\Http\Services\Sms;

use Bikeshare\Exceptions\CouldNotSendEuroSmsNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class EuroSms
{

    public $id;

    public $key;

    public $senderNumber;

    public $apiUrl = 'http://as.eurosms.com/sms/Sender';


    public function __construct($config, Client $client)
    {
        $this->id = $config['id'] ?? null;
        $this->key = $config['key'] ?? null;
        $this->senderNumber = $config['senderNumber'] ?? null;
        $this->client = $client;
    }


    public function makeRequest(array $message)
    {
        if (! $this->id || ! $this->key || ! $this->senderNumber) {
            throw CouldNotSendEuroSmsNotification::serviceConfigNotProvided();
        }

        try {
            $promise = $this->client->request('GET', $this->apiUrl, [
                'query' => [
                    'action' => 'basend1SMSHTTP',
                    'i' => $this->id,
                    's' => substr(md5($this->key . $message['phone']), 10, 11),
                    'd' => 1,
                    'sender' => $this->senderNumber,
                    'number' => $message['phone'],
                    'msg' => urlencode($message['text']),
                ],
            ]);
        } catch (ClientException $e) {
            throw CouldNotSendEuroSmsNotification::serviceRespondedWithAnError($e);
        } catch (\Exception $e) {
            throw CouldNotSendEuroSmsNotification::couldNotCommunicateWithService();
        }
    }


    public function receive()
    {
        $id = request()->get('sms_id');

        return response("ok:$id");
    }
}
