<?php


namespace AlfredAutosuggest;

class ScriptFilterResponse
{

    protected $items = [];
    protected $variables = [];

    public function addItem(ScriptFilterItem $item)
    {
        $this->items[] = $item;
    }

    public function addVariable(string $name, $value)
    {
        $this->variables[$name] = $value;
    }
    
    public function toJson(): string
    {
        return json_encode([
            'items' => $this->items
        ]);
    }

}