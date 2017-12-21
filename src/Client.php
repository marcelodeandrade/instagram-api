<?php

namespace InstagramAPI;

/**
 * A PHP cliente for Instagram API
 */
class Client
{
    private $clientID;
    private $clientSecret;
    private $accessToken;

    private $endpoints = [
        'auth' => 'https://api.instagram.com/oauth/authorize/
                    ?client_id=%s
                    &redirect_uri=%s
                    &response_type=code
                    &scope=likes',
        'media' => 'https://api.instagram.com/v1/media/%s/likes',
    ];

    public function __construct($clientID, $clientSecret)
    {
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
    }

    public function makeRequest(array $options)
    {
        $response = (new \GuzzleHttp\Client)->request($options['request_type'], $options['url']);
        return $response->getBody();
    }
    

    public function getAuthorization() : string
    {
        return sprintf($endpoints['auth'], $this->clientID);
    }

    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken() : string
    {
        return $this->accessToken;
    }
    
    public function getMedia(string $mediaID) : string
    {
        return sprintf($endpoints['media'], $mediaID);
    }

    public function login()
    {
        
    }
}
