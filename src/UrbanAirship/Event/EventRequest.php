<?php
/*
Copyright 2013-2016 Urban Airship and Contributors
*/

namespace UrbanAirship\Event;

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
    }

    /**
     * EventRequest constructor.
     * @param $airship
     */
    function __construct($airship)
    {
        $this->airship = $airship;
        $this->user = 'channel';
        $this->value = 0;
        $this->interactionType = 'web';
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
            'occured' => $this->occurred,
            'user' => $this->user,
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
        $uri = $this->airship->buildUrl(self::PUSH_URL);
        $logger = UALog::getLogger();

        $response = $this->airship->request("POST",
            json_encode($this->getPayload()), $uri, "application/vnd.urbanairship+json", 3);

        $logger->info("Event sent successfully.");
        return new EventResponse($response);
    }

}
