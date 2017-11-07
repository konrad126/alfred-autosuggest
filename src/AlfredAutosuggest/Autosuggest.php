<?php

namespace AlfredAutosuggest;

use GuzzleHttp\Client;

/**
 * Class Autosuggest
 *
 * Template method pattern.
 *
 */
abstract class Autosuggest
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ScriptFilterResponse $result
     */
    private $result;


    /**
     * Autosuggest constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->result = new ScriptFilterResponse();
    }

    /**
     * @param string $searchQuery
     * @return string
     */
    public function retrieveSuggestions(string $searchQuery): string
    {
        $response = $this->client->request('GET', $this->generateSearchUrl($searchQuery));

        try {
            $normalizedResponse = $this->normalizeResponse($response->getBody());
            foreach ($normalizedResponse as $item) {
                $this->addToResults($item);
            }
        } catch (NoResponseException $e) {
            // if there are no results skip
        }
        return $this->result->toJson();
    }

    /**
     * @param $item
     */
    protected function addToResults($item)
    {
        try {
            $this->result->addItem($this->createResponseItem($item));
        } catch (\Throwable $exception) {
            // skip all unhandled errors - better than crashing the app
        }
    }

    /**
     * Generate search url
     *
     * @param string $searchQuery
     * @return string
     */
    abstract protected function generateSearchUrl(string $searchQuery): string;

    /**
     * Normalize response returned from server (if
     * needed)
     *
     * @param $response
     * @return array
     * @throws NoResponseException
     */
    abstract protected function normalizeResponse($response): array;

    /**
     * Creates Alfred Script Filter Response Item
     *
     * @param $item
     * @return ScriptFilterItem
     */
    abstract protected function createResponseItem($item): ScriptFilterItem;

}
