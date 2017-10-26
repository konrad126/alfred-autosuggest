<?php

namespace AlfredAutosuggest;

interface UrlGenerator
{
    /**
     * @param string $searchQuery
     * @return string
     */
    public function generateUrl(string $searchQuery) : string ;
}
