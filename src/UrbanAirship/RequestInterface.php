<?php

interface RequestInterface {
    function send();
    function getPayload();
}