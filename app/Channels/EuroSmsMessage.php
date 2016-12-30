<?php
namespace BikeShare\Channels;

class EuroSmsMessage
{


    /**
     * @var array Params payload.
     */
    public $payload = [];


    /**
     * @param string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Message constructor.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content($content);
    }


    /**
     * Notification message.
     *
     * @param $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->payload['text'] = $content;

        return $this;
    }


    /**
     * Recipient's phones numbers.
     *
     * @param $phone string
     *
     * @return $this
     */
    public function to($phone)
    {
        $this->payload['phone'] = $phone;

        return $this;
    }


    /**
     * phone number or alphanumeric sender ID
     *
     * @param $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->payload['from'] = $from;

        return $this;
    }


    /**
     * Determine if phones is not given.
     *
     * @return bool
     */
    public function toNotGiven()
    {
        return empty($this->payload['phone']);
    }


    /**
     * Returns params payload.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }
}
