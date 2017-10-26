<?php

namespace AlfredAutosuggest;

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
     * Autosuggest constructor.
     * @param QueryUrlGenerator $urlGenerator
     * @param ScriptFilterItemFormater $responseFormatter
     * @param ResponseNormalizer $responseNormalizer
     */
    public function __construct(QueryUrlGenerator $urlGenerator, ScriptFilterItemFormater $responseFormatter, ResponseNormalizer $responseNormalizer)
    {
        $this->client = new Client();
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
        $normalizedResponse = $this->responseNormalizer->normalizeResponse($response->getBody());
        $scriptFilterResponse = new ScriptFilterResponse();
        foreach ($normalizedResponse as $item) {
            try {
                $scriptFilterResponse->addItem($this->responseFormatter->format($item));
            } catch (\Exception $e) {
                // skip unhandled exceptions - to prevent app from crashing
            }
        }

        return $scriptFilterResponse;
    }

    /**
     * @param string $searchQuery
     * @return string
     */
    protected function generateSearchUrl(string $searchQuery): string
    {
        return $this->urlGenerator->generateUrl($searchQuery);
    }


}
