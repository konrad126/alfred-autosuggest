<?php

namespace AlfredAutosuggest;

/**
 * Class ScriptFilterResponse
 * @package AlfredAutosuggest
 */
class ScriptFilterResponse
{

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @param ScriptFilterItem $item
     */
    public function addItem(ScriptFilterItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode([
            'items' => $this->items
        ]);
    }

}