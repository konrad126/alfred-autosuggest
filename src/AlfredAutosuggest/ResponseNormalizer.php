<?php

namespace AlfredAutosuggest;

interface ResponseNormalizer
{
    public function normalizeResponse(string $response) : array;
}