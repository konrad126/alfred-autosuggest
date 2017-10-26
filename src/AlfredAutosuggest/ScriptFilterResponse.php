<?php


namespace AlfredAutosuggest;

class ScriptFilterResponse
{

    protected $items = [];

    public function addItem(ScriptFilterItem $item)
    {
        $this->items[] = $item;
    }

    public function toJson(): string
    {
        return json_encode([
            'items' => $this->items
        ]);
    }

}