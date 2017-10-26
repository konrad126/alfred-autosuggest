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
     * @var UrlGenerator
     */
    private $urlGenerator;
    /**
     * @var ResponseFormatter
     */
    private $responseFormatter;
    /**
     * @var ResponseNormalizer
     */
    private $responseNormalizer;

    /**
     * Autosuggest constructor.
     * @param UrlGenerator $urlGenerator
     * @param ResponseFormatter $responseFormatter
     * @param ResponseNormalizer $responseNormalizer
     */
    public function __construct(UrlGenerator $urlGenerator, ResponseFormatter $responseFormatter, ResponseNormalizer $responseNormalizer)
    {
        $this->client = new Client();
        $this->urlGenerator = $urlGenerator;
        $this->responseFormatter = $responseFormatter;
        $this->responseNormalizer = $responseNormalizer;
    }

    /**
     * @param string $searchQuery
     * @return string
     */
    public function retrieveSuggestions(string $searchQuery): string
    {
        $response = $this->client->request('GET', $this->generateSearchUrl($searchQuery));
        $normalizedResponse = $this->responseNormalizer->normalizeResponse($response->getBody());
        foreach ($normalizedResponse as $item) {
            $result = $this->responseFormatter->format($item);
        }

        return json_encode(['items' => $result]);
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
