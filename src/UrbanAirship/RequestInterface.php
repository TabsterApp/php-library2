<?php

namespace UrbanAirship;

interface RequestInterface {
    function send();
    function getPayload();
}