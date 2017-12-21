<?php

namespace InstagramAPI;

/**
 * A PHP cliente for Instagram API
 */
class Client
{
    private $client_id;
    private $client_secret;
    private $acess_token;
    private $redirect_url;
    private $scope;

    private $endpoints = [
        'auth' => 'https://api.instagram.com/oauth/authorize/
                    ?client_id=%s
                    &redirect_uri=%s
                    &response_type=code
                    &scope=%s',
        'media' => 'https://api.instagram.com/v1/media/%s/likes',
    ];

    public function __construct($options)
    {
        array_map(function($value, $key){
            $this->{$key} = $value;
        }, $options, array_keys($options));
    }

    public function makeRequest(array $options)
    {
        $response = (new \GuzzleHttp\Client)->request($options['request_type'], $options['url']);
        return $response->getBody();
    }
    

    public function getAuthorization(): string
    {
        return sprintf($endpoints['auth'], $this->client_id);
    }

    public function setAccessToken(string $acess_token): void
    {
        $this->acess_token = $acess_token;
    }

    public function getAcessToken(): string
    {
        return $this->acess_token;
    }
    
    public function getMedia(string $mediaID): string
    {
        return sprintf($endpoints['media'], $mediaID);
    }

    public function login()
    {
        
    }
}
