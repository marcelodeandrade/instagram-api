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
    private $redirect_uri;
    private $scope;

    private $endpoints = [
        'auth' => 'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s',
        'access_token' => 'https://api.instagram.com/oauth/access_token',
        'media' => 'https://api.instagram.com/v1/media/%s/likes',
    ];

    public function __construct($options)
    {
        array_map(function($value, $key){
            $this->{$key} = $value;
        }, $options, array_keys($options));
    }

    public function makeRequest(string $request, string $url, array $options): string
    {
        return (string) (new \GuzzleHttp\Client)
        ->request($request, $url, $options)
        ->getBody();
    }
    
    public function getAuthURI(): string
    {
        return sprintf($this->endpoints['auth'], $this->client_id, $this->redirect_uri, $this->scope);
    }

    public function requestAccessToken(string $code): void
    {
        $options = [
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->redirect_uri,
            'code'          => $code,
        ];

        $requestAccessToken = $this->makeRequest('POST', $this->endpoints['access_token'], ['form_params' => $options]);

        $this->setAccessToken((json_decode($requestAccessToken))->access_token);
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
