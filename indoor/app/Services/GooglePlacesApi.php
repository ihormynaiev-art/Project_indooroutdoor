<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GooglePlacesApi
{
    public const BASE_URL = 'https://maps.googleapis.com/maps/api/place/';

    public const DETAILS_SEARCH_URL = 'details/json';

    public $status;

    /**
     * @var null|string
     */
    private $key;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var bool
     */
    private $verifySSL;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * PlacesApi constructor.
     *
     * @param  string|null  $key
     */
    public function __construct(bool $verifySSL = true, array $headers = [])
    {
        $this->key = config('services.google.api_key');

        $this->verifySSL = $verifySSL;

        $this->client = Http::withOptions([
            'base_uri' => self::BASE_URL,
            'headers' => $headers,
            'key' => $this->key,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function placeDetails(string $placeId, array $params = [])
    {
        $this->checkKey();

        $params['placeid'] = $placeId;
        $params['key'] = $this->key;
        $params['reviews_no_translations'] = true;
        $params['reviews_sort'] = 'newest';

        return $this->makeRequest(self::DETAILS_SEARCH_URL, $params);
    }

    /**
     * @throws \Exception
     */
    public function placeDetailsRelevantReviews(string $placeId, array $params = [])
    {
        $this->checkKey();

        $params['placeid'] = $placeId;
        $params['key'] = $this->key;
        $params['fields'] = 'name,url,reviews,rating,user_ratings_total';
        $params['reviews_no_translations'] = true;
        $params['reviews_sort'] = 'most_relevant';

        return $this->makeRequest(self::DETAILS_SEARCH_URL, $params);
    }

    /**
     * @throws \Exception
     */
    public function placeDetailsNewestReviews(string $placeId, array $params = [])
    {
        $this->checkKey();

        $params['placeid'] = $placeId;
        $params['key'] = $this->key;
        $params['fields'] = 'name,url,reviews,rating,user_ratings_total';
        $params['reviews_no_translations'] = true;
        $params['reviews_sort'] = 'newest';

        return $this->makeRequest(self::DETAILS_SEARCH_URL, $params);
    }

    private function makeRequest(string $uri, array $params, string $method = 'get')
    {
        $response = $this->client->$method($uri, $params);
        $data = json_decode($response->getBody()->getContents(), true);

        if (($data['status'] ?? null) !== 'OK') {
            Log::error('Google API error', [
                'uri' => $uri,
                'params' => $params,
                'response' => $data,
            ]);
        }

        return $data;
    }

    /**
     * @throws \Exception
     */
    public function getReviews(string $placeId): Collection
    {
        $placeResponse = $this->placeDetails($placeId);

        return collect($placeResponse['result']['reviews'] ?? []);
    }

    /**
     * @throws \Exception
     */
    private function checkKey()
    {
        if (! $this->key) {
            throw new \Exception('API KEY is not specified.');
        }
    }
}
