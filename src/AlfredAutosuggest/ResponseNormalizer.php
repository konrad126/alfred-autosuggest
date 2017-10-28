<?php

namespace AlfredAutosuggest;

/**
 * Interface ResponseNormalizer
 * @package AlfredAutosuggest
 */
interface ResponseNormalizer
{
    /**
     * Normalizes raw response from server into
     * form suitable for further processing.
     *
     *
     * If null or invalid Response throws
     * NoResponseException
     * 
     * @param string $response
     * @return array
     * @throws NoResponseException
     */
    public function normalizeResponse(string $response) : array;
}