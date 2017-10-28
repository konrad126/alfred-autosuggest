<?php

namespace AlfredAutosuggest;

use AlfredAutosuggest\NoResponseException;
use GuzzleHttp\Client;

/**
 * Class Autosuggest
 */
class Autosuggest
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var QueryUrlGenerator
     */
    private $urlGenerator;

    /**
     * @var ScriptFilterItemFormater
     */
    private $responseFormatter;

    /**
     * @var ResponseNormalizer
     */
    private $responseNormalizer;


    /**
     * @var ScriptFilterResponse $result
     */
    private $result;

    /**
     * Autosuggest constructor.
     * @param QueryUrlGenerator $urlGenerator
     * @param ScriptFilterItemFormater $responseFormatter
     * @param ResponseNormalizer $responseNormalizer
     */
    public function __construct(QueryUrlGenerator $urlGenerator, ScriptFilterItemFormater $responseFormatter, ResponseNormalizer $responseNormalizer)
    {
        $this->client = new Client();
        $this->result = new ScriptFilterResponse();
        $this->urlGenerator = $urlGenerator;
        $this->responseFormatter = $responseFormatter;
        $this->responseNormalizer = $responseNormalizer;
    }

    /**
     * @param string $searchQuery
     * @return ScriptFilterResponse
     */
    public function retrieveSuggestions(string $searchQuery): ScriptFilterResponse
    {
        $response = $this->client->request('GET', $this->generateSearchUrl($searchQuery));

        try {
            $normalizedResponse = $this->normalizeResponse($response);
            foreach ($normalizedResponse as $item) {
                $this->addToResults($item);
            }
        } catch (NoResponseException $e) {
            // if there are no results skip
        }
        return $this->result;
    }

    /**
     * @param string $searchQuery
     * @return string
     */
    protected function generateSearchUrl(string $searchQuery): string
    {
        return $this->urlGenerator->generateUrl($searchQuery);
    }

    /**
     * @param $item
     */
    protected function addToResults($item)
    {
        try {
            $this->result->addItem($this->responseFormatter->format($item));
        } catch (\Throwable $exception) {
            // skip all unhandled errors - better than crashing the app
        }
    }

    /**
     * @param $response
     * @return array
     * @throws NoResponseException
     */
    protected function normalizeResponse($response): array
    {
        return $this->responseNormalizer->normalizeResponse($response->getBody());
    }


}
