<?php


namespace AlfredAutosuggest;


interface ResponseNormalizer
{
    public function normalizeResponse() : array;
}