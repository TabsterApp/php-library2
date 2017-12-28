<?php
/*
Copyright 2013-2016 Urban Airship and Contributors
*/

namespace UrbanAirship\Event;

use UrbanAirship\RequestInterface;
use UrbanAirship\UALog;

/**
 * Class EventRequest
 * @package UrbanAirship\Push
 */
class EventRequest implements RequestInterface
{

    const EVENTS_URL = "/api/custom-events";
    private $airship;
    private $occurred;
    private $value;
    private $channel;
    private $name;
    private $interactionType;
    private $sessionId;
    private $properties = [];

    /**
     * @param mixed $interactionType
     */
    public function setInteractionType($interactionType)
    {
        $this->interactionType = $interactionType;

        return $this;
    }

    /**
     * @param mixed $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * EventRequest constructor.
     * @param $airship
     */
    function __construct($airship)
    {
        $this->airship = $airship;
        $this->value = 0;
        $this->interactionType = 'url';
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
     * @param mixed $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }



    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    function getPayload()
    {
        $payload = array(
            'occurred' => $this->occurred,
            'user' => [
                'channel' => $this->channel
            ],
            'body' => [
                'name' => $this->name,
                'value' => $this->value,
                'interaction_type' => $this->interactionType,
                'session_id' => $this->sessionId,
                'properties' => $this->properties
            ]
        );

        return $payload;
    }

    /**
     * @return EventResponse
     */
    function send()
    {
        $uri = $this->airship->buildUrl(self::EVENTS_URL);
        $logger = UALog::getLogger();

        $response = $this->airship->request("POST",
            json_encode($this->getPayload()), $uri, "application/json", 3 , null, true);

        $logger->info("Event sent successfully.");
        return new EventResponse($response);
    }

}
