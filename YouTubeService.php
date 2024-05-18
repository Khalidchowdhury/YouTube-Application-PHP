<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class YouTubeService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'AIzaSyDsnuThUL5lFSrug4oNZ5wlQJs4QgrXTqk'; 
    }

    public function fetchVideos($query, $maxResults = 50, $pageToken = '')
    {
        $url = 'https://www.googleapis.com/youtube/v3/search';
        $params = [
            'query' => [
                'part' => 'snippet',
                'q' => $query,
                'type' => 'video',
                'maxResults' => $maxResults,
                'key' => $this->apiKey,
                'pageToken' => $pageToken
            ]
        ];

        $response = $this->client->get($url, $params);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }
}
