<?php

namespace AlfredAutosuggest;

interface QueryUrlGenerator
{
    /**
     * @param string $searchQuery
     * @return string
     */
    public function generateUrl(string $searchQuery) : string ;
}
