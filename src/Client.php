<?php

namespace InstagramAPI;

/**
 * A PHP cliente for Instagram API
 */
class Client
{
    /**
     * Array for config keys to call API
     * 
     * client_id
     * client_secret
     * acess_token
     * redirect_uri
     * scope
     *
     * @var [array]
     */
    private $config;
    private $guzzleHttpClient;

    private $endpoints = [
        'auth' => 'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s',
        'access_token' => 'https://api.instagram.com/oauth/access_token',
        'media' => 'https://api.instagram.com/v1/media/%s/likes',
    ];

    public function __construct($config)
    {
        $this->config = $config;
        $this->guzzleHttpClient  = new \GuzzleHttp\Client;
    }

    public function makeRequest(string $request, string $url, array $options): string
    {
        return (string) $this->guzzleHttpClient
        ->request($request, $url, $options)
        ->getBody();
    }
    
    public function getAuthURI(): string
    {
        return sprintf($this->endpoints['auth'], $this->config['client_id'], $this->config['redirect_uri'], $this->config['scope']);
    }

    public function requestAccessToken(string $code): void
    {
        $options = [
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->config['redirect_uri'],
            'code'          => $code,
        ];

        $requestAccessToken = $this->makeRequest('POST', $this->endpoints['access_token'], ['form_params' => $options]);

        $this->setAccessToken((json_decode($requestAccessToken))->access_token);
    }
    
    public function setAccessToken(string $acess_token): void
    {
        $this->config['acess_token'] = $acess_token;
    }

    public function getAcessToken(): string
    {
        return $this->config['acess_token'];
    }
    
    public function getMedia(string $mediaID): string
    {
        return sprintf($endpoints['media'], $mediaID);
    }

    public function login()
    {
        
    }
}
