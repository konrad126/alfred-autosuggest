<?php

namespace AlfredAutosuggest;

interface ScriptFilterItemFormater
{
    public function format($response): ScriptFilterItem;
}
