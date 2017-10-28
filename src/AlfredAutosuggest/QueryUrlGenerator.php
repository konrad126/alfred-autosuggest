<?php

namespace AlfredAutosuggest;

interface QueryUrlGenerator
{
    /**
     * Generates search url
     *
     * @param string $searchQuery
     * @return string
     */
    public function generateUrl(string $searchQuery) : string ;
}
