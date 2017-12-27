<?php
/*
Copyright 2013-2016 Urban Airship and Contributors
*/

namespace UrbanAirship\Push;

use UrbanAirship\UALog;

/**
 * Class EventRequest
 * @package UrbanAirship\Push
 */
class EventRequest
{

    const PUSH_URL = "/api/custom-events";
    private $airship;
    private $occurred;
    private $user;
    private $body = [];

    /**
     * EventRequest constructor.
     * @param $airship
     */
    function __construct($airship)
    {
        $this->airship = $airship;
        $this->user = 'channel';
    }

    /**
     * @param $occurred
     * @return $this
     */
    public function setOccurred($occurred)
    {
        $this->occurred = $occurred;

        return $this;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return array
     */
    function getPayload()
    {
        $payload = array(
            'occured' => $this->occurred,
            'user' => $this->user
        );

        if (!is_null($this->body)) {
            $payload['body'] = $this->body;
        }

        return $payload;
    }

    /**
     * @return EventResponse
     */
    function send()
    {
        $uri = $this->airship->buildUrl(self::PUSH_URL);
        $logger = UALog::getLogger();

        $response = $this->airship->request("POST",
            json_encode($this->getPayload()), $uri, "application/vnd.urbanairship+json", 3);

        $logger->info("Event sent successfully.");
        return new EventResponse($response);
    }

}
