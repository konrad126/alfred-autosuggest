<?php

namespace AlfredAutosuggest;

interface ResponseFormatter
{
    public function format(array $response): ScriptFilterResponseItem ;
}
