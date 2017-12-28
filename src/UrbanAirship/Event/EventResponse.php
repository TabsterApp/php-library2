<?php
/*
Copyright 2013 Urban Airship and Contributors
*/

namespace UrbanAirship\Event;

use UrbanAirship\UALog;

class EventResponse
{
    public $ok = null;
    public $operation_id = null;

    private $expected_keys = array('operation_id', 'ok');

    function __construct($response) {
        $payload = json_decode($response->raw_body, true);
        foreach ($this->expected_keys as $key) {
            if (array_key_exists($key, $payload)) {
                $this->$key = $payload[$key];
            }
        }
        $this->payload = $payload;
        $this->response = $response;
    }
}
