<?php
/*
Copyright 2013-2016 Urban Airship and Contributors
*/

namespace UrbanAirship\User\NamedUserLookup;


class NamedUserLookup
{

    const LOOKUP_URL = "api/named_users/?id=";

    /**
     * @var object Device info for device id
     */
    private $deviceInfo;

    function __construct($airship, $userId)
    {
        $this->airship = $airship;
        $this->identifier = $userId;
        $this->lookup_url = $airship->buildUrl(static::LOOKUP_URL.$userId);
    }

    /**
     * Fetch metadata from a channel ID
     */
    function channelInfo() {
        if ($this->identifier == null) {
            return null;
        } else {
            $url = $this->lookup_url;
            $response = $this->airship->request("GET", null, $url, null, 3);
            $this->deviceInfo = json_decode($response->raw_body);
            return $this->deviceInfo;
        }
    }

}
